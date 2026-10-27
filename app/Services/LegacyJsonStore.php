<?php

namespace App\Services;

use App\Models\Invite;
use App\Models\MemoryComment;
use App\Models\MemoryPost;
use App\Models\Rsvp;
use App\Models\Setting;
use App\Models\Wish;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Converts between the database and the legacy data/*.json file format
 * (data.json, comments.json, invites.json, memories.json,
 * memory_comments.json, media.json).
 *
 * Used to import the old JSON store into MySQL, and by BackupService to
 * export/restore S3 backups in that same format.
 *
 * The old JSON store HTML-escaped guest input (e()) before saving; the
 * database stores raw text, so import decodes and export re-encodes those
 * fields (both directions stay symmetric).
 */
class LegacyJsonStore
{
    public const FILES = [
        'data.json',
        'comments.json',
        'invites.json',
        'memories.json',
        'memory_comments.json',
        'media.json',
    ];

    /**
     * Read every legacy JSON file that exists in $dir.
     *
     * @return array<string, array> file name => decoded payload
     */
    public static function readDirectory(string $dir): array
    {
        $payloads = [];

        foreach (self::FILES as $file) {
            $path = $dir.DIRECTORY_SEPARATOR.$file;
            if (is_file($path)) {
                $data = json_decode(file_get_contents($path), true);
                if (is_array($data)) {
                    $payloads[$file] = $data;
                }
            }
        }

        return $payloads;
    }

    /**
     * Import legacy payloads. Idempotent: records are matched on their
     * legacy id (or invite token), so importing twice updates instead of
     * duplicating. With $replace, all wedding tables are emptied first
     * (used when restoring a backup).
     *
     * @param  array<string, array>  $payloads  file name => decoded payload
     * @return array<string, int> number of records imported per table
     */
    public function import(array $payloads, bool $replace = false): array
    {
        return DB::transaction(function () use ($payloads, $replace) {
            if ($replace) {
                MemoryComment::query()->delete();
                MemoryPost::query()->delete();
                Wish::query()->delete();
                Rsvp::query()->delete();
                Invite::query()->delete();
                Setting::whereKey(MediaSettingsRepository::SETTING_KEY)->delete();
            }

            $counts = [];

            $counts['rsvps'] = 0;
            foreach ($payloads['data.json']['rsvp_list'] ?? [] as $item) {
                $rsvp = Rsvp::where('legacy_id', $item['id'])->first()
                    ?? (! empty($item['token']) ? Rsvp::whereToken($item['token'])->first() : null)
                    ?? new Rsvp(['legacy_id' => $item['id']]);

                $rsvp->fill([
                    'fullname' => self::decode($item['fullname'] ?? ''),
                    'phone' => self::decode($item['phone'] ?? ''),
                    'guests' => (int) ($item['guests'] ?? 1),
                    'attend' => ($item['attend'] ?? 'yes') === 'no' ? 'no' : 'yes',
                    'message' => self::decode($item['message'] ?? ''),
                    'ip_address' => (string) ($item['ip_address'] ?? ''),
                    'user_agent' => mb_substr((string) ($item['user_agent'] ?? ''), 0, 255),
                    'edited_at' => self::date($item['updated_at'] ?? null),
                    'created_at' => self::date($item['timestamp'] ?? null) ?? now(),
                    'updated_at' => self::date($item['updated_at'] ?? $item['timestamp'] ?? null) ?? now(),
                ]);
                if (! empty($item['token'])) {
                    $rsvp->token = $item['token'];
                }
                $rsvp->save();
                $counts['rsvps']++;
            }

            $counts['wishes'] = 0;
            foreach ($payloads['comments.json']['comments'] ?? [] as $item) {
                $rsvpId = isset($item['rsvp_id'])
                    ? Rsvp::where('legacy_id', $item['rsvp_id'])->value('id')
                    : null;
                $wish = Wish::where('legacy_id', $item['id'])->first()
                    ?? ($rsvpId ? Wish::where('rsvp_id', $rsvpId)->first() : null)
                    ?? new Wish(['legacy_id' => $item['id']]);

                $wish->fill([
                    'rsvp_id' => $rsvpId,
                    'name' => self::decode($item['name'] ?? ''),
                    'message' => self::decode($item['message'] ?? ''),
                    'active' => ($item['active'] ?? false) === true,
                    'sent_at' => self::date($item['sent_at'] ?? null),
                    'ip_address' => (string) ($item['ip_address'] ?? ''),
                    'user_agent' => mb_substr((string) ($item['user_agent'] ?? ''), 0, 255),
                    'created_at' => self::date($item['sent_at'] ?? null) ?? now(),
                ])->save();
                $counts['wishes']++;
            }

            $counts['invites'] = 0;
            foreach ($payloads['invites.json']['invites'] ?? [] as $item) {
                $invite = Invite::whereToken($item['token'])->first() ?? new Invite(['token' => $item['token']]);

                $invite->fill([
                    'name' => $item['name'],
                    'first_opened_at' => self::date($item['first_opened_at'] ?? null),
                    'last_opened_at' => self::date($item['last_opened_at'] ?? null),
                    'open_count' => (int) ($item['open_count'] ?? 0),
                    'created_at' => self::date($item['created_at'] ?? null) ?? now(),
                ])->save();
                $counts['invites']++;
            }

            $counts['memory_posts'] = 0;
            foreach ($payloads['memories.json']['posts'] ?? [] as $item) {
                MemoryPost::updateOrCreate(['legacy_id' => $item['id']], [
                    'posted_at' => self::date($item['date'] ?? null),
                    'content' => (string) ($item['content'] ?? ''),
                    'images' => array_values($item['images'] ?? []),
                    'likes' => (int) ($item['likes'] ?? 0),
                ]);
                $counts['memory_posts']++;
            }

            $counts['memory_comments'] = 0;
            foreach ($payloads['memory_comments.json']['comments'] ?? [] as $item) {
                $postId = MemoryPost::where('legacy_id', $item['post_id'] ?? null)->value('id');
                if (! $postId) {
                    continue; // comment on a post that no longer exists
                }

                MemoryComment::updateOrCreate(['legacy_id' => $item['id']], [
                    'memory_post_id' => $postId,
                    'name' => mb_substr(self::decode($item['name'] ?? ''), 0, 100),
                    'message' => self::decode($item['message'] ?? ''),
                    'ip_address' => (string) ($item['ip_address'] ?? ''),
                    'user_agent' => mb_substr((string) ($item['user_agent'] ?? ''), 0, 255),
                    'created_at' => self::date($item['created_at'] ?? null) ?? now(),
                ]);
                $counts['memory_comments']++;
            }

            if (isset($payloads['media.json'])) {
                Setting::setValue(MediaSettingsRepository::SETTING_KEY, $payloads['media.json']);
                $counts['settings'] = 1;
            }

            return $counts;
        });
    }

    /**
     * Export the database in the legacy JSON format.
     *
     * @return array<string, array> file name => payload
     */
    public function export(): array
    {
        $now = now()->format('Y-m-d H:i:s');

        $rsvps = Rsvp::orderBy('id')->get()->map(fn (Rsvp $r) => array_filter([
            'id' => $r->legacy_id ?? 'db_rsvp_'.$r->id,
            'token' => $r->token,
            'timestamp' => $r->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $r->edited_at?->format('Y-m-d H:i:s'),
            'fullname' => e($r->fullname),
            'phone' => e($r->phone),
            'guests' => $r->guests,
            'attend' => $r->attend,
            'message' => e((string) $r->message),
            'ip_address' => $r->ip_address,
            'user_agent' => $r->user_agent,
        ], fn ($v) => $v !== null))->all();

        $legacyRsvpIds = Rsvp::pluck('legacy_id', 'id')->map(fn ($legacy, $id) => $legacy ?? 'db_rsvp_'.$id);

        $wishes = Wish::orderBy('id')->get()->map(fn (Wish $w) => [
            'id' => $w->legacy_id ?? 'db_wish_'.$w->id,
            'rsvp_id' => $w->rsvp_id ? $legacyRsvpIds[$w->rsvp_id] : null,
            'name' => e($w->name),
            'sent_at' => $w->sent_at?->format('Y-m-d H:i:s'),
            'active' => $w->active,
            'message' => e((string) $w->message),
            'ip_address' => $w->ip_address,
            'user_agent' => $w->user_agent,
        ])->all();

        $invites = (new InviteRepository())->all();

        $legacyPostIds = MemoryPost::pluck('legacy_id', 'id')->map(fn ($legacy, $id) => $legacy ?? 'db_post_'.$id);

        $posts = MemoryPost::orderBy('id')->get()->map(fn (MemoryPost $p) => [
            'id' => $legacyPostIds[$p->id],
            'date' => $p->posted_at?->format('Y-m-d H:i:s'),
            'content' => $p->content,
            'images' => $p->images ?? [],
            'likes' => $p->likes,
        ])->all();

        $memoryComments = MemoryComment::orderBy('id')->get()->map(fn (MemoryComment $c) => [
            'id' => $c->legacy_id ?? 'db_mzc_'.$c->id,
            'post_id' => $legacyPostIds[$c->memory_post_id],
            'name' => e($c->name),
            'message' => e($c->message),
            'created_at' => $c->created_at?->format('Y-m-d H:i:s'),
            'ip_address' => $c->ip_address,
            'user_agent' => $c->user_agent,
        ])->all();

        $payloads = [
            'data.json' => ['total_rsvp' => count($rsvps), 'last_updated' => $now, 'rsvp_list' => $rsvps],
            'comments.json' => ['total_comments' => count($wishes), 'last_updated' => $now, 'comments' => $wishes],
            'invites.json' => ['total_invites' => count($invites), 'last_updated' => $now, 'invites' => $invites],
            'memories.json' => ['total_posts' => count($posts), 'last_updated' => $now, 'posts' => $posts],
            'memory_comments.json' => ['total_comments' => count($memoryComments), 'last_updated' => $now, 'comments' => $memoryComments],
        ];

        $media = Setting::getValue(MediaSettingsRepository::SETTING_KEY);
        if ($media !== null) {
            $payloads['media.json'] = $media;
        }

        return $payloads;
    }

    private static function decode(string $value): string
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }

    private static function date(?string $value): ?Carbon
    {
        return $value ? Carbon::parse($value) : null;
    }
}

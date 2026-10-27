<?php

namespace Database\Seeders;

use App\Models\Invite;
use App\Models\MemoryComment;
use App\Models\MemoryPost;
use App\Models\Rsvp;
use App\Models\Wish;
use App\Services\InviterCodec;
use Illuminate\Database\Seeder;

/**
 * Demo guests, RSVPs, wishes and memories for trying the site locally.
 *
 * Every demo row is tagged (legacy_id "demo_*", invite names from
 * DEMO_GUESTS) so `php artisan wedding:clear-demo` removes exactly these.
 * Running the seeder again doesn't duplicate anything.
 */
class DemoDataSeeder extends Seeder
{
    public const DEMO_GUESTS = [
        // name => [opens, rsvp attend, guests, wish message, wish approved]
        'Anh Minh & chị Lan (demo)' => [3, 'yes', 2, 'Chúc hai bạn trăm năm hạnh phúc, sớm có tin vui nhé! 💕', true],
        'Gia đình cô Ba (demo)' => [1, 'yes', 4, 'Cả nhà cô chúc hai con mãi yêu thương, thuận hòa.', true],
        'Bạn Tuấn lớp 12A1 (demo)' => [2, 'no', 1, 'Tiếc quá hôm đó mình đi công tác, chúc mừng hai bạn nha!', false],
        'Chị Hà Linh (demo)' => [1, null, 0, null, false],
        'Anh Quốc Bảo (demo)' => [0, null, 0, null, false],
    ];

    public function run()
    {
        $key = config('wedding.inviter_secret_key');

        foreach (self::DEMO_GUESTS as $name => [$opens, $attend, $guests, $message, $approved]) {
            $token = InviterCodec::encode($name, $key);

            $invite = Invite::whereToken($token)->first() ?? new Invite(['token' => $token]);
            $invite->fill([
                'name' => $name,
                'open_count' => $opens,
                'first_opened_at' => $opens ? now()->subDays(3) : null,
                'last_opened_at' => $opens ? now()->subHours($opens) : null,
            ])->save();

            if ($attend === null) {
                continue;
            }

            $slug = substr(md5($name), 0, 8);
            $rsvp = Rsvp::firstOrNew(['legacy_id' => 'demo_rsvp_'.$slug]);
            $rsvp->fill([
                'fullname' => $name,
                'phone' => '09'.substr(crc32($name), 0, 8),
                'guests' => $guests,
                'attend' => $attend,
                'message' => $message,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'DemoDataSeeder',
            ]);
            $rsvp->token = $token;
            $rsvp->save();

            Wish::updateOrCreate(['legacy_id' => 'demo_wish_'.$slug], [
                'rsvp_id' => $rsvp->id,
                'name' => $name,
                'message' => $message,
                'active' => $approved,
                'sent_at' => now()->subDays(2),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'DemoDataSeeder',
            ]);
        }

        $gallery = array_column(config('wedding.gallery_images', []), 'url');
        $posts = [
            'demo_post_1' => ['2025-08-20 19:30:00', 'Chuyến Đà Lạt đầu tiên của hai đứa — sương sớm, cà phê và rất nhiều tiếng cười ☕🌲 (demo)', 214],
            'demo_post_2' => ['2026-03-08 20:00:00', 'Ngày anh ngỏ lời, em chỉ kịp gật đầu rồi khóc 💍 (demo)', 356],
        ];

        foreach ($posts as $legacyId => [$date, $content, $likes]) {
            $post = MemoryPost::updateOrCreate(['legacy_id' => $legacyId], [
                'posted_at' => $date,
                'content' => $content,
                'images' => array_slice($gallery, 0, 2),
                'likes' => $likes,
            ]);

            MemoryComment::updateOrCreate(['legacy_id' => $legacyId.'_c1'], [
                'memory_post_id' => $post->id,
                'name' => 'Bạn thân (demo)',
                'message' => 'Đẹp đôi quá trời luôn! 😍',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'DemoDataSeeder',
            ]);
        }

        $this->command?->info('Demo data seeded (remove with: php artisan wedding:clear-demo).');
    }

    /**
     * Delete every row created by this seeder.
     *
     * @return array<string, int> rows deleted per table
     */
    public static function clear(): array
    {
        $key = config('wedding.inviter_secret_key');
        $tokens = array_map(fn ($name) => InviterCodec::encode($name, $key), array_keys(self::DEMO_GUESTS));

        return [
            'memory_comments' => MemoryComment::where('legacy_id', 'like', 'demo_%')->delete(),
            'memory_posts' => MemoryPost::where('legacy_id', 'like', 'demo_%')->delete(),
            'wishes' => Wish::where('legacy_id', 'like', 'demo_%')->delete(),
            'rsvps' => Rsvp::where('legacy_id', 'like', 'demo_%')->delete(),
            'invites' => Invite::whereIn('token_hash', array_map(fn ($t) => hash('sha256', $t), $tokens))->delete(),
        ];
    }
}

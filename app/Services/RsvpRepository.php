<?php

namespace App\Services;

/**
 * Reads/writes the file-based JSON stores used by the wedding site
 * (data/data.json for RSVPs, data/comments.json for guest wishes),
 * ported from the original api/save-rsvp.php.
 */
class RsvpRepository
{
    protected string $dataFile;

    protected string $commentsFile;

    public function __construct()
    {
        $dataDir = base_path('data');
        $this->dataFile = $dataDir.DIRECTORY_SEPARATOR.'data.json';
        $this->commentsFile = $dataDir.DIRECTORY_SEPARATOR.'comments.json';

        if (! is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
    }

    /**
     * Persist an RSVP submission and its related comment/wish entry.
     *
     * When $attributes['token'] (the guest's invite token) matches an earlier
     * RSVP, that RSVP is updated instead of adding a duplicate; its wish goes
     * back to pending approval if the message changed.
     *
     * Returns ['rsvp' => record, 'updated' => bool].
     */
    public function store(array $attributes): array
    {
        $rsvpList = $this->readList($this->dataFile, 'rsvp_list');
        $token = $attributes['token'] ?? '';
        $now = now()->format('Y-m-d H:i:s');

        $fields = [
            'fullname' => e($attributes['fullname']),
            'phone' => $attributes['phone'] !== '' ? e($attributes['phone']) : '',
            'guests' => $attributes['guests'],
            'attend' => $attributes['attend'],
            'message' => $attributes['message'] !== '' ? e($attributes['message']) : '',
            'ip_address' => $attributes['ip_address'] ?? '',
            'user_agent' => $attributes['user_agent'] ?? '',
        ];

        $index = $token !== '' ? $this->indexOfToken($rsvpList, $token) : null;

        if ($index !== null) {
            $rsvp = array_merge($rsvpList[$index], $fields, ['updated_at' => $now]);
            $rsvpList[$index] = $rsvp;
        } else {
            $rsvp = ['id' => uniqid('rsvp_', true), 'timestamp' => $now] + ($token !== '' ? ['token' => $token] : []) + $fields;
            $rsvpList[] = $rsvp;
        }

        $this->writeList($this->dataFile, 'total_rsvp', 'rsvp_list', $rsvpList);
        $this->saveCommentFor($rsvp, $now);

        return ['rsvp' => $rsvp, 'updated' => $index !== null];
    }

    /**
     * The RSVP previously sent with this invite token, if any.
     */
    public function findByToken(string $token): ?array
    {
        $rsvpList = $this->readList($this->dataFile, 'rsvp_list');
        $index = $this->indexOfToken($rsvpList, $token);

        return $index === null ? null : $rsvpList[$index];
    }

    private function indexOfToken(array $rsvpList, string $token): ?int
    {
        foreach ($rsvpList as $i => $rsvp) {
            if (($rsvp['token'] ?? null) === $token) {
                return $i;
            }
        }

        return null;
    }

    /**
     * Create the wish entry for an RSVP, or update it when the RSVP is resent.
     */
    private function saveCommentFor(array $rsvp, string $now): void
    {
        $comments = $this->readList($this->commentsFile, 'comments');
        $entry = [
            'rsvp_id' => $rsvp['id'],
            'name' => $rsvp['fullname'],
            'sent_at' => $now,
            'message' => $rsvp['message'],
            'ip_address' => $rsvp['ip_address'],
            'user_agent' => $rsvp['user_agent'],
        ];

        $existing = array_search($rsvp['id'], array_column($comments, 'rsvp_id'), true);

        if ($existing === false) {
            $comments[] = ['id' => uniqid('comment_', true)] + $entry + ['active' => false];
        } else {
            $messageChanged = ($comments[$existing]['message'] ?? '') !== $entry['message'];
            $comments[$existing] = array_merge($comments[$existing], $entry);
            if ($messageChanged) {
                $comments[$existing]['active'] = false;
            }
        }

        $this->writeList($this->commentsFile, 'total_comments', 'comments', $comments);
    }

    /**
     * Get every comment/wish marked as active, for display on the invite page.
     */
    public function getActiveComments(): array
    {
        $comments = $this->readList($this->commentsFile, 'comments');

        return array_values(array_filter($comments, function ($comment) {
            return isset($comment['active']) && $comment['active'] === true;
        }));
    }

    /**
     * Get every RSVP submission (used by the /dashboard admin panel).
     */
    public function getAllRsvp(): array
    {
        return $this->readList($this->dataFile, 'rsvp_list');
    }

    /**
     * Get every comment/wish, active or not (used by the /dashboard admin panel).
     */
    public function getAllComments(): array
    {
        return $this->readList($this->commentsFile, 'comments');
    }

    /**
     * Show/hide a comment on the invite page. Returns the updated comment,
     * or null if no comment has that id.
     */
    public function setCommentActive(string $id, bool $active): ?array
    {
        $comments = $this->readList($this->commentsFile, 'comments');

        foreach ($comments as $i => $comment) {
            if (($comment['id'] ?? null) === $id) {
                $comments[$i]['active'] = $active;
                $this->writeList($this->commentsFile, 'total_comments', 'comments', $comments);

                return $comments[$i];
            }
        }

        return null;
    }

    /**
     * Permanently remove a comment. Returns false if no comment has that id.
     */
    public function deleteComment(string $id): bool
    {
        $comments = $this->readList($this->commentsFile, 'comments');
        $remaining = array_values(array_filter($comments, fn ($comment) => ($comment['id'] ?? null) !== $id));

        if (count($remaining) === count($comments)) {
            return false;
        }

        $this->writeList($this->commentsFile, 'total_comments', 'comments', $remaining);

        return true;
    }

    protected function readList(string $file, string $key): array
    {
        if (! file_exists($file)) {
            return [];
        }

        $data = json_decode(file_get_contents($file), true);

        return $data[$key] ?? [];
    }

    protected function writeList(string $file, string $countKey, string $listKey, array $list): void
    {
        $payload = [
            $countKey => count($list),
            'last_updated' => now()->format('Y-m-d H:i:s'),
            $listKey => $list,
        ];

        file_put_contents(
            $file,
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }
}

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
     * Persist a new RSVP submission and its related (initially inactive)
     * comment/wish entry. Returns the newly created RSVP record.
     */
    public function store(array $attributes): array
    {
        $rsvpList = $this->readList($this->dataFile, 'rsvp_list');

        $newRsvp = [
            'id' => uniqid('rsvp_', true),
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'fullname' => e($attributes['fullname']),
            'phone' => $attributes['phone'] !== '' ? e($attributes['phone']) : '',
            'guests' => $attributes['guests'],
            'attend' => $attributes['attend'],
            'message' => $attributes['message'] !== '' ? e($attributes['message']) : '',
            'ip_address' => $attributes['ip_address'] ?? '',
            'user_agent' => $attributes['user_agent'] ?? '',
        ];

        $rsvpList[] = $newRsvp;
        $this->writeList($this->dataFile, 'total_rsvp', 'rsvp_list', $rsvpList);

        $comments = $this->readList($this->commentsFile, 'comments');
        $comments[] = [
            'id' => uniqid('comment_', true),
            'rsvp_id' => $newRsvp['id'],
            'name' => $newRsvp['fullname'],
            'sent_at' => now()->format('Y-m-d H:i:s'),
            'active' => false,
            'message' => $newRsvp['message'],
            'ip_address' => $newRsvp['ip_address'],
            'user_agent' => $newRsvp['user_agent'],
        ];
        $this->writeList($this->commentsFile, 'total_comments', 'comments', $comments);

        return $newRsvp;
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

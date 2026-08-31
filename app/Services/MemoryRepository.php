<?php

namespace App\Services;

/**
 * Reads the file-based JSON store of "our memories" timeline posts
 * (data/memories.json), used by the Facebook-style /memorize page.
 */
class MemoryRepository
{
    protected string $memoriesFile;

    protected string $commentsFile;

    public function __construct()
    {
        $dataDir = base_path('data');
        $this->memoriesFile = $dataDir.DIRECTORY_SEPARATOR.'memories.json';
        $this->commentsFile = $dataDir.DIRECTORY_SEPARATOR.'memory_comments.json';

        if (! is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
    }

    /**
     * Get every timeline post, newest first (like a real Facebook feed).
     */
    public function getTimeline(): array
    {
        $posts = $this->readList($this->memoriesFile, 'posts');

        usort($posts, function ($a, $b) {
            return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
        });

        return $posts;
    }

    /**
     * Get every comment for a given post, oldest first (natural reading order).
     */
    public function getComments(string $postId): array
    {
        $comments = $this->readList($this->commentsFile, 'comments');

        $comments = array_values(array_filter($comments, function ($comment) use ($postId) {
            return ($comment['post_id'] ?? null) === $postId;
        }));

        usort($comments, function ($a, $b) {
            return strtotime($a['created_at'] ?? '') <=> strtotime($b['created_at'] ?? '');
        });

        return $comments;
    }

    /**
     * Append a new comment for a post and persist it to memory_comments.json.
     */
    public function addComment(string $postId, array $attributes): array
    {
        $comments = $this->readList($this->commentsFile, 'comments');

        $newComment = [
            'id' => uniqid('mzc_', true),
            'post_id' => $postId,
            'name' => e($attributes['name']),
            'message' => e($attributes['message']),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'ip_address' => $attributes['ip_address'] ?? '',
            'user_agent' => $attributes['user_agent'] ?? '',
        ];

        $comments[] = $newComment;
        $this->writeList($this->commentsFile, 'total_comments', 'comments', $comments);

        return $newComment;
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

<?php

namespace App\Services;

use App\Models\MemoryComment;
use App\Models\MemoryPost;

/**
 * "Our memories" timeline posts (memory_posts) and their comments
 * (memory_comments), used by the Facebook-style /memorize page.
 */
class MemoryRepository
{
    /**
     * Get every timeline post, newest first (like a real Facebook feed).
     */
    public function getTimeline(): array
    {
        return MemoryPost::orderByDesc('posted_at')->orderByDesc('id')->get()
            ->map(fn (MemoryPost $post) => $this->presentPost($post))->all();
    }

    /**
     * Get every comment for a given post, oldest first (natural reading order).
     */
    public function getComments(string $postId): array
    {
        return MemoryComment::where('memory_post_id', $postId)->orderBy('created_at')->orderBy('id')->get()
            ->map(fn (MemoryComment $comment) => $this->presentComment($comment))->all();
    }

    /**
     * Add a new comment to a post (404 if the post doesn't exist).
     */
    public function addComment(string $postId, array $attributes): array
    {
        $post = MemoryPost::findOrFail($postId);

        $comment = $post->comments()->create([
            'name' => $attributes['name'],
            'message' => $attributes['message'],
            'ip_address' => $attributes['ip_address'] ?? '',
            'user_agent' => $attributes['user_agent'] ?? '',
        ]);

        return $this->presentComment($comment);
    }

    public function presentPost(MemoryPost $post): array
    {
        return [
            'id' => (string) $post->id,
            'date' => $post->posted_at?->format('Y-m-d H:i:s'),
            'content' => $post->content,
            'images' => $post->images ?? [],
            'likes' => $post->likes,
        ];
    }

    public function presentComment(MemoryComment $comment): array
    {
        return [
            'id' => $comment->id,
            'post_id' => (string) $comment->memory_post_id,
            'name' => $comment->name,
            'message' => $comment->message,
            'created_at' => $comment->created_at?->format('Y-m-d H:i:s'),
            'ip_address' => $comment->ip_address,
            'user_agent' => $comment->user_agent,
        ];
    }
}

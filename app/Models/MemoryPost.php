<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A post on the Facebook-style /memorize timeline.
 */
class MemoryPost extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'posted_at' => 'datetime',
        'images' => 'array',
        'likes' => 'integer',
    ];

    public function comments()
    {
        return $this->hasMany(MemoryComment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoryComment extends Model
{
    protected $guarded = ['id'];

    public function post()
    {
        return $this->belongsTo(MemoryPost::class, 'memory_post_id');
    }
}

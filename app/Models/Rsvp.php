<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'guests' => 'integer',
        'edited_at' => 'datetime',
    ];

    public function wish()
    {
        return $this->hasOne(Wish::class);
    }

    /**
     * Keep token_hash (the indexed lookup key) in sync with the token.
     */
    public function setTokenAttribute(?string $value): void
    {
        $this->attributes['token'] = $value;
        $this->attributes['token_hash'] = $value ? hash('sha256', $value) : null;
    }

    public function scopeWhereToken(Builder $query, string $token): Builder
    {
        return $query->where('token_hash', hash('sha256', $token));
    }
}

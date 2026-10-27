<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * A guest the couple generated a personalized /invite/<token> link for.
 */
class Invite extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'first_opened_at' => 'datetime',
        'last_opened_at' => 'datetime',
        'open_count' => 'integer',
    ];

    /**
     * Keep token_hash (the indexed lookup key) in sync with the token.
     */
    public function setTokenAttribute(string $value): void
    {
        $this->attributes['token'] = $value;
        $this->attributes['token_hash'] = hash('sha256', $value);
    }

    public function scopeWhereToken(Builder $query, string $token): Builder
    {
        return $query->where('token_hash', hash('sha256', $token));
    }
}

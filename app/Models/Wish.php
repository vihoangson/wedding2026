<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A guest's wish sent along with their RSVP; shown on the invite page
 * once approved (active) from the dashboard.
 */
class Wish extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function rsvp()
    {
        return $this->belongsTo(Rsvp::class);
    }
}

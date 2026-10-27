<?php

namespace App\Services;

use App\Models\Rsvp;
use App\Models\Wish;
use Illuminate\Support\Facades\DB;

/**
 * RSVPs (rsvps table) and the guest wishes sent with them (wishes table).
 * Records are returned as plain arrays in the same shape the JSON store
 * used, so controllers, views and dashboard JS stay unchanged.
 */
class RsvpRepository
{
    /**
     * Persist an RSVP submission and its related wish.
     *
     * When $attributes['token'] (the guest's invite token) matches an earlier
     * RSVP, that RSVP is updated instead of adding a duplicate; its wish goes
     * back to pending approval if the message changed.
     *
     * Returns ['rsvp' => record, 'updated' => bool].
     */
    public function store(array $attributes): array
    {
        return DB::transaction(function () use ($attributes) {
            $token = $attributes['token'] ?? '';

            $fields = [
                'fullname' => $attributes['fullname'],
                'phone' => $attributes['phone'] ?? '',
                'guests' => $attributes['guests'],
                'attend' => $attributes['attend'],
                'message' => $attributes['message'] ?? '',
                'ip_address' => $attributes['ip_address'] ?? '',
                'user_agent' => $attributes['user_agent'] ?? '',
            ];

            $rsvp = $token !== '' ? Rsvp::whereToken($token)->lockForUpdate()->first() : null;
            $updated = $rsvp !== null;

            if ($updated) {
                $rsvp->fill($fields + ['edited_at' => now()])->save();
            } else {
                $rsvp = new Rsvp($fields);
                if ($token !== '') {
                    $rsvp->token = $token;
                }
                $rsvp->save();
            }

            $this->saveWishFor($rsvp);

            return ['rsvp' => $this->presentRsvp($rsvp), 'updated' => $updated];
        });
    }

    /**
     * The RSVP previously sent with this invite token, if any.
     */
    public function findByToken(string $token): ?array
    {
        $rsvp = Rsvp::whereToken($token)->first();

        return $rsvp ? $this->presentRsvp($rsvp) : null;
    }

    /**
     * Get every wish marked as active, for display on the invite page.
     */
    public function getActiveComments(): array
    {
        return Wish::where('active', true)->orderBy('id')->get()
            ->map(fn (Wish $wish) => $this->presentWish($wish))->all();
    }

    /**
     * Get every RSVP submission (used by the /dashboard admin panel).
     */
    public function getAllRsvp(): array
    {
        return Rsvp::orderBy('id')->get()
            ->map(fn (Rsvp $rsvp) => $this->presentRsvp($rsvp))->all();
    }

    /**
     * Get every wish, active or not (used by the /dashboard admin panel).
     */
    public function getAllComments(): array
    {
        return Wish::orderBy('id')->get()
            ->map(fn (Wish $wish) => $this->presentWish($wish))->all();
    }

    /**
     * Show/hide a wish on the invite page. Returns the updated wish,
     * or null if no wish has that id.
     */
    public function setCommentActive(string $id, bool $active): ?array
    {
        $wish = Wish::find($id);

        if (! $wish) {
            return null;
        }

        $wish->update(['active' => $active]);

        return $this->presentWish($wish);
    }

    /**
     * Permanently remove a wish. Returns false if no wish has that id.
     */
    public function deleteComment(string $id): bool
    {
        return Wish::whereKey($id)->delete() > 0;
    }

    /**
     * Create the wish for an RSVP, or update it when the RSVP is resent.
     */
    private function saveWishFor(Rsvp $rsvp): void
    {
        $wish = $rsvp->wish()->first() ?? new Wish(['rsvp_id' => $rsvp->id, 'active' => false]);

        if ($wish->exists && (string) $wish->message !== (string) $rsvp->message) {
            $wish->active = false;
        }

        $wish->fill([
            'name' => $rsvp->fullname,
            'message' => $rsvp->message,
            'sent_at' => now(),
            'ip_address' => $rsvp->ip_address,
            'user_agent' => $rsvp->user_agent,
        ])->save();
    }

    public function presentRsvp(Rsvp $rsvp): array
    {
        return [
            'id' => $rsvp->id,
            'token' => $rsvp->token,
            'timestamp' => $rsvp->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $rsvp->edited_at?->format('Y-m-d H:i:s'),
            'fullname' => $rsvp->fullname,
            'phone' => $rsvp->phone,
            'guests' => $rsvp->guests,
            'attend' => $rsvp->attend,
            'message' => (string) $rsvp->message,
            'ip_address' => $rsvp->ip_address,
            'user_agent' => $rsvp->user_agent,
        ];
    }

    public function presentWish(Wish $wish): array
    {
        return [
            'id' => $wish->id,
            'rsvp_id' => $wish->rsvp_id,
            'name' => $wish->name,
            'sent_at' => $wish->sent_at?->format('Y-m-d H:i:s'),
            'active' => $wish->active,
            'message' => (string) $wish->message,
            'ip_address' => $wish->ip_address,
            'user_agent' => $wish->user_agent,
        ];
    }
}

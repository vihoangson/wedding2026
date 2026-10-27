<?php

namespace App\Services;

use App\Models\Invite;

/**
 * The guests the couple has generated personalized /invite/<token> links
 * for from the dashboard (invites table).
 *
 * Tokens are deterministic (InviterCodec), so the token doubles as the
 * guest's id: generating a link for the same name twice is a no-op.
 */
class InviteRepository
{
    /**
     * Every invite, in the order they were added.
     */
    public function all(): array
    {
        return Invite::orderBy('id')->get()
            ->map(fn (Invite $invite) => $this->present($invite))->all();
    }

    /**
     * Add one invite per name (skipping names that already have one).
     * Returns ['created' => [...invites], 'existing' => [...invites]].
     */
    public function addNames(array $names, string $secretKey): array
    {
        $created = [];
        $existing = [];

        foreach ($names as $name) {
            $token = InviterCodec::encode($name, $secretKey);
            $invite = Invite::whereToken($token)->first();

            if ($invite) {
                $existing[] = $this->present($invite);
                continue;
            }

            $created[] = $this->present(Invite::create(['token' => $token, 'name' => $name]));
        }

        return ['created' => $created, 'existing' => $existing];
    }

    /**
     * Record that a guest opened their invitation. Links generated before
     * the guest list existed are added to the list on their first open.
     */
    public function recordOpen(string $token, string $name): void
    {
        $invite = Invite::whereToken($token)->first() ?? Invite::create(['token' => $token, 'name' => $name]);

        // increment() is a single atomic UPDATE, so concurrent opens aren't lost.
        $invite->increment('open_count', 1, [
            'first_opened_at' => $invite->first_opened_at ?? now(),
            'last_opened_at' => now(),
        ]);
    }

    /**
     * Remove an invite from the list. The link itself keeps working
     * (it is derived from the secret key), it just stops being tracked.
     */
    public function delete(string $token): bool
    {
        return Invite::whereToken($token)->delete() > 0;
    }

    public function present(Invite $invite): array
    {
        return [
            'token' => $invite->token,
            'name' => $invite->name,
            'created_at' => $invite->created_at?->format('Y-m-d H:i:s'),
            'first_opened_at' => $invite->first_opened_at?->format('Y-m-d H:i:s'),
            'last_opened_at' => $invite->last_opened_at?->format('Y-m-d H:i:s'),
            'open_count' => $invite->open_count,
        ];
    }
}

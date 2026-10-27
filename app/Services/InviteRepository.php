<?php

namespace App\Services;

/**
 * File-based store (data/invites.json) of the guests the couple has
 * generated personalized /invite/<token> links for from the dashboard.
 *
 * Tokens are deterministic (InviterCodec), so the token doubles as the
 * guest's id: generating a link for the same name twice is a no-op.
 */
class InviteRepository
{
    protected string $file;

    public function __construct()
    {
        $dataDir = base_path('data');
        $this->file = $dataDir.DIRECTORY_SEPARATOR.'invites.json';

        if (! is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
    }

    /**
     * Every invite, in the order they were added.
     */
    public function all(): array
    {
        if (! file_exists($this->file)) {
            return [];
        }

        $data = json_decode(file_get_contents($this->file), true);

        return $data['invites'] ?? [];
    }

    /**
     * Add one invite per name (skipping names that already have one).
     * Returns ['created' => [...invites], 'existing' => [...invites]].
     */
    public function addNames(array $names, string $secretKey): array
    {
        $invites = $this->all();
        $byToken = array_column($invites, null, 'token');
        $created = [];
        $existing = [];

        foreach ($names as $name) {
            $token = InviterCodec::encode($name, $secretKey);

            if (isset($byToken[$token])) {
                $existing[] = $byToken[$token];
                continue;
            }

            $invite = [
                'token' => $token,
                'name' => $name,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ];

            $invites[] = $invite;
            $byToken[$token] = $invite;
            $created[] = $invite;
        }

        if ($created) {
            $this->write($invites);
        }

        return ['created' => $created, 'existing' => $existing];
    }

    /**
     * Remove an invite from the list. The link itself keeps working
     * (it is derived from the secret key), it just stops being tracked.
     */
    public function delete(string $token): bool
    {
        $invites = $this->all();
        $remaining = array_values(array_filter($invites, fn ($invite) => $invite['token'] !== $token));

        if (count($remaining) === count($invites)) {
            return false;
        }

        $this->write($remaining);

        return true;
    }

    protected function write(array $invites): void
    {
        $payload = [
            'total_invites' => count($invites),
            'last_updated' => now()->format('Y-m-d H:i:s'),
            'invites' => $invites,
        ];

        file_put_contents(
            $this->file,
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }
}

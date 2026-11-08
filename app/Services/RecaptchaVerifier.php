<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Server-side check of a Google reCAPTCHA v3 token.
 * Disabled (always passes) while RECAPTCHA_SECRET_KEY is not set.
 */
class RecaptchaVerifier
{
    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function enabled(): bool
    {
        return (string) config('services.recaptcha.secret_key') !== ''
            && (string) config('services.recaptcha.site_key') !== '';
    }

    public function verify(?string $token, string $expectedAction, ?string $ip = null): bool
    {
        if (! $this->enabled()) {
            return true;
        }

        if ($token === null || $token === '') {
            return false;
        }

        try {
            $result = Http::asForm()->timeout(5)->post(self::VERIFY_URL, array_filter([
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => $ip,
            ]))->json();
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA verify request failed: '.$e->getMessage());

            return false;
        }

        return ($result['success'] ?? false) === true
            && ($result['action'] ?? null) === $expectedAction
            && (float) ($result['score'] ?? 0) >= (float) config('services.recaptcha.min_score', 0.5);
    }
}

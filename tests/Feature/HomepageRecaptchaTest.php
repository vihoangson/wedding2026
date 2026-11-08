<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomepageRecaptchaTest extends TestCase
{
    use RefreshDatabase;

    private function enableRecaptcha(): void
    {
        config([
            'services.recaptcha.site_key' => 'site-key-test',
            'services.recaptcha.secret_key' => 'secret-key-test',
            'services.recaptcha.min_score' => 0.5,
        ]);
    }

    private function rsvpPayload(array $extra = []): array
    {
        return array_merge([
            'fullname' => 'Khách Test',
            'guests' => 2,
            'attend' => 'yes',
        ], $extra);
    }

    public function test_homepage_shows_the_invitation_without_recaptcha_script_when_disabled()
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('id="rsvpForm"', false)
            ->assertDontSee('recaptcha/api.js', false);
    }

    public function test_homepage_loads_recaptcha_when_keys_are_set()
    {
        $this->enableRecaptcha();

        $this->get('/')
            ->assertOk()
            ->assertSee('recaptcha/api.js?render=site-key-test', false);
    }

    public function test_rsvp_works_without_token_when_recaptcha_disabled()
    {
        Http::fake();

        $this->postJson('/api/rsvp', $this->rsvpPayload())->assertOk()->assertJson(['success' => true]);
        Http::assertNothingSent();
    }

    public function test_rsvp_rejected_without_token_when_recaptcha_enabled()
    {
        $this->enableRecaptcha();
        Http::fake();

        $this->postJson('/api/rsvp', $this->rsvpPayload())->assertStatus(422)->assertJson(['success' => false]);
    }

    public function test_rsvp_rejected_on_low_score()
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/*' => Http::response(['success' => true, 'action' => 'rsvp', 'score' => 0.1])]);

        $this->postJson('/api/rsvp', $this->rsvpPayload(['recaptcha_token' => 'abc']))->assertStatus(422);
    }

    public function test_rsvp_accepted_with_valid_token()
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/*' => Http::response(['success' => true, 'action' => 'rsvp', 'score' => 0.9])]);

        $this->postJson('/api/rsvp', $this->rsvpPayload(['recaptcha_token' => 'abc']))
            ->assertOk()
            ->assertJson(['success' => true]);

        Http::assertSent(fn ($request) => $request['secret'] === 'secret-key-test' && $request['response'] === 'abc');
    }
}

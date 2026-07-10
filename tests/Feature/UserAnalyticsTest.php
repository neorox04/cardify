<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\CardEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private function subscribedUser(array $attrs = []): User
    {
        $user = User::factory()->create(array_merge(['is_active' => true, 'type' => 'user'], $attrs));
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);

        return $user;
    }

    private function card(User $user): BusinessCard
    {
        return BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => 'c@example.com',
            'slug'      => 'card-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);
    }

    // ── Event logging on public routes ────────────────────────────────────

    public function test_public_view_logs_view_event(): void
    {
        $user = $this->subscribedUser();
        $card = $this->card($user);

        $this->get('/card/' . $card->slug . '?src=nfc');

        $event = CardEvent::where('business_card_id', $card->id)->where('type', 'view')->first();
        $this->assertNotNull($event);
        $this->assertEquals('nfc', $event->channel);
    }

    public function test_scan_route_logs_scan_event_defaulting_to_qr(): void
    {
        $user = $this->subscribedUser();
        $card = $this->card($user);

        $this->get('/card/' . $card->slug . '/save');

        $this->assertDatabaseHas('card_events', [
            'business_card_id' => $card->id,
            'type'             => 'scan',
            'channel'          => 'qr',
        ]);
    }

    public function test_vcard_logs_save_event(): void
    {
        $user = $this->subscribedUser();
        $card = $this->card($user);

        $this->get('/card/' . $card->slug . '/vcard');

        $this->assertDatabaseHas('card_events', [
            'business_card_id' => $card->id,
            'type'             => 'save',
        ]);
    }

    public function test_lapsed_card_does_not_log_events(): void
    {
        // Owner with no subscription — card is gated, nothing should log.
        $user = User::factory()->create(['is_active' => true]);
        $card = $this->card($user);

        $this->get('/card/' . $card->slug);

        $this->assertDatabaseCount('card_events', 0);
    }

    // ── Analytics page ────────────────────────────────────────────────────

    public function test_analytics_page_renders(): void
    {
        $user = $this->subscribedUser();
        $card = $this->card($user);
        $card->forceFill(['views_count' => 40, 'qr_scans' => 20, 'contacts_saved' => 8])->save();
        CardEvent::create(['business_card_id' => $card->id, 'type' => 'scan', 'channel' => 'qr']);

        $response = $this->actingAs($user)->get('/user/analytics');
        $response->assertStatus(200)
            ->assertSee('O meu Analytics')
            ->assertSee('Taxa de conversão')
            ->assertSee('Canal de partilha');
    }

    public function test_analytics_conversion_and_totals(): void
    {
        $user = $this->subscribedUser();
        $c1 = $this->card($user); $c1->forceFill(['qr_scans' => 100, 'contacts_saved' => 25, 'views_count' => 200])->save();
        $c2 = $this->card($user); $c2->forceFill(['qr_scans' => 0, 'contacts_saved' => 0, 'views_count' => 10])->save();

        // 125 saves? no: 25 saves / 100 scans = 25%
        $this->actingAs($user)->get('/user/analytics')
            ->assertStatus(200)
            ->assertSee('25,0%');
    }

    public function test_analytics_requires_auth(): void
    {
        $this->get('/user/analytics')->assertRedirect('/login');
    }
}

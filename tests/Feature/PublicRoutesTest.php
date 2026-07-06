<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user with an active subscription (card owners must be subscribed
     * for their cards to stay publicly available).
     */
    private function subscribedUser(array $attrs = []): User
    {
        $user = User::factory()->create($attrs);
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_test_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);

        return $user;
    }

    // -------------------------------------------------------------------------
    // Welcome / Landing page
    // -------------------------------------------------------------------------

    public function test_welcome_page_returns_200(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_privacidade_page_returns_200(): void
    {
        $response = $this->get('/privacidade');

        $response->assertStatus(200);
    }

    public function test_termos_page_returns_200(): void
    {
        $response = $this->get('/termos');

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Cartão público
    // -------------------------------------------------------------------------

    public function test_public_card_is_accessible_by_slug(): void
    {
        $user = $this->subscribedUser();
        $card = BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => 'test-public-card',
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $response = $this->get('/card/test-public-card');

        $response->assertStatus(200);
    }

    public function test_public_card_unavailable_when_owner_not_subscribed(): void
    {
        // Owner has NO subscription — card must not be served.
        $user = User::factory()->create();
        BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => 'lapsed-card',
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $response = $this->get('/card/lapsed-card');

        $response->assertStatus(404);
        $response->assertSee('Este cartão não está disponível');
    }

    public function test_lapsed_card_does_not_increment_views(): void
    {
        $user = User::factory()->create();
        $card = BusinessCard::create([
            'user_id'     => $user->id,
            'full_name'   => $user->name,
            'email'       => $user->email,
            'slug'        => 'lapsed-no-views',
            'is_public'   => true,
            'is_active'   => true,
            'theme'       => 'default',
            'views_count' => 0,
        ]);

        $this->get('/card/lapsed-no-views');

        $this->assertEquals(0, $card->fresh()->views_count);
    }

    public function test_private_card_returns_404(): void
    {
        $user = User::factory()->create();
        BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => 'private-card',
            'is_public' => false,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $response = $this->get('/card/private-card');

        $response->assertStatus(404);
    }

    public function test_inactive_card_returns_404(): void
    {
        $user = User::factory()->create();
        BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => 'inactive-card',
            'is_public' => true,
            'is_active' => false,
            'theme'     => 'default',
        ]);

        $response = $this->get('/card/inactive-card');

        $response->assertStatus(404);
    }

    public function test_nonexistent_card_returns_404(): void
    {
        $response = $this->get('/card/this-slug-does-not-exist');

        $response->assertStatus(404);
    }

    public function test_public_card_increments_views_count(): void
    {
        $user = $this->subscribedUser();
        $card = BusinessCard::create([
            'user_id'     => $user->id,
            'full_name'   => $user->name,
            'email'       => $user->email,
            'slug'        => 'view-counter-card',
            'is_public'   => true,
            'is_active'   => true,
            'theme'       => 'default',
            'views_count' => 0,
        ]);

        $this->get('/card/view-counter-card');

        $this->assertEquals(1, $card->fresh()->views_count);
    }

    // -------------------------------------------------------------------------
    // vCard download
    // -------------------------------------------------------------------------

    public function test_vcard_download_returns_vcf_content(): void
    {
        $user = $this->subscribedUser(['name' => 'João Silva']);
        $card = BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => 'João Silva',
            'email'     => 'joao@example.com',
            'slug'      => 'joao-silva',
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $response = $this->get("/card/{$card->slug}/vcard");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/vcard; charset=UTF-8');
        $this->assertStringContainsString('BEGIN:VCARD', $response->getContent());
        $this->assertStringContainsString('END:VCARD', $response->getContent());
        $this->assertStringContainsString('João Silva', $response->getContent());
    }

    // -------------------------------------------------------------------------
    // Dashboard redireciona se não autenticado
    // -------------------------------------------------------------------------

    public function test_dashboard_redirects_guest_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}

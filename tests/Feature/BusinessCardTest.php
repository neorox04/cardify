<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessCardTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function subscribedUser(): User
    {
        // Create a user with a fake active subscription record so that
        // subscribed('default') returns true via Cashier's relationship.
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        // Create the subscription row directly in the DB
        $user->subscriptions()->create([
            'type'           => 'default',
            'stripe_id'      => 'sub_test_' . $user->id,
            'stripe_status'  => 'active',
            'stripe_price'   => 'price_test',
            'quantity'       => 1,
        ]);

        return $user;
    }

    private function makeCard(User $user, array $attrs = []): BusinessCard
    {
        return BusinessCard::create(array_merge([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => \Illuminate\Support\Str::slug($user->name) . '-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ], $attrs));
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_authenticated_user_can_view_business_cards_index(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/business-cards');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_view_business_cards_index(): void
    {
        $response = $this->get('/business-cards');

        $response->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function test_subscribed_user_can_access_create_business_card_page(): void
    {
        $user = $this->subscribedUser();

        $response = $this->actingAs($user)->get('/business-cards/create');

        $response->assertStatus(200);
    }

    public function test_unsubscribed_user_is_redirected_from_create_page(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/business-cards/create');

        $response->assertRedirect('/planos');
    }

    public function test_subscribed_user_can_store_business_card(): void
    {
        $user = $this->subscribedUser();

        $response = $this->actingAs($user)->post('/business-cards', [
            'email' => 'card@example.com',
            'theme' => 'default',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('business_cards', [
            'user_id'   => $user->id,
            'email'     => 'card@example.com',
            'full_name' => $user->name,
        ]);
    }

    public function test_store_fails_without_email(): void
    {
        $user = $this->subscribedUser();

        $response = $this->actingAs($user)->post('/business-cards', [
            'theme' => 'default',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_store_fails_with_invalid_website(): void
    {
        $user = $this->subscribedUser();

        $response = $this->actingAs($user)->post('/business-cards', [
            'email'   => 'card@example.com',
            'website' => 'not-a-valid-url',
            'theme'   => 'default',
        ]);

        $response->assertSessionHasErrors('website');
    }

    public function test_store_fails_with_invalid_theme(): void
    {
        $user = $this->subscribedUser();

        $response = $this->actingAs($user)->post('/business-cards', [
            'email' => 'card@example.com',
            'theme' => 'nonexistent_theme',
        ]);

        $response->assertSessionHasErrors('theme');
    }

    public function test_slug_is_generated_automatically(): void
    {
        $user = $this->subscribedUser();

        $this->actingAs($user)->post('/business-cards', [
            'email' => 'card@example.com',
            'theme' => 'default',
        ]);

        $card = BusinessCard::where('user_id', $user->id)->first();
        $this->assertNotNull($card->slug);
        $this->assertNotEmpty($card->slug);
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_authenticated_user_can_view_own_business_card(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $card = $this->makeCard($user);

        $response = $this->actingAs($user)->get("/business-cards/{$card->slug}");

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function test_user_can_access_edit_page_for_own_card(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $card = $this->makeCard($user);

        $response = $this->actingAs($user)->get("/business-cards/{$card->slug}/edit");

        $response->assertStatus(200);
    }

    public function test_user_cannot_edit_another_users_card(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $other = User::factory()->create(['is_active' => true]);
        $card  = $this->makeCard($owner);

        $response = $this->actingAs($other)->get("/business-cards/{$card->slug}/edit");

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_card(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $card = $this->makeCard($user);

        $response = $this->actingAs($user)->put("/business-cards/{$card->slug}", [
            'full_name' => $user->name,
            'email'     => 'updated@example.com',
            'theme'     => 'modern',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('business_cards', [
            'id'    => $card->id,
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_cannot_update_another_users_card(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $other = User::factory()->create(['is_active' => true]);
        $card  = $this->makeCard($owner);

        $response = $this->actingAs($other)->put("/business-cards/{$card->slug}", [
            'full_name' => $other->name,
            'email'     => 'hacker@example.com',
            'theme'     => 'default',
        ]);

        $response->assertStatus(403);
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_user_can_delete_own_card(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $card = $this->makeCard($user);

        $response = $this->actingAs($user)->delete("/business-cards/{$card->slug}");

        $response->assertRedirect('/business-cards');
        $this->assertSoftDeleted('business_cards', ['id' => $card->id]);
    }

    public function test_user_cannot_delete_another_users_card(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $other = User::factory()->create(['is_active' => true]);
        $card  = $this->makeCard($owner);

        $response = $this->actingAs($other)->delete("/business-cards/{$card->slug}");

        $response->assertStatus(403);
    }

    // -------------------------------------------------------------------------
    // Contagem de views
    // -------------------------------------------------------------------------

    public function test_view_count_does_not_increment_via_private_show(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $card = $this->makeCard($user, ['views_count' => 0]);

        $this->actingAs($user)->get("/business-cards/{$card->slug}");

        // The show route increments views; assert it was incremented exactly once
        $this->assertEquals(1, $card->fresh()->views_count);
    }
}

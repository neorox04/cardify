<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserProfileTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::factory()->create(['type' => 'super_admin', 'is_active' => true]);
    }

    private function subscribe(User $user): void
    {
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);
    }

    public function test_users_list_shows_subscription_status(): void
    {
        $admin = $this->superAdmin();
        $subbed = User::factory()->create(['is_active' => true, 'name' => 'Subbed Sue']);
        $this->subscribe($subbed);
        User::factory()->create(['is_active' => true, 'name' => 'Free Fred']);

        $this->actingAs($admin)->get('/admin/users')
            ->assertStatus(200)
            ->assertSee('Subscrição')
            ->assertSee('Ativa')
            ->assertSee('Sem sub');
    }

    public function test_admin_user_profile_renders_with_stats(): void
    {
        $admin  = $this->superAdmin();
        $target = User::factory()->create(['is_active' => true, 'name' => 'Target Tom']);
        $this->subscribe($target);
        $card = BusinessCard::create([
            'user_id'   => $target->id,
            'full_name' => 'Target Tom',
            'email'     => 't@example.com',
            'slug'      => 'tom-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);
        $card->forceFill(['views_count' => 50, 'qr_scans' => 20, 'contacts_saved' => 5])->save();

        $this->actingAs($admin)->get(route('admin.users.show', $target))
            ->assertStatus(200)
            ->assertSee('Target Tom')
            ->assertSee('Estatísticas gerais')
            ->assertSee('Subscrição')
            ->assertSee('50'); // total views
    }

    public function test_non_super_admin_cannot_view_user_profile(): void
    {
        $user   = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $target = User::factory()->create(['is_active' => true]);

        $this->actingAs($user)->get(route('admin.users.show', $target))->assertStatus(403);
    }
}

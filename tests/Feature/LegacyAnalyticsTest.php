<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private function subscribe(User $user, string $priceKey, int $qty = 1): void
    {
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config("services.stripe.prices.$priceKey"),
            'quantity'      => $qty,
        ]);
    }

    public function test_monthly_subscription_counts_as_monthly_not_annual(): void
    {
        $admin = User::factory()->create(['type' => 'super_admin', 'is_active' => true]);

        $monthly = User::factory()->create(['is_active' => true]);
        $this->subscribe($monthly, 'individual_monthly');

        $response = $this->actingAs($admin)->get('/admin/analytics');

        $response->assertStatus(200)
            ->assertSee('1 mensais')   // classified as monthly
            ->assertSee('0 anuais');   // not annual
    }

    public function test_annual_subscription_counts_as_annual(): void
    {
        $admin = User::factory()->create(['type' => 'super_admin', 'is_active' => true]);

        $annual = User::factory()->create(['is_active' => true]);
        $this->subscribe($annual, 'individual_yearly');

        $this->actingAs($admin)->get('/admin/analytics')
            ->assertStatus(200)
            ->assertSee('0 mensais')
            ->assertSee('1 anuais');
    }
}

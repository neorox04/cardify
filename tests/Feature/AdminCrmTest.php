<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminCrmTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::factory()->create([
            'is_active' => true,
            'type'      => 'super_admin',
        ]);
    }

    public function test_guest_cannot_access_crm(): void
    {
        $this->get('/admin/crm')->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_crm(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $this->actingAs($user)->get('/admin/crm')->assertStatus(403);
    }

    public function test_super_admin_can_access_crm(): void
    {
        $response = $this->actingAs($this->superAdmin())->get('/admin/crm');
        $response->assertStatus(200);
        $response->assertSee('Visão geral do negócio');
        $response->assertSee('Dados reais');
    }

    public function test_crm_loads_with_no_data(): void
    {
        // Empty DB (only the admin) must not divide-by-zero or crash.
        $this->actingAs($this->superAdmin())->get('/admin/crm')->assertStatus(200);
    }

    public function test_mrr_reflects_individual_monthly_subscription(): void
    {
        $admin = $this->superAdmin();
        $customer = User::factory()->create(['stripe_id' => 'cus_test1']);

        DB::table('subscriptions')->insert([
            'user_id'       => $customer->id,
            'type'          => 'default',
            'stripe_id'     => 'sub_test1',
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
            'created_at'    => now()->subDays(5),
            'updated_at'    => now()->subDays(5),
        ]);

        $response = $this->actingAs($admin)->get('/admin/crm');
        $response->assertStatus(200);
        // €10/month individual plan → MRR shows €10
        $response->assertSee('€10');
    }

    public function test_mrr_reflects_company_seats_with_tier_pricing(): void
    {
        $admin = $this->superAdmin();
        $customer = User::factory()->create(['stripe_id' => 'cus_test2']);

        // 20 seats → tier 1 (€9.50/seat) → 20 * 9.50 = €190
        DB::table('subscriptions')->insert([
            'user_id'       => $customer->id,
            'type'          => 'default',
            'stripe_id'     => 'sub_test2',
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.company'),
            'quantity'      => 20,
            'created_at'    => now()->subDays(5),
            'updated_at'    => now()->subDays(5),
        ]);

        $response = $this->actingAs($admin)->get('/admin/crm');
        $response->assertStatus(200);
        $response->assertSee('€190');
    }
}

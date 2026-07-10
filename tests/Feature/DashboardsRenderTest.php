<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Smoke tests: the dashboards touched by the single-account refactor must
 * still render (no orphaned variables/routes after removing invites/members).
 */
class DashboardsRenderTest extends TestCase
{
    use RefreshDatabase;

    private function subscribe(User $user, string $priceKey = 'individual_monthly', int $qty = 1): void
    {
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config("services.stripe.prices.$priceKey"),
            'quantity'      => $qty,
        ]);
    }

    public function test_user_dashboard_renders(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $this->actingAs($user)->get('/user/dashboard')->assertStatus(200);
    }

    public function test_company_dashboard_and_show_render(): void
    {
        $admin = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);
        $this->subscribe($admin, 'company', 5);

        $company = Company::create(['name' => 'Acme', 'slug' => 'acme', 'is_active' => true]);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);

        // /company/dashboard redirects to the company's page when one exists.
        $this->actingAs($admin)->get('/company/dashboard')
            ->assertRedirect(route('company.show', $company));
        $this->actingAs($admin)->get('/company/' . $company->slug)
            ->assertStatus(200)
            ->assertSee('Seats usados');
    }

    public function test_admin_users_and_companies_render(): void
    {
        $admin = User::factory()->create(['is_active' => true, 'type' => 'super_admin']);
        $company = Company::create(['name' => 'Acme', 'slug' => 'acme', 'is_active' => true]);

        $this->actingAs($admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/companies')->assertStatus(200);
    }
}

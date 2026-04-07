<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Rotas protegidas por autenticação
    // -------------------------------------------------------------------------

    public function test_guest_cannot_access_user_dashboard(): void
    {
        $response = $this->get('/user/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_company_dashboard(): void
    {
        $response = $this->get('/company/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_planos_page(): void
    {
        $response = $this->get('/planos');

        $response->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Middleware active.user — conta desativada
    // -------------------------------------------------------------------------

    public function test_inactive_user_is_logged_out_and_blocked(): void
    {
        $inactiveUser = User::factory()->create([
            'is_active' => false,
            'type'      => 'user',
        ]);

        $response = $this->actingAs($inactiveUser)->get('/user/dashboard');

        // EnsureUserIsActive logs the user out and redirects to /login
        $response->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Super Admin middleware
    // -------------------------------------------------------------------------

    public function test_regular_user_cannot_access_admin_area(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_company_admin_cannot_access_super_admin_area(): void
    {
        $admin = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_admin_dashboard(): void
    {
        $superAdmin = User::factory()->create([
            'is_active' => true,
            'type'      => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_access_admin_users_list(): void
    {
        $superAdmin = User::factory()->create([
            'is_active' => true,
            'type'      => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_access_admin_companies_list(): void
    {
        $superAdmin = User::factory()->create([
            'is_active' => true,
            'type'      => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get('/admin/companies');

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Company Admin middleware
    // -------------------------------------------------------------------------

    public function test_regular_user_cannot_access_company_create(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/company/create');

        $response->assertStatus(403);
    }

    public function test_company_admin_can_access_company_create(): void
    {
        $admin = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);

        $response = $this->actingAs($admin)->get('/company/create');

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Dashboard role-based redirect
    // -------------------------------------------------------------------------

    public function test_super_admin_dashboard_redirects_to_admin(): void
    {
        $superAdmin = User::factory()->create([
            'is_active' => true,
            'type'      => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_company_admin_dashboard_redirects_to_company(): void
    {
        $admin = User::factory()->create([
            'is_active' => true,
            'type'      => 'company_admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect(route('company.dashboard'));
    }

    public function test_regular_user_dashboard_redirects_to_user_dashboard(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
            'type'      => 'user',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('user.dashboard'));
    }
}

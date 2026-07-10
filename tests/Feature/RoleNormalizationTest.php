<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleNormalizationTest extends TestCase
{
    use RefreshDatabase;

    private function companyOwner(): User
    {
        $admin   = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);
        $company = Company::create(['name' => 'Acme', 'slug' => 'acme-' . uniqid(), 'is_active' => true]);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);

        return $admin;
    }

    // ── isCompanyAdmin is ownership-based, not flag-based ──────────────────

    public function test_stale_company_admin_flag_is_not_treated_as_company_admin(): void
    {
        $user = User::factory()->create(['type' => 'company_admin']); // no company owned
        $this->assertFalse($user->isCompanyAdmin());
    }

    public function test_real_company_owner_is_company_admin(): void
    {
        $this->assertTrue($this->companyOwner()->isCompanyAdmin());
    }

    public function test_stale_company_admin_lands_on_user_dashboard(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);
        $this->actingAs($user)->get('/dashboard')->assertRedirect(route('user.dashboard'));
    }

    // ── Cleanup command ────────────────────────────────────────────────────

    public function test_normalize_command_resets_only_stale_flags(): void
    {
        $stale  = User::factory()->create(['type' => 'company_admin']); // no company
        $owner  = $this->companyOwner();                                // real owner
        $normal = User::factory()->create(['type' => 'user']);

        $this->artisan('cardify:normalize-roles')
            ->expectsOutputToContain('Reset 1')
            ->assertSuccessful();

        $this->assertEquals('user', $stale->fresh()->type);
        $this->assertEquals('company_admin', $owner->fresh()->type);
        $this->assertEquals('user', $normal->fresh()->type);
    }

    public function test_normalize_dry_run_changes_nothing(): void
    {
        $stale = User::factory()->create(['type' => 'company_admin']);

        $this->artisan('cardify:normalize-roles --dry-run')->assertSuccessful();

        $this->assertEquals('company_admin', $stale->fresh()->type);
    }
}

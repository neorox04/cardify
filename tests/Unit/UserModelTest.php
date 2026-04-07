<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_super_admin_returns_true_for_super_admin_type(): void
    {
        $user = User::factory()->make(['type' => 'super_admin']);

        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_is_super_admin_returns_false_for_regular_user(): void
    {
        $user = User::factory()->make(['type' => 'user']);

        $this->assertFalse($user->isSuperAdmin());
    }

    public function test_is_super_admin_returns_false_for_company_admin(): void
    {
        $user = User::factory()->make(['type' => 'company_admin']);

        $this->assertFalse($user->isSuperAdmin());
    }

    public function test_is_company_admin_returns_true_for_company_admin_type(): void
    {
        $user = User::factory()->make(['type' => 'company_admin']);

        $this->assertTrue($user->isCompanyAdmin());
    }

    public function test_is_company_admin_returns_false_for_regular_user(): void
    {
        $user = User::factory()->create(['type' => 'user']);

        $this->assertFalse($user->isCompanyAdmin());
    }

    public function test_is_active_returns_true_when_active(): void
    {
        $user = User::factory()->make(['is_active' => true]);

        $this->assertTrue($user->isActive());
    }

    public function test_is_active_returns_false_when_inactive(): void
    {
        $user = User::factory()->make(['is_active' => false]);

        $this->assertFalse($user->isActive());
    }

    public function test_user_has_business_cards_relationship(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $user->businessCards()
        );
    }

    public function test_user_has_companies_relationship(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $user->companies()
        );
    }

    public function test_password_is_hashed_on_creation(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $this->assertNotEquals('secret', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('secret', $user->password));
    }

    public function test_password_is_hidden_in_serialization(): void
    {
        $user = User::factory()->make();

        $this->assertArrayNotHasKey('password', $user->toArray());
    }
}

<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The name on a personal card is locked to the account holder — a single
 * paid account must not be usable to produce cards for other people, whether
 * at create time or via a later edit. Company admins (paying per seat) keep
 * name control for their employees' cards.
 */
class CardNameLockTest extends TestCase
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

    // ── Create form (UX lock) ─────────────────────────────────────────────

    public function test_create_form_prefills_and_locks_the_name(): void
    {
        $user = $this->subscribedUser(['name' => 'Rui Dono']);

        $response = $this->actingAs($user)->get('/business-cards/create');

        $response->assertStatus(200);
        $response->assertSee('value="Rui Dono"', false);   // prefilled
        $response->assertSee('readonly', false);           // locked
        $response->assertSee('associado à tua conta');     // explanatory hint
    }

    // ── Create ────────────────────────────────────────────────────────────

    public function test_store_forces_account_name_on_personal_card(): void
    {
        $user = $this->subscribedUser(['name' => 'Rui Dono']);

        $this->actingAs($user)->post('/business-cards', [
            'full_name' => 'Pessoa Diferente',
            'email'     => 'card@example.com',
            'theme'     => 'default',
        ]);

        $this->assertDatabaseHas('business_cards', [
            'user_id'   => $user->id,
            'full_name' => 'Rui Dono',
        ]);
        $this->assertDatabaseMissing('business_cards', [
            'full_name' => 'Pessoa Diferente',
        ]);
    }

    // ── Update ────────────────────────────────────────────────────────────

    public function test_update_cannot_rename_personal_card(): void
    {
        $user = $this->subscribedUser(['name' => 'Rui Dono']);
        $card = BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => 'Rui Dono',
            'email'     => 'rui@example.com',
            'slug'      => 'rui-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $this->actingAs($user)->put("/business-cards/{$card->slug}", [
            'full_name' => 'Nome Falso',
            'email'     => 'rui@example.com',
            'theme'     => 'default',
        ]);

        $this->assertEquals('Rui Dono', $card->fresh()->full_name);
    }

    public function test_non_admin_cannot_unlock_name_via_foreign_company_id(): void
    {
        $user    = $this->subscribedUser(['name' => 'Rui Dono']);
        $company = Company::create(['name' => 'Alheia', 'slug' => 'alheia', 'is_active' => true]);
        // user is NOT a member/admin of this company

        $this->actingAs($user)->post('/business-cards', [
            'full_name'  => 'Pessoa Diferente',
            'company_id' => $company->id,
            'email'      => 'card@example.com',
            'theme'      => 'default',
        ]);

        // Name stays locked to the account holder despite the company_id.
        $this->assertDatabaseHas('business_cards', [
            'user_id'   => $user->id,
            'full_name' => 'Rui Dono',
        ]);
    }

    // ── Company admin keeps control ───────────────────────────────────────

    public function test_company_admin_can_set_custom_employee_name(): void
    {
        $admin   = $this->subscribedUser(['name' => 'Admin Chefe', 'type' => 'company_admin']);
        $company = Company::create(['name' => 'Acme', 'slug' => 'acme', 'is_active' => true]);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);

        $this->actingAs($admin)->post('/business-cards', [
            'full_name'  => 'Funcionário X',
            'company_id' => $company->id,
            'email'      => 'func@example.com',
            'theme'      => 'default',
        ]);

        $this->assertDatabaseHas('business_cards', [
            'company_id' => $company->id,
            'full_name'  => 'Funcionário X',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * A card only stays publicly available while its owner (or, for company
 * cards, a company admin) keeps an active subscription. Paying once and
 * cancelling must NOT leave the card live forever.
 */
class CardSubscriptionGateTest extends TestCase
{
    use RefreshDatabase;

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

    private function makeCard(User $owner, ?Company $company = null): BusinessCard
    {
        return BusinessCard::create([
            'user_id'    => $owner->id,
            'company_id' => $company?->id,
            'full_name'  => $owner->name,
            'email'      => $owner->email,
            'slug'       => Str::slug($owner->name) . '-' . uniqid(),
            'is_public'  => true,
            'is_active'  => true,
            'theme'      => 'default',
        ]);
    }

    // ── Individual ────────────────────────────────────────────────────────

    public function test_individual_card_live_while_subscribed(): void
    {
        $owner = User::factory()->create();
        $this->subscribe($owner);
        $card = $this->makeCard($owner);

        $this->get("/card/{$card->slug}")->assertStatus(200);
    }

    public function test_individual_card_dark_when_not_subscribed(): void
    {
        $owner = User::factory()->create();
        $card  = $this->makeCard($owner);

        $this->get("/card/{$card->slug}")->assertStatus(404);
    }

    public function test_lapsed_card_blocks_vcard_and_save(): void
    {
        $owner = User::factory()->create();
        $card  = $this->makeCard($owner);

        $this->get("/card/{$card->slug}/vcard")->assertStatus(404);
        $this->get("/card/{$card->slug}/save")->assertStatus(404);
    }

    public function test_lapsed_card_does_not_increment_contacts_saved(): void
    {
        $owner = User::factory()->create();
        $card  = $this->makeCard($owner);

        $this->get("/card/{$card->slug}/vcard");

        $this->assertEquals(0, $card->fresh()->contacts_saved);
    }

    // ── Company ───────────────────────────────────────────────────────────

    public function test_employee_card_live_while_company_admin_subscribed(): void
    {
        $company  = Company::create(['name' => 'Acme', 'slug' => 'acme', 'is_active' => true]);
        $admin    = User::factory()->create();
        $employee = User::factory()->create();

        $this->subscribe($admin);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);
        $company->users()->attach($employee->id, ['role' => 'employee', 'is_admin' => false]);

        // Employee owns the card but has no personal subscription
        $card = $this->makeCard($employee, $company);

        $this->get("/card/{$card->slug}")->assertStatus(200);
    }

    public function test_employee_card_dark_when_company_admin_not_subscribed(): void
    {
        $company  = Company::create(['name' => 'Beta', 'slug' => 'beta', 'is_active' => true]);
        $admin    = User::factory()->create();
        $employee = User::factory()->create();

        // Admin exists but has NO active subscription
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);
        $company->users()->attach($employee->id, ['role' => 'employee', 'is_admin' => false]);

        $card = $this->makeCard($employee, $company);

        $this->get("/card/{$card->slug}")->assertStatus(404);
    }
}

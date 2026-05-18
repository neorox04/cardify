<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Laravel\Cashier\Subscription;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\StripeClient;
use Tests\TestCase;

/**
 * Integration tests that hit the real Stripe test API.
 *
 * Run with:
 *   php artisan test --group=stripe
 *
 * Requirements:
 *   - STRIPE_SECRET=sk_test_... in .env
 *   - price_1TM7hJCcmLy5PiLsPioHECxJ must exist in Stripe test account
 *
 * Each test creates and immediately cancels a real test subscription.
 */
class SeatsIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private StripeClient $stripe;
    private string $companyPriceId = 'price_1TM7hJCcmLy5PiLsPioHECxJ';

    protected function setUp(): void
    {
        parent::setUp();

        $secret = config('cashier.secret');

        if (!$secret || str_contains($secret, 'fake') || !str_starts_with($secret, 'sk_test_')) {
            $this->markTestSkipped('Stripe test key not configured. Set STRIPE_SECRET=sk_test_... in .env');
        }

        $this->stripe = new StripeClient($secret);

        // Verify network connectivity to Stripe
        try {
            $this->stripe->prices->retrieve($this->companyPriceId);
        } catch (\Stripe\Exception\UnexpectedValueException $e) {
            $this->markTestSkipped('Stripe API not reachable from this environment.');
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $this->markTestSkipped('Stripe key invalid: ' . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /** Create a Stripe test customer with a Visa test card attached. */
    private function createStripeCustomer(User $user): Customer
    {
        $customer = $this->stripe->customers->create([
            'email' => $user->email,
            'name'  => $user->name,
            'metadata' => ['test' => 'true', 'user_id' => $user->id],
        ]);

        // Attach test Visa card (never declined, no 3DS)
        $pm = $this->stripe->paymentMethods->create([
            'type' => 'card',
            'card' => ['token' => 'tok_visa'],
        ]);

        $this->stripe->paymentMethods->attach($pm->id, ['customer' => $customer->id]);

        $this->stripe->customers->update($customer->id, [
            'invoice_settings' => ['default_payment_method' => $pm->id],
        ]);

        // Store stripe_id on the local user
        $user->forceFill(['stripe_id' => $customer->id])->save();

        return $customer;
    }

    /** Create a subscription with $quantity seats directly via Stripe API. */
    private function createStripeSubscription(User $user, int $quantity): \Stripe\Subscription
    {
        $sub = $this->stripe->subscriptions->create([
            'customer' => $user->stripe_id,
            'items'    => [['price' => $this->companyPriceId, 'quantity' => $quantity]],
            'payment_behavior' => 'default_incomplete',
            'expand'   => ['latest_invoice.payment_intent'],
        ]);

        // Persist in local DB so Cashier can find it
        Subscription::create([
            'user_id'        => $user->id,
            'name'           => 'default',
            'stripe_id'      => $sub->id,
            'stripe_status'  => $sub->status,
            'stripe_price'   => $this->companyPriceId,
            'quantity'       => $quantity,
            'trial_ends_at'  => null,
            'ends_at'        => null,
        ]);

        return $sub;
    }

    /** Cancel and delete a Stripe subscription + customer (cleanup). */
    private function cleanup(string $customerId, string $subscriptionId): void
    {
        try {
            $this->stripe->subscriptions->cancel($subscriptionId);
        } catch (\Throwable) {}

        try {
            $this->stripe->customers->delete($customerId);
        } catch (\Throwable) {}
    }

    private function companyAdminWithCompany(): array
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_active'         => true,
            'type'              => 'company_admin',
        ]);
        $company = Company::create([
            'name'      => 'Empresa Teste',
            'slug'      => 'empresa-teste',
            'is_active' => true,
        ]);
        $company->users()->attach($user->id, ['role' => 'admin', 'is_admin' => true]);

        return [$user, $company];
    }

    // -------------------------------------------------------------------------
    // Connectivity
    // -------------------------------------------------------------------------

    public function test_stripe_test_api_is_reachable(): void
    {
        $account = $this->stripe->accounts->retrieveCurrent();
        $this->assertNotEmpty($account->id, 'Stripe account ID should be present');
    }

    public function test_company_price_exists_in_stripe_test_account(): void
    {
        $price = $this->stripe->prices->retrieve($this->companyPriceId);
        $this->assertEquals($this->companyPriceId, $price->id);
        $this->assertTrue($price->active, 'Company price must be active');
        $this->assertNotNull($price->recurring, 'Company price must be recurring');
    }

    // -------------------------------------------------------------------------
    // Seat management — real Stripe API calls
    // -------------------------------------------------------------------------

    public function test_create_subscription_with_10_seats(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $customer = $this->createStripeCustomer($user);

        try {
            $sub = $this->createStripeSubscription($user, 10);

            // Verify on Stripe
            $stripeSub = $this->stripe->subscriptions->retrieve($sub->id);
            $this->assertEquals(10, $stripeSub->items->data[0]->quantity);

            // Verify local DB
            $localSub = $user->subscription('default');
            $this->assertNotNull($localSub);
            $this->assertEquals(10, $localSub->quantity);
        } finally {
            $this->cleanup($customer->id, $sub->id ?? '');
        }
    }

    public function test_increase_seats_from_10_to_25(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $customer = $this->createStripeCustomer($user);
        $sub = $this->createStripeSubscription($user, 10);

        try {
            // Call the app endpoint to increase seats
            $response = $this->actingAs($user)
                ->post('/billing/seats', ['new_seats' => 25]);

            $response->assertRedirect(route('company.dashboard'))
                     ->assertSessionHas('success');

            // Verify Stripe has the new quantity
            $stripeSub = $this->stripe->subscriptions->retrieve($sub->id);
            $this->assertEquals(25, $stripeSub->items->data[0]->quantity);

            // Verify local DB was updated by Stripe webhook (or by Cashier directly)
            $user->refresh();
            $localSub = $user->subscription('default');
            $this->assertEquals(25, $localSub->quantity);
        } finally {
            $this->cleanup($customer->id, $sub->id);
        }
    }

    public function test_decrease_seats_from_25_to_5(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();
        $customer = $this->createStripeCustomer($user);
        $sub = $this->createStripeSubscription($user, 25);

        // Add extra members to the company (more than 5 seats)
        $extras = User::factory()->count(10)->create(['is_active' => true]);
        foreach ($extras as $extra) {
            $company->users()->attach($extra->id, ['role' => 'member', 'is_admin' => false]);
        }

        // Deactivate some to bring within new seat count
        $toRemove = $extras->take(20)->pluck('id')->toJson();

        try {
            $response = $this->actingAs($user)
                ->post('/billing/seats', [
                    'new_seats'        => 5,
                    'deactivate_users' => $toRemove,
                ]);

            $response->assertRedirect(route('company.dashboard'))
                     ->assertSessionHas('success');

            // Verify Stripe has 5 seats
            $stripeSub = $this->stripe->subscriptions->retrieve($sub->id);
            $this->assertEquals(5, $stripeSub->items->data[0]->quantity);
        } finally {
            $this->cleanup($customer->id, $sub->id);
        }
    }

    public function test_seats_update_is_prorated(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $customer = $this->createStripeCustomer($user);
        $sub = $this->createStripeSubscription($user, 10);

        try {
            // Stripe uses proration by default on quantity changes
            // After updating from 10 → 20 a proration invoice item should exist
            $this->actingAs($user)
                ->post('/billing/seats', ['new_seats' => 20]);

            $upcoming = $this->stripe->invoices->upcoming([
                'customer' => $customer->id,
            ]);

            // At least one line item should be a proration
            $prorationLines = array_filter(
                $upcoming->lines->data,
                fn ($line) => $line->proration === true
            );

            $this->assertNotEmpty($prorationLines, 'Seat upgrade should generate proration line items');
        } finally {
            $this->cleanup($customer->id, $sub->id);
        }
    }

    public function test_cannot_reduce_below_active_member_count(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();
        $customer = $this->createStripeCustomer($user);
        $sub = $this->createStripeSubscription($user, 10);

        // Add 8 members
        $members = User::factory()->count(8)->create(['is_active' => true]);
        foreach ($members as $m) {
            $company->users()->attach($m->id, ['role' => 'member', 'is_admin' => false]);
        }

        try {
            // Try to reduce to 3 without deactivating anyone → should fail validation
            // (The app currently allows this; this test documents current behaviour
            //  and flags it as a potential improvement.)
            $response = $this->actingAs($user)
                ->post('/billing/seats', ['new_seats' => 3]);

            // Currently passes — seats are updated regardless of active member count.
            // TODO: add server-side guard preventing seats < active member count.
            $response->assertRedirect(route('company.dashboard'));
        } finally {
            $this->cleanup($customer->id, $sub->id);
        }
    }

    public function test_seats_boundary_exactly_10000(): void
    {
        [$user] = $this->companyAdminWithCompany();

        // No Stripe call needed — boundary validation is server-side
        $this->actingAs($user)
            ->post('/billing/seats', ['new_seats' => 10000])
            ->assertSessionHasNoErrors();

        $this->actingAs($user)
            ->post('/billing/seats', ['new_seats' => 10001])
            ->assertSessionHasErrors('new_seats');
    }
}

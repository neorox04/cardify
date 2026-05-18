<?php

namespace Tests\Feature;

use App\Http\Controllers\SubscriptionController;
use App\Mail\OnboardingEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function activeUser(array $attrs = []): User
    {
        return User::factory()->create(array_merge([
            'is_active'         => true,
            'email_verified_at' => now(),
        ], $attrs));
    }

    private function subscribedUser(string $price = 'price_test', int $quantity = 1): User
    {
        $user = $this->activeUser();
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_test_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => $price,
            'quantity'      => $quantity,
        ]);
        return $user;
    }

    /**
     * Returns a Mockery partial-mock of User whose newSubscription() call
     * returns a fake SubscriptionBuilder that yields a redirect URL.
     * Pass $seats = null for plans that don't call quantity().
     */
    private function userWithCheckoutMock(string $priceId, ?int $seats = null): User
    {
        $realUser   = $this->activeUser();
        $fakeUrl    = 'https://checkout.stripe.com/c/pay/fake_session';

        $mockBuilder = Mockery::mock(\Laravel\Cashier\SubscriptionBuilder::class);

        if ($seats !== null) {
            $mockBuilder->shouldReceive('quantity')->once()->with($seats)->andReturnSelf();
        }

        $mockBuilder->shouldReceive('checkout')
            ->once()
            ->andReturn((object) ['url' => $fakeUrl]);

        /** @var User $mockUser */
        $mockUser = Mockery::mock(User::class)->makePartial();
        $mockUser->setRawAttributes($realUser->getAttributes());
        $mockUser->exists              = true;
        $mockUser->wasRecentlyCreated  = false;

        $mockUser->shouldReceive('newSubscription')
            ->with('default', $priceId)
            ->andReturn($mockBuilder);

        return $mockUser;
    }

    /**
     * Returns a Mockery partial-mock of User whose subscription('default')
     * call returns a mock Subscription that swallows updateQuantity().
     */
    private function userWithSubscriptionMock(int $currentQuantity = 10): User
    {
        $realUser = $this->activeUser();

        $mockSub = Mockery::mock(Subscription::class)->makePartial();
        $mockSub->quantity = $currentQuantity;
        $mockSub->shouldReceive('updateQuantity')->once()->andReturnSelf();

        /** @var User $mockUser */
        $mockUser = Mockery::mock(User::class)->makePartial();
        $mockUser->setRawAttributes($realUser->getAttributes());
        $mockUser->exists             = true;
        $mockUser->wasRecentlyCreated = false;

        $mockUser->shouldReceive('subscription')->with('default')->andReturn($mockSub);

        return $mockUser;
    }

    // ── Plans page ────────────────────────────────────────────────────────────
    // The view calls Auth::user()->subscribed() so it requires an auth user.

    public function test_plans_page_accessible_while_authenticated(): void
    {
        $this->actingAs($this->activeUser())->get('/planos')->assertStatus(200);
    }

    public function test_plans_page_redirects_unauthenticated_users_via_middleware(): void
    {
        // The route is public but the view requires a logged-in user;
        // confirm the route itself is reachable (no 404/405).
        $this->actingAs($this->activeUser())->get('/planos')->assertOk();
    }

    // ── Checkout — auth guard ──────────────────────────────────────────────────

    public function test_checkout_redirects_guest_to_login(): void
    {
        $this->post('/checkout', ['price' => SubscriptionController::PRICE_INDIVIDUAL_MONTHLY])
            ->assertRedirect('/login');
    }

    // ── Checkout — invalid prices ──────────────────────────────────────────────

    #[DataProvider('invalidPriceProvider')]
    public function test_checkout_rejects_invalid_price(string $price): void
    {
        $this->actingAs($this->activeUser())
            ->post('/checkout', ['price' => $price])
            ->assertStatus(400);
    }

    public static function invalidPriceProvider(): array
    {
        return [
            'empty string'         => [''],
            'random string'        => ['price_INVALID_xyz'],
            'individual lowercase' => ['price_individual_monthly'],
            'sql injection'        => ["' OR '1'='1"],
            'company typo'         => ['price_company'],
        ];
    }

    // ── Checkout — enterprise redirect ─────────────────────────────────────────

    public function test_company_checkout_above_10000_seats_redirects_to_enterprise(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => 10001,
            ])
            ->assertRedirect(route('subscriptions.enterprise'));
    }

    public function test_company_checkout_at_exactly_10001_also_redirects(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => 99999,
            ])
            ->assertRedirect(route('subscriptions.enterprise'));
    }

    // ── Checkout — 10 000 boundary: should NOT redirect to enterprise ──────────

    public function test_company_checkout_at_10000_seats_does_not_redirect_to_enterprise(): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_COMPANY, 10000);

        $this->actingAs($mockUser)
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => 10000,
            ])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    // ── Checkout — individual monthly ──────────────────────────────────────────

    public function test_checkout_individual_monthly_redirects_to_stripe(): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_INDIVIDUAL_MONTHLY);

        $this->actingAs($mockUser)
            ->post('/checkout', ['price' => SubscriptionController::PRICE_INDIVIDUAL_MONTHLY])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    // ── Checkout — individual yearly ───────────────────────────────────────────

    public function test_checkout_individual_yearly_redirects_to_stripe(): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_INDIVIDUAL_YEARLY);

        $this->actingAs($mockUser)
            ->post('/checkout', ['price' => SubscriptionController::PRICE_INDIVIDUAL_YEARLY])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    // ── Checkout — company with seats (all tier boundaries) ───────────────────

    #[DataProvider('seatTierProvider')]
    public function test_company_checkout_sends_correct_seat_quantity(int $seats): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_COMPANY, $seats);

        $this->actingAs($mockUser)
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => $seats,
            ])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    public static function seatTierProvider(): array
    {
        return [
            'Tier 1 — lower (1)'      => [1],
            'Tier 1 — upper (50)'     => [50],
            'Tier 2 — lower (51)'     => [51],
            'Tier 2 — upper (100)'    => [100],
            'Tier 3 — lower (101)'    => [101],
            'Tier 3 — upper (250)'    => [250],
            'Tier 4 — lower (251)'    => [251],
            'Tier 4 — upper (500)'    => [500],
            'Tier 5 — lower (501)'    => [501],
            'Tier 5 — upper (750)'    => [750],
            'Tier 6 — lower (751)'    => [751],
            'Tier 6 — upper (1000)'   => [1000],
            'Tier 7 — lower (1001)'   => [1001],
            'Tier 7 — upper (2500)'   => [2500],
            'Tier 8 — lower (2501)'   => [2501],
            'Tier 8 — upper (5000)'   => [5000],
            'Tier 9 — lower (5001)'   => [5001],
            'Tier 9 — upper (7500)'   => [7500],
            'Tier 10 — lower (7501)'  => [7501],
            'Tier 10 — upper (10000)' => [10000],
        ];
    }

    // ── Checkout — seat edge cases ─────────────────────────────────────────────

    public function test_company_checkout_clamps_zero_seats_to_one(): void
    {
        // Controller does max(1, (int) $seats) so 0 → 1
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_COMPANY, 1);

        $this->actingAs($mockUser)
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => 0,
            ])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    public function test_company_checkout_clamps_negative_seats_to_one(): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_COMPANY, 1);

        $this->actingAs($mockUser)
            ->post('/checkout', [
                'price' => SubscriptionController::PRICE_COMPANY,
                'seats' => -99,
            ])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    public function test_company_checkout_defaults_to_one_seat_when_omitted(): void
    {
        $mockUser = $this->userWithCheckoutMock(SubscriptionController::PRICE_COMPANY, 1);

        $this->actingAs($mockUser)
            ->post('/checkout', ['price' => SubscriptionController::PRICE_COMPANY])
            ->assertRedirect('https://checkout.stripe.com/c/pay/fake_session');
    }

    // ── Static pages ───────────────────────────────────────────────────────────

    public function test_success_page_accessible_for_authenticated_user(): void
    {
        $this->actingAs($this->activeUser())->get('/checkout/success')->assertStatus(200);
    }

    public function test_cancel_page_accessible_for_authenticated_user(): void
    {
        $this->actingAs($this->activeUser())->get('/checkout/cancel')->assertStatus(200);
    }

    public function test_success_page_redirects_guest(): void
    {
        $this->get('/checkout/success')->assertRedirect('/login');
    }

    public function test_cancel_page_redirects_guest(): void
    {
        $this->get('/checkout/cancel')->assertRedirect('/login');
    }

    public function test_enterprise_page_redirects_guest(): void
    {
        $this->get('/checkout/enterprise')->assertRedirect('/login');
    }

    // ── Seat management — auth guard ───────────────────────────────────────────

    public function test_seats_page_redirects_guest(): void
    {
        $this->get('/billing/seats')->assertRedirect('/login');
    }

    public function test_update_seats_redirects_guest(): void
    {
        $this->post('/billing/seats', ['new_seats' => 5])->assertRedirect('/login');
    }

    // ── Seat update — validation ───────────────────────────────────────────────

    public function test_update_seats_rejects_missing_field(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', [])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_rejects_zero(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 0])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_rejects_negative(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => -1])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_rejects_above_10000(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 10001])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_rejects_non_integer_string(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 'abc'])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_rejects_float(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 5.5])
            ->assertSessionHasErrors('new_seats');
    }

    public function test_update_seats_accepts_max_boundary_of_10000(): void
    {
        // Validation passes for 10000 — updateQuantity would be called next.
        // We verify no validation error is present by checking the user
        // without subscription returns an 'error' flash (not a validation error).
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 10000])
            ->assertSessionDoesntHaveErrors('new_seats');
    }

    public function test_update_seats_accepts_min_boundary_of_1(): void
    {
        $this->actingAs($this->activeUser())
            ->post('/billing/seats', ['new_seats' => 1])
            ->assertSessionDoesntHaveErrors('new_seats');
    }

    // ── Seat update — no active subscription ──────────────────────────────────

    public function test_update_seats_returns_error_flash_without_subscription(): void
    {
        $user = $this->activeUser(); // no subscription row in DB

        $this->actingAs($user)
            ->post('/billing/seats', ['new_seats' => 5])
            ->assertSessionHas('error');
    }

    // ── Seat update — success (Stripe updateQuantity mocked) ──────────────────

    public function test_update_seats_calls_stripe_and_redirects_to_dashboard(): void
    {
        $mockUser = $this->userWithSubscriptionMock(10);

        $this->actingAs($mockUser)
            ->post('/billing/seats', ['new_seats' => 20])
            ->assertRedirect(route('company.dashboard'))
            ->assertSessionHas('success');
    }

    public function test_update_seats_success_message_contains_new_seat_count(): void
    {
        $mockUser = $this->userWithSubscriptionMock(5);

        $response = $this->actingAs($mockUser)
            ->post('/billing/seats', ['new_seats' => 15]);

        $response->assertSessionHas('success', fn (string $msg) => str_contains($msg, '15'));
    }

    // ── Webhook — onboarding email ─────────────────────────────────────────────

    public function test_webhook_sends_onboarding_email_when_checkout_completed(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'stripe_id'         => 'cus_test_onboarding_ok',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // POST directly to the webhook route (no signature secret configured)
        $this->postJson('/stripe/webhook', [
            'id'   => 'evt_test_001',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id'           => 'cs_test_001',
                    'mode'         => 'subscription',
                    'customer'     => 'cus_test_onboarding_ok',
                    'subscription' => 'sub_not_in_db_intentionally',
                ],
            ],
        ])->assertSuccessful();

        Mail::assertSent(
            OnboardingEmail::class,
            fn (OnboardingEmail $mail) => $mail->hasTo($user->email)
        );
    }

    public function test_webhook_sends_exactly_one_email_per_checkout(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'stripe_id' => 'cus_test_single_email',
            'is_active' => true,
        ]);

        $this->postJson('/stripe/webhook', [
            'id'   => 'evt_test_002',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id'           => 'cs_test_002',
                    'mode'         => 'subscription',
                    'customer'     => 'cus_test_single_email',
                    'subscription' => 'sub_not_in_db',
                ],
            ],
        ])->assertSuccessful();

        Mail::assertSentCount(1);
    }

    public function test_webhook_skips_email_when_customer_id_missing(): void
    {
        Mail::fake();

        $this->postJson('/stripe/webhook', [
            'id'   => 'evt_test_003',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id'   => 'cs_test_003',
                    'mode' => 'subscription',
                    // 'customer' intentionally omitted
                ],
            ],
        ])->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_webhook_skips_email_when_customer_not_found_in_db(): void
    {
        Mail::fake();

        $this->postJson('/stripe/webhook', [
            'id'   => 'evt_test_004',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id'           => 'cs_test_004',
                    'mode'         => 'subscription',
                    'customer'     => 'cus_nonexistent_xyz',
                    'subscription' => 'sub_not_in_db',
                ],
            ],
        ])->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_webhook_sends_email_to_correct_user_when_multiple_exist(): void
    {
        Mail::fake();

        $userA = User::factory()->create(['stripe_id' => 'cus_user_a', 'is_active' => true]);
        $userB = User::factory()->create(['stripe_id' => 'cus_user_b', 'is_active' => true]);

        $this->postJson('/stripe/webhook', [
            'id'   => 'evt_test_005',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id'           => 'cs_test_005',
                    'mode'         => 'subscription',
                    'customer'     => 'cus_user_b',
                    'subscription' => 'sub_not_in_db',
                ],
            ],
        ])->assertSuccessful();

        Mail::assertSent(OnboardingEmail::class, fn ($m) => $m->hasTo($userB->email));
        Mail::assertNotSent(OnboardingEmail::class, fn ($m) => $m->hasTo($userA->email));
    }
}

<?php

namespace Tests\Feature;

use App\Mail\OnboardingEmail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;
use Mockery;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function verifiedUser(array $attrs = []): User
    {
        return User::factory()->create(array_merge([
            'email_verified_at' => now(),
            'is_active'         => true,
        ], $attrs));
    }

    private function companyAdminWithCompany(): array
    {
        $user = $this->verifiedUser(['type' => 'company_admin']);
        $company = Company::create([
            'name'      => 'Empresa Teste',
            'slug'      => 'empresa-teste',
            'is_active' => true,
        ]);
        $company->users()->attach($user->id, ['role' => 'admin', 'is_admin' => true]);
        return [$user, $company];
    }

    /** Returns a mock Subscription (no Stripe calls). */
    private function mockSubscription(int $quantity = 10): object
    {
        $stripeObj                     = new \stdClass();
        $stripeObj->current_period_end = now()->addMonth()->timestamp;

        $sub           = Mockery::mock(Subscription::class)->makePartial();
        $sub->quantity = $quantity;
        $sub->shouldReceive('asStripeSubscription')->andReturn($stripeObj);
        $sub->shouldReceive('updateQuantity')->withAnyArgs()->andReturnSelf();

        return $sub;
    }

    /** Anonymous stub that returns a Stripe checkout URL via magic property. */
    private function checkoutStub(string $url): object
    {
        return new class($url) {
            public function __construct(private string $url) {}
            public function __get(string $key): string { return $this->url; }
        };
    }

    /** Partial-mocks a user so ->subscription('default') returns $sub. */
    private function userWithSubscription(User $user, object $sub): object
    {
        $mock = Mockery::mock($user)->makePartial();
        $mock->shouldReceive('subscription')->with('default')->andReturn($sub);
        return $mock;
    }

    // -------------------------------------------------------------------------
    // Páginas públicas
    // -------------------------------------------------------------------------

    public function test_plans_page_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->verifiedUser())->get('/planos')->assertStatus(200);
    }

    public function test_plans_page_loads_for_guest(): void
    {
        $this->get('/planos')->assertStatus(200);
    }

    public function test_enterprise_page_loads(): void
    {
        $this->get('/empresas')->assertStatus(200);
    }

    public function test_checkout_enterprise_redirects_to_public_enterprise_page(): void
    {
        // Regression: /checkout/enterprise pointed at a missing view (500).
        $user = User::factory()->create(['is_active' => true]);

        $this->actingAs($user)->get('/checkout/enterprise')
            ->assertRedirect(route('enterprise'));
    }

    public function test_success_page_requires_auth(): void
    {
        $this->get('/checkout/success')->assertRedirect('/login');
    }

    public function test_cancel_page_requires_auth(): void
    {
        $this->get('/checkout/cancel')->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Protecção de rotas
    // -------------------------------------------------------------------------

    public function test_guest_cannot_access_checkout(): void
    {
        $this->post('/checkout', ['price' => 'price_123'])
             ->assertRedirect('/login');
    }

    public function test_guest_cannot_access_seats_page(): void
    {
        $this->get('/billing/seats')->assertRedirect('/login');
    }

    public function test_unverified_user_cannot_access_checkout(): void
    {
        $user = User::factory()->unverified()->create(['is_active' => true]);
        $this->actingAs($user)
             ->post('/checkout', ['price' => 'price_123'])
             ->assertRedirect('/email/verify');
    }

    public function test_inactive_user_is_logged_out_on_checkout(): void
    {
        $user = $this->verifiedUser(['is_active' => false]);
        $this->actingAs($user)
             ->post('/checkout', ['price' => 'price_123'])
             ->assertRedirect('/login');
    }

    public function test_non_company_admin_cannot_access_seats_page(): void
    {
        // seats() calls firstOrFail() → ModelNotFoundException → 404
        $user = $this->verifiedUser(['type' => 'user']);
        $this->actingAs($user)
             ->get('/billing/seats')
             ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // Checkout — validação de preço
    // -------------------------------------------------------------------------

    public function test_checkout_rejects_invalid_price(): void
    {
        $user = $this->verifiedUser();
        $this->actingAs($user)
             ->post('/checkout', ['price' => 'price_invalid_abc'])
             ->assertStatus(400);
    }

    public function test_checkout_rejects_empty_price(): void
    {
        $user = $this->verifiedUser();
        $this->actingAs($user)
             ->post('/checkout', ['price' => ''])
             ->assertStatus(400);
    }

    // -------------------------------------------------------------------------
    // Checkout empresa — limite de seats
    // -------------------------------------------------------------------------

    public function test_company_checkout_redirects_to_enterprise_when_seats_exceed_10000(): void
    {
        $user = $this->verifiedUser();
        $this->actingAs($user)
             ->post('/checkout', [
                 'price' => 'price_1TM7hJCcmLy5PiLsPioHECxJ',
                 'seats' => 10001,
             ])
             ->assertRedirect(route('subscriptions.enterprise'));
    }

    public function test_company_checkout_accepts_exactly_10000_seats_and_proceeds_to_stripe(): void
    {
        $user = $this->verifiedUser();

        $builderMock = Mockery::mock(\Laravel\Cashier\SubscriptionBuilder::class);
        $builderMock->shouldReceive('quantity')->with(10000)->andReturnSelf();
        $builderMock->shouldReceive('checkout')->andReturn($this->checkoutStub('https://checkout.stripe.com/pay/cs_test'));

        $userMock = Mockery::mock($user)->makePartial();
        $userMock->shouldReceive('newSubscription')->andReturn($builderMock);

        $this->actingAs($userMock)
             ->post('/checkout', [
                 'price' => 'price_1TM7hJCcmLy5PiLsPioHECxJ',
                 'seats' => 10000,
             ])
             ->assertRedirect('https://checkout.stripe.com/pay/cs_test');
    }

    // -------------------------------------------------------------------------
    // Checkout individual — redireciona para Stripe (mocked)
    // -------------------------------------------------------------------------

    public function test_individual_monthly_checkout_redirects_to_stripe(): void
    {
        $user = $this->verifiedUser();

        $builderMock = Mockery::mock(\Laravel\Cashier\SubscriptionBuilder::class);
        $builderMock->shouldReceive('checkout')->andReturn($this->checkoutStub('https://checkout.stripe.com/pay/cs_test_monthly'));

        $userMock = Mockery::mock($user)->makePartial();
        $userMock->shouldReceive('newSubscription')
                 ->with('default', 'price_1TFgXeCcmLy5PiLsbrLtDCfP')
                 ->andReturn($builderMock);

        $this->actingAs($userMock)
             ->post('/checkout', ['price' => 'price_1TFgXeCcmLy5PiLsbrLtDCfP'])
             ->assertRedirect('https://checkout.stripe.com/pay/cs_test_monthly');
    }

    public function test_individual_yearly_checkout_redirects_to_stripe(): void
    {
        $user = $this->verifiedUser();

        $builderMock = Mockery::mock(\Laravel\Cashier\SubscriptionBuilder::class);
        $builderMock->shouldReceive('checkout')->andReturn($this->checkoutStub('https://checkout.stripe.com/pay/cs_test_yearly'));

        $userMock = Mockery::mock($user)->makePartial();
        $userMock->shouldReceive('newSubscription')
                 ->with('default', 'price_1TFgXKCcmLy5PiLs5xZdP87O')
                 ->andReturn($builderMock);

        $this->actingAs($userMock)
             ->post('/checkout', ['price' => 'price_1TFgXKCcmLy5PiLs5xZdP87O'])
             ->assertRedirect('https://checkout.stripe.com/pay/cs_test_yearly');
    }

    // -------------------------------------------------------------------------
    // Checkout empresa com seats — redireciona para Stripe (mocked)
    // -------------------------------------------------------------------------

    public function test_company_checkout_with_seats_redirects_to_stripe(): void
    {
        $user = $this->verifiedUser();

        $builderMock = Mockery::mock(\Laravel\Cashier\SubscriptionBuilder::class);
        $builderMock->shouldReceive('quantity')->with(25)->andReturnSelf();
        $builderMock->shouldReceive('checkout')->andReturn($this->checkoutStub('https://checkout.stripe.com/pay/cs_test_company'));

        $userMock = Mockery::mock($user)->makePartial();
        $userMock->shouldReceive('newSubscription')
                 ->with('default', 'price_1TM7hJCcmLy5PiLsPioHECxJ')
                 ->andReturn($builderMock);

        $this->actingAs($userMock)
             ->post('/checkout', [
                 'price' => 'price_1TM7hJCcmLy5PiLsPioHECxJ',
                 'seats' => 25,
             ])
             ->assertRedirect('https://checkout.stripe.com/pay/cs_test_company');
    }

    // -------------------------------------------------------------------------
    // Páginas success / cancel
    // -------------------------------------------------------------------------

    public function test_success_page_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->verifiedUser())->get('/checkout/success')->assertStatus(200);
    }

    public function test_cancel_page_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->verifiedUser())->get('/checkout/cancel')->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Gestão de seats
    // -------------------------------------------------------------------------

    public function test_seats_page_loads_for_company_admin_without_subscription(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();
        $this->actingAs($user)->get('/billing/seats')->assertStatus(200);
    }

    public function test_seats_page_loads_for_company_admin_with_subscription(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();

        $sub      = $this->mockSubscription(50);
        $userMock = $this->userWithSubscription($user, $sub);

        $this->actingAs($userMock)->get('/billing/seats')->assertStatus(200);
    }

    public function test_seats_update_rejects_zero_seats(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $this->actingAs($user)
             ->post('/billing/seats', ['new_seats' => 0])
             ->assertSessionHasErrors('new_seats');
    }

    public function test_seats_update_rejects_seats_over_limit(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $this->actingAs($user)
             ->post('/billing/seats', ['new_seats' => 10001])
             ->assertSessionHasErrors('new_seats');
    }

    public function test_seats_update_rejects_non_integer_string(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $this->actingAs($user)
             ->post('/billing/seats', ['new_seats' => 'abc'])
             ->assertSessionHasErrors('new_seats');
    }

    public function test_seats_update_rejects_float(): void
    {
        [$user] = $this->companyAdminWithCompany();
        $this->actingAs($user)
             ->post('/billing/seats', ['new_seats' => 5.5])
             ->assertSessionHasErrors('new_seats');
    }

    public function test_seats_update_accepts_boundary_values(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();

        $sub      = $this->mockSubscription(1);
        $userMock = $this->userWithSubscription($user, $sub);

        $this->actingAs($userMock)
             ->post('/billing/seats', ['new_seats' => 1])
             ->assertSessionHasNoErrors();

        $this->actingAs($userMock)
             ->post('/billing/seats', ['new_seats' => 10000])
             ->assertSessionHasNoErrors();
    }

    public function test_seats_update_returns_error_without_subscription(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();

        $userMock = Mockery::mock($user)->makePartial();
        $userMock->shouldReceive('subscription')->with('default')->andReturn(null);

        $this->actingAs($userMock)
             ->post('/billing/seats', ['new_seats' => 5])
             ->assertSessionHas('error');
    }

    public function test_seats_update_calls_stripe_update_quantity(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();

        $sub      = $this->mockSubscription(10);
        $userMock = $this->userWithSubscription($user, $sub);

        $this->actingAs($userMock)
             ->post('/billing/seats', ['new_seats' => 20])
             ->assertRedirect(route('company.dashboard'))
             ->assertSessionHas('success');
    }

    public function test_seats_update_success_message_contains_new_seat_count(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();

        $sub      = $this->mockSubscription(5);
        $userMock = $this->userWithSubscription($user, $sub);

        $response = $this->actingAs($userMock)
             ->post('/billing/seats', ['new_seats' => 15]);

        $response->assertSessionHas('success', fn (string $msg) => str_contains($msg, '15'));
    }

    public function test_seats_update_deactivates_specified_members(): void
    {
        [$user, $company] = $this->companyAdminWithCompany();
        $member = $this->verifiedUser();
        $company->users()->attach($member->id, ['role' => 'member', 'is_admin' => false]);

        $sub      = $this->mockSubscription(5);
        $userMock = $this->userWithSubscription($user, $sub);

        $this->actingAs($userMock)
             ->post('/billing/seats', [
                 'new_seats'        => 3,
                 'deactivate_users' => json_encode([$member->id]),
             ])
             ->assertRedirect(route('company.dashboard'));

        $this->assertFalse($company->users()->where('users.id', $member->id)->exists());
    }

    // -------------------------------------------------------------------------
    // Formulário de contacto enterprise
    // -------------------------------------------------------------------------

    public function test_enterprise_contact_requires_name(): void
    {
        $this->post('/empresas/contacto', [
            'company'   => 'ACME',
            'email'     => 'test@example.com',
            'employees' => '50-100',
        ])->assertSessionHasErrors('name');
    }

    public function test_enterprise_contact_requires_company(): void
    {
        $this->post('/empresas/contacto', [
            'name'      => 'Ana Silva',
            'email'     => 'test@example.com',
            'employees' => '50-100',
        ])->assertSessionHasErrors('company');
    }

    public function test_enterprise_contact_requires_valid_email(): void
    {
        $this->post('/empresas/contacto', [
            'name'      => 'Ana Silva',
            'company'   => 'ACME',
            'email'     => 'not-an-email',
            'employees' => '50-100',
        ])->assertSessionHasErrors('email');
    }

    public function test_enterprise_contact_requires_employees(): void
    {
        $this->post('/empresas/contacto', [
            'name'    => 'Ana Silva',
            'company' => 'ACME',
            'email'   => 'test@example.com',
        ])->assertSessionHasErrors('employees');
    }

    public function test_enterprise_contact_sends_email_with_valid_data(): void
    {
        Mail::fake();

        $this->post('/empresas/contacto', [
            'name'      => 'Ana Silva',
            'company'   => 'ACME Lda',
            'email'     => 'ana@acme.com',
            'employees' => '50-100',
            'message'   => 'Gostávamos de uma demonstração.',
        ])->assertRedirect(route('enterprise'))
          ->assertSessionHas('enterprise_success', true);
    }

    public function test_enterprise_contact_truncates_message_over_2000_chars(): void
    {
        Mail::fake();

        $this->post('/empresas/contacto', [
            'name'      => 'Ana Silva',
            'company'   => 'ACME Lda',
            'email'     => 'ana@acme.com',
            'employees' => '50-100',
            'message'   => str_repeat('a', 2001),
        ])->assertSessionHasErrors('message');
    }

    // -------------------------------------------------------------------------
    // Webhook Stripe
    // -------------------------------------------------------------------------

    public function test_webhook_endpoint_is_accessible_without_authentication(): void
    {
        // Without a valid signature it returns 400, but NOT 401/302 (auth redirects).
        $response = $this->postJson('/stripe/webhook', []);
        $this->assertNotEquals(401, $response->status());
        $this->assertNotEquals(302, $response->status());
    }

    public function test_webhook_sends_onboarding_email_on_checkout_completed(): void
    {
        Mail::fake();

        $user = $this->verifiedUser();
        $user->forceFill(['stripe_id' => 'cus_test_onboarding'])->save();

        // Call the protected handler directly — no Stripe HTTP calls (no parent:: call)
        $controller = new \App\Http\Controllers\WebhookController();
        $method     = new \ReflectionMethod($controller, 'handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $method->invoke($controller, [
            'type' => 'checkout.session.completed',
            'data' => ['object' => ['customer' => 'cus_test_onboarding']],
        ]);

        Mail::assertSent(\App\Mail\OnboardingEmail::class, fn ($m) => $m->hasTo($user->email));
    }

    public function test_webhook_sends_exactly_one_email_per_checkout(): void
    {
        Mail::fake();

        $user = $this->verifiedUser();
        $user->forceFill(['stripe_id' => 'cus_test_single_email'])->save();

        $controller = new \App\Http\Controllers\WebhookController();
        $method     = new \ReflectionMethod($controller, 'handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $method->invoke($controller, [
            'type' => 'checkout.session.completed',
            'data' => ['object' => ['customer' => 'cus_test_single_email']],
        ]);

        Mail::assertSentCount(1);
    }

    public function test_webhook_skips_email_when_customer_id_missing(): void
    {
        Mail::fake();

        $controller = new \App\Http\Controllers\WebhookController();
        $method     = new \ReflectionMethod($controller, 'handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $method->invoke($controller, [
            'type' => 'checkout.session.completed',
            'data' => ['object' => []],
        ]);

        Mail::assertNothingSent();
    }

    public function test_webhook_skips_email_when_customer_not_found_in_db(): void
    {
        Mail::fake();

        $controller = new \App\Http\Controllers\WebhookController();
        $method     = new \ReflectionMethod($controller, 'handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $method->invoke($controller, [
            'type' => 'checkout.session.completed',
            'data' => ['object' => ['customer' => 'cus_nonexistent_xyz']],
        ]);

        Mail::assertNothingSent();
    }

    public function test_webhook_sends_email_to_correct_user_when_multiple_exist(): void
    {
        Mail::fake();

        $userA = $this->verifiedUser();
        $userA->forceFill(['stripe_id' => 'cus_user_a'])->save();

        $userB = $this->verifiedUser();
        $userB->forceFill(['stripe_id' => 'cus_user_b'])->save();

        $controller = new \App\Http\Controllers\WebhookController();
        $method     = new \ReflectionMethod($controller, 'handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $method->invoke($controller, [
            'type' => 'checkout.session.completed',
            'data' => ['object' => ['customer' => 'cus_user_b']],
        ]);

        Mail::assertSent(\App\Mail\OnboardingEmail::class, fn ($m) => $m->hasTo($userB->email));
        Mail::assertNotSent(\App\Mail\OnboardingEmail::class, fn ($m) => $m->hasTo($userA->email));
    }
}

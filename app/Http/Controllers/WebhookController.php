<?php

namespace App\Http\Controllers;

use App\Mail\OnboardingEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

class WebhookController extends CashierWebhookController
{
    /**
     * Disparado quando o Stripe confirma que o checkout foi concluído
     * e a subscrição está ativa. Este é o momento certo para enviar
     * o email de onboarding.
     */
    protected function handleCheckoutSessionCompleted(array $payload): void
    {
        // Cashier's base WebhookController does not define handleCheckoutSessionCompleted,
        // so no parent:: call here — this method is ours alone.
        $session    = $payload['data']['object'] ?? [];
        $customerId = $session['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if (!$user) {
            return;
        }

        // Belt-and-suspenders: make sure the subscription is synced locally
        // even if the `customer.subscription.created` webhook wasn't delivered
        // (e.g. the endpoint wasn't subscribed to that event). This means a
        // resend of `checkout.session.completed` alone is enough to grant
        // access, so no paying customer stays locked out.
        if (($session['mode'] ?? null) === 'subscription' && !empty($session['subscription'])) {
            $stripeSubscription = Cashier::stripe()->subscriptions->retrieve($session['subscription']);

            // Reuse Cashier's own creation logic — it is idempotent and skips
            // when the subscription already exists locally.
            $this->handleCustomerSubscriptionCreated([
                'data' => ['object' => $stripeSubscription->toArray()],
            ]);
        }

        Mail::to($user->email)->send(new OnboardingEmail($user));
    }
}

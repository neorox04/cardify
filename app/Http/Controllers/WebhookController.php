<?php

namespace App\Http\Controllers;

use App\Mail\OnboardingEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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
        parent::handleCheckoutSessionCompleted($payload);

        $customerId = $payload['data']['object']['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if ($user) {
            Mail::to($user->email)->send(new OnboardingEmail($user));
        }
    }
}

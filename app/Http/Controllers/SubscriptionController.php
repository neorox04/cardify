<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    // Exibe a página de escolha de plano
    public function showPlans()
    {
        return view('subscriptions.plans');
    }

    // Cria uma sessão Stripe Checkout para o plano selecionado
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $price = $request->input('price');
        if (!in_array($price, [
            'price_1TFgXKCcmLy5PiLs5xZdP87O', // anual
            'price_1TFgXeCcmLy5PiLsbrLtDCfP', // mensal
        ])) {
            abort(400, 'Plano inválido');
        }
        $checkout = $user->newSubscription('default', $price)
            ->checkout([
                'success_url' => route('subscriptions.success'),
                'cancel_url' => route('subscriptions.cancel'),
            ]);
        return redirect($checkout->url);
    }

    // Página de sucesso
    public function success()
    {
        return view('subscriptions.success');
    }

    // Página de cancelamento
    public function cancel()
    {
        return view('subscriptions.cancel');
    }
}

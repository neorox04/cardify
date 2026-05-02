<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    const PRICE_INDIVIDUAL_MONTHLY = 'price_1TFgXeCcmLy5PiLsbrLtDCfP';
    const PRICE_INDIVIDUAL_YEARLY  = 'price_1TFgXKCcmLy5PiLs5xZdP87O';
    const PRICE_COMPANY            = 'price_1TM7hJCcmLy5PiLsPioHECxJ';

    const TIERS = [
        ['min' => 1,    'max' => 50,    'price' => 9.50],
        ['min' => 51,   'max' => 100,   'price' => 9.00],
        ['min' => 101,  'max' => 250,   'price' => 8.00],
        ['min' => 251,  'max' => 500,   'price' => 7.00],
        ['min' => 501,  'max' => 750,   'price' => 6.50],
        ['min' => 751,  'max' => 1000,  'price' => 6.00],
        ['min' => 1001, 'max' => 2500,  'price' => 5.50],
        ['min' => 2501, 'max' => 5000,  'price' => 5.00],
        ['min' => 5001, 'max' => 7500,  'price' => 4.50],
        ['min' => 7501, 'max' => 10000, 'price' => 4.00],
    ];

    // Exibe a página de escolha de plano
    public function showPlans()
    {
        return view('subscriptions.plans');
    }

    // Cria uma sessão Stripe Checkout para o plano selecionado
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $price = $request->input('price');
        $seats = max(1, (int) $request->input('seats', 1));

        $allowed = [self::PRICE_INDIVIDUAL_MONTHLY, self::PRICE_INDIVIDUAL_YEARLY, self::PRICE_COMPANY];
        if (!in_array($price, $allowed)) {
            abort(400, 'Plano inválido');
        }

        if ($price === self::PRICE_COMPANY && $seats > 10000) {
            return redirect()->route('subscriptions.enterprise');
        }

        $checkoutOptions = [
            'success_url' => route('subscriptions.success'),
            'cancel_url'  => route('subscriptions.cancel'),
        ];

        $subscription = $user->newSubscription('default', $price);

        if ($price === self::PRICE_COMPANY) {
            $subscription->quantity($seats);
        }

        return redirect($subscription->checkout($checkoutOptions)->url);
    }

    // Página de gestão de seats (empresa)
    public function seats()
    {
        /** @var \App\Models\User $user */
        $user        = Auth::user();
        $company     = $user->companies()->wherePivot('is_admin', true)->firstOrFail();
        $subscription = $user->subscription('default');

        $currentSeats = $subscription ? $subscription->quantity : 1;
        $currentTier  = $this->getTier($currentSeats);

        // Dias restantes no período atual
        $periodEnd     = $subscription?->asStripeSubscription()->current_period_end ?? now()->endOfMonth()->timestamp;
        $daysRemaining = max(1, (int) ceil((Carbon::createFromTimestamp($periodEnd)->diffInHours(now()) / 24)));

        // Membros da empresa para a lista de desativação
        $members = $company->users()
            ->where('users.id', '!=', $user->id)
            ->get()
            ->map(function ($member) {
                $daysAgo = $member->last_login_at
                    ? (int) now()->diffInDays($member->last_login_at)
                    : 999;

                $lastLoginLabel = match(true) {
                    $daysAgo === 999 => 'Nunca',
                    $daysAgo === 0   => 'Hoje',
                    $daysAgo === 1   => 'Ontem',
                    default          => $daysAgo . ' dias',
                };

                $nameParts = explode(' ', $member->name);
                $initials  = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

                return [
                    'id'              => $member->id,
                    'name'            => $member->name,
                    'role'            => $member->pivot->role ?? null,
                    'initials'        => $initials,
                    'days_ago'        => $daysAgo,
                    'last_login_label'=> $lastLoginLabel,
                ];
            });

        return view('subscriptions.seats', compact('currentSeats', 'currentTier', 'daysRemaining', 'members'));
    }

    // Processa a atualização de seats
    public function updateSeats(Request $request)
    {
        $request->validate([
            'new_seats'        => 'required|integer|min:1|max:10000',
            'deactivate_users' => 'nullable|json',
        ]);

        /** @var \App\Models\User $user */
        $user         = Auth::user();
        $newSeats     = (int) $request->input('new_seats');
        $toDeactivate = json_decode($request->input('deactivate_users', '[]'), true);
        $subscription = $user->subscription('default');

        if (!$subscription) {
            return back()->with('error', 'Não tens uma subscrição ativa.');
        }

        // Se downgrade, remover membros primeiro
        if (!empty($toDeactivate)) {
            $company = $user->companies()->wherePivot('is_admin', true)->firstOrFail();
            $company->users()->detach($toDeactivate);
        }

        // Atualizar quantity no Stripe
        $subscription->updateQuantity($newSeats);

        return redirect()->route('company.dashboard')
            ->with('success', "Plano atualizado para {$newSeats} seats com sucesso!");
    }

    // Página enterprise pública
    public function enterprisePage()
    {
        return view('subscriptions.enterprise-public');
    }

    // Formulário de contacto enterprise
    public function enterpriseContact(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:120',
            'company'   => 'required|string|max:120',
            'email'     => 'required|email|max:200',
            'employees' => 'required|string',
            'message'   => 'nullable|string|max:2000',
        ]);

        try {
            $body = "Novo pedido de demonstração — Plano Empresas\n\n"
                . "Nome: {$data['name']}\n"
                . "Empresa: {$data['company']}\n"
                . "Email: {$data['email']}\n"
                . "Colaboradores: {$data['employees']}\n"
                . "Mensagem: " . ($data['message'] ?? '—');

            Mail::raw($body, function ($msg) use ($data) {
                $msg->to('hello@cardifys.com')
                    ->replyTo($data['email'], $data['name'])
                    ->subject("Demo Empresas — {$data['company']}");
            });

            return redirect()->route('enterprise')->with('enterprise_success', true);
        } catch (\Exception $e) {
            return redirect()->route('enterprise')->with('enterprise_error', true);
        }
    }

    // Página enterprise (10.000+ seats)
    public function enterprise()
    {
        return view('subscriptions.enterprise');
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

    private function getTier(int $seats): array
    {
        foreach (self::TIERS as $tier) {
            if ($seats >= $tier['min'] && $seats <= $tier['max']) {
                return $tier;
            }
        }
        return self::TIERS[count(self::TIERS) - 1];
    }
}

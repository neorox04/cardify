<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\BusinessCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class AdminPanelController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalCompanies = Company::count();
        $totalBusinessCards = BusinessCard::count();
        $totalViews = BusinessCard::sum('views_count');
        $activeUsers = User::where('is_active', true)->count();
        $recentUsers = User::latest()->take(10)->get();
        $recentCompanies = Company::latest()->take(10)->get();
        $topBusinessCards = BusinessCard::orderBy('views_count', 'desc')->take(10)->with(['user', 'company'])->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCompanies', 
            'totalBusinessCards',
            'totalViews',
            'activeUsers',
            'recentUsers',
            'recentCompanies',
            'topBusinessCards'
        ));
    }

    /**
     * Display analytics dashboard with all platform metrics.
     */
    public function analytics(): View
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // ── USERS ────────────────────────────────────────────
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = $totalUsers - $activeUsers;
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        $newUsersLastMonth = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $userGrowthPct = $newUsersLastMonth > 0
            ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1)
            : ($newUsersThisMonth > 0 ? 100 : 0);

        $usersByType = User::selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        // ── BUSINESS CARDS ───────────────────────────────────
        $totalCards = BusinessCard::count();
        $newCardsThisMonth = BusinessCard::where('created_at', '>=', $startOfMonth)->count();
        $avgCardsPerUser = $totalUsers > 0 ? round($totalCards / $totalUsers, 1) : 0;
        $totalViews = BusinessCard::sum('views_count');
        $totalQrScans = BusinessCard::sum('qr_scans');
        $totalContacts = BusinessCard::sum('contacts_saved');

        // ── COMPANIES ────────────────────────────────────────
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('is_active', true)->count();

        // ── SUBSCRIPTIONS ────────────────────────────────────
        $subscriptions = DB::table('subscriptions');

        $totalActive = (clone $subscriptions)->where('stripe_status', 'active')->count();
        $totalCancelled = (clone $subscriptions)->where('stripe_status', 'canceled')->count();
        $totalTrialing = (clone $subscriptions)->where('stripe_status', 'trialing')->count();
        $totalPastDue = (clone $subscriptions)->where('stripe_status', 'past_due')->count();

        $churnedThisMonth = DB::table('subscriptions')
            ->where('stripe_status', 'canceled')
            ->where('updated_at', '>=', $startOfMonth)
            ->count();

        $activeAtStartOfMonth = DB::table('subscriptions')
            ->where('created_at', '<', $startOfMonth)
            ->whereIn('stripe_status', ['active', 'canceled', 'past_due'])
            ->count();

        $churnRate = $activeAtStartOfMonth > 0
            ? round(($churnedThisMonth / $activeAtStartOfMonth) * 100, 1)
            : 0;

        // Monthly vs Annual breakdown
        $monthlySubCount = DB::table('subscriptions')
            ->where('stripe_status', 'active')
            ->where(function ($q) {
                $q->where('type', 'like', '%monthly%')
                  ->orWhere('type', 'like', '%mensal%')
                  ->orWhere('stripe_price', 'like', '%month%');
            })->count();
        $annualSubCount = $totalActive - $monthlySubCount;

        // MRR calculation (monthly * price + annual / 12)
        $monthlyPrice = 10; // €10/mês
        $annualPrice = 84;  // €84/ano
        $mrr = ($monthlySubCount * $monthlyPrice) + ($annualSubCount * ($annualPrice / 12));
        $arr = $mrr * 12;

        // ── GROWTH CHARTS (last 12 months) ───────────────────
        $userGrowth = [];
        $subGrowth = [];
        $cardGrowth = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $key = $month->format('Y-m');
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $userGrowth[$key] = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $subGrowth[$key] = DB::table('subscriptions')
                ->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $cardGrowth[$key] = BusinessCard::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        // ── TABLES ────────────────────────────────────────────
        $topCards = BusinessCard::orderBy('views_count', 'desc')
            ->take(10)
            ->with('user')
            ->get();

        $recentUsers = User::latest()->take(8)->get();

        return view('admin.analytics', compact(
            'mrr', 'arr', 'totalActive', 'monthlySubCount', 'annualSubCount',
            'churnRate', 'churnedThisMonth',
            'totalUsers', 'activeUsers', 'inactiveUsers',
            'newUsersThisMonth', 'userGrowthPct',
            'totalCards', 'avgCardsPerUser', 'newCardsThisMonth',
            'totalViews', 'totalQrScans', 'totalContacts',
            'totalCompanies', 'activeCompanies',
            'totalCancelled', 'totalTrialing', 'totalPastDue',
            'usersByType',
            'userGrowth', 'subGrowth', 'cardGrowth',
            'topCards', 'recentUsers'
        ));
    }

    /**
     * Founder CRM dashboard — real business metrics, polished design.
     */
    public function crm(): View
    {
        $now               = Carbon::now();
        $startOfMonth      = $now->copy()->startOfMonth();
        $startOfLastMonth  = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth    = $now->copy()->subMonth()->endOfMonth();

        // ── MRR / ARR (real, from local subscription rows mapped to real prices) ──
        $activeSubs = DB::table('subscriptions')
            ->whereIn('stripe_status', ['active', 'past_due'])
            ->get(['stripe_price', 'quantity', 'stripe_status', 'created_at']);

        $mrr = 0.0;
        $planBreakdown = [
            'individual_monthly' => ['label' => 'Individual mensal', 'accounts' => 0, 'mrr' => 0.0],
            'individual_yearly'  => ['label' => 'Individual anual',  'accounts' => 0, 'mrr' => 0.0],
            'company'            => ['label' => 'Empresas',          'accounts' => 0, 'mrr' => 0.0],
            'unknown'            => ['label' => 'Outro',             'accounts' => 0, 'mrr' => 0.0],
        ];

        foreach ($activeSubs as $sub) {
            [$key, $monthly] = $this->subscriptionMonthlyValue($sub->stripe_price, (int) ($sub->quantity ?: 1));
            $mrr += $monthly;
            $planBreakdown[$key]['accounts']++;
            $planBreakdown[$key]['mrr'] += $monthly;
        }
        $arr  = $mrr * 12;
        $arpa = count($activeSubs) > 0 ? $mrr / count($activeSubs) : 0;

        // ── Accounts / subscription states ───────────────────────────────────
        $totalActive    = DB::table('subscriptions')->where('stripe_status', 'active')->count();
        $totalTrialing  = DB::table('subscriptions')->where('stripe_status', 'trialing')->count();
        $totalPastDue   = DB::table('subscriptions')->where('stripe_status', 'past_due')->count();
        $totalCancelled = DB::table('subscriptions')->where('stripe_status', 'canceled')->count();
        $payingAccounts = count($activeSubs);

        // ── Churn (logo) this month ──────────────────────────────────────────
        $churnedThisMonth = DB::table('subscriptions')
            ->where('stripe_status', 'canceled')
            ->where('updated_at', '>=', $startOfMonth)
            ->count();
        $activeAtStartOfMonth = DB::table('subscriptions')
            ->where('created_at', '<', $startOfMonth)
            ->whereIn('stripe_status', ['active', 'canceled', 'past_due'])
            ->count();
        $churnRate = $activeAtStartOfMonth > 0
            ? round(($churnedThisMonth / $activeAtStartOfMonth) * 100, 1)
            : 0;

        // ── Users / signups ──────────────────────────────────────────────────
        $totalUsers        = User::count();
        $activeUsers       = User::where('is_active', true)->count();
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        $newUsersLastMonth = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $userGrowthPct     = $newUsersLastMonth > 0
            ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1)
            : ($newUsersThisMonth > 0 ? 100 : 0);

        // ── Platform engagement (real counters) ──────────────────────────────
        $totalCards    = BusinessCard::count();
        $totalViews    = (int) BusinessCard::sum('views_count');
        $totalQrScans  = (int) BusinessCard::sum('qr_scans');
        $totalContacts = (int) BusinessCard::sum('contacts_saved');
        $scanToSave    = $totalQrScans > 0 ? round(($totalContacts / $totalQrScans) * 100, 1) : 0;

        // Engagement funnel (only the steps we genuinely track)
        $funnel = [
            ['name' => 'QR scans / tap',     'value' => $totalQrScans],
            ['name' => 'Cartões vistos',     'value' => $totalViews],
            ['name' => 'Contactos guardados', 'value' => $totalContacts],
        ];

        // ── 12-month MRR + signup trend ──────────────────────────────────────
        $months = [];
        $signupSeries = [];
        $mrrSeries = [];
        for ($i = 11; $i >= 0; $i--) {
            $month      = $now->copy()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd   = $month->copy()->endOfMonth();
            $months[]   = $month->locale('pt')->isoFormat('MMM');

            $signupSeries[] = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();

            // MRR contributed by subscriptions that were active during that month
            $subsInMonth = DB::table('subscriptions')
                ->where('created_at', '<=', $monthEnd)
                ->where(function ($q) use ($monthStart) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', $monthStart);
                })
                ->get(['stripe_price', 'quantity']);
            $monthMrr = 0.0;
            foreach ($subsInMonth as $s) {
                [, $m] = $this->subscriptionMonthlyValue($s->stripe_price, (int) ($s->quantity ?: 1));
                $monthMrr += $m;
            }
            $mrrSeries[] = round($monthMrr, 2);
        }

        // ── Accounts table (real, with health signal) ───────────────────────
        $accounts = User::whereHas('subscriptions', function ($q) {
                $q->whereIn('stripe_status', ['active', 'trialing', 'past_due']);
            })
            ->with('subscriptions')
            ->withSum('businessCards as views_sum', 'views_count')
            ->withSum('businessCards as contacts_sum', 'contacts_saved')
            ->withCount('businessCards')
            ->get()
            ->map(function ($u) use ($now) {
                $sub      = $u->subscriptions->firstWhere('stripe_status', 'active')
                            ?? $u->subscriptions->first();
                [$planKey, $monthly] = $this->subscriptionMonthlyValue(
                    $sub->stripe_price ?? null, (int) ($sub->quantity ?? 1)
                );
                $daysInactive = $u->last_login_at
                    ? (int) $u->last_login_at->diffInDays($now)
                    : 999;
                $status = $sub->stripe_status ?? 'active';
                $health = match (true) {
                    $status === 'past_due'      => 'risk',
                    $daysInactive >= 14         => 'risk',
                    $daysInactive >= 7          => 'watch',
                    $status === 'trialing'      => 'watch',
                    default                     => 'healthy',
                };
                return (object) [
                    'name'         => $u->name,
                    'email'        => $u->email,
                    'plan'         => $this->planLabel($planKey, (int) ($sub->quantity ?? 1)),
                    'mrr'          => $monthly,
                    'cards'        => $u->business_cards_count,
                    'views'        => (int) $u->views_sum,
                    'contacts'     => (int) $u->contacts_sum,
                    'status'       => $status,
                    'health'       => $health,
                    'days_inactive'=> $daysInactive,
                    'since'        => $u->created_at,
                ];
            })
            ->sortByDesc('mrr')
            ->values();

        $healthCounts = [
            'healthy' => $accounts->where('health', 'healthy')->count(),
            'watch'   => $accounts->where('health', 'watch')->count(),
            'risk'    => $accounts->where('health', 'risk')->count(),
        ];

        // ── Top cards (real performers) ──────────────────────────────────────
        $topCards = BusinessCard::orderByDesc('views_count')
            ->take(8)
            ->with('user')
            ->get()
            ->map(function ($c) {
                $conv = $c->qr_scans > 0 ? round(($c->contacts_saved / $c->qr_scans) * 100) : 0;
                return (object) [
                    'name'     => $c->full_name,
                    'position' => $c->position,
                    'views'    => (int) $c->views_count,
                    'saves'    => (int) $c->contacts_saved,
                    'scans'    => (int) $c->qr_scans,
                    'conv'     => $conv,
                ];
            });

        // ── Recent activity (real events from local data) ────────────────────
        $recentSignups = User::latest()->take(6)->get(['name', 'created_at']);

        return view('admin.crm', compact(
            'mrr', 'arr', 'arpa', 'planBreakdown',
            'totalActive', 'totalTrialing', 'totalPastDue', 'totalCancelled', 'payingAccounts',
            'churnRate', 'churnedThisMonth',
            'totalUsers', 'activeUsers', 'newUsersThisMonth', 'userGrowthPct',
            'totalCards', 'totalViews', 'totalQrScans', 'totalContacts', 'scanToSave',
            'funnel', 'months', 'signupSeries', 'mrrSeries',
            'accounts', 'healthCounts', 'topCards', 'recentSignups'
        ));
    }

    /**
     * Map a subscription's Stripe price + quantity to a monthly EUR value.
     * Returns [planKey, monthlyValue]. Uses real configured price IDs.
     */
    private function subscriptionMonthlyValue(?string $stripePrice, int $quantity): array
    {
        $prices = config('services.stripe.prices');

        if ($stripePrice && $stripePrice === ($prices['individual_monthly'] ?? null)) {
            return ['individual_monthly', 10.0];
        }
        if ($stripePrice && $stripePrice === ($prices['individual_yearly'] ?? null)) {
            // €7/mês cobrado anualmente (€84/ano) → €7 MRR
            return ['individual_yearly', 7.0];
        }
        if ($stripePrice && $stripePrice === ($prices['company'] ?? null)) {
            $tier = $this->companySeatPrice($quantity);
            return ['company', $tier * $quantity];
        }
        return ['unknown', 0.0];
    }

    /**
     * Per-seat price for the company plan, mirroring SubscriptionController tiers.
     */
    private function companySeatPrice(int $seats): float
    {
        foreach (SubscriptionController::TIERS as $tier) {
            if ($seats >= $tier['min'] && $seats <= $tier['max']) {
                return (float) $tier['price'];
            }
        }
        return (float) SubscriptionController::TIERS[count(SubscriptionController::TIERS) - 1]['price'];
    }

    private function planLabel(string $planKey, int $quantity): string
    {
        return match ($planKey) {
            'individual_monthly' => 'Individual · mensal',
            'individual_yearly'  => 'Individual · anual',
            'company'            => "Empresas · {$quantity} seats",
            default              => 'Outro',
        };
    }

    /**
     * Display users management.
     */
    public function users(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            if ($request->type === 'company') {
                // "Company" is derived from owning a company, not a role.
                $query->whereHas('companies', fn ($q) => $q->where('company_user.is_admin', true));
            } else {
                $query->where('type', $request->type);
            }
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('company')) {
            $query->whereHas('companies', function($q) use ($request) {
                $q->where('company_id', $request->company);
            });
        }

        $users = $query->with(['businessCards', 'companies'])->paginate(20);
        $companies = Company::orderBy('name')->get();

        return view('admin.users', compact('users', 'companies'));
    }

    /**
     * Display companies management.
     */
    public function companies(Request $request): View
    {
        $query = Company::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $companies = $query->withCount(['users', 'businessCards'])->paginate(20);

        return view('admin.companies', compact('companies'));
    }

    /**
     * Display business cards management.
     */
    public function businessCards(Request $request): View
    {
        $query = BusinessCard::with(['user', 'company']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $businessCards = $query->paginate(20);

        return view('admin.business-cards', compact('businessCards'));
    }

    /**
     * Toggle user status.
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'ativado' : 'desativado';
        return back()->with('success', "Usuário {$status} com sucesso!");
    }

    /**
     * Toggle company status.
     */
    public function toggleCompanyStatus(Company $company)
    {
        $company->update(['is_active' => !$company->is_active]);

        $status = $company->is_active ? 'ativada' : 'desativada';
        return back()->with('success', "Empresa {$status} com sucesso!");
    }

    /**
     * Toggle business card status.
     */
    public function toggleBusinessCardStatus(BusinessCard $businessCard)
    {
        $businessCard->update(['is_active' => !$businessCard->is_active]);

        $status = $businessCard->is_active ? 'ativado' : 'desativado';
        return back()->with('success', "Cartão de visita {$status} com sucesso!");
    }

    /**
     * Show form to create a new company.
     */
    public function createCompany(): View
    {
        return view('admin.companies-create');
    }

    /**
     * Store a new company.
     */
    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:companies,slug',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'industry' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ]);

        $validated['is_active'] = true;

        Company::create($validated);

        return redirect()->route('admin.companies')->with('success', 'Empresa criada com sucesso!');
    }

    /**
     * Delete a company.
     */
    public function destroyCompany(Company $company)
    {
        $companyName = $company->name;
        $company->delete();

        return redirect()->route('admin.companies')->with('success', "Empresa '{$companyName}' removida com sucesso!");
    }

}

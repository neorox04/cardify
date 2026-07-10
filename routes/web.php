<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\ContactShareController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\WebhookController;

// Stripe webhook (fora do middleware de auth)
Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);

// Preview de páginas de erro (remover antes de deploy)
if (app()->isLocal()) {
    Route::get('/_errors/{code}', fn(int $code) => response()->view("errors.{$code}", [], $code));
}

// Public routes
Route::get('/', function () {
    return view('welcome2');
})->name('home');

Route::get('/privacidade', fn() => view('privacidade'))->name('privacidade');
Route::get('/termos', fn() => view('termos'))->name('termos');
Route::get('/planos', [SubscriptionController::class, 'showPlans'])->name('subscriptions.plans');
Route::get('/empresas', [SubscriptionController::class, 'enterprisePage'])->name('enterprise');
Route::post('/empresas/contacto', [SubscriptionController::class, 'enterpriseContact'])->name('enterprise.contact');

// Public support request form
Route::get('/suporte', [SupportController::class, 'create'])->name('support.contact');
Route::post('/suporte', [SupportController::class, 'store'])->middleware('throttle:6,1')->name('support.store');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    // Endpoint de polling — sem middleware verified, usado pela página de verificação
    Route::get('/email/verified-status', function () {
        return response()->json(['verified' => auth()->user()->hasVerifiedEmail()]);
    })->name('verification.status');
});

// Verification link — sem auth: funciona em qualquer dispositivo, mesmo sem sessão ativa
Route::get('/email/verify/{id}/{hash}', function (Illuminate\Http\Request $request, $id, $hash) {
    $user = App\Models\User::findOrFail($id);

    if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        abort(403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Illuminate\Auth\Events\Verified($user));
    }

    // Autenticar no dispositivo atual se ainda não estiver logado
    if (!auth()->check()) {
        auth()->login($user);
        $request->session()->regenerate();
    }

    return redirect()->route('dashboard')->with('success', 'Email verificado com sucesso! Bem-vindo ao Cardifys!');
})->middleware('signed')->name('verification.verify');

// Password Reset routes
Route::middleware('guest')->group(function () {
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Public business card view
Route::get('/card/demo', [BusinessCardController::class, 'demoCard'])->name('card.demo');
Route::get('/card/demo/vcard', [BusinessCardController::class, 'demoVCard'])->name('card.demo.vcard');
Route::get('/card/{slug}', [BusinessCardController::class, 'publicCard'])->name('card.public');
Route::get('/card/{businessCard}/vcard', [BusinessCardController::class, 'downloadVCard'])->name('card.vcard');
Route::get('/card/{businessCard}/save', [BusinessCardController::class, 'saveContact'])->name('card.save');

// Reciprocity — a visitor shares their contact back with the card owner
Route::post('/card/{businessCard}/share', [ContactShareController::class, 'store'])
    ->middleware('throttle:8,1')->name('card.share');
Route::get('/contact/{token}', [ContactShareController::class, 'qr'])->name('contact.qr');
Route::get('/contact/{token}/vcard', [ContactShareController::class, 'vcard'])->name('contact.vcard');

// Authentication required routes
Route::middleware(['auth', 'verified', 'active.user'])->group(function () {
    
    // Subscription checkout & billing
    Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
    Route::get('/checkout/success', [SubscriptionController::class, 'success'])->name('subscriptions.success');
    Route::get('/checkout/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::get('/checkout/enterprise', [SubscriptionController::class, 'enterprise'])->name('subscriptions.enterprise');
    Route::get('/billing/seats', [SubscriptionController::class, 'seats'])->name('subscriptions.seats');
    Route::post('/billing/seats', [SubscriptionController::class, 'updateSeats'])->name('subscriptions.seats.update');
    Route::get('/billing/invoices', [SubscriptionController::class, 'invoices'])->name('subscriptions.invoices');
    Route::get('/billing/invoices/{invoice}', [SubscriptionController::class, 'downloadInvoice'])->name('subscriptions.invoices.download');
    Route::get('/billing/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel-confirm');
    Route::post('/billing/cancel', [SubscriptionController::class, 'confirmCancelSubscription'])->name('subscriptions.cancel-confirm.post');

    // Main Dashboard (redirects based on user type)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCompanyAdmin()) {
            return redirect()->route('company.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
    
    // User Dashboard
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [UserDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/received-contacts', [UserDashboardController::class, 'receivedContacts'])->name('received-contacts');
        Route::get('/received-contacts/{sharedContact}/vcard', [UserDashboardController::class, 'downloadReceived'])->name('received-contacts.vcard');
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    });

    // Business Cards
    Route::resource('business-cards', BusinessCardController::class);

    // Company Dashboard - for company admins
    Route::middleware('company.admin')->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
        Route::get('/create', [CompanyDashboardController::class, 'create'])->name('create');
        Route::post('/store', [CompanyDashboardController::class, 'store'])->name('store');
        Route::get('/{company}', [CompanyDashboardController::class, 'show'])->name('show');
        Route::get('/{company}/edit', [CompanyDashboardController::class, 'edit'])->name('edit');
        Route::put('/{company}', [CompanyDashboardController::class, 'update'])->name('update');
        Route::get('/{company}/import/template', [CompanyDashboardController::class, 'downloadTemplate'])->name('import.template');
        Route::post('/{company}/import', [CompanyDashboardController::class, 'importCards'])->name('import');
    });

    // Admin Panel - for super admins only
    Route::middleware('super.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminPanelController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [AdminPanelController::class, 'analytics'])->name('analytics');
        Route::get('/crm', [AdminPanelController::class, 'crm'])->name('crm');

        // Support board
        Route::get('/support', [SupportController::class, 'index'])->name('support');
        Route::patch('/support/{ticket}/status', [SupportController::class, 'updateStatus'])->name('support.status');
        Route::delete('/support/{ticket}', [SupportController::class, 'destroy'])->name('support.destroy');

        // Roadmap board
        Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap');
        Route::post('/roadmap', [RoadmapController::class, 'store'])->name('roadmap.store');
        Route::patch('/roadmap/{item}', [RoadmapController::class, 'update'])->name('roadmap.update');
        Route::delete('/roadmap/{item}', [RoadmapController::class, 'destroy'])->name('roadmap.destroy');
        Route::get('/users', [AdminPanelController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminPanelController::class, 'showUser'])->name('users.show');
        Route::delete('/users/{user}', [AdminPanelController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/companies', [AdminPanelController::class, 'companies'])->name('companies');
        Route::get('/business-cards', [AdminPanelController::class, 'businessCards'])->name('business-cards');
        
        // Company management (companies are created self-serve at registration).
        Route::delete('/companies/{company}', [AdminPanelController::class, 'destroyCompany'])->name('companies.destroy');
        
        // Status toggles
        Route::patch('/users/{user}/toggle-status', [AdminPanelController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/companies/{company}/toggle-status', [AdminPanelController::class, 'toggleCompanyStatus'])->name('companies.toggle-status');
        Route::patch('/business-cards/{businessCard}/toggle-status', [AdminPanelController::class, 'toggleBusinessCardStatus'])->name('business-cards.toggle-status');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\CompanyInviteController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Stripe webhook (fora do middleware de auth)
Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Email verificado com sucesso! Bem-vindo ao Cardify!');
    })->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

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

// Authentication required routes
Route::middleware(['auth', 'verified', 'active.user'])->group(function () {
    
    // Subscription plans & checkout
    Route::get('/planos', [SubscriptionController::class, 'showPlans'])->name('subscriptions.plans');
    Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
    Route::get('/checkout/success', [SubscriptionController::class, 'success'])->name('subscriptions.success');
    Route::get('/checkout/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

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
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/invites', [CompanyInviteController::class, 'index'])->name('invites');
        Route::post('/invites/{invite}/accept', [CompanyInviteController::class, 'accept'])->name('invites.accept');
        Route::post('/invites/{invite}/decline', [CompanyInviteController::class, 'decline'])->name('invites.decline');
        
        // User's company area
        Route::get('/company/{company}', [UserDashboardController::class, 'companyShow'])->name('company.show');
        Route::get('/company/{company}/colleagues', [UserDashboardController::class, 'companyColleagues'])->name('company.colleagues');
        Route::post('/company/{company}/leave', [UserDashboardController::class, 'leaveCompany'])->name('company.leave');
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
        Route::get('/{company}/employees', [CompanyDashboardController::class, 'employees'])->name('employees');
        
        // Company invites
        Route::get('/{company}/invites', [CompanyInviteController::class, 'create'])->name('invites');
        Route::post('/{company}/invites', [CompanyInviteController::class, 'store'])->name('invites.store');
        Route::delete('/invites/{invite}', [CompanyInviteController::class, 'cancel'])->name('invites.cancel');
        Route::delete('/{company}/members/{user}', [CompanyInviteController::class, 'removeMember'])->name('members.remove');
    });

    // Admin Panel - for super admins only
    Route::middleware('super.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminPanelController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminPanelController::class, 'users'])->name('users');
        Route::get('/companies', [AdminPanelController::class, 'companies'])->name('companies');
        Route::get('/business-cards', [AdminPanelController::class, 'businessCards'])->name('business-cards');
        
        // Company management
        Route::get('/companies/create', [AdminPanelController::class, 'createCompany'])->name('companies.create');
        Route::post('/companies', [AdminPanelController::class, 'storeCompany'])->name('companies.store');
        Route::delete('/companies/{company}', [AdminPanelController::class, 'destroyCompany'])->name('companies.destroy');
        
        // Company invites (admin can manage any company)
        Route::get('/companies/{company}/invites', [CompanyInviteController::class, 'create'])->name('companies.invites');
        Route::post('/companies/{company}/invites', [CompanyInviteController::class, 'store'])->name('companies.invites.store');
        Route::delete('/invites/{invite}', [CompanyInviteController::class, 'cancel'])->name('invites.cancel');
        Route::delete('/companies/{company}/members/{user}', [CompanyInviteController::class, 'removeMember'])->name('companies.members.remove');
        
        // Company members management (assign users directly)
        Route::get('/companies/{company}/members', [AdminPanelController::class, 'companyMembers'])->name('companies.members');
        Route::post('/companies/{company}/members', [AdminPanelController::class, 'addCompanyMember'])->name('companies.members.add');
        Route::patch('/companies/{company}/members/{user}', [AdminPanelController::class, 'updateCompanyMember'])->name('companies.members.update');
        
        // User company management (from users page)
        Route::post('/users/{user}/add-company', [AdminPanelController::class, 'addUserToCompany'])->name('users.add-company');
        
        // Status toggles
        Route::patch('/users/{user}/toggle-status', [AdminPanelController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/companies/{company}/toggle-status', [AdminPanelController::class, 'toggleCompanyStatus'])->name('companies.toggle-status');
        Route::patch('/business-cards/{businessCard}/toggle-status', [AdminPanelController::class, 'toggleBusinessCardStatus'])->name('business-cards.toggle-status');
    });
});

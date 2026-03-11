<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\BusinessCardController;

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

// Public business card view
Route::get('/card/{slug}', [BusinessCardController::class, 'publicCard'])->name('card.public');

// Authentication required routes
Route::middleware(['auth', 'active.user'])->group(function () {
    
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
    });

    // Admin Panel - for super admins only
    Route::middleware('super.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminPanelController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminPanelController::class, 'users'])->name('users');
        Route::get('/companies', [AdminPanelController::class, 'companies'])->name('companies');
        Route::get('/business-cards', [AdminPanelController::class, 'businessCards'])->name('business-cards');
        
        // Status toggles
        Route::patch('/users/{user}/toggle-status', [AdminPanelController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::patch('/companies/{company}/toggle-status', [AdminPanelController::class, 'toggleCompanyStatus'])->name('companies.toggle-status');
        Route::patch('/business-cards/{businessCard}/toggle-status', [AdminPanelController::class, 'toggleBusinessCardStatus'])->name('business-cards.toggle-status');
    });
});

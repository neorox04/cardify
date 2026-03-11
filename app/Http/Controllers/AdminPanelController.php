<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\BusinessCard;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $activeUsers = User::where('is_active', true)->count();
        $recentUsers = User::latest()->take(10)->get();
        $recentCompanies = Company::latest()->take(10)->get();
        $topBusinessCards = BusinessCard::orderBy('views_count', 'desc')->take(10)->with(['user', 'company'])->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCompanies', 
            'totalBusinessCards',
            'activeUsers',
            'recentUsers',
            'recentCompanies',
            'topBusinessCards'
        ));
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
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->with('businessCards')->paginate(20);

        return view('admin.users', compact('users'));
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
}

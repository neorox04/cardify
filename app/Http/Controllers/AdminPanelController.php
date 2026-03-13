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
     * Add a user to a company (from users page).
     */
    public function addUserToCompany(Request $request, User $user)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'role' => 'required|in:employee,manager,admin',
            'is_admin' => 'nullable',
        ]);

        $company = Company::findOrFail($validated['company_id']);

        // Check if user is already a member
        if ($user->companies()->where('company_id', $company->id)->exists()) {
            return back()->with('error', 'Este utilizador já pertence a esta empresa.');
        }

        $isAdmin = $request->boolean('is_admin');

        $user->companies()->attach($company->id, [
            'role' => $validated['role'],
            'is_admin' => $isAdmin,
        ]);

        // If user becomes company admin, update their type
        if ($isAdmin && $user->type === 'user') {
            $user->update(['type' => 'company_admin']);
        }

        return back()->with('success', "Utilizador '{$user->name}' adicionado à empresa '{$company->name}' com sucesso!");
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

    /**
     * Display company members management.
     */
    public function companyMembers(Company $company): View
    {
        $company->load(['users' => function($query) {
            $query->orderBy('name');
        }]);
        
        // Get users not in this company for the "add user" dropdown
        $availableUsers = User::whereDoesntHave('companies', function($query) use ($company) {
            $query->where('company_id', $company->id);
        })->orderBy('name')->get();
        
        return view('admin.company-members', compact('company', 'availableUsers'));
    }

    /**
     * Add a user to a company.
     */
    public function addCompanyMember(Request $request, Company $company)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:employee,manager,admin',
            'is_admin' => 'boolean',
        ]);

        // Check if user is already a member
        if ($company->users()->where('user_id', $validated['user_id'])->exists()) {
            return back()->with('error', 'Este utilizador já pertence a esta empresa.');
        }

        $company->users()->attach($validated['user_id'], [
            'role' => $validated['role'],
            'is_admin' => $request->boolean('is_admin'),
        ]);

        $user = User::find($validated['user_id']);
        
        // If user becomes company admin, update their type
        if ($request->boolean('is_admin') && $user->type === 'user') {
            $user->update(['type' => 'company_admin']);
        }

        return back()->with('success', "Utilizador '{$user->name}' adicionado à empresa com sucesso!");
    }

    /**
     * Update a user's role in a company.
     */
    public function updateCompanyMember(Request $request, Company $company, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:employee,manager,admin',
            'is_admin' => 'nullable',
        ]);

        $isAdmin = $request->boolean('is_admin');

        $company->users()->updateExistingPivot($user->id, [
            'role' => $validated['role'],
            'is_admin' => $isAdmin,
        ]);

        // Update user type if needed
        if ($isAdmin && $user->type === 'user') {
            $user->update(['type' => 'company_admin']);
        } elseif (!$isAdmin) {
            // Check if user is admin of any other company
            $isAdminElsewhere = $user->companies()
                ->where('company_id', '!=', $company->id)
                ->wherePivot('is_admin', true)
                ->exists();
            
            if (!$isAdminElsewhere && $user->type === 'company_admin') {
                $user->update(['type' => 'user']);
            }
        }

        return back()->with('success', "Função do utilizador '{$user->name}' atualizada com sucesso!");
    }
}

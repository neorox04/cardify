<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CompanyDashboardController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the company dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $companies = $user->companies()->with(['businessCards', 'users'])->get();
        
        $totalEmployees = 0;
        $totalBusinessCards = 0;
        $totalViews = 0;
        
        foreach ($companies as $company) {
            $totalEmployees += $company->users->count();
            $totalBusinessCards += $company->businessCards->count();
            $totalViews += $company->businessCards->sum('views_count');
        }

        return view('company.dashboard', compact('companies', 'totalEmployees', 'totalBusinessCards', 'totalViews'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(): View
    {
        return view('company.create');
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|in:startup,small,medium,large,enterprise',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $companyData = $request->except(['logo']);
        $companyData['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $companyData['logo'] = $logoPath;
        }

        $company = Company::create($companyData);
        
        // Associate the creating user as admin
        $company->users()->attach(Auth::id(), [
            'role' => 'admin',
            'is_admin' => true,
        ]);

        return redirect()->route('company.dashboard')->with('success', 'Empresa criada com sucesso!');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): View
    {
        $this->authorize('view', $company);
        
        $businessCards = $company->businessCards()->with('user')->latest()->get();
        $employees = $company->users()->get();

        return view('company.show', compact('company', 'businessCards', 'employees'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company): View
    {
        $this->authorize('update', $company);
        
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|in:startup,small,medium,large,enterprise',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $companyData = $request->except(['logo']);
        
        if ($request->name !== $company->name) {
            $companyData['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $companyData['logo'] = $logoPath;
        }

        $company->update($companyData);

        return redirect()->back()->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Manage company employees.
     */
    public function employees(Company $company): View
    {
        $this->authorize('update', $company);
        
        $employees = $company->users()->withPivot(['role', 'is_admin'])->get();
        
        return view('company.employees', compact('company', 'employees'));
    }
}

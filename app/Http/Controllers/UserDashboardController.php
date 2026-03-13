<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessCard;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{


    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $businessCards = $user->businessCards()->latest()->get();
        $totalViews = $businessCards->sum('views_count');
        $companies = $user->companies()->get();

        return view('dashboards.user', compact('user', 'businessCards', 'totalViews', 'companies'));
    }

    /**
     * Show user profile.
     */
    public function profile(): View
    {
        $user = Auth::user();
        
        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        $userData = $request->only(['name', 'email', 'phone', 'bio']);

        if ($request->hasFile('avatar')) {
            // Handle avatar upload
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Show company details for the user.
     */
    public function companyShow(Company $company): View
    {
        $user = Auth::user();
        
        // Check if user belongs to this company
        $membership = $user->companies()->where('company_id', $company->id)->first();
        
        if (!$membership) {
            abort(403, 'Não pertences a esta empresa.');
        }

        $colleagues = $company->users()->where('user_id', '!=', $user->id)->get();
        $companyCards = $company->businessCards()->with('user')->latest()->get();
        $myRole = $membership->pivot->role;

        return view('user.company-show', compact('company', 'colleagues', 'companyCards', 'myRole', 'membership'));
    }

    /**
     * Show company colleagues.
     */
    public function companyColleagues(Company $company): View
    {
        $user = Auth::user();
        
        // Check if user belongs to this company
        if (!$user->companies()->where('company_id', $company->id)->exists()) {
            abort(403, 'Não pertences a esta empresa.');
        }

        $colleagues = $company->users()->get();

        return view('user.company-colleagues', compact('company', 'colleagues'));
    }

    /**
     * Leave a company.
     */
    public function leaveCompany(Company $company)
    {
        $user = Auth::user();
        
        // Check if user belongs to this company
        if (!$user->companies()->where('company_id', $company->id)->exists()) {
            abort(403, 'Não pertences a esta empresa.');
        }

        // Remove user from company
        $user->companies()->detach($company->id);

        return redirect()->route('user.dashboard')->with('success', "Saíste da empresa {$company->name}.");
    }
}

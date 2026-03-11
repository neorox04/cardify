<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessCard;
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

        return view('dashboards.user', compact('user', 'businessCards', 'totalViews'));
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
}

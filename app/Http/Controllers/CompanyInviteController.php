<?php

namespace App\Http\Controllers;

use App\Models\CompanyInvite;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyInviteController extends Controller
{
    /**
     * Display pending invites for the current user.
     */
    public function index(): View
    {
        $invites = CompanyInvite::with(['company', 'inviter'])
            ->forEmail(Auth::user()->email)
            ->pending()
            ->latest()
            ->get();

        return view('user.invites', compact('invites'));
    }

    /**
     * Show the invite employees page for a company.
     */
    public function create(Company $company): View
    {
        // Check if user is admin of this company
        $this->authorizeCompanyAdmin($company);

        $pendingInvites = CompanyInvite::where('company_id', $company->id)
            ->pending()
            ->with('inviter')
            ->latest()
            ->get();

        $members = $company->users()->get();

        // Use different view based on if user is super admin
        $view = Auth::user()->isSuperAdmin() ? 'admin.company-invites' : 'company.invites';

        return view($view, compact('company', 'pendingInvites', 'members'));
    }

    /**
     * Send an invite to join a company.
     */
    public function store(Request $request, Company $company)
    {
        $this->authorizeCompanyAdmin($company);

        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'role' => 'nullable|string|max:100',
        ]);

        // Check if user is already a member
        $existingMember = $company->users()->where('email', $validated['email'])->exists();
        if ($existingMember) {
            return back()->with('error', 'Este utilizador já é membro da empresa.');
        }

        // Check if there's already a pending invite
        $existingInvite = CompanyInvite::where('company_id', $company->id)
            ->where('email', $validated['email'])
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->exists();

        if ($existingInvite) {
            return back()->with('error', 'Já existe um convite pendente para este email.');
        }

        CompanyInvite::create([
            'company_id' => $company->id,
            'email' => $validated['email'],
            'invited_by' => Auth::id(),
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'Convite enviado com sucesso!');
    }

    /**
     * Accept an invite.
     */
    public function accept(CompanyInvite $invite)
    {
        // Verify the invite belongs to the current user
        if ($invite->email !== Auth::user()->email) {
            abort(403);
        }

        if (!$invite->isPending()) {
            return redirect()->route('user.invites')->with('error', 'Este convite já não é válido.');
        }

        // Add user to company
        $invite->company->users()->attach(Auth::id(), [
            'role' => $invite->role ?? 'Colaborador',
            'is_admin' => false,
        ]);

        // Update invite status
        $invite->update(['status' => 'accepted']);

        return redirect()->route('user.invites')->with('success', "Juntaste-te à empresa {$invite->company->name}!");
    }

    /**
     * Decline an invite.
     */
    public function decline(CompanyInvite $invite)
    {
        // Verify the invite belongs to the current user
        if ($invite->email !== Auth::user()->email) {
            abort(403);
        }

        if (!$invite->isPending()) {
            return redirect()->route('user.invites')->with('error', 'Este convite já não é válido.');
        }

        $invite->update(['status' => 'declined']);

        return redirect()->route('user.invites')->with('success', 'Convite recusado.');
    }

    /**
     * Cancel a pending invite (company admin).
     */
    public function cancel(CompanyInvite $invite)
    {
        $this->authorizeCompanyAdmin($invite->company);

        if ($invite->status !== 'pending') {
            return back()->with('error', 'Este convite já não pode ser cancelado.');
        }

        $invite->delete();

        return back()->with('success', 'Convite cancelado.');
    }

    /**
     * Remove a member from company.
     */
    public function removeMember(Company $company, User $user)
    {
        $this->authorizeCompanyAdmin($company);

        // Can't remove yourself
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Não podes remover-te a ti próprio.');
        }

        $company->users()->detach($user->id);

        return back()->with('success', "Utilizador {$user->name} removido da empresa.");
    }

    /**
     * Check if current user is admin of the company.
     */
    private function authorizeCompanyAdmin(Company $company): void
    {
        $user = Auth::user();
        
        // Super admin can manage all
        if ($user->isSuperAdmin()) {
            return;
        }

        // Check if user is company admin
        $membership = $company->users()->where('user_id', $user->id)->first();
        
        if (!$membership || !$membership->pivot->is_admin) {
            abort(403, 'Não tens permissão para gerir esta empresa.');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsCompanyAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!$user->isCompanyAdmin() && !$user->isSuperAdmin()) {
            abort(403, 'Acesso negado. Você não tem permissões de administrador de empresa.');
        }

        return $next($request);
    }
}
<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Super admins may do anything.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    /**
     * Any member of the company may view it.
     */
    public function view(User $user, Company $company): bool
    {
        return $company->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Only company admins may manage the company (edit, import, invites, seats).
     */
    public function update(User $user, Company $company): bool
    {
        return $company->users()
            ->where('users.id', $user->id)
            ->wherePivot('is_admin', true)
            ->exists();
    }
}

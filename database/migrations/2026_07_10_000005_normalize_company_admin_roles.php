<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Roles are now just 'user' and 'super_admin'. Being a company is derived
 * from owning a company (is_admin pivot), not a separate account type, so
 * collapse existing company_admin accounts to plain users. Their company
 * ownership (and therefore company-admin access) is preserved via the pivot.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('type', 'company_admin')->update(['type' => 'user']);
    }

    public function down(): void
    {
        // Best-effort: re-tag users who own a company as company_admin.
        $ownerIds = DB::table('company_user')->where('is_admin', true)->pluck('user_id')->unique();
        if ($ownerIds->isNotEmpty()) {
            DB::table('users')->whereIn('id', $ownerIds)->update(['type' => 'company_admin']);
        }
    }
};

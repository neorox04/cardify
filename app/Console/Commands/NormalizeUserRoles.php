<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class NormalizeUserRoles extends Command
{
    protected $signature = 'cardify:normalize-roles {--dry-run : Show what would change without saving}';

    protected $description = 'Reset stale company_admin roles to user for accounts that do not own a company';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        // company_admin accounts that don't actually own any company (no is_admin
        // pivot). Filter on the pivot column directly — wherePivot() does not
        // apply inside a whereDoesntHave() closure.
        $stale = User::where('type', 'company_admin')
            ->whereDoesntHave('companies', fn ($q) => $q->where('company_user.is_admin', true))
            ->get(['id', 'name', 'email']);

        if ($stale->isEmpty()) {
            $this->info('Nothing to normalize — no stale company_admin accounts found.');
            return self::SUCCESS;
        }

        $this->warn(($dry ? '[dry-run] ' : '') . "Found {$stale->count()} stale company_admin account(s):");
        foreach ($stale as $u) {
            $this->line("  #{$u->id}  {$u->email}  ({$u->name})");
        }

        if ($dry) {
            $this->info('Dry run — nothing changed. Re-run without --dry-run to apply.');
            return self::SUCCESS;
        }

        $updated = User::whereIn('id', $stale->pluck('id'))->update(['type' => 'user']);
        $this->info("Reset {$updated} account(s) to 'user'.");

        return self::SUCCESS;
    }
}

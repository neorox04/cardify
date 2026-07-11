<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiagnosePrices extends Command
{
    protected $signature = 'cardify:diagnose-prices {email? : Email of a subscriber to inspect}';

    protected $description = 'Show the configured Stripe price IDs and how a user\'s subscription is classified';

    public function handle(): int
    {
        $prices = config('services.stripe.prices');

        $this->info('Configured price IDs:');
        foreach ($prices as $key => $id) {
            $this->line("  {$key} = {$id}");
        }
        $this->newLine();

        $email = $this->argument('email');
        if (!$email) {
            $this->comment('Pass an email to inspect a subscription: php artisan cardify:diagnose-prices you@email.com');
            return self::SUCCESS;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("No user with email {$email}.");
            return self::FAILURE;
        }

        $sub = DB::table('subscriptions')->where('user_id', $user->id)->where('type', 'default')->first();
        if (!$sub) {
            $this->warn("User {$email} has no default subscription.");
            return self::SUCCESS;
        }

        // Classification mirrors AdminPanelController::subscriptionMonthlyValue().
        $match = 'unknown (Outro)';
        if ($sub->stripe_price === ($prices['individual_monthly'] ?? null)) {
            $match = 'individual_monthly  →  Individual · mensal';
        } elseif ($sub->stripe_price === ($prices['individual_yearly'] ?? null)) {
            $match = 'individual_yearly   →  Individual · anual';
        } elseif ($sub->stripe_price === ($prices['company'] ?? null)) {
            $match = 'company             →  Empresas';
        }

        $this->info("Subscription for {$email}:");
        $this->line("  stripe_status = {$sub->stripe_status}");
        $this->line("  stripe_price  = {$sub->stripe_price}");
        $this->line("  quantity      = {$sub->quantity}");
        $this->newLine();
        $this->line("  Classified as: {$match}");
        $this->newLine();
        $this->comment('If this label is wrong, the STRIPE_PRICE_* env values do not match the real Stripe prices — fix them in Laravel Cloud so the monthly/yearly IDs are correct.');

        return self::SUCCESS;
    }
}

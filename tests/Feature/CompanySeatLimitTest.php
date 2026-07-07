<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Each company card consumes one paid seat. A company cannot create more
 * cards than it pays for (block on creation), and cannot downgrade seats
 * below the number of cards already in use.
 */
class CompanySeatLimitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a company with an admin subscribed to `$seats` seats.
     */
    private function companyWithSeats(int $seats): array
    {
        $admin = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);
        $admin->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $admin->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.company'),
            'quantity'      => $seats,
        ]);

        $company = Company::create(['name' => 'Acme', 'slug' => 'acme-' . uniqid(), 'is_active' => true]);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);

        return [$company, $admin];
    }

    private function seedCards(Company $company, User $admin, int $n): void
    {
        for ($i = 0; $i < $n; $i++) {
            BusinessCard::create([
                'user_id'    => $admin->id,
                'company_id' => $company->id,
                'full_name'  => "Employee {$i}",
                'email'      => "emp{$i}@acme.pt",
                'slug'       => Str::slug("emp-{$i}") . '-' . uniqid(),
                'is_public'  => true,
                'is_active'  => true,
                'theme'      => 'default',
            ]);
        }
    }

    // ── Seat accounting ───────────────────────────────────────────────────

    public function test_seat_limit_and_available_seats(): void
    {
        [$company, $admin] = $this->companyWithSeats(5);
        $this->assertEquals(5, $company->seatLimit());
        $this->assertEquals(5, $company->availableSeats());

        $this->seedCards($company, $admin, 3);
        $this->assertEquals(3, $company->companyCardCount());
        $this->assertEquals(2, $company->fresh()->availableSeats());
    }

    public function test_company_without_subscription_has_zero_seats(): void
    {
        $admin   = User::factory()->create(['is_active' => true, 'type' => 'company_admin']);
        $company = Company::create(['name' => 'Beta', 'slug' => 'beta', 'is_active' => true]);
        $company->users()->attach($admin->id, ['role' => 'admin', 'is_admin' => true]);

        $this->assertEquals(0, $company->seatLimit());
        $this->assertEquals(0, $company->availableSeats());
    }

    // ── Creation blocking ─────────────────────────────────────────────────

    public function test_admin_can_create_company_card_within_seats(): void
    {
        [$company, $admin] = $this->companyWithSeats(2);

        $this->actingAs($admin)->post('/business-cards', [
            'full_name'  => 'Funcionário Um',
            'company_id' => $company->id,
            'email'      => 'um@acme.pt',
            'theme'      => 'default',
        ]);

        $this->assertDatabaseHas('business_cards', [
            'company_id' => $company->id,
            'full_name'  => 'Funcionário Um',
        ]);
    }

    public function test_admin_cannot_create_company_card_beyond_seats(): void
    {
        [$company, $admin] = $this->companyWithSeats(1);
        $this->seedCards($company, $admin, 1); // seat already used

        $response = $this->actingAs($admin)->post('/business-cards', [
            'full_name'  => 'Extra',
            'company_id' => $company->id,
            'email'      => 'extra@acme.pt',
            'theme'      => 'default',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('business_cards', ['email' => 'extra@acme.pt']);
    }

    // ── Import blocking ───────────────────────────────────────────────────

    public function test_import_only_fills_available_seats(): void
    {
        [$company, $admin] = $this->companyWithSeats(2);

        $csv = "nome_completo,email\n"
             . "Ana,ana@acme.pt\n"
             . "Bruno,bruno@acme.pt\n"
             . "Carlos,carlos@acme.pt\n";
        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('team.csv', $csv);

        $this->actingAs($admin)->post("/company/{$company->slug}/import", [
            'csv_file' => $file,
        ]);

        // Only 2 of 3 imported (2 seats)
        $this->assertEquals(2, $company->fresh()->companyCardCount());
        $this->assertDatabaseMissing('business_cards', ['email' => 'carlos@acme.pt']);
    }

    // ── Downgrade guard ───────────────────────────────────────────────────

    public function test_cannot_downgrade_seats_below_cards_in_use(): void
    {
        [$company, $admin] = $this->companyWithSeats(5);
        $this->seedCards($company, $admin, 4);

        $response = $this->actingAs($admin)->post('/billing/seats', [
            'new_seats' => 2,
        ]);

        $response->assertSessionHas('error');
    }
}

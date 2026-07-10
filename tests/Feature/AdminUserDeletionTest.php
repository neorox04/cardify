<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\Company;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserDeletionTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(string $password = 'secret123'): User
    {
        return User::factory()->create([
            'type'      => 'super_admin',
            'is_active' => true,
            'password'  => Hash::make($password),
        ]);
    }

    private function targetWithData(): array
    {
        $user = User::factory()->create(['is_active' => true, 'email' => 'gone@example.com']);

        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_x',
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);

        $card = BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => 'c@example.com',
            'slug'      => 'card-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);
        $card->recordEvent('view', 'link');
        SharedContact::create([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $user->id,
            'token'             => 'tok' . uniqid(),
            'full_name'         => 'Visitor',
            'email'             => 'v@x.pt',
            'phone'             => '900',
            'method'            => 'email',
        ]);

        $company = Company::create(['name' => 'Acme', 'slug' => 'acme-' . uniqid(), 'is_active' => true]);
        $company->users()->attach($user->id, ['role' => 'admin', 'is_admin' => true]);

        return [$user, $card, $company];
    }

    public function test_super_admin_deletes_user_and_all_data_and_frees_email(): void
    {
        $admin = $this->superAdmin();
        [$user, $card, $company] = $this->targetWithData();

        $this->actingAs($admin)
            ->delete("/admin/users/{$user->id}", ['password' => 'secret123'])
            ->assertRedirect(route('admin.users'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('business_cards', ['id' => $card->id]);
        $this->assertDatabaseMissing('card_events', ['business_card_id' => $card->id]);
        $this->assertDatabaseMissing('shared_contacts', ['recipient_user_id' => $user->id]);
        $this->assertDatabaseMissing('subscriptions', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);

        // Email is free again.
        User::factory()->create(['email' => 'gone@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'gone@example.com']);
    }

    public function test_wrong_password_does_not_delete(): void
    {
        $admin = $this->superAdmin();
        [$user] = $this->targetWithData();

        $this->actingAs($admin)
            ->delete("/admin/users/{$user->id}", ['password' => 'wrong'])
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_cannot_delete_self(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)
            ->delete("/admin/users/{$admin->id}", ['password' => 'secret123'])
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_cannot_delete_another_super_admin(): void
    {
        $admin = $this->superAdmin();
        $other = User::factory()->create(['type' => 'super_admin', 'is_active' => true]);

        $this->actingAs($admin)
            ->delete("/admin/users/{$other->id}", ['password' => 'secret123'])
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $other->id]);
    }

    public function test_non_super_admin_cannot_delete_users(): void
    {
        $user   = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $target = User::factory()->create(['is_active' => true]);

        $this->actingAs($user)
            ->delete("/admin/users/{$target->id}", ['password' => 'whatever'])
            ->assertStatus(403);

        $this->assertDatabaseHas('users', ['id' => $target->id]);
    }
}

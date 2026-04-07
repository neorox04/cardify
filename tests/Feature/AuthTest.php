<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Páginas de guest
    // -------------------------------------------------------------------------

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_page_loads(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Registro
    // -------------------------------------------------------------------------

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'testuser@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'name'                  => 'Another User',
            'email'                 => 'existing@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_fails_with_mismatched_passwords(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_fails_without_name(): void
    {
        $response = $this->post('/register', [
            'name'                  => '',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_registration_fails_with_short_password(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email'     => 'login@example.com',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email'    => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'login@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'login@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_with_nonexistent_email(): void
    {
        $response = $this->post('/login', [
            'email'    => 'nobody@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_without_email(): void
    {
        $response = $this->post('/login', [
            'email'    => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // -------------------------------------------------------------------------
    // Redirecionamentos pós-login por papel (role)
    // -------------------------------------------------------------------------

    public function test_super_admin_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'type'      => 'super_admin',
            'is_active' => true,
            'password'  => Hash::make('password'),
        ]);

        $this->post('/login', ['email' => $admin->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($admin);
    }

    public function test_regular_user_is_redirected_to_user_dashboard(): void
    {
        $user = User::factory()->create([
            'type'      => 'user',
            'is_active' => true,
            'password'  => Hash::make('password'),
        ]);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
    }

    // -------------------------------------------------------------------------
    // Logout
    // -------------------------------------------------------------------------

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_logout(): void
    {
        $response = $this->post('/logout');

        // Redirects to login
        $response->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Guest redirect quando já autenticado
    // -------------------------------------------------------------------------

    public function test_authenticated_user_is_redirected_from_login_page(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect();
    }

    public function test_authenticated_user_is_redirected_from_register_page(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect();
    }
}

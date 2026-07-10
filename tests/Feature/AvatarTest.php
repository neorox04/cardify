<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\User;
use App\Support\Avatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    private function subscribedUser(array $attrs = []): User
    {
        $user = User::factory()->create(array_merge(['is_active' => true, 'type' => 'user'], $attrs));
        $user->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);

        return $user;
    }

    // ── Helper ────────────────────────────────────────────────────────────

    public function test_initials(): void
    {
        $this->assertEquals('C', Avatar::initials('Cardifys'));
        $this->assertEquals('RP', Avatar::initials('Rodrigo Pacheco'));
        $this->assertEquals('RS', Avatar::initials('Rodrigo Miguel Silva')); // first + last
        $this->assertEquals('?', Avatar::initials('   '));
    }

    public function test_svg_renders_each_style_and_falls_back(): void
    {
        foreach (array_keys(Avatar::STYLES) as $style) {
            $this->assertStringContainsString('<svg', Avatar::svg('Ana Silva', $style, 96));
        }
        // Unknown style falls back to the default (still valid svg).
        $this->assertStringContainsString('<svg', Avatar::svg('Ana Silva', 'bogus', 96));
    }

    public function test_duotone_splits_letters(): void
    {
        $svg = Avatar::svg('Ana Silva', 'dark-duo', 96);
        // First letter white, second purple.
        $this->assertStringContainsString('<tspan fill="white">A</tspan>', $svg);
        $this->assertStringContainsString('#B884FF">S</tspan>', $svg);
    }

    // ── Profile picker ────────────────────────────────────────────────────

    public function test_profile_shows_avatar_picker(): void
    {
        $user = User::factory()->create(['is_active' => true, 'name' => 'Rui Dono']);

        $response = $this->actingAs($user)->get('/user/profile');
        $response->assertStatus(200);
        $response->assertSee('estilo do teu avatar', false)->assertSee('Duotone');
        $response->assertSee('name="avatar_style"', false);
    }

    public function test_profile_saves_avatar_style(): void
    {
        $user = User::factory()->create(['is_active' => true, 'avatar_style' => 'dark-white']);

        $this->actingAs($user)->put('/user/profile', [
            'email'        => $user->email,
            'avatar_style' => 'dark-glow',
        ]);

        $this->assertEquals('dark-glow', $user->fresh()->avatar_style);
    }

    public function test_profile_rejects_invalid_style(): void
    {
        $user = User::factory()->create(['is_active' => true, 'avatar_style' => 'dark-white']);

        $this->actingAs($user)->put('/user/profile', [
            'email'        => $user->email,
            'avatar_style' => 'hacker',
        ])->assertSessionHasErrors('avatar_style');

        $this->assertEquals('dark-white', $user->fresh()->avatar_style);
    }

    // ── Public card uses the owner's chosen style ─────────────────────────

    public function test_public_card_renders_chosen_style(): void
    {
        $user = $this->subscribedUser(['name' => 'Ana Silva', 'avatar_style' => 'dark-duo']);
        $card = BusinessCard::create([
            'user_id'   => $user->id,
            'full_name' => 'Ana Silva',
            'email'     => 'ana@example.com',
            'slug'      => 'ana-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $response = $this->get('/card/' . $card->slug);
        $response->assertStatus(200);
        // Duotone split present → confirms the owner's style flows through.
        $response->assertSee('<tspan fill="white">A</tspan>', false);
    }
}

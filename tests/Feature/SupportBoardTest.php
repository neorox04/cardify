<?php

namespace Tests\Feature;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SupportBoardTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::factory()->create(['type' => 'super_admin', 'is_active' => true]);
    }

    // ── Public form ───────────────────────────────────────────────────────

    public function test_support_form_is_public(): void
    {
        $this->get('/suporte')->assertStatus(200)->assertSee('Precisas de ajuda?');
    }

    public function test_submitting_creates_ticket_and_notifies_admins(): void
    {
        Mail::fake();
        $this->superAdmin(); // recipient

        $this->post('/suporte', [
            'name'    => 'Ana Cliente',
            'email'   => 'ana@example.com',
            'subject' => 'Não consigo criar cartão',
            'message' => 'Aparece um erro quando guardo.',
        ])->assertRedirect(route('support.contact'))->assertSessionHas('support_sent');

        $this->assertDatabaseHas('support_tickets', [
            'email'  => 'ana@example.com',
            'status' => 'received',
        ]);
    }

    public function test_submitting_validates(): void
    {
        $this->post('/suporte', ['name' => 'X'])
            ->assertSessionHasErrors(['email', 'subject', 'message']);
    }

    // ── Admin board ───────────────────────────────────────────────────────

    public function test_admin_board_renders_grouped_tickets(): void
    {
        $admin = $this->superAdmin();
        SupportTicket::create(['name' => 'A', 'email' => 'a@x.pt', 'subject' => 'Bug X', 'message' => 'm', 'status' => 'received']);

        $this->actingAs($admin)->get('/admin/support')
            ->assertStatus(200)
            ->assertSee('Suporte')
            ->assertSee('Bug X')
            ->assertSee('A tratar');
    }

    public function test_status_can_be_updated_via_drag_endpoint(): void
    {
        $admin  = $this->superAdmin();
        $ticket = SupportTicket::create(['name' => 'A', 'email' => 'a@x.pt', 'subject' => 'S', 'message' => 'm']);

        $this->actingAs($admin)
            ->patchJson("/admin/support/{$ticket->id}/status", ['status' => 'in_progress'])
            ->assertStatus(200)->assertJson(['ok' => true]);

        $this->assertEquals('in_progress', $ticket->fresh()->status);
    }

    public function test_invalid_status_is_rejected(): void
    {
        $admin  = $this->superAdmin();
        $ticket = SupportTicket::create(['name' => 'A', 'email' => 'a@x.pt', 'subject' => 'S', 'message' => 'm']);

        $this->actingAs($admin)
            ->patchJson("/admin/support/{$ticket->id}/status", ['status' => 'bogus'])
            ->assertStatus(422);
    }

    public function test_non_super_admin_cannot_access_board(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $this->actingAs($user)->get('/admin/support')->assertStatus(403);
    }
}

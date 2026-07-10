<?php

namespace Tests\Feature;

use App\Models\RoadmapItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoadmapTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::factory()->create(['type' => 'super_admin', 'is_active' => true]);
    }

    public function test_board_renders(): void
    {
        $admin = $this->superAdmin();
        RoadmapItem::create(['title' => 'Nova feature', 'status' => 'todo', 'priority' => 'high']);

        $this->actingAs($admin)->get('/admin/roadmap')
            ->assertStatus(200)
            ->assertSee('Roadmap')
            ->assertSee('Nova feature')
            ->assertSee('Em curso');
    }

    public function test_can_add_item_and_stays_on_roadmap(): void
    {
        $admin = $this->superAdmin();

        // Non-AJAX fallback returns to the roadmap, not the home page.
        $this->actingAs($admin)->post('/admin/roadmap', [
            'title'    => 'Integração calendário',
            'priority' => 'high',
        ])->assertRedirect(route('admin.roadmap'));

        $this->assertDatabaseHas('roadmap_items', [
            'title'    => 'Integração calendário',
            'status'   => 'todo',
            'priority' => 'high',
        ]);
    }

    public function test_ajax_add_returns_item_json(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)->postJson('/admin/roadmap', [
            'title'    => 'App móvel',
            'priority' => 'medium',
        ])->assertStatus(200)
          ->assertJsonPath('item.title', 'App móvel')
          ->assertJsonPath('item.status', 'todo');
    }

    public function test_status_updates_via_drag(): void
    {
        $admin = $this->superAdmin();
        $item  = RoadmapItem::create(['title' => 'T', 'status' => 'todo']);

        $this->actingAs($admin)
            ->patchJson("/admin/roadmap/{$item->id}", ['status' => 'done'])
            ->assertStatus(200)->assertJson(['ok' => true]);

        $this->assertEquals('done', $item->fresh()->status);
    }

    public function test_can_delete_item(): void
    {
        $admin = $this->superAdmin();
        $item  = RoadmapItem::create(['title' => 'T', 'status' => 'todo']);

        $this->actingAs($admin)->delete("/admin/roadmap/{$item->id}")->assertRedirect();
        $this->assertDatabaseMissing('roadmap_items', ['id' => $item->id]);
    }

    public function test_non_super_admin_cannot_access(): void
    {
        $user = User::factory()->create(['is_active' => true, 'type' => 'user']);
        $this->actingAs($user)->get('/admin/roadmap')->assertStatus(403);
    }
}

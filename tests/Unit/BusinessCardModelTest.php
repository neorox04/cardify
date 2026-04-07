<?php

namespace Tests\Unit;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessCardModelTest extends TestCase
{
    use RefreshDatabase;

    private function makeCard(array $attrs = []): BusinessCard
    {
        $user = User::factory()->create();

        return BusinessCard::create(array_merge([
            'user_id'   => $user->id,
            'full_name' => $user->name,
            'email'     => $user->email,
            'slug'      => 'test-card-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ], $attrs));
    }

    public function test_route_key_name_is_slug(): void
    {
        $card = new BusinessCard();

        $this->assertEquals('slug', $card->getRouteKeyName());
    }

    public function test_url_attribute_returns_full_url(): void
    {
        $card = $this->makeCard(['slug' => 'my-card']);

        $this->assertStringContainsString('/card/my-card', $card->url);
    }

    public function test_increment_views_increases_count_by_one(): void
    {
        $card = $this->makeCard(['views_count' => 5]);

        $card->incrementViews();

        $this->assertEquals(6, $card->fresh()->views_count);
    }

    public function test_increment_views_multiple_times(): void
    {
        $card = $this->makeCard(['views_count' => 0]);

        $card->incrementViews();
        $card->incrementViews();
        $card->incrementViews();

        $this->assertEquals(3, $card->fresh()->views_count);
    }

    public function test_custom_fields_are_cast_to_array(): void
    {
        $card = $this->makeCard(['custom_fields' => ['foo' => 'bar', 'baz' => 42]]);

        $this->assertIsArray($card->fresh()->custom_fields);
        $this->assertEquals('bar', $card->fresh()->custom_fields['foo']);
    }

    public function test_is_public_is_cast_to_boolean(): void
    {
        $card = $this->makeCard(['is_public' => true]);

        $this->assertIsBool($card->fresh()->is_public);
        $this->assertTrue($card->fresh()->is_public);
    }

    public function test_is_active_is_cast_to_boolean(): void
    {
        $card = $this->makeCard(['is_active' => false]);

        $this->assertIsBool($card->fresh()->is_active);
        $this->assertFalse($card->fresh()->is_active);
    }

    public function test_business_card_belongs_to_user(): void
    {
        $card = $this->makeCard();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $card->user()
        );
    }

    public function test_business_card_belongs_to_company(): void
    {
        $card = $this->makeCard();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $card->company()
        );
    }

    public function test_soft_delete_does_not_permanently_remove_record(): void
    {
        $card = $this->makeCard();
        $id   = $card->id;

        $card->delete();

        $this->assertSoftDeleted('business_cards', ['id' => $id]);
        $this->assertDatabaseHas('business_cards', ['id' => $id]);
    }
}

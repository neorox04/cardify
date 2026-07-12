<?php

namespace Tests\Feature;

use App\Models\BusinessCard;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceivedContactsExportTest extends TestCase
{
    use RefreshDatabase;

    private function ownerWithContact(array $overrides = []): array
    {
        $owner = User::factory()->create(['is_active' => true, 'name' => 'Rui Dono']);
        $card  = BusinessCard::create([
            'user_id'   => $owner->id,
            'full_name' => 'Rui Dono',
            'email'     => 'owner@example.com',
            'slug'      => 'rui-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        SharedContact::create(array_merge([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $owner->id,
            'token'             => 'tok-' . uniqid(),
            'full_name'         => 'Ana Maria Silva',
            'email'             => 'ana@example.com',
            'phone'             => '+351 912 000 000',
            'method'            => 'qr',
        ], $overrides));

        return [$owner, $card];
    }

    public function test_export_returns_csv_with_contacts(): void
    {
        [$owner] = $this->ownerWithContact();

        $res = $this->actingAs($owner)->get(route('user.received-contacts.export'));

        $res->assertStatus(200);
        $this->assertStringContainsString('text/csv', $res->headers->get('Content-Type'));
        $this->assertStringContainsString('.csv', $res->headers->get('Content-Disposition'));

        $csv = $res->streamedContent();
        // CRM-friendly headers.
        $this->assertStringContainsString('first_name,last_name,email,phone,source,channel,captured_at', $csv);
        // Name is split on the last space: first="Ana Maria", last="Silva".
        $this->assertStringContainsString('"Ana Maria",Silva,ana@example.com', $csv);
        $this->assertStringContainsString('QR', $csv);
    }

    public function test_single_word_name_has_empty_last_name(): void
    {
        [$owner] = $this->ownerWithContact(['full_name' => 'Madonna', 'email' => 'm@example.com']);

        $csv = $this->actingAs($owner)
            ->get(route('user.received-contacts.export'))
            ->streamedContent();

        $this->assertStringContainsString('Madonna,,m@example.com', $csv);
    }

    public function test_export_only_includes_own_contacts(): void
    {
        [$owner] = $this->ownerWithContact();
        [$other] = $this->ownerWithContact(['full_name' => 'Outro Contacto', 'email' => 'outro@example.com']);

        $csv = $this->actingAs($owner)
            ->get(route('user.received-contacts.export'))
            ->streamedContent();

        $this->assertStringContainsString('ana@example.com', $csv);
        $this->assertStringNotContainsString('outro@example.com', $csv);
    }

    public function test_export_requires_auth(): void
    {
        $this->get(route('user.received-contacts.export'))->assertRedirect('/login');
    }
}

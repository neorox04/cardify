<?php

namespace Tests\Feature;

use App\Mail\SharedContactEmail;
use App\Models\BusinessCard;
use App\Models\SharedContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactShareTest extends TestCase
{
    use RefreshDatabase;

    private function ownerCard(): array
    {
        $owner = User::factory()->create(['is_active' => true, 'name' => 'Rui Dono']);
        $owner->subscriptions()->create([
            'type'          => 'default',
            'stripe_id'     => 'sub_' . $owner->id,
            'stripe_status' => 'active',
            'stripe_price'  => config('services.stripe.prices.individual_monthly'),
            'quantity'      => 1,
        ]);
        $card = BusinessCard::create([
            'user_id'   => $owner->id,
            'full_name' => 'Rui Dono',
            'email'     => 'owner@example.com',
            'slug'      => 'rui-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        return [$owner, $card];
    }

    private function payload(string $method): array
    {
        return [
            'full_name' => 'Ana Visitante',
            'phone'     => '+351 912 000 000',
            'email'     => 'ana@example.com',
            'method'    => $method,
        ];
    }

    public function test_share_by_email_stores_and_mails_owner(): void
    {
        Mail::fake();
        [$owner, $card] = $this->ownerCard();

        $this->post("/card/{$card->slug}/share", $this->payload('email'))
            ->assertRedirect(route('card.save', $card))
            ->assertSessionHas('shared_ok', 'email');

        $this->assertDatabaseHas('shared_contacts', [
            'recipient_user_id' => $owner->id,
            'full_name'         => 'Ana Visitante',
            'method'            => 'email',
        ]);
        Mail::assertSent(SharedContactEmail::class, fn ($m) => $m->hasTo('owner@example.com'));
    }

    public function test_share_by_qr_sets_expiry_and_redirects_to_qr(): void
    {
        [$owner, $card] = $this->ownerCard();

        $response = $this->post("/card/{$card->slug}/share", $this->payload('qr'));

        $shared = SharedContact::first();
        $this->assertNotNull($shared->expires_at);
        $this->assertTrue($shared->expires_at->isFuture());
        $response->assertRedirect(route('contact.qr', $shared->token));
    }

    public function test_shared_vcard_serves_while_valid(): void
    {
        [$owner, $card] = $this->ownerCard();
        $shared = SharedContact::create([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $owner->id,
            'token'             => 'tok123',
            'full_name'         => 'Ana Visitante',
            'email'             => 'ana@example.com',
            'phone'             => '912000000',
            'method'            => 'qr',
            'expires_at'        => now()->addMinutes(5),
        ]);

        $response = $this->get("/contact/{$shared->token}/vcard");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/vcard; charset=UTF-8');
        $this->assertStringContainsString('Ana Visitante', $response->getContent());
    }

    public function test_shared_vcard_gone_when_expired(): void
    {
        [$owner, $card] = $this->ownerCard();
        $shared = SharedContact::create([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $owner->id,
            'token'             => 'tokexp',
            'full_name'         => 'Ana',
            'email'             => 'a@x.pt',
            'phone'             => '900',
            'method'            => 'qr',
            'expires_at'        => now()->subMinute(),
        ]);

        $this->get("/contact/{$shared->token}/vcard")->assertStatus(410);
    }

    public function test_cannot_share_to_lapsed_card(): void
    {
        // Owner has no subscription → card gated.
        $owner = User::factory()->create(['is_active' => true]);
        $card = BusinessCard::create([
            'user_id'   => $owner->id,
            'full_name' => 'Lapsed',
            'email'     => 'l@x.pt',
            'slug'      => 'lapsed-' . uniqid(),
            'is_public' => true,
            'is_active' => true,
            'theme'     => 'default',
        ]);

        $this->post("/card/{$card->slug}/share", $this->payload('email'))->assertStatus(404);
        $this->assertDatabaseCount('shared_contacts', 0);
    }

    public function test_share_validates_required_fields(): void
    {
        [$owner, $card] = $this->ownerCard();
        $this->post("/card/{$card->slug}/share", ['method' => 'email'])
            ->assertSessionHasErrors(['full_name', 'phone', 'email']);
    }

    public function test_received_contacts_list_and_download(): void
    {
        [$owner, $card] = $this->ownerCard();
        $shared = SharedContact::create([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $owner->id,
            'token'             => 'tokdl',
            'full_name'         => 'Ana Visitante',
            'email'             => 'ana@example.com',
            'phone'             => '912000000',
            'method'            => 'email',
        ]);

        $this->actingAs($owner)->get('/user/received-contacts')
            ->assertStatus(200)
            ->assertSee('Ana Visitante');

        // Recipient can download; even with no expiry it always works.
        $this->actingAs($owner)->get(route('user.received-contacts.vcard', $shared))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/vcard; charset=UTF-8');
    }

    public function test_other_user_cannot_download_received_contact(): void
    {
        [$owner, $card] = $this->ownerCard();
        $other = User::factory()->create(['is_active' => true]);
        $shared = SharedContact::create([
            'business_card_id'  => $card->id,
            'recipient_user_id' => $owner->id,
            'token'             => 'tokx',
            'full_name'         => 'Ana',
            'email'             => 'a@x.pt',
            'phone'             => '900',
            'method'            => 'email',
        ]);

        $this->actingAs($other)->get(route('user.received-contacts.vcard', $shared))->assertStatus(403);
    }
}

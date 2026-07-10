<?php

namespace App\Mail;

use App\Models\BusinessCard;
use App\Models\SharedContact;
use App\Support\VCard;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SharedContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SharedContact $shared,
        public BusinessCard $card,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->shared->full_name . ' partilhou o contacto contigo — Cardifys',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.shared-contact', with: [
            'shared' => $this->shared,
            'card'   => $this->card,
        ]);
    }

    public function attachments(): array
    {
        $vcard = VCard::build([
            'full_name' => $this->shared->full_name,
            'email'     => $this->shared->email,
            'phone'     => $this->shared->phone,
        ]);

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $vcard, Str::slug($this->shared->full_name) . '.vcf')
                ->withMime('text/vcard'),
        ];
    }
}

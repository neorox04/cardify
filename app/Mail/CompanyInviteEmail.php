<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\CompanyInvite;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyInviteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CompanyInvite $invite,
        public Company $company,
        public User $inviter,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "Foste convidado para {$this->company->name} no Cardify");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.company-invite');
    }
}

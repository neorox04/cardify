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

class InviteDeclinedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CompanyInvite $invite,
        public Company $company,
        public User $decliningUser,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "{$this->decliningUser->name} recusou o convite para {$this->company->name}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.invite-declined');
    }
}

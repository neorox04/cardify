@extends('emails.layouts.base')

@section('content')
    <span class="badge">Convite</span>
    <h1>Foste convidado para uma empresa</h1>
    <p><strong style="color:#fafafa">{{ $inviter->name }}</strong> convidou-te para te juntares à empresa <strong style="color:#fafafa">{{ $company->name }}</strong> no Cardify.</p>

    @if($invite->role)
        <div class="info-box">
            <p>Vais entrar com o cargo: <strong style="color:#fafafa">{{ $invite->role }}</strong></p>
        </div>
    @endif

    @php
        $inviteUrl = url('/user/invites');
    @endphp

    <p>Para aceitar ou recusar este convite, entra na tua conta Cardify e vai à secção de convites.</p>

    <div class="btn-center">
        <a href="{{ $inviteUrl }}" class="btn">Ver Convite</a>
    </div>

    <hr class="divider">

    <p style="font-size:13px; color:#52525b">
        Este convite expira em <strong style="color:#71717a">{{ $invite->expires_at->format('d/m/Y \à\s H:i') }}</strong>.
        Se não tens conta no Cardify, podes criar uma gratuitamente em
        <a href="{{ url('/register') }}" style="color:#6366f1">cardify.app</a>.
    </p>
@endsection

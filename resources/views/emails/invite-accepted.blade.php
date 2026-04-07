@extends('emails.layouts.base')

@section('content')
    <span class="badge">Convite Aceite</span>
    <h1>Novo membro na equipa!</h1>
    <p><strong style="color:#fafafa">{{ $newMember->name }}</strong> aceitou o teu convite e juntou-se à empresa <strong style="color:#fafafa">{{ $company->name }}</strong>.</p>

    @if($invite->role)
        <div class="success-box">
            <p>Cargo atribuído: <strong>{{ $invite->role }}</strong></p>
        </div>
    @else
        <div class="success-box">
            <p>{{ $newMember->name }} já pode ver e ser visto pelos outros membros da empresa.</p>
        </div>
    @endif

    <div class="btn-center">
        <a href="{{ url('/company/' . $company->slug . '/employees') }}" class="btn">Ver Equipa</a>
    </div>
@endsection

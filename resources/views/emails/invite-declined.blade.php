@extends('emails.layouts.base')

@section('content')
    <span class="badge">Convite Recusado</span>
    <h1>Convite recusado</h1>
    <p><strong style="color:#fafafa">{{ $decliningUser->name }}</strong> recusou o convite para se juntar à empresa <strong style="color:#fafafa">{{ $company->name }}</strong>.</p>

    <div class="warning-box">
        <p>Podes enviar um novo convite a qualquer momento a partir do painel da empresa.</p>
    </div>

    <div class="btn-center">
        <a href="{{ url('/company/' . $company->slug . '/invites') }}" class="btn-outline">Gerir Convites</a>
    </div>
@endsection

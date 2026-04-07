@extends('layouts.legal')
@section('title', 'Pagamento bem-sucedido')
@section('content')
    <h1>Pagamento realizado com sucesso!</h1>
    <p>A sua assinatura foi ativada. Obrigado por escolher a Cardifys.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-6" style="display:inline-flex;align-items:center;gap:8px;font-size:1.1rem;font-weight:700;padding:12px 28px;">
        Ir para o dashboard
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </a>
@endsection

@extends('layouts.dashboard')

@section('title', 'Suporte')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Suporte</h1>
        <p class="page-subtitle">Precisas de ajuda? Envia-nos a tua mensagem e respondemos por email.</p>
    </div>
</div>

<div class="sup-wrap">
    @if(session('support_sent'))
        <div class="sup-ok">
            <div class="sup-ok-ic">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <h2>Pedido enviado! 🎉</h2>
            <p>Recebemos a tua mensagem e vamos responder o mais rápido possível para <strong>{{ auth()->user()->email }}</strong>.</p>
            <a href="{{ route('user.support') }}" class="sup-again">Enviar outro pedido</a>
        </div>
    @else
        <form method="POST" action="{{ route('support.store') }}" class="sup-form">
            @csrf
            <input type="hidden" name="source" value="dashboard">
            <div class="sup-field">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')<div class="sup-err">{{ $message }}</div>@enderror
            </div>
            <div class="sup-field">
                <label for="email">Email de resposta</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')<div class="sup-err">{{ $message }}</div>@enderror
            </div>
            <div class="sup-field">
                <label for="message">Mensagem</label>
                <textarea id="message" name="message" placeholder="Descreve o teu pedido ou problema…" required>{{ old('message') }}</textarea>
                @error('message')<div class="sup-err">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="sup-btn">Enviar pedido</button>
            <p class="sup-hint">Ou escreve-nos diretamente para <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a></p>
        </form>
    @endif
</div>
@endsection

@push('styles')
<style>
    .sup-wrap { max-width: 560px; }
    .sup-form, .sup-ok { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 18px; padding: 28px 26px; }
    .sup-field { margin-bottom: 16px; }
    .sup-field label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--ink-mute, #7a7a85); margin-bottom: 7px; }
    .sup-field input, .sup-field textarea { width: 100%; padding: 12px 14px; background: var(--bg-3, #1d2029); border: 1.5px solid var(--line-soft, rgba(255,255,255,0.1)); border-radius: 10px; color: var(--ink, #f0f0f3); font-family: inherit; font-size: 14px; outline: none; transition: border-color .15s; }
    .sup-field input:focus, .sup-field textarea:focus { border-color: var(--purple, #B884FF); }
    .sup-field textarea { min-height: 150px; resize: vertical; }
    .sup-err { color: #ef4444; font-size: 12px; margin-top: 5px; }
    .sup-btn { width: 100%; height: 48px; margin-top: 4px; background: linear-gradient(135deg, #a56bff, #7c3aed); color: #fff; border: none; border-radius: 11px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .sup-btn:hover { opacity: 0.92; }
    .sup-hint { text-align: center; font-size: 12px; color: var(--ink-mute, #7a7a85); margin-top: 14px; }
    .sup-hint a { color: var(--ink-dim, #a9a9b3); }

    .sup-ok { text-align: center; }
    .sup-ok-ic { width: 60px; height: 60px; border-radius: 50%; background: rgba(52,211,153,0.12); border: 1px solid rgba(52,211,153,0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
    .sup-ok-ic svg { width: 28px; height: 28px; color: #34d399; }
    .sup-ok h2 { font-size: 20px; font-weight: 600; margin-bottom: 8px; }
    .sup-ok p { font-size: 14px; color: var(--ink-dim, #a9a9b3); line-height: 1.6; margin-bottom: 20px; }
    .sup-again { display: inline-block; color: var(--purple, #B884FF); text-decoration: none; font-weight: 600; font-size: 14px; }
</style>
@endpush

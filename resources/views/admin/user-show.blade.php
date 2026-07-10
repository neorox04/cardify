@extends('layouts.dashboard')

@section('title', 'Utilizador · ' . $user->name)

@section('content')
@php
    $nf = fn ($n) => number_format((float) $n, 0, ',', '.');
    $eur = fn ($n) => '€' . number_format((float) $n, 2, ',', '.');
    $status = $subscription?->stripe_status;
    $subMeta = match ($status) {
        'active'    => ['Ativa', 'au-ok'],
        'trialing'  => ['Trial', 'au-purple'],
        'past_due'  => ['Em atraso', 'au-warn'],
        'canceled'  => ['Cancelada', 'au-muted'],
        default     => ['Sem subscrição', 'au-muted'],
    };
@endphp

<a href="{{ route('admin.users') }}" class="au-back">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
    Voltar aos utilizadores
</a>

{{-- Header --}}
<div class="au-header">
    <x-avatar :name="$user->name" :photo="$user->avatar" :style="$user->avatar_style" :size="64" />
    <div class="au-id">
        <div class="au-name-row">
            <h1 class="au-name">{{ $user->name }}</h1>
            @if($user->isSuperAdmin())
                <span class="au-tag au-purple">Super Admin</span>
            @elseif($ownsCompany)
                <span class="au-tag au-purple">Empresa</span>
            @else
                <span class="au-tag au-muted">Utilizador</span>
            @endif
            <span class="au-tag {{ $user->is_active ? 'au-ok' : 'au-warn' }}">{{ $user->is_active ? 'Ativo' : 'Inativo' }}</span>
        </div>
        <div class="au-email">{{ $user->email }}</div>
        <div class="au-meta">
            Registado {{ $user->created_at->locale('pt')->isoFormat('D MMM YYYY') }}
            @if($user->last_login_at) · Último acesso {{ $user->last_login_at->locale('pt')->diffForHumans() }} @endif
        </div>
    </div>
</div>

<div class="au-grid">
    {{-- Subscription --}}
    <div class="au-panel">
        <div class="au-panel-title">Subscrição</div>
        <div class="au-sub-status"><span class="au-tag {{ $subMeta[1] }}">{{ $subMeta[0] }}</span></div>
        @if($subscription)
            <div class="au-kv"><span>Plano</span><span>{{ $planLabel }}</span></div>
            <div class="au-kv"><span>Contribuição MRR</span><span>{{ $eur($mrr) }}</span></div>
            @if(($subscription->quantity ?? 1) > 1)
                <div class="au-kv"><span>Seats</span><span>{{ $nf($subscription->quantity) }}</span></div>
            @endif
            <div class="au-kv"><span>Desde</span><span>{{ $subscription->created_at?->locale('pt')->isoFormat('D MMM YYYY') ?? '—' }}</span></div>
        @else
            <p class="au-empty-sm">Este utilizador não tem subscrição ativa.</p>
        @endif
    </div>

    {{-- Companies --}}
    <div class="au-panel">
        <div class="au-panel-title">Empresas</div>
        @if($user->companies->isNotEmpty())
            @foreach($user->companies as $company)
                <div class="au-kv">
                    <span>{{ $company->name }}</span>
                    <span>{{ $company->pivot->is_admin ? 'Dono' : 'Membro' }}</span>
                </div>
            @endforeach
        @else
            <p class="au-empty-sm">Sem empresa associada.</p>
        @endif
    </div>
</div>

{{-- Stats overview --}}
<div class="au-panel-title au-section">Estatísticas gerais</div>
<div class="au-stats">
    <div class="au-stat"><div class="au-stat-v">{{ $nf($cardStats->count()) }}</div><div class="au-stat-l">Cartões</div></div>
    <div class="au-stat"><div class="au-stat-v">{{ $nf($totalViews) }}</div><div class="au-stat-l">Visualizações</div></div>
    <div class="au-stat"><div class="au-stat-v">{{ $nf($totalScans) }}</div><div class="au-stat-l">Scans</div></div>
    <div class="au-stat"><div class="au-stat-v">{{ $nf($totalSaves) }}</div><div class="au-stat-l">Contactos guardados</div></div>
    <div class="au-stat"><div class="au-stat-v">{{ number_format($conversion, 1, ',', '.') }}%</div><div class="au-stat-l">Conversão</div></div>
    <div class="au-stat"><div class="au-stat-v">{{ $nf($receivedCount) }}</div><div class="au-stat-l">Contactos recebidos</div></div>
</div>

{{-- Cards --}}
<div class="au-panel" style="margin-top:16px;">
    <div class="au-panel-title">Cartões</div>
    @if($cardStats->isNotEmpty())
        <table class="au-table">
            <thead><tr><th>Cartão</th><th class="r">Views</th><th class="r">Scans</th><th class="r">Guardados</th></tr></thead>
            <tbody>
                @foreach($cardStats as $c)
                    <tr>
                        <td>
                            <a href="{{ route('card.public', $c->slug) }}" target="_blank" class="au-cardlink">{{ $c->name }}</a>
                            @unless($c->active)<span class="au-tag au-muted" style="margin-left:6px;">inativo</span>@endunless
                        </td>
                        <td class="r">{{ $nf($c->views) }}</td>
                        <td class="r">{{ $nf($c->scans) }}</td>
                        <td class="r">{{ $nf($c->saves) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="au-empty-sm">Este utilizador ainda não criou cartões.</p>
    @endif
</div>
@endsection

@push('styles')
<style>
    .au-back { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: var(--ink-mute, #8b8b93); text-decoration: none; margin-bottom: 20px; }
    .au-back:hover { color: var(--purple, #B884FF); }
    .au-header { display: flex; align-items: center; gap: 18px; margin-bottom: 24px; }
    .au-name-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .au-name { font-size: 22px; font-weight: 600; letter-spacing: -0.02em; }
    .au-email { font-size: 14px; color: var(--ink-dim, #a9a9b3); margin-top: 4px; }
    .au-meta { font-size: 12px; color: var(--ink-mute, #7a7a85); margin-top: 4px; }
    .au-tag { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; }
    .au-ok { background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.3); }
    .au-purple { background: rgba(184,132,255,0.12); color: #B884FF; border: 1px solid rgba(184,132,255,0.3); }
    .au-warn { background: rgba(245,158,11,0.12); color: #e0a43a; border: 1px solid rgba(245,158,11,0.3); }
    .au-muted { background: rgba(255,255,255,0.05); color: var(--ink-mute, #7a7a85); border: 1px solid rgba(255,255,255,0.09); }

    .au-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 8px; }
    .au-panel { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 16px; padding: 18px 20px; }
    .au-panel-title { font-size: 14px; font-weight: 600; margin-bottom: 14px; }
    .au-section { margin: 24px 0 12px; }
    .au-sub-status { margin-bottom: 12px; }
    .au-kv { display: flex; justify-content: space-between; gap: 12px; padding: 8px 0; border-bottom: 1px solid var(--line-soft, rgba(255,255,255,0.06)); font-size: 13px; }
    .au-kv:last-child { border-bottom: none; }
    .au-kv span:first-child { color: var(--ink-mute, #7a7a85); }
    .au-empty-sm { font-size: 13px; color: var(--ink-mute, #7a7a85); }

    .au-stats { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; }
    .au-stat { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 14px; padding: 14px 15px; }
    .au-stat-v { font-size: 22px; font-weight: 600; letter-spacing: -0.02em; }
    .au-stat-l { font-size: 11px; color: var(--ink-mute, #7a7a85); margin-top: 3px; }

    .au-table { width: 100%; border-collapse: collapse; }
    .au-table th { text-align: left; font-size: 10px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-mute, #7a7a85); padding: 0 12px 10px; }
    .au-table th.r, .au-table td.r { text-align: right; }
    .au-table td { padding: 11px 12px; font-size: 13px; border-top: 1px solid var(--line-soft, rgba(255,255,255,0.07)); }
    .au-cardlink { color: var(--ink, #f0f0f3); text-decoration: none; font-weight: 500; }
    .au-cardlink:hover { color: var(--purple, #B884FF); }

    @media (max-width: 900px) { .au-grid { grid-template-columns: 1fr; } .au-stats { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 520px) { .au-stats { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@extends('layouts.dashboard')

@section('title', 'Dashboard Empresas')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">As Minhas Empresas</h1>
        <p class="page-subtitle">Gerir empresas e colaboradores</p>
    </div>
    <a href="{{ route('company.create') }}" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Nova Empresa
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3 21H21M3 7L12 3L21 7M4 7H20V21H4V7Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $companies->count() }}</div>
            <div class="stat-label">Empresas</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalEmployees }}</div>
            <div class="stat-label">Colaboradores</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalBusinessCards }}</div>
            <div class="stat-label">Cartões</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon pink">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-label">Visualizações</div>
        </div>
    </div>
</div>

@if($subscription)
<div class="plan-banner">
    <div class="plan-banner-left">
        <div class="plan-info">
            <span class="plan-badge">Plano Empresa</span>
            <div class="plan-seats-label">
                <span class="seats-used">{{ $usedSeats }}</span>
                <span class="seats-sep">/</span>
                <span class="seats-total">{{ $currentSeats }}</span>
                <span class="seats-unit">seats utilizados</span>
            </div>
        </div>
        <div class="plan-bar-wrap">
            @php $pct = $currentSeats > 0 ? min(100, round(($usedSeats / $currentSeats) * 100)) : 0; @endphp
            <div class="plan-bar">
                <div class="plan-bar-fill {{ $pct >= 90 ? 'warn' : '' }}" style="width: {{ $pct }}%"></div>
            </div>
            <span class="plan-bar-pct">{{ $pct }}% ocupado</span>
        </div>
    </div>
    <div class="plan-banner-right">
        <a href="{{ route('subscriptions.seats') }}" class="btn-seats">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Gerir Seats
        </a>
    </div>
</div>
@endif

<div class="content-section">
    @if($companies->isEmpty())
        <div class="empty-state">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                <path d="M8 56H56M8 20L32 8L56 20M12 20H52V56H12V20Z" stroke="#D4D4D4" stroke-width="2"/>
            </svg>
            <h3>Ainda não tem empresas</h3>
            <p>Crie a sua primeira empresa para começar</p>
            <a href="{{ route('company.create') }}" class="btn btn-primary">Criar Primeira Empresa</a>
        </div>
    @else
        <div class="cards-grid">
            @foreach($companies as $company)
                <div class="business-card">
                    <div class="card-header">
                        <h3>{{ $company->name }}</h3>
                        <span class="card-badge active">Ativa</span>
                    </div>
                    <p class="card-subtitle">{{ $company->users->count() }} colaboradores</p>
                    <p class="card-company">{{ $company->businessCards->count() }} cartões criados</p>
                    
                    <div class="card-actions">
                        <a href="{{ route('company.show', $company) }}" class="btn-link">Ver</a>
                        <a href="{{ route('company.edit', $company) }}" class="btn-link">Editar</a>
                        <a href="{{ route('company.employees', $company) }}" class="btn-link">Colaboradores</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<style>
    .plan-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        background: oklch(0.18 0.014 290 / 0.65);
        border: 1px solid oklch(0.72 0.19 300 / 0.22);
        border-radius: var(--radius-xl);
        padding: 20px 24px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
    }

    .plan-banner-left { flex: 1; min-width: 0; display: flex; align-items: center; gap: 24px; }

    .plan-info { flex-shrink: 0; }

    .plan-badge {
        display: inline-block;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--purple);
        background: var(--purple-soft);
        border: 1px solid oklch(0.72 0.19 300 / 0.22);
        padding: 3px 11px;
        border-radius: 999px;
        margin-bottom: 8px;
        font-family: 'Geist Mono', monospace;
    }

    .plan-seats-label { display: flex; align-items: baseline; gap: 4px; }
    .seats-used  { font-size: 22px; font-weight: 700; color: var(--ink); letter-spacing: -0.02em; }
    .seats-sep   { font-size: 16px; color: var(--ink-mute); }
    .seats-total { font-size: 16px; font-weight: 600; color: var(--ink-dim); }
    .seats-unit  { font-size: 12px; color: var(--ink-mute); margin-left: 4px; }

    .plan-bar-wrap { flex: 1; min-width: 120px; }
    .plan-bar {
        height: 5px;
        background: oklch(0.28 0.018 290 / 0.40);
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 6px;
    }
    .plan-bar-fill {
        height: 100%;
        background: var(--purple);
        border-radius: 999px;
        transition: width 0.4s ease;
    }
    .plan-bar-fill.warn { background: oklch(0.72 0.16 35); }
    .plan-bar-pct { font-size: 11.5px; color: var(--ink-mute); font-family: 'Geist Mono', monospace; }

    .btn-seats {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: var(--purple-soft);
        border: 1px solid oklch(0.72 0.19 300 / 0.30);
        border-radius: var(--radius-lg);
        color: var(--purple);
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-seats:hover {
        background: oklch(0.72 0.19 300 / 0.18);
        border-color: oklch(0.72 0.19 300 / 0.45);
        transform: translateY(-1px);
    }

    @media (max-width: 600px) {
        .plan-banner { flex-direction: column; align-items: flex-start; }
        .plan-banner-left { flex-direction: column; align-items: flex-start; gap: 12px; width: 100%; }
        .plan-bar-wrap { width: 100%; }
    }
</style>
@endsection

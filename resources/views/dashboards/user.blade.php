@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Bem-vindo, {{ $user->name }}</h1>
        <p class="page-subtitle">Gerir os seus cartões de visita digitais</p>
    </div>
    <a href="{{ route('business-cards.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Criar Cartão
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $businessCards->count() }}</div>
            <div class="stat-label">Cartões Criados</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-label">Visualizações Totais</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $companies->count() }}</div>
            <div class="stat-label">Empresas</div>
        </div>
    </div>
</div>

<!-- Empresas do Utilizador -->
@if($companies->isNotEmpty())
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">As Minhas Empresas</h2>
    </div>
    
    <div class="companies-grid">
        @foreach($companies as $company)
            <a href="{{ route('user.company.show', $company) }}" class="company-card">
                <div class="company-avatar">
                    {{ strtoupper(substr($company->name, 0, 2)) }}
                </div>
                <div class="company-info">
                    <h3 class="company-name">{{ $company->name }}</h3>
                    <p class="company-role">{{ $company->pivot->role }}</p>
                    @if($company->industry)
                        <span class="company-industry">{{ $company->industry }}</span>
                    @endif
                </div>
                <svg class="company-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @endforeach
    </div>
</div>
@endif

<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Os Meus Cartões</h2>
    </div>

    @if($businessCards->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="64" height="64">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3>Ainda não tem cartões</h3>
            <p>Crie o seu primeiro cartão de visita digital e comece a fazer networking de forma moderna.</p>
            <a href="{{ route('business-cards.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Criar Primeiro Cartão
            </a>
        </div>
    @else
        <div class="cards-grid">
            @foreach($businessCards as $card)
                <div class="business-card">
                    <div class="card-header">
                        <h3>{{ $card->full_name }}</h3>
                        <span class="card-badge {{ $card->is_active ? 'active' : 'inactive' }}">
                            {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                    <p class="card-subtitle">{{ $card->job_title }}</p>
                    <p class="card-company">{{ $card->company->name ?? 'Sem empresa' }}</p>
                    
                    <div class="card-stats">
                        <div class="card-stat">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($card->views_count) }} visualizações
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('business-cards.show', $card) }}" class="btn-link">Ver</a>
                        <a href="{{ route('business-cards.edit', $card) }}" class="btn-link">Editar</a>
                        <a href="{{ route('card.public', $card->slug) }}" class="btn-link" target="_blank">Partilhar</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 14px;
    }

    .company-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        background: oklch(0.18 0.014 290 / 0.65);
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-xl);
        text-decoration: none;
        color: inherit;
        transition: var(--transition);
        backdrop-filter: blur(10px);
    }

    .company-card:hover {
        border-color: oklch(0.72 0.19 300 / 0.30);
        transform: translateY(-2px);
    }

    .company-avatar {
        width: 46px; height: 46px;
        border-radius: 13px;
        background: var(--purple-soft);
        color: var(--purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        flex-shrink: 0;
        border: 1px solid oklch(0.72 0.19 300 / 0.22);
    }

    .company-info { flex: 1; min-width: 0; }

    .company-name {
        font-size: 14.5px;
        font-weight: 600;
        color: var(--ink);
        margin: 0 0 3px;
        letter-spacing: -0.01em;
    }

    .company-role {
        font-size: 12.5px;
        color: var(--purple);
        margin: 0 0 4px;
        font-weight: 500;
    }

    .company-industry {
        display: inline-block;
        font-family: 'Geist Mono', monospace;
        font-size: 10px;
        color: var(--ink-mute);
        background: oklch(0.22 0.016 290 / 0.6);
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid var(--line-soft);
    }

    .company-arrow { color: var(--ink-mute); flex-shrink: 0; }
    .company-card:hover .company-arrow { color: var(--purple); }
</style>
@endsection

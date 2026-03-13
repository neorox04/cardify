@extends('layouts.dashboard')

@section('title', $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">{{ $company->name }}</h1>
        <p class="page-subtitle">{{ $myRole }}</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Voltar
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<!-- Company Info -->
<div class="company-hero">
    <div class="company-hero-avatar">
        {{ strtoupper(substr($company->name, 0, 2)) }}
    </div>
    <div class="company-hero-info">
        <h2>{{ $company->name }}</h2>
        @if($company->description)
            <p class="company-description">{{ $company->description }}</p>
        @endif
        <div class="company-meta">
            @if($company->industry)
                <span class="meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                    </svg>
                    {{ $company->industry }}
                </span>
            @endif
            @if($company->website)
                <a href="{{ $company->website }}" target="_blank" class="meta-item meta-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
                    </svg>
                    Website
                </a>
            @endif
            @if($company->email)
                <a href="mailto:{{ $company->email }}" class="meta-item meta-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    Email
                </a>
            @endif
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M16 3.13a4 4 0 010 7.75"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $colleagues->count() + 1 }}</div>
            <div class="stat-label">Membros</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $companyCards->count() }}</div>
            <div class="stat-label">Cartões da Equipa</div>
        </div>
    </div>
</div>

<!-- Colleagues -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Colegas</h2>
        <a href="{{ route('user.company.colleagues', $company) }}" class="btn btn-secondary btn-sm">Ver todos</a>
    </div>

    @if($colleagues->isEmpty())
        <p class="empty-text">Ainda não há outros colegas na empresa.</p>
    @else
        <div class="colleagues-grid">
            @foreach($colleagues->take(6) as $colleague)
                <div class="colleague-card">
                    <div class="colleague-avatar">
                        {{ strtoupper(substr($colleague->name, 0, 2)) }}
                    </div>
                    <div class="colleague-info">
                        <h4 class="colleague-name">{{ $colleague->name }}</h4>
                        <p class="colleague-role">{{ $colleague->pivot->role }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Company Cards -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Cartões da Equipa</h2>
    </div>

    @if($companyCards->isEmpty())
        <p class="empty-text">Ainda não há cartões associados a esta empresa.</p>
    @else
        <div class="cards-grid">
            @foreach($companyCards as $card)
                <div class="business-card">
                    <div class="card-header">
                        <h3>{{ $card->full_name }}</h3>
                        <span class="card-badge {{ $card->is_active ? 'active' : 'inactive' }}">
                            {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                    <p class="card-subtitle">{{ $card->job_title }}</p>
                    <p class="card-owner">Por {{ $card->user->name }}</p>
                    
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
                        <a href="{{ route('card.public', $card->slug) }}" class="btn-link" target="_blank">Ver cartão</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Leave Company -->
<div class="content-section danger-zone">
    <div class="section-header">
        <h2 class="section-title">Zona de Perigo</h2>
    </div>
    
    <div class="danger-content">
        <div class="danger-info">
            <h4>Sair da empresa</h4>
            <p>Ao sair, perderás acesso aos recursos da empresa. Esta ação pode ser revertida apenas com um novo convite.</p>
        </div>
        <form action="{{ route('user.company.leave', $company) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres sair da empresa {{ $company->name }}?')">
            @csrf
            <button type="submit" class="btn btn-danger">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Sair da Empresa
            </button>
        </form>
    </div>
</div>

<style>
    .company-hero {
        display: flex;
        align-items: flex-start;
        gap: 24px;
        padding: 32px;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        margin-bottom: 32px;
    }

    .company-hero-avatar {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-lg);
        background: var(--accent-subtle);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .company-hero-info h2 {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: var(--text-primary);
    }

    .company-description {
        color: var(--text-secondary);
        margin: 0 0 16px 0;
        line-height: 1.6;
    }

    .company-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--text-secondary);
    }

    .meta-link {
        color: var(--accent);
        text-decoration: none;
    }

    .meta-link:hover {
        text-decoration: underline;
    }

    .stat-icon.purple {
        background: #F3E8FF;
        color: #9333EA;
    }

    .stat-icon.blue {
        background: #EEF2FF;
        color: #6366F1;
    }

    .colleagues-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .colleague-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
    }

    .colleague-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .colleague-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .colleague-role {
        font-size: 12px;
        color: var(--text-tertiary);
        margin: 4px 0 0 0;
    }

    .card-owner {
        font-size: 12px;
        color: var(--text-tertiary);
        margin-top: 4px;
    }

    .empty-text {
        color: var(--text-tertiary);
        font-size: 14px;
    }

    .btn-sm {
        padding: 8px 14px;
        font-size: 13px;
    }

    .danger-zone {
        border-color: var(--error);
    }

    .danger-zone .section-title {
        color: var(--error);
    }

    .danger-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .danger-info h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px 0;
    }

    .danger-info p {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 0;
    }

    .btn-danger {
        background: var(--error);
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .alert {
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: var(--success-subtle);
        color: var(--success);
        border: 1px solid var(--success);
    }

    .alert-error {
        background: var(--error-subtle);
        color: var(--error);
        border: 1px solid var(--error);
    }

    @media (max-width: 768px) {
        .company-hero {
            flex-direction: column;
            text-align: center;
        }

        .company-meta {
            justify-content: center;
        }

        .danger-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

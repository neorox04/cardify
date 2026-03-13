@extends('layouts.dashboard')

@section('title', 'Colegas - ' . $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Colegas</h1>
        <p class="page-subtitle">{{ $company->name }}</p>
    </div>
    <a href="{{ route('user.company.show', $company) }}" class="btn btn-secondary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Voltar
    </a>
</div>

<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Todos os Membros</h2>
        <span class="badge">{{ $colleagues->count() }}</span>
    </div>

    <div class="colleagues-list">
        @foreach($colleagues as $colleague)
            <div class="colleague-row">
                <div class="colleague-main">
                    <div class="colleague-avatar">
                        {{ strtoupper(substr($colleague->name, 0, 2)) }}
                    </div>
                    <div class="colleague-info">
                        <h4 class="colleague-name">
                            {{ $colleague->name }}
                            @if($colleague->id === auth()->id())
                                <span class="you-badge">Tu</span>
                            @endif
                        </h4>
                        <p class="colleague-email">{{ $colleague->email }}</p>
                    </div>
                </div>
                <div class="colleague-role-info">
                    <span class="role-badge">{{ $colleague->pivot->role }}</span>
                    @if($colleague->pivot->is_admin)
                        <span class="admin-badge">Admin</span>
                    @endif
                </div>
                <div class="colleague-cards">
                    @php
                        $colleagueCards = $colleague->businessCards()->where('company_id', $company->id)->get();
                    @endphp
                    @if($colleagueCards->isNotEmpty())
                        <div class="cards-dropdown">
                            <button class="cards-dropdown-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                                </svg>
                                {{ $colleagueCards->count() }} cartão(ões)
                            </button>
                            <div class="cards-dropdown-content">
                                @foreach($colleagueCards as $card)
                                    <a href="{{ route('card.public', $card->slug) }}" target="_blank" class="dropdown-card">
                                        <span>{{ $card->full_name }}</span>
                                        <span class="card-job">{{ $card->job_title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="no-cards">Sem cartões</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .badge {
        background: var(--accent-subtle);
        color: var(--accent);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .colleagues-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .colleague-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        transition: var(--transition);
    }

    .colleague-row:hover {
        border-color: var(--border-hover);
    }

    .colleague-main {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }

    .colleague-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .colleague-info {
        flex: 1;
    }

    .colleague-name {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .you-badge {
        background: var(--accent);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .colleague-email {
        font-size: 14px;
        color: var(--text-tertiary);
        margin: 4px 0 0 0;
    }

    .colleague-role-info {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 200px;
    }

    .role-badge {
        background: var(--bg-elevated);
        color: var(--text-secondary);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .admin-badge {
        background: var(--success-subtle);
        color: var(--success);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .colleague-cards {
        min-width: 150px;
        text-align: right;
    }

    .no-cards {
        color: var(--text-tertiary);
        font-size: 13px;
    }

    .cards-dropdown {
        position: relative;
        display: inline-block;
    }

    .cards-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        font-size: 13px;
        cursor: pointer;
        transition: var(--transition);
    }

    .cards-dropdown-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .cards-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 8px;
        min-width: 220px;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        z-index: 100;
        overflow: hidden;
    }

    .cards-dropdown:hover .cards-dropdown-content {
        display: block;
    }

    .dropdown-card {
        display: flex;
        flex-direction: column;
        padding: 12px 16px;
        text-decoration: none;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }

    .dropdown-card:last-child {
        border-bottom: none;
    }

    .dropdown-card:hover {
        background: var(--bg-tertiary);
    }

    .card-job {
        font-size: 12px;
        color: var(--text-tertiary);
        margin-top: 2px;
    }

    @media (max-width: 768px) {
        .colleague-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .colleague-role-info,
        .colleague-cards {
            min-width: auto;
            width: 100%;
            text-align: left;
        }
    }
</style>
@endsection

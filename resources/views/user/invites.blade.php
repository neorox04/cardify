@extends('layouts.dashboard')

@section('title', 'Convites')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Convites</h1>
        <p class="page-subtitle">Convites para te juntares a empresas</p>
    </div>
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

<div class="content-section">
    @if($invites->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <p>Não tens convites pendentes.</p>
        </div>
    @else
        <div class="invites-list">
            @foreach($invites as $invite)
                <div class="invite-card">
                    <div class="invite-info">
                        <div class="invite-company-avatar">
                            {{ strtoupper(substr($invite->company->name, 0, 2)) }}
                        </div>
                        <div class="invite-details">
                            <h3 class="invite-company-name">{{ $invite->company->name }}</h3>
                            @if($invite->role)
                                <p class="invite-role">Cargo: {{ $invite->role }}</p>
                            @endif
                            <p class="invite-meta">
                                Convidado por {{ $invite->inviter->name }} • 
                                Expira em {{ $invite->expires_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="invite-actions">
                        <form action="{{ route('user.invites.decline', $invite) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Recusar
                            </button>
                        </form>
                        <form action="{{ route('user.invites.accept', $invite) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Aceitar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-tertiary);
    }

    .empty-state svg {
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .invites-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .invite-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        transition: var(--transition);
    }

    .invite-card:hover {
        border-color: var(--border-hover);
    }

    .invite-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .invite-company-avatar {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        background: var(--accent-subtle);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
    }

    .invite-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .invite-company-name {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .invite-role {
        font-size: 14px;
        color: var(--accent);
        margin: 0;
    }

    .invite-meta {
        font-size: 13px;
        color: var(--text-tertiary);
        margin: 0;
    }

    .invite-actions {
        display: flex;
        gap: 12px;
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
        .invite-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .invite-actions {
            width: 100%;
        }

        .invite-actions .btn {
            flex: 1;
        }
    }
</style>
@endsection

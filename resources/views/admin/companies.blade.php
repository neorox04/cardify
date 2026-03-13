@extends('layouts.dashboard')

@section('title', 'Gerir Empresas')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Empresas</h1>
        <p class="page-subtitle">Todas as empresas da plataforma</p>
    </div>
    <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Nova Empresa
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

<!-- Filtros -->
<div class="content-section" style="margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.companies') }}" class="filters-form">
        <div class="form-row">
            <div class="form-group" style="flex: 1;">
                <input type="text" name="search" class="form-input" placeholder="Pesquisar por nome..." value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <select name="status" class="form-input">
                    <option value="">Todos os estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativas</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </div>
    </form>
</div>

<div class="content-section">
    @if($companies->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <p>Não há empresas registadas.</p>
            <a href="{{ route('admin.companies.create') }}" class="btn btn-primary" style="margin-top: 16px;">Criar primeira empresa</a>
        </div>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Indústria</th>
                        <th>Colaboradores</th>
                        <th>Cartões</th>
                        <th>Estado</th>
                        <th>Criada em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                <div class="company-info">
                                    <div class="company-avatar">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $company->name }}</strong>
                                        @if($company->website)
                                            <br><small style="color: var(--text-tertiary);">{{ $company->website }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $company->industry ?? '-' }}</td>
                            <td>{{ $company->users_count }}</td>
                            <td>{{ $company->business_cards_count }}</td>
                            <td>
                                <span class="status-badge {{ $company->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $company->is_active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td>{{ $company->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions-group">
                                    <a href="{{ route('admin.companies.members', $company) }}" class="btn btn-icon" title="Gerir membros">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.companies.invites', $company) }}" class="btn btn-icon" title="Enviar convites">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.companies.toggle-status', $company) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-icon" title="{{ $company->is_active ? 'Desativar' : 'Ativar' }}">
                                            @if($company->is_active)
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"></path>
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            @else
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover a empresa \'{{ $company->name }}\'? Esta ação não pode ser desfeita.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger" title="Remover empresa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($companies->hasPages())
            <div class="pagination-wrapper">
                {{ $companies->links() }}
            </div>
        @endif
    @endif
</div>

<style>
    .filters-form .form-row {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    .data-table th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-tertiary);
        background: var(--bg-tertiary);
    }

    .data-table tbody tr:hover {
        background: var(--bg-tertiary);
    }

    .company-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .company-avatar {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: var(--accent-subtle);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: var(--success-subtle);
        color: var(--success);
    }

    .status-inactive {
        background: var(--error-subtle);
        color: var(--error);
    }

    .actions-group {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-secondary);
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-icon:hover {
        background: var(--bg-elevated);
        color: var(--text-primary);
        border-color: var(--border-hover);
    }

    .btn-icon.btn-danger:hover {
        background: var(--error-subtle);
        color: var(--error);
        border-color: var(--error);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-tertiary);
    }

    .empty-state svg {
        margin-bottom: 16px;
        opacity: 0.5;
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

    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }
</style>
@endsection

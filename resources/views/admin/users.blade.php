@extends('layouts.dashboard')

@section('title', 'Gerir Utilizadores')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Utilizadores</h1>
        <p class="page-subtitle">Todos os utilizadores da plataforma</p>
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

<!-- Filtros -->
<div class="content-section" style="margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.users') }}" class="filters-form">
        <div class="form-row">
            <div class="form-group" style="flex: 1;">
                <input type="text" name="search" class="form-input" placeholder="Pesquisar por nome ou email..." value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <select name="type" class="form-input">
                    <option value="">Todos os tipos</option>
                    <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="company_admin" {{ request('type') === 'company_admin' ? 'selected' : '' }}>Company Admin</option>
                    <option value="super_admin" {{ request('type') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>
            <div class="form-group">
                <select name="company" class="form-input">
                    <option value="">Todas as empresas</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="status" class="form-input">
                    <option value="">Todos os estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativos</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativos</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            @if(request()->hasAny(['search', 'type', 'company', 'status']))
                <a href="{{ route('admin.users') }}" class="btn btn-ghost">Limpar</a>
            @endif
        </div>
    </form>
</div>

<div class="content-section">
    @if($users->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M16 3.13a4 4 0 010 7.75"></path>
            </svg>
            <p>Não há utilizadores registados.</p>
        </div>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Tipo</th>
                        <th>Empresas</th>
                        <th>Estado</th>
                        <th>Registado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <x-avatar :name="$user->name" :photo="$user->avatar" :style="$user->avatar_style" :size="34" />
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small style="color: var(--text-tertiary);">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="type-badge type-{{ $user->type }}">
                                    @switch($user->type)
                                        @case('super_admin')
                                            Super Admin
                                            @break
                                        @case('company_admin')
                                            Admin Empresa
                                            @break
                                        @default
                                            Utilizador
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                @if($user->companies->isEmpty())
                                    <span style="color: var(--text-tertiary);">Nenhuma</span>
                                @else
                                    <div class="companies-list">
                                        @foreach($user->companies->take(2) as $company)
                                            <span class="company-tag" title="{{ $company->name }}">
                                                {{ Str::limit($company->name, 15) }}
                                                @if($company->pivot->is_admin)
                                                    <span class="admin-star">★</span>
                                                @endif
                                            </span>
                                        @endforeach
                                        @if($user->companies->count() > 2)
                                            <span class="company-tag more">+{{ $user->companies->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions-group">
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-icon" title="{{ $user->is_active ? 'Desativar' : 'Ativar' }}">
                                            @if($user->is_active)
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
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    @endif
</div>

<style>
    .filters-form .form-row {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
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

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
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

    .type-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .type-user {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
    }

    .type-company_admin {
        background: rgba(99, 102, 241, 0.15);
        color: var(--accent);
    }

    .type-super_admin {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
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

    .companies-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .company-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 12px;
        color: var(--text-secondary);
        text-decoration: none;
        transition: var(--transition);
    }

    .company-tag:hover {
        background: var(--accent-subtle);
        border-color: var(--accent);
        color: var(--accent);
    }

    .company-tag.more {
        background: var(--bg-elevated);
        cursor: default;
    }

    .admin-star {
        color: #f59e0b;
        font-size: 10px;
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

    .btn-ghost {
        background: transparent;
        border: none;
        color: var(--text-tertiary);
        padding: 8px 12px;
        cursor: pointer;
    }

    .btn-ghost:hover {
        color: var(--text-primary);
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

    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
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

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        position: relative;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: var(--text-tertiary);
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .modal-close:hover {
        color: var(--text-primary);
    }

    .modal-body {
        padding: 24px;
    }

    .modal-section {
        margin-bottom: 24px;
    }

    .modal-section:last-child {
        margin-bottom: 0;
    }

    .modal-section h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 12px;
    }

    .current-companies {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .company-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-sm);
    }

    .company-info-modal {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .role-tag {
        font-size: 11px;
        padding: 2px 6px;
        background: var(--bg-elevated);
        border-radius: 4px;
        color: var(--text-tertiary);
    }

    .admin-tag {
        font-size: 11px;
        padding: 2px 6px;
        background: rgba(245, 158, 11, 0.15);
        border-radius: 4px;
        color: #f59e0b;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .btn-danger {
        background: var(--error-subtle);
        color: var(--error);
        border: 1px solid var(--error);
    }

    .btn-danger:hover {
        background: var(--error);
        color: white;
    }

    .add-company-form .form-row {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-secondary);
        cursor: pointer;
    }

    .checkbox-group input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--accent);
    }

    .text-muted {
        color: var(--text-tertiary);
        font-size: 14px;
    }
</style>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});
</script>
@endsection

@extends('layouts.dashboard')

@section('title', 'Membros - ' . $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.companies') }}">Empresas</a>
            <span>/</span>
            <span>{{ $company->name }}</span>
        </nav>
        <h1 class="page-title">Gerir Membros</h1>
        <p class="page-subtitle">Atribuir e gerir utilizadores da empresa {{ $company->name }}</p>
    </div>
    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
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

<!-- Adicionar Membro -->
<div class="content-section" style="margin-bottom: 24px;">
    <h3 class="section-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
        </svg>
        Adicionar Utilizador à Empresa
    </h3>
    
    @if($availableUsers->isEmpty())
        <p class="text-muted">Todos os utilizadores já pertencem a esta empresa.</p>
    @else
        <form method="POST" action="{{ route('admin.companies.members.add', $company) }}" class="add-member-form">
            @csrf
            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <label class="form-label">Utilizador</label>
                    <select name="user_id" class="form-input" required>
                        <option value="">Selecionar utilizador...</option>
                        @foreach($availableUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Função</label>
                    <select name="role" class="form-input" required>
                        <option value="employee">Colaborador</option>
                        <option value="manager">Gestor</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Admin da Empresa</label>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="is_admin" id="is_admin" value="1">
                        <label for="is_admin">Pode gerir a empresa</label>
                    </div>
                </div>
                <div class="form-group" style="align-self: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Adicionar
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>

<!-- Lista de Membros -->
<div class="content-section">
    <h3 class="section-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
            <path d="M16 3.13a4 4 0 010 7.75"></path>
        </svg>
        Membros Atuais ({{ $company->users->count() }})
    </h3>

    @if($company->users->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M16 3.13a4 4 0 010 7.75"></path>
            </svg>
            <p>Esta empresa não tem membros.</p>
            <p class="text-small">Utilize o formulário acima para adicionar utilizadores.</p>
        </div>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Email</th>
                        <th>Função</th>
                        <th>Admin</th>
                        <th>Desde</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company->users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-small">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.companies.members.update', [$company, $user]) }}" class="inline-form" id="form-role-{{ $user->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_admin" value="{{ $user->pivot->is_admin ? '1' : '0' }}">
                                    <select name="role" class="form-input-small" onchange="document.getElementById('form-role-{{ $user->id }}').submit()">
                                        <option value="employee" {{ $user->pivot->role === 'employee' ? 'selected' : '' }}>Colaborador</option>
                                        <option value="manager" {{ $user->pivot->role === 'manager' ? 'selected' : '' }}>Gestor</option>
                                        <option value="admin" {{ $user->pivot->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.companies.members.update', [$company, $user]) }}" class="inline-form" id="form-admin-{{ $user->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="role" value="{{ $user->pivot->role }}">
                                    <input type="hidden" name="is_admin" value="0">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="is_admin" value="1" {{ $user->pivot->is_admin ? 'checked' : '' }} onchange="document.getElementById('form-admin-{{ $user->id }}').submit()">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </form>
                            </td>
                            <td>{{ $user->pivot->created_at ? \Carbon\Carbon::parse($user->pivot->created_at)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <form action="{{ route('admin.companies.members.remove', [$company, $user]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover {{ $user->name }} desta empresa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" title="Remover da empresa">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="18" y1="8" x2="23" y2="13"></line>
                                            <line x1="23" y1="8" x2="18" y2="13"></line>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .breadcrumb a {
        color: var(--accent);
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb span {
        color: var(--text-tertiary);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--text-primary);
    }

    .section-title svg {
        color: var(--accent);
    }

    .add-member-form .form-row {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .add-member-form .form-group {
        flex: 1;
        min-width: 180px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 0;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--accent);
    }

    .checkbox-wrapper label {
        font-size: 14px;
        color: var(--text-secondary);
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
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .form-input-small {
        padding: 6px 10px;
        font-size: 13px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: var(--bg-tertiary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .inline-form {
        display: inline;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--bg-elevated);
        border: 1px solid var(--border);
        transition: .3s;
        border-radius: 24px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 2px;
        bottom: 2px;
        background-color: var(--text-tertiary);
        transition: .3s;
        border-radius: 50%;
    }

    .toggle-switch input:checked + .toggle-slider {
        background-color: var(--accent);
        border-color: var(--accent);
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(20px);
        background-color: white;
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

    .text-muted {
        color: var(--text-tertiary);
        font-size: 14px;
    }

    .text-small {
        font-size: 13px;
        margin-top: 8px;
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
</style>
@endsection

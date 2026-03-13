@extends('layouts.dashboard')

@section('title', 'Gerir Equipa - ' . $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Equipa</h1>
        <p class="page-subtitle">{{ $company->name }}</p>
    </div>
    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
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

<!-- Enviar Convite -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Convidar Colaborador</h2>
    </div>
    
    <form action="{{ route('admin.companies.invites.store', $company) }}" method="POST" class="invite-form">
        @csrf
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <label for="email" class="form-label">Email do colaborador</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="colaborador@email.com" required value="{{ old('email') }}">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="role" class="form-label">Cargo (opcional)</label>
                <input type="text" id="role" name="role" class="form-input" placeholder="Ex: Designer" value="{{ old('role') }}">
            </div>
            <div class="form-group" style="align-self: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Enviar Convite
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Convites Pendentes -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Convites Pendentes</h2>
        <span class="badge">{{ $pendingInvites->count() }}</span>
    </div>
    
    @if($pendingInvites->isEmpty())
        <p class="empty-text">Nenhum convite pendente.</p>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Enviado por</th>
                        <th>Expira em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingInvites as $invite)
                        <tr>
                            <td>{{ $invite->email }}</td>
                            <td>{{ $invite->role ?? '-' }}</td>
                            <td>{{ $invite->inviter->name }}</td>
                            <td>{{ $invite->expires_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('admin.invites.cancel', $invite) }}" method="POST" onsubmit="return confirm('Cancelar este convite?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" title="Cancelar convite">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
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

<!-- Membros Atuais -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Membros da Equipa</h2>
        <span class="badge">{{ $members->count() }}</span>
    </div>
    
    @if($members->isEmpty())
        <p class="empty-text">Nenhum membro na equipa.</p>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Admin</th>
                        <th>Entrou em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    <span>{{ $member->name }}</span>
                                </div>
                            </td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->pivot->role ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $member->pivot->is_admin ? 'status-active' : 'status-inactive' }}">
                                    {{ $member->pivot->is_admin ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td>{{ $member->pivot->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('admin.companies.members.remove', [$company, $member]) }}" method="POST" onsubmit="return confirm('Remover {{ $member->name }} da empresa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" title="Remover membro">
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
    .invite-form .form-row {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .form-input {
        padding: 12px 14px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        font-size: 14px;
        transition: var(--transition);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-subtle);
    }

    .form-error {
        color: var(--error);
        font-size: 12px;
        margin-top: 4px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .badge {
        background: var(--accent-subtle);
        color: var(--accent);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .empty-text {
        color: var(--text-tertiary);
        font-size: 14px;
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

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--accent-subtle);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
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
        background: var(--bg-elevated);
        color: var(--text-tertiary);
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
    }

    .btn-icon.btn-danger:hover {
        background: var(--error-subtle);
        color: var(--error);
        border-color: var(--error);
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
        .invite-form .form-row {
            flex-direction: column;
        }

        .form-group {
            width: 100%;
        }
    }
</style>
@endsection

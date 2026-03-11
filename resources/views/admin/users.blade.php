@extends('layouts.dashboard')

@section('title', 'Gerir Utilizadores')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Utilizadores</h1>
        <p class="page-subtitle">Todos os utilizadores da plataforma</p>
    </div>
</div>

<div class="content-section">
    @if($users->isEmpty())
        <p style="color: #737373;">Não há utilizadores registados.</p>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Último Login</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->type) }}</td>
                            <td>
                                <span class="card-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>{{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Nunca' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-link">
                                        {{ $user->is_active ? 'Desativar' : 'Ativar' }}
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
@endsection

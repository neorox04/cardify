@extends('layouts.dashboard')

@section('title', 'Colaboradores - ' . $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Colaboradores</h1>
        <p class="page-subtitle">{{ $company->name }}</p>
    </div>
</div>

<div class="content-section">
    @if($employees->isEmpty())
        <p style="color: #737373;">Ainda não há colaboradores nesta empresa.</p>
    @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Função</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ ucfirst($employee->pivot->role) }}</td>
                            <td>
                                <span class="card-badge {{ $employee->is_active ? 'active' : 'inactive' }}">
                                    {{ $employee->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Gerir Empresas')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Empresas</h1>
        <p class="page-subtitle">Todas as empresas da plataforma</p>
    </div>
</div>

<div class="content-section">
    @if($companies->isEmpty())
        <p style="color: #737373;">Não há empresas registadas.</p>
    @else
        <div class="cards-grid">
            @foreach($companies as $company)
                <div class="business-card">
                    <div class="card-header">
                        <h3>{{ $company->name }}</h3>
                    </div>
                    <p class="card-subtitle">{{ $company->users->count() }} colaboradores</p>
                    <p class="card-company">{{ $company->businessCards->count() }} cartões</p>
                    <p class="card-company" style="font-size: 13px; color: #737373;">Criada em {{ $company->created_at->format('d/m/Y') }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

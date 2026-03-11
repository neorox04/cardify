@extends('layouts.dashboard')

@section('title', $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">{{ $company->name }}</h1>
        <p class="page-subtitle">{{ $company->description }}</p>
    </div>
    <a href="{{ route('company.edit', $company) }}" class="btn btn-primary">Editar Empresa</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $employees->count() }}</div>
        <div class="stat-label">Colaboradores</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $businessCards->count() }}</div>
        <div class="stat-label">Cartões</div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">Cartões da Empresa</h2>
    
    @if($businessCards->isEmpty())
        <p style="color: #737373;">Ainda não há cartões criados para esta empresa.</p>
    @else
        <div class="cards-grid">
            @foreach($businessCards as $card)
                <div class="business-card">
                    <div class="card-header">
                        <h3>{{ $card->full_name }}</h3>
                        <span class="card-badge {{ $card->is_active ? 'active' : 'inactive' }}">
                            {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                    <p class="card-subtitle">{{ $card->job_title }}</p>
                    <p class="card-company">{{ number_format($card->views_count) }} visualizações</p>
                    
                    <div class="card-actions">
                        <a href="{{ route('business-cards.show', $card) }}" class="btn-link">Ver</a>
                        <a href="{{ route('business-cards.public', $card->slug) }}" class="btn-link" target="_blank">Partilhar</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

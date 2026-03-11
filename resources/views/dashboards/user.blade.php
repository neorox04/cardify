@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Bem-vindo, {{ $user->name }}</h1>
        <p class="page-subtitle">Gerir os seus cartões de visita digitais</p>
    </div>
    <a href="{{ route('business-cards.create') }}" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Criar Cartão
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #EEF2FF; color: #0066FF;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="2"/>
                <path d="M16 21V5C16 3.89543 15.1046 3 14 3H10C8.89543 3 8 3.89543 8 5V21" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $businessCards->count() }}</div>
            <div class="stat-label">Cartões Criados</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #F0FDF4; color: #10B981;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2"/>
                <path d="M2.45825 12C3.73253 7.94288 7.52281 5 12.0004 5C16.4781 5 20.2684 7.94291 21.5426 12C20.2684 16.0571 16.4781 19 12.0005 19C7.52281 19 3.73251 16.0571 2.45825 12Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-label">Visualizações Totais</div>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Os Meus Cartões</h2>
    </div>

    @if($businessCards->isEmpty())
        <div class="empty-state">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="8" y="20" width="48" height="32" rx="4" stroke="#D4D4D4" stroke-width="2"/>
                <line x1="16" y1="30" x2="32" y2="30" stroke="#D4D4D4" stroke-width="2" stroke-linecap="round"/>
                <line x1="16" y1="38" x2="40" y2="38" stroke="#D4D4D4" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h3>Ainda não tem cartões</h3>
            <p>Crie o seu primeiro cartão de visita digital</p>
            <a href="{{ route('business-cards.create') }}" class="btn btn-primary">Criar Primeiro Cartão</a>
        </div>
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
                    <p class="card-company">{{ $card->company->name ?? 'Sem empresa' }}</p>
                    
                    <div class="card-stats">
                        <div class="card-stat">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M1.63867 8C2.48835 5.29525 5.01521 3.33333 8.00027 3.33333C10.9853 3.33333 13.5122 5.29527 14.3619 8C13.5122 10.7047 10.9853 12.6667 8.00033 12.6667C5.01521 12.6667 2.48834 10.7047 1.63867 8Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            {{ number_format($card->views_count) }}
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('business-cards.show', $card) }}" class="btn-link">Ver</a>
                        <a href="{{ route('business-cards.edit', $card) }}" class="btn-link">Editar</a>
                        <a href="{{ route('business-cards.public', $card->slug) }}" class="btn-link" target="_blank">Partilhar</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
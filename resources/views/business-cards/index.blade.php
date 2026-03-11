@extends('layouts.dashboard')

@section('title', 'Os Meus Cartões')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Os Meus Cartões</h1>
        <p class="page-subtitle">Gerir todos os seus cartões de visita digitais</p>
    </div>
    <a href="{{ route('business-cards.create') }}" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Criar Cartão
    </a>
</div>

@if($businessCards->isEmpty())
    <div class="empty-state">
        <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
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
                        {{ number_format($card->views_count) }} visualizações
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
@endsection

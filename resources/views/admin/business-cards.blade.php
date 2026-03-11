@extends('layouts.dashboard')

@section('title', 'Gerir Cartões')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gerir Cartões de Visita</h1>
        <p class="page-subtitle">Todos os cartões da plataforma</p>
    </div>
</div>

<div class="content-section">
    @if($businessCards->isEmpty())
        <p style="color: #737373;">Não há cartões criados.</p>
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
                    <p class="card-company" style="font-size: 13px; color: #737373;">
                        Proprietário: {{ $card->user->name }}
                    </p>
                    
                    <div class="card-stats">
                        <div class="card-stat">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            {{ number_format($card->views_count) }} visualizações
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('business-cards.public', $card->slug) }}" class="btn-link" target="_blank">Ver</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

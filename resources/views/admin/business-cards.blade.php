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
                        <div class="card-stat" style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center;">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" style="margin-right: 6px; color: #b3b3b3;">
                                    <path d="M9 12c1.1046 0 2-0.8954 2-2s-0.8954-2-2-2-2 0.8954-2 2 0.8954 2 2 2z" stroke="#b3b3b3" stroke-width="1.5"/>
                                    <path d="M2.5 9c0.8497-2.7048 3.3766-4.6667 6.3617-4.6667 2.9851 0 5.512 1.9619 6.3617 4.6667-0.8497 2.7048-3.3766 4.6667-6.3617 4.6667-2.9851 0-5.512-1.9619-6.3617-4.6667z" stroke="#b3b3b3" stroke-width="1.5"/>
                                </svg>
                                <span style="color: #b3b3b3;">{{ number_format($card->views_count) }} visualizações</span>
                            </div>
                            <div style="color:#6366f1;">QR Scans: {{ $card->qr_scans ?? 0 }}</div>
                            <div style="color:#22c55e;">Contacts Saved: {{ $card->contacts_saved ?? 0 }}</div>
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('card.public', $card->slug) }}" class="btn-link" target="_blank">Ver</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

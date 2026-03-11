@extends('layouts.dashboard')

@section('title', $businessCard->full_name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">{{ $businessCard->full_name }}</h1>
        <p class="page-subtitle">{{ $businessCard->job_title }}</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('business-cards.edit', $businessCard) }}" class="btn btn-secondary">Editar</a>
        <a href="{{ route('business-cards.public', $businessCard->slug) }}" class="btn btn-primary" target="_blank">Ver Público</a>
    </div>
</div>

<div class="card-detail">
    <div class="detail-section">
        <h3 class="detail-title">Informações de Contacto</h3>
        <dl class="detail-list">
            <div class="detail-item">
                <dt>Email</dt>
                <dd>{{ $businessCard->email }}</dd>
            </div>
            @if($businessCard->phone)
                <div class="detail-item">
                    <dt>Telefone</dt>
                    <dd>{{ $businessCard->phone }}</dd>
                </div>
            @endif
            @if($businessCard->website)
                <div class="detail-item">
                    <dt>Website</dt>
                    <dd><a href="{{ $businessCard->website }}" target="_blank">{{ $businessCard->website }}</a></dd>
                </div>
            @endif
        </dl>
    </div>

    @if($businessCard->address || $businessCard->city || $businessCard->country)
        <div class="detail-section">
            <h3 class="detail-title">Endereço</h3>
            <dl class="detail-list">
                @if($businessCard->address)
                    <div class="detail-item">
                        <dt>Morada</dt>
                        <dd>{{ $businessCard->address }}</dd>
                    </div>
                @endif
                @if($businessCard->city)
                    <div class="detail-item">
                        <dt>Cidade</dt>
                        <dd>{{ $businessCard->city }}</dd>
                    </div>
                @endif
                @if($businessCard->country)
                    <div class="detail-item">
                        <dt>País</dt>
                        <dd>{{ $businessCard->country }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    @endif

    <div class="detail-section">
        <h3 class="detail-title">Estatísticas</h3>
        <dl class="detail-list">
            <div class="detail-item">
                <dt>Visualizações</dt>
                <dd>{{ number_format($businessCard->views_count) }}</dd>
            </div>
            <div class="detail-item">
                <dt>Estado</dt>
                <dd>
                    <span class="card-badge {{ $businessCard->is_active ? 'active' : 'inactive' }}">
                        {{ $businessCard->is_active ? 'Ativo' : 'Inativo' }}
                    </span>
                </dd>
            </div>
            <div class="detail-item">
                <dt>Criado em</dt>
                <dd>{{ $businessCard->created_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Painel de Administração</h1>
        <p class="page-subtitle">Visão geral da plataforma</p>
    </div>
    <a href="{{ route('admin.analytics') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Analytics
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Utilizadores</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11ZM20 8L22 10L18 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $activeUsers }}</div>
            <div class="stat-label">Utilizadores Ativos</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3 21H21M3 7L12 3L21 7M4 7H20V21H4V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalCompanies }}</div>
            <div class="stat-label">Empresas</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="2"/>
                <path d="M16 3H8L6 7H18L16 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalBusinessCards }}</div>
            <div class="stat-label">Cartões</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon pink">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-label">Visualizações</div>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Ações Rápidas</h2>
    </div>

    <div class="cards-grid">
        <a href="{{ route('admin.users') }}" class="business-card" style="text-decoration: none; color: inherit;">
            <div class="card-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="stat-icon blue" style="width:40px;height:40px;border-radius:10px;flex-shrink:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Gerir Utilizadores</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:var(--text-tertiary);flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <p class="card-subtitle">Ver e gerir todos os utilizadores</p>
        </a>

        <a href="{{ route('admin.companies') }}" class="business-card" style="text-decoration: none; color: inherit;">
            <div class="card-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="stat-icon purple" style="width:40px;height:40px;border-radius:10px;flex-shrink:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 21H21M3 7L12 3L21 7M4 7H20V21H4V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Gerir Empresas</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:var(--text-tertiary);flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <p class="card-subtitle">Ver e gerir todas as empresas</p>
        </a>

        <a href="{{ route('admin.business-cards') }}" class="business-card" style="text-decoration: none; color: inherit;">
            <div class="card-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="stat-icon yellow" style="width:40px;height:40px;border-radius:10px;flex-shrink:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Gerir Cartões</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:var(--text-tertiary);flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <p class="card-subtitle">Ver e gerir todos os cartões</p>
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(400px,1fr));gap:24px;margin-bottom:40px;">
    <div class="content-section" style="margin-bottom:0;">
        <div class="section-header">
            <h2 class="section-title">Utilizadores Recentes</h2>
            <a href="{{ route('admin.users') }}" class="btn-link">Ver todos</a>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Registado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:30px;height:30px;border-radius:50%;background:var(--accent-subtle);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;">{{ $user->name }}</div>
                                    <div style="font-size:12px;color:var(--text-tertiary);">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="card-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                {{ $user->type }}
                            </span>
                        </td>
                        <td style="color:var(--text-secondary);font-size:13px;">{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center;color:var(--text-tertiary);padding:32px;">Sem utilizadores</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($topBusinessCards->count() > 0)
    <div class="content-section" style="margin-bottom:0;">
        <div class="section-header">
            <h2 class="section-title">Top Cartões</h2>
            <a href="{{ route('admin.business-cards') }}" class="btn-link">Ver todos</a>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Empresa</th>
                        <th>Visualizações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBusinessCards as $card)
                    <tr>
                        <td style="font-weight:600;">{{ $card->full_name ?? $card->user?->name ?? '—' }}</td>
                        <td style="color:var(--text-secondary);font-size:13px;">{{ $card->company?->name ?? '—' }}</td>
                        <td>
                            <span style="font-weight:700;color:var(--accent);">{{ number_format($card->views_count) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.dashboard')

@section('title', $company->name)

@section('content')

<div class="dashboard-header">
    <div>
        <h1 class="page-title">{{ $company->name }}</h1>
        <p class="page-subtitle">{{ $company->industry ?? 'Painel de empresa' }}</p>
    </div>
    <a href="{{ route('company.edit', $company) }}" class="btn btn-secondary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Editar
    </a>
</div>

{{-- Alerts --}}
@if(session('import_success'))
    <div class="alert-success" style="margin-bottom:20px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
        {{ session('import_success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert-error" style="margin-bottom:20px;">{{ session('error') }}</div>
@endif
@if($errors->has('csv_file'))
    <div class="alert-error" style="margin-bottom:20px;">{{ $errors->first('csv_file') }}</div>
@endif

{{-- ── SEATS BANNER ── --}}
@php
    $pct      = $currentSeats > 0 ? min(100, round(($usedSeats / $currentSeats) * 100)) : 0;
    $available = max(0, $currentSeats - $usedSeats);
    $warn      = $pct >= 80;
    $full      = $pct >= 100;
@endphp

<div class="seats-banner {{ $full ? 'seats-full' : ($warn ? 'seats-warn' : '') }}">
    <div class="seats-banner-main">
        <div class="seats-numbers">
            <span class="seats-used-num">{{ $usedSeats }}</span>
            <span class="seats-sep">/</span>
            <span class="seats-total-num">{{ $currentSeats }}</span>
            <span class="seats-unit-label">seats utilizados</span>
        </div>
        <div class="seats-bar-wrap">
            <div class="seats-bar">
                <div class="seats-bar-fill {{ $full ? 'full' : ($warn ? 'warn' : '') }}" style="width:{{ $pct }}%"></div>
            </div>
            <div class="seats-bar-meta">
                <span class="{{ $full ? 'text-red' : ($warn ? 'text-orange' : 'text-muted') }}">
                    @if($full)
                        Sem seats disponíveis
                    @elseif($warn)
                        Apenas {{ $available }} {{ $available === 1 ? 'seat disponível' : 'seats disponíveis' }}
                    @else
                        {{ $available }} {{ $available === 1 ? 'seat disponível' : 'seats disponíveis' }}
                    @endif
                </span>
                <span class="text-muted">{{ $pct }}% ocupado</span>
            </div>
        </div>
    </div>
    <div class="seats-banner-actions">
        <a href="{{ route('subscriptions.seats') }}" class="btn btn-primary btn-sm">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Gerir Seats
        </a>
    </div>
</div>

{{-- ── STATS ── --}}
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $usedSeats }}/{{ $currentSeats }}</div>
            <div class="stat-label">Seats usados</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $businessCards->count() }}</div>
            <div class="stat-label">Cartões criados</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($businessCards->sum('views_count')) }}</div>
            <div class="stat-label">Visualizações totais</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pink">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $available }}</div>
            <div class="stat-label">Seats disponíveis</div>
        </div>
    </div>
</div>

{{-- ── ANALYTICS ── --}}
@if($businessCards->isNotEmpty())
<div class="analytics-grid" style="margin-bottom:28px;">

    {{-- Top Performers --}}
    <div class="analytics-panel">
        <div class="analytics-panel-header">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Top Performers
        </div>
        @foreach($topCards as $i => $card)
        @php $pct = $maxViews > 0 ? round(($card->views_count / $maxViews) * 100) : 0; @endphp
        <div class="top-row">
            <span class="top-rank rank-{{ $i + 1 }}">{{ $i + 1 }}</span>
            <div class="top-info">
                <div class="top-name">{{ $card->full_name ?? $card->title ?? '—' }}</div>
                <div class="top-dept">{{ $card->department ?: $card->position ?: '—' }}</div>
                <div class="top-bar-wrap">
                    <div class="top-bar" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            <div class="top-views">
                <span class="top-views-num">{{ number_format($card->views_count) }}</span>
                <span class="top-views-label">views</span>
            </div>
        </div>
        @endforeach
        @if($businessCards->count() === 0)
            <p class="analytics-empty">Ainda sem dados</p>
        @endif
    </div>

    {{-- Por Departamento --}}
    <div class="analytics-panel">
        <div class="analytics-panel-header">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Por Departamento
        </div>
        @if($departmentStats->isEmpty())
            <p class="analytics-empty">Nenhum cartão tem departamento definido</p>
        @else
            <div class="dept-table">
                <div class="dept-head">
                    <span>Departamento</span>
                    <span>Cartões</span>
                    <span>Views</span>
                    <span>Média</span>
                </div>
                @foreach($departmentStats as $dept)
                <div class="dept-row">
                    <span class="dept-name">{{ $dept['name'] }}</span>
                    <span class="dept-val">{{ $dept['card_count'] }}</span>
                    <span class="dept-val dept-views">{{ number_format($dept['views']) }}</span>
                    <span class="dept-val">{{ number_format($dept['avg_views']) }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endif

{{-- ── IMPORT SECTION ── --}}
<div class="content-section" style="margin-bottom:28px;">
    <div class="section-header">
        <div>
            <h2 class="section-title">Importar Colaboradores via Excel</h2>
            <p class="section-desc">Preenche o template e importa todos os cartões de uma vez.</p>
        </div>
        <a href="{{ route('company.import.template', $company) }}" class="btn btn-secondary btn-sm">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Descarregar Template
        </a>
    </div>

    <div class="import-box">
        <form method="POST" action="{{ route('company.import', $company) }}" enctype="multipart/form-data" id="import-form">
            @csrf
            <div class="import-drop" id="import-drop">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                <p class="import-drop-title">Arrasta o ficheiro CSV aqui</p>
                <p class="import-drop-sub">ou <label for="csv_file" class="import-browse">escolhe um ficheiro</label></p>
                <p class="import-drop-hint">Formato: CSV (compatível com Excel) · Máx. 2MB</p>
                <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" style="display:none" onchange="handleFileSelect(this)">
                <div id="file-selected" class="file-selected" style="display:none"></div>
            </div>
            <div style="margin-top:14px;text-align:right;">
                <button type="submit" class="btn btn-primary" id="import-btn" disabled>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 11 12 6 7 11"/><line x1="12" y1="6" x2="12" y2="18"/></svg>
                    Importar Cartões
                </button>
            </div>
        </form>
    </div>

    <div class="import-help">
        <p><strong>Como funciona:</strong></p>
        <ol>
            <li>Descarrega o template CSV acima</li>
            <li>Abre no Excel ou Google Sheets e preenche os dados dos colaboradores (uma linha por pessoa)</li>
            <li>Guarda como CSV e carrega aqui</li>
            <li>Os cartões são criados automaticamente com os dados preenchidos</li>
        </ol>
    </div>
</div>

{{-- ── CARDS LIST ── --}}
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Cartões da Empresa</h2>
        <a href="{{ route('business-cards.create') }}" class="btn btn-primary btn-sm">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Novo Cartão
        </a>
    </div>

    @if($businessCards->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <h3>Ainda não há cartões</h3>
            <p>Importa colaboradores via Excel ou cria o primeiro cartão manualmente.</p>
        </div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th>Visualizações</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($businessCards as $card)
                    <tr>
                        <td>
                            <div class="td-name">
                                <x-avatar :name="$card->full_name ?? $card->title ?? '?'" :photo="$card->avatar" :style="$card->user?->avatar_style" :size="34" />
                                <div>
                                    <div class="td-main">{{ $card->full_name ?? $card->title }}</div>
                                    <div class="td-sub">{{ $card->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="td-muted">{{ $card->position ?: '—' }}</td>
                        <td class="td-muted">{{ $card->department ?: '—' }}</td>
                        <td>
                            <div class="views-cell">
                                <span class="views-num">{{ number_format($card->views_count) }}</span>
                                @if($totalViews > 0)
                                <div class="views-bar-wrap">
                                    <div class="views-bar" style="width:{{ round(($card->views_count / $maxViews) * 100) }}%"></div>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $card->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="td-actions">
                            <a href="{{ route('business-cards.edit', $card) }}" class="btn-link">Editar</a>
                            <a href="{{ route('card.public', $card->slug) }}" class="btn-link" target="_blank">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
/* ── Seats Banner ── */
.seats-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    background: var(--bg-2);
    border: 1px solid var(--line-soft);
    border-radius: var(--radius-xl);
    padding: 22px 26px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.seats-banner.seats-warn { border-color: oklch(0.72 0.16 35 / 0.4); background: oklch(0.72 0.16 35 / 0.04); }
.seats-banner.seats-full { border-color: oklch(0.55 0.22 20 / 0.5); background: oklch(0.55 0.22 20 / 0.05); }

.seats-banner-main { flex: 1; min-width: 260px; }
.seats-numbers { display: flex; align-items: baseline; gap: 4px; margin-bottom: 12px; }
.seats-used-num { font-size: 32px; font-weight: 800; color: var(--ink); letter-spacing: -0.03em; }
.seats-sep { font-size: 22px; color: var(--ink-mute); }
.seats-total-num { font-size: 22px; font-weight: 600; color: var(--ink-dim); }
.seats-unit-label { font-size: 13px; color: var(--ink-mute); margin-left: 8px; }

.seats-bar { height: 6px; background: var(--bg-3); border-radius: 3px; overflow: hidden; }
.seats-bar-fill { height: 100%; border-radius: 3px; background: var(--purple); transition: width .4s; }
.seats-bar-fill.warn { background: oklch(0.72 0.16 35); }
.seats-bar-fill.full { background: oklch(0.55 0.22 20); }
.seats-bar-meta { display: flex; justify-content: space-between; margin-top: 6px; font-size: 12px; }
.text-orange { color: oklch(0.72 0.16 35); font-weight: 600; }
.text-red { color: oklch(0.55 0.22 20); font-weight: 600; }
.text-muted { color: var(--ink-mute); }

.seats-banner-actions { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }

/* ── Import box ── */
.import-box { background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: var(--radius-xl); padding: 24px; margin-bottom: 14px; }
.import-drop {
    border: 2px dashed var(--line);
    border-radius: var(--radius-lg);
    padding: 36px 24px;
    text-align: center;
    transition: border-color .2s, background .2s;
    cursor: pointer;
}
.import-drop.dragover { border-color: var(--purple); background: oklch(0.72 0.19 300 / 0.05); }
.import-drop svg { color: var(--ink-mute); margin-bottom: 12px; }
.import-drop-title { font-size: 15px; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
.import-drop-sub { font-size: 13px; color: var(--ink-mute); margin-bottom: 6px; }
.import-browse { color: var(--purple); cursor: pointer; text-decoration: underline; }
.import-drop-hint { font-size: 12px; color: var(--ink-mute); }
.file-selected { margin-top: 12px; font-size: 13px; font-weight: 600; color: var(--purple); }

.import-help { font-size: 13px; color: var(--ink-mute); line-height: 1.7; }
.import-help strong { color: var(--ink-dim); }
.import-help ol { padding-left: 18px; margin-top: 6px; }

/* ── Section header ── */
.section-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; gap: 12px; }
.section-desc { font-size: 13px; color: var(--ink-mute); margin-top: 2px; }

/* ── Table ── */
.table-wrap { overflow-x: auto; border-radius: var(--radius-xl); border: 1px solid var(--line-soft); }
.data-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.data-table thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-mute); background: var(--bg-2); border-bottom: 1px solid var(--line-soft); }
.data-table tbody td { padding: 13px 16px; border-bottom: 1px solid oklch(0.28 0.018 290 / 0.08); vertical-align: middle; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td { background: oklch(0.22 0.016 290 / 0.3); }
.td-name { display: flex; align-items: center; gap: 10px; }
.td-avatar { width: 34px; height: 34px; border-radius: 10px; background: var(--purple-soft); color: var(--purple); font-size: 13px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.td-main { font-weight: 600; color: var(--ink); }
.td-sub { font-size: 12px; color: var(--ink-mute); }
.td-muted { color: var(--ink-dim); }
.td-actions { display: flex; gap: 8px; white-space: nowrap; }
.badge { display: inline-block; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
.badge-active { background: oklch(0.72 0.16 155 / 0.12); color: oklch(0.55 0.16 155); border: 1px solid oklch(0.72 0.16 155 / 0.22); }
.badge-inactive { background: oklch(0.28 0.018 290 / 0.5); color: var(--ink-mute); border: 1px solid var(--line-soft); }

.btn-sm { padding: 8px 14px; font-size: 13px; }

/* ── Analytics grid ── */
.analytics-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
@media (max-width: 860px) { .analytics-grid { grid-template-columns: 1fr; } }

.analytics-panel {
    background: var(--bg-2);
    border: 1px solid var(--line-soft);
    border-radius: var(--radius-xl);
    padding: 22px 24px;
}

.analytics-panel-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    color: var(--ink-mute);
    margin-bottom: 18px;
    font-family: 'Geist Mono', monospace;
}

.analytics-panel-header svg { color: var(--purple); flex-shrink: 0; }
.analytics-empty { font-size: 13px; color: var(--ink-mute); text-align: center; padding: 20px 0; }

/* Top performers */
.top-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--line-soft);
}
.top-row:last-child { border-bottom: none; }

.top-rank {
    width: 24px; height: 24px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800;
    flex-shrink: 0;
    font-family: 'Geist Mono', monospace;
}
.rank-1 { background: oklch(0.82 0.12 85 / 0.18); color: oklch(0.82 0.12 85); }
.rank-2 { background: oklch(0.72 0.015 290 / 0.12); color: var(--ink-dim); }
.rank-3 { background: oklch(0.65 0.10 40 / 0.14); color: oklch(0.65 0.10 40); }

.top-info { flex: 1; min-width: 0; }
.top-name { font-size: 13.5px; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.top-dept { font-size: 12px; color: var(--ink-mute); margin-bottom: 6px; }
.top-bar-wrap { height: 4px; background: var(--bg-3); border-radius: 2px; overflow: hidden; }
.top-bar { height: 100%; background: var(--purple); border-radius: 2px; transition: width .4s; }

.top-views { text-align: right; flex-shrink: 0; }
.top-views-num { display: block; font-size: 15px; font-weight: 700; color: var(--ink); font-family: 'Geist Mono', monospace; }
.top-views-label { font-size: 11px; color: var(--ink-mute); }

/* Department table */
.dept-table { display: flex; flex-direction: column; gap: 0; }
.dept-head {
    display: grid;
    grid-template-columns: 1fr 52px 64px 52px;
    gap: 8px;
    padding: 0 0 10px 0;
    border-bottom: 1px solid var(--line-soft);
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--ink-mute);
    font-family: 'Geist Mono', monospace;
}
.dept-head span:not(:first-child) { text-align: right; }
.dept-row {
    display: grid;
    grid-template-columns: 1fr 52px 64px 52px;
    gap: 8px;
    padding: 11px 0;
    border-bottom: 1px solid oklch(0.28 0.018 290 / 0.10);
    align-items: center;
}
.dept-row:last-child { border-bottom: none; }
.dept-name { font-size: 13.5px; font-weight: 500; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dept-val { font-size: 13px; color: var(--ink-dim); text-align: right; font-family: 'Geist Mono', monospace; }
.dept-views { color: var(--purple); font-weight: 600; }

/* Views bar in table */
.views-cell { display: flex; flex-direction: column; gap: 4px; min-width: 80px; }
.views-num { font-size: 13px; color: var(--ink-dim); font-family: 'Geist Mono', monospace; }
.views-bar-wrap { height: 3px; background: var(--bg-3); border-radius: 2px; overflow: hidden; }
.views-bar { height: 100%; background: var(--purple); border-radius: 2px; min-width: 2px; }
</style>

<script>
function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById('file-selected').style.display = 'block';
    document.getElementById('file-selected').textContent   = '✓ ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
    document.getElementById('import-btn').disabled = false;
}

// Drag & drop
const drop = document.getElementById('import-drop');
drop.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('dragover'); });
drop.addEventListener('dragleave', () => drop.classList.remove('dragover'));
drop.addEventListener('drop', e => {
    e.preventDefault();
    drop.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        const input = document.getElementById('csv_file');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        handleFileSelect(input);
    }
});
drop.addEventListener('click', () => document.getElementById('csv_file').click());
</script>

@endsection

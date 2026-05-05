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
        <a href="{{ route('company.invites', $company) }}" class="btn btn-secondary btn-sm">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Convidar Colaboradores
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
            <div class="stat-value">{{ $employees->count() }}</div>
            <div class="stat-label">Colaboradores</div>
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
                                <div class="td-avatar">{{ strtoupper(substr($card->full_name ?? $card->title ?? '?', 0, 1)) }}</div>
                                <div>
                                    <div class="td-main">{{ $card->full_name ?? $card->title }}</div>
                                    <div class="td-sub">{{ $card->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="td-muted">{{ $card->position ?: '—' }}</td>
                        <td class="td-muted">{{ $card->department ?: '—' }}</td>
                        <td class="td-muted">{{ number_format($card->views_count) }}</td>
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

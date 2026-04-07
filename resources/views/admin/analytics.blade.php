@extends('layouts.dashboard')

@section('title', 'Analytics — CEO Dashboard')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   ANALYTICS — PREMIUM REDESIGN
   ═══════════════════════════════════════════════════════════════ */

/* ── Section headers ─────────────────────────────────────────── */
.an-section {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 28px 0 16px;
}
.an-section-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.an-section-icon svg { width: 15px; height: 15px; }
.an-section-icon.green  { background: var(--success-subtle); color: var(--success); }
.an-section-icon.blue   { background: var(--accent-subtle);  color: var(--accent);  }
.an-section-icon.cyan   { background: rgba(6,182,212,.1);    color: #06b6d4;        }
.an-section-icon.violet { background: var(--purple-subtle);  color: var(--purple);  }
.an-section-label {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .09em;
    color: var(--text-tertiary);
}
.an-section-line {
    flex: 1; height: 1px;
    background: var(--border);
    margin-left: 6px;
}

/* ── KPI Grid ─────────────────────────────────────────────────── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 8px;
}

/* ── KPI Card ─────────────────────────────────────────────────── */
.kpi-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px 22px 22px;
    position: relative;
    overflow: hidden;
    transition: border-color .2s cubic-bezier(.4,0,.2,1), box-shadow .2s;
}
.kpi-card:hover {
    border-color: var(--border-hover);
    box-shadow: 0 6px 28px rgba(0,0,0,.12);
}
.kpi-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    border-radius: 16px 16px 0 0;
}
.kpi-card.blue::after   { background: linear-gradient(90deg,#6366f1,#818cf8); }
.kpi-card.green::after  { background: linear-gradient(90deg,#10b981,#34d399); }
.kpi-card.amber::after  { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
.kpi-card.rose::after   { background: linear-gradient(90deg,#f43f5e,#fb7185); }
.kpi-card.cyan::after   { background: linear-gradient(90deg,#06b6d4,#22d3ee); }
.kpi-card.violet::after { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
.kpi-card.teal::after   { background: linear-gradient(90deg,#14b8a6,#2dd4bf); }
.kpi-card.orange::after { background: linear-gradient(90deg,#f97316,#fb923c); }

.kpi-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
}
.kpi-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.kpi-icon svg { width: 18px; height: 18px; }
.kpi-icon.blue   { background: var(--accent-subtle);      color: var(--accent);  }
.kpi-icon.green  { background: var(--success-subtle);     color: var(--success); }
.kpi-icon.amber  { background: var(--warning-subtle);     color: var(--warning); }
.kpi-icon.rose   { background: rgba(244,63,94,.1);        color: #f43f5e;        }
.kpi-icon.cyan   { background: rgba(6,182,212,.1);        color: #06b6d4;        }
.kpi-icon.violet { background: var(--purple-subtle);      color: var(--purple);  }
.kpi-icon.teal   { background: rgba(20,184,166,.1);       color: #14b8a6;        }
.kpi-icon.orange { background: rgba(249,115,22,.1);       color: #f97316;        }

.kpi-label {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--text-tertiary);
    margin-bottom: 6px;
}
.kpi-value {
    font-size: 34px; font-weight: 800;
    letter-spacing: -2px;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 8px;
}
.kpi-sub {
    font-size: 12px;
    color: var(--text-tertiary);
    line-height: 1.5;
}
.kpi-badge {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 11px; font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
    margin-top: 8px;
    width: fit-content;
}
.kpi-badge.up      { background: rgba(16,185,129,.12); color: #10b981; }
.kpi-badge.down    { background: rgba(244,63,94,.12);  color: #f43f5e; }
.kpi-badge.neutral { background: rgba(113,113,122,.1); color: #71717a; }
.kpi-badges        { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }

/* ── Chart grid ───────────────────────────────────────────────── */
.an-row           { display: grid; gap: 14px; margin-bottom: 14px; }
.an-row.cols-2    { grid-template-columns: 1fr 1fr; }
.an-row.cols-3    { grid-template-columns: 2fr 1fr; }
.an-row.cols-1    { grid-template-columns: 1fr; }

/* ── Chart card ───────────────────────────────────────────────── */
.chart-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px 24px;
    transition: border-color .2s;
}
.chart-card:hover { border-color: var(--border-hover); }
.chart-card-title {
    font-size: 15px; font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -.3px; margin-bottom: 3px;
}
.chart-card-sub {
    font-size: 12px; color: var(--text-tertiary);
    margin-bottom: 20px;
}
.chart-wrap     { position: relative; height: 220px; }
.chart-wrap.sm  { height: 180px; }

/* ── Sub breakdown ────────────────────────────────────────────── */
.sub-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
}
.sub-row:last-child { border-bottom: none; }
.sub-row-label {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--text-secondary); font-weight: 500;
}
.sub-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.sub-row-val { font-size: 16px; font-weight: 700; color: var(--text-primary); letter-spacing: -.5px; }

/* ── Metric rows (companies) ──────────────────────────────────── */
.metric-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 13px 16px;
    border-radius: 12px;
    background: var(--bg-tertiary);
    margin-bottom: 8px;
    transition: background .15s;
}
.metric-row:last-child { margin-bottom: 0; }
.metric-row:hover { background: var(--bg-elevated); }
.metric-row-label {
    display: flex; align-items: center; gap: 10px;
    font-size: 13px; color: var(--text-secondary); font-weight: 500;
}
.metric-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.metric-row-val {
    font-size: 22px; font-weight: 800;
    letter-spacing: -1px; color: var(--text-primary);
}

/* ── Tables ───────────────────────────────────────────────────── */
.an-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.an-table thead th {
    text-align: left;
    padding: 10px 14px;
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--text-tertiary);
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border);
}
.an-table tbody td {
    padding: 12px 14px;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}
.an-table tbody tr:last-child td { border-bottom: none; }
.an-table tbody tr { transition: background .12s; }
.an-table tbody tr:hover td { background: var(--bg-tertiary); }
.an-table tbody tr:hover td:first-child {
    border-left: 2px solid var(--accent);
    padding-left: 12px;
}

/* ── Rank badges ──────────────────────────────────────────────── */
.rank {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; border-radius: 50%;
    font-size: 11px; font-weight: 800;
}
.rank-1 { background: rgba(251,191,36,.18); color: #fbbf24; }
.rank-2 { background: rgba(161,161,170,.13); color: #a1a1aa; }
.rank-3 { background: rgba(251,146,60,.15); color: #fb923c; }
.rank-n { background: transparent; color: var(--text-tertiary); font-size: 13px; font-weight: 600; }

/* ── User avatar (small) ──────────────────────────────────────── */
.u-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    flex-shrink: 0;
    background: var(--accent-subtle); color: var(--accent);
}

/* ── Status pills ─────────────────────────────────────────────── */
.pill {
    display: inline-block; padding: 3px 9px;
    border-radius: 20px; font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em; white-space: nowrap;
}
.pill-active   { background: rgba(16,185,129,.12); color: #10b981; }
.pill-inactive { background: rgba(244,63,94,.12);  color: #f43f5e; }

/* ── Animations ───────────────────────────────────────────────── */
@media (prefers-reduced-motion: no-preference) {
    .kpi-card {
        animation: an-up .38s cubic-bezier(.22,1,.36,1) both;
    }
    .kpi-card:nth-child(1) { animation-delay: .04s; }
    .kpi-card:nth-child(2) { animation-delay: .09s; }
    .kpi-card:nth-child(3) { animation-delay: .14s; }
    .kpi-card:nth-child(4) { animation-delay: .19s; }
    @keyframes an-up {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
}

/* ── Responsive ───────────────────────────────────────────────── */
@media (max-width: 1200px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
    .an-row.cols-2,
    .an-row.cols-3 { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .kpi-grid { grid-template-columns: 1fr; }
    .kpi-value { font-size: 28px; }
}
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
<div class="dashboard-header" style="margin-bottom:28px;">
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;border-radius:14px;background:var(--accent-subtle);color:var(--accent);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Analytics</h1>
            <p class="page-subtitle">Métricas em tempo real · Plataforma Cardify</p>
        </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:8px;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar ao Painel
    </a>
</div>

{{-- ── SECTION: RECEITA ─────────────────────────────────────────── --}}
<div class="an-section">
    <div class="an-section-icon green">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <span class="an-section-label">Receita</span>
    <div class="an-section-line"></div>
</div>

<div class="kpi-grid" style="margin-bottom:28px;">
    <div class="kpi-card green">
        <div class="kpi-top">
            <div class="kpi-icon green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">MRR</div>
        <div class="kpi-value">€{{ number_format($mrr, 0) }}</div>
        <div class="kpi-sub">Receita mensal recorrente</div>
    </div>

    <div class="kpi-card blue">
        <div class="kpi-top">
            <div class="kpi-icon blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">ARR</div>
        <div class="kpi-value">€{{ number_format($arr, 0) }}</div>
        <div class="kpi-sub">Receita anual recorrente (est.)</div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-top">
            <div class="kpi-icon amber">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Subscrições Ativas</div>
        <div class="kpi-value">{{ $totalActive }}</div>
        <div class="kpi-sub">{{ $monthlySubCount }} mensais · {{ $annualSubCount }} anuais</div>
    </div>

    <div class="kpi-card rose">
        <div class="kpi-top">
            <div class="kpi-icon rose">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Churn Rate</div>
        <div class="kpi-value">{{ $churnRate }}%</div>
        <div class="kpi-sub">{{ $churnedThisMonth }} cancelamentos este mês</div>
        @if($churnRate > 5)
            <span class="kpi-badge down">Acima do ideal (&lt;5%)</span>
        @elseif($churnRate > 0)
            <span class="kpi-badge neutral">Dentro do normal</span>
        @else
            <span class="kpi-badge up">0% — Excelente</span>
        @endif
    </div>
</div>

{{-- ── SECTION: UTILIZADORES & ENGAGEMENT ──────────────────────── --}}
<div class="an-section">
    <div class="an-section-icon blue">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>
    <span class="an-section-label">Utilizadores &amp; Engagement</span>
    <div class="an-section-line"></div>
</div>

<div class="kpi-grid" style="margin-bottom:28px;">
    <div class="kpi-card cyan">
        <div class="kpi-top">
            <div class="kpi-icon cyan">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Total Utilizadores</div>
        <div class="kpi-value">{{ $totalUsers }}</div>
        <div class="kpi-badges">
            <span class="kpi-badge up">{{ $activeUsers }} ativos</span>
            <span class="kpi-badge down">{{ $inactiveUsers }} inativos</span>
        </div>
    </div>

    <div class="kpi-card violet">
        <div class="kpi-top">
            <div class="kpi-icon violet">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Novos este mês</div>
        <div class="kpi-value">{{ $newUsersThisMonth }}</div>
        @if($userGrowthPct >= 0)
            <span class="kpi-badge up">
                <svg width="9" height="9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                +{{ $userGrowthPct }}% vs mês anterior
            </span>
        @else
            <span class="kpi-badge down">
                <svg width="9" height="9" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                {{ abs($userGrowthPct) }}% vs mês anterior
            </span>
        @endif
    </div>

    <div class="kpi-card teal">
        <div class="kpi-top">
            <div class="kpi-icon teal">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Total Cartões</div>
        <div class="kpi-value">{{ $totalCards }}</div>
        <div class="kpi-sub">{{ $avgCardsPerUser }} por utilizador · {{ $newCardsThisMonth }} novos este mês</div>
    </div>

    <div class="kpi-card orange">
        <div class="kpi-top">
            <div class="kpi-icon orange">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-label">Visualizações Totais</div>
        <div class="kpi-value">{{ number_format($totalViews) }}</div>
        <div class="kpi-sub">{{ number_format($totalQrScans) }} QR scans · {{ number_format($totalContacts) }} contactos</div>
    </div>
</div>

{{-- ── SECTION: CRESCIMENTO ─────────────────────────────────────── --}}
<div class="an-section">
    <div class="an-section-icon cyan">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
    </div>
    <span class="an-section-label">Crescimento — Últimos 12 Meses</span>
    <div class="an-section-line"></div>
</div>

<div class="an-row cols-2">
    <div class="chart-card">
        <div class="chart-card-title">Novos Utilizadores</div>
        <div class="chart-card-sub">Registos mensais</div>
        <div class="chart-wrap"><canvas id="chartUsers"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Novas Subscrições</div>
        <div class="chart-card-sub">Subscrições criadas por mês</div>
        <div class="chart-wrap"><canvas id="chartSubs"></canvas></div>
    </div>
</div>

<div class="an-row cols-3" style="margin-bottom:28px;">
    <div class="chart-card">
        <div class="chart-card-title">Cartões Criados</div>
        <div class="chart-card-sub">Novos cartões por mês</div>
        <div class="chart-wrap"><canvas id="chartCards"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Estado das Subscrições</div>
        <div class="chart-card-sub">Distribuição por estado e tipo de plano</div>
        <div class="chart-wrap sm"><canvas id="chartSubStatus"></canvas></div>
        <div style="margin-top:16px;">
            <div class="sub-row">
                <span class="sub-row-label"><span class="sub-dot" style="background:#6366f1;"></span>Mensal (€10/mês)</span>
                <span class="sub-row-val">{{ $monthlySubCount }}</span>
            </div>
            <div class="sub-row">
                <span class="sub-row-label"><span class="sub-dot" style="background:#06b6d4;"></span>Anual (€84/ano)</span>
                <span class="sub-row-val">{{ $annualSubCount }}</span>
            </div>
            <div class="sub-row">
                <span class="sub-row-label"><span class="sub-dot" style="background:#10b981;"></span>Em trial</span>
                <span class="sub-row-val">{{ $totalTrialing }}</span>
            </div>
            <div class="sub-row">
                <span class="sub-row-label"><span class="sub-dot" style="background:#f43f5e;"></span>Canceladas</span>
                <span class="sub-row-val">{{ $totalCancelled }}</span>
            </div>
            <div class="sub-row">
                <span class="sub-row-label"><span class="sub-dot" style="background:#f59e0b;"></span>Past Due</span>
                <span class="sub-row-val">{{ $totalPastDue }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── SECTION: PLATAFORMA ──────────────────────────────────────── --}}
<div class="an-section">
    <div class="an-section-icon violet">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
    </div>
    <span class="an-section-label">Plataforma</span>
    <div class="an-section-line"></div>
</div>

<div class="an-row cols-2" style="margin-bottom:28px;">
    <div class="chart-card">
        <div class="chart-card-title">Tipos de Utilizador</div>
        <div class="chart-card-sub">Distribuição por role na plataforma</div>
        <div class="chart-wrap sm"><canvas id="chartUserTypes"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Métricas de Empresas</div>
        <div class="chart-card-sub">Estado das empresas registadas</div>
        <div style="margin-top:8px;">
            <div class="metric-row">
                <span class="metric-row-label">
                    <span class="metric-dot" style="background:var(--text-tertiary);"></span>
                    Total Empresas
                </span>
                <span class="metric-row-val">{{ $totalCompanies }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-row-label">
                    <span class="metric-dot" style="background:#10b981;"></span>
                    Empresas Ativas
                </span>
                <span class="metric-row-val" style="color:#10b981;">{{ $activeCompanies }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-row-label">
                    <span class="metric-dot" style="background:#f43f5e;"></span>
                    Empresas Inativas
                </span>
                <span class="metric-row-val" style="color:#f43f5e;">{{ $totalCompanies - $activeCompanies }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-row-label">
                    <span class="metric-dot" style="background:#f59e0b;"></span>
                    Subscrições Past Due
                </span>
                <span class="metric-row-val" style="color:#f59e0b;">{{ $totalPastDue }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── TABLE: TOP CARDS ─────────────────────────────────────────── --}}
<div class="an-row cols-1" style="margin-bottom:14px;">
    <div class="chart-card">
        <div class="chart-card-title">Top 10 Cartões por Visualizações</div>
        <div class="chart-card-sub">Cartões com maior engagement na plataforma</div>
        <table class="an-table">
            <thead>
                <tr>
                    <th style="width:44px;">#</th>
                    <th>Nome / Cargo</th>
                    <th>Utilizador</th>
                    <th>Visualizações</th>
                    <th>QR Scans</th>
                    <th>Contactos</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCards as $i => $card)
                <tr>
                    <td>
                        @if($i === 0) <span class="rank rank-1">1</span>
                        @elseif($i === 1) <span class="rank rank-2">2</span>
                        @elseif($i === 2) <span class="rank rank-3">3</span>
                        @else <span class="rank rank-n">{{ $i + 1 }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('card.public', $card->slug) }}" target="_blank"
                           style="color:var(--text-primary);text-decoration:none;font-weight:600;font-size:13px;display:block;transition:color .15s;"
                           onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-primary)'">
                            {{ $card->full_name }}
                        </a>
                        @if($card->position)
                            <span style="font-size:11px;color:var(--text-tertiary);">{{ $card->position }}</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);">{{ $card->user?->name ?? '—' }}</td>
                    <td><span style="font-weight:700;color:var(--text-primary);">{{ number_format($card->views_count) }}</span></td>
                    <td>{{ number_format($card->qr_scans) }}</td>
                    <td>{{ number_format($card->contacts_saved) }}</td>
                    <td>
                        <span class="pill {{ $card->is_active ? 'pill-active' : 'pill-inactive' }}">
                            {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-tertiary);padding:48px 14px;">
                        Nenhum cartão encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── TABLE: RECENT USERS ──────────────────────────────────────── --}}
<div class="an-row cols-1">
    <div class="chart-card">
        <div class="chart-card-title">Registos Recentes</div>
        <div class="chart-card-sub">Últimos 8 utilizadores registados na plataforma</div>
        <table class="an-table">
            <thead>
                <tr>
                    <th>Utilizador</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Registado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $u)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="u-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:600;color:var(--text-primary);font-size:13px;">{{ $u->name }}</div>
                                <div style="font-size:11px;color:var(--text-tertiary);">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="pill" style="
                            background:{{ $u->type === 'super_admin' ? 'rgba(139,92,246,.15)' : ($u->type === 'company_admin' ? 'rgba(6,182,212,.15)' : 'rgba(161,161,170,.1)') }};
                            color:{{ $u->type === 'super_admin' ? '#a78bfa' : ($u->type === 'company_admin' ? '#22d3ee' : '#a1a1aa') }};">
                            {{ $u->type === 'super_admin' ? 'Super Admin' : ($u->type === 'company_admin' ? 'Admin Empresa' : 'Utilizador') }}
                        </span>
                    </td>
                    <td>
                        <span class="pill {{ $u->is_active ? 'pill-active' : 'pill-inactive' }}">
                            {{ $u->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td style="color:var(--text-tertiary);font-size:12px;">{{ $u->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
// ── THEME DETECTION ───────────────────────────────────────────
const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
const C = {
    textPrimary:   isDark ? '#fafafa'               : '#09090b',
    textSecondary: isDark ? '#a1a1aa'               : '#52525b',
    textTertiary:  isDark ? '#71717a'               : '#71717a',
    grid:          isDark ? 'rgba(255,255,255,.05)'  : 'rgba(0,0,0,.06)',
    tooltipBg:     isDark ? '#1f1f23'               : '#ffffff',
    tooltipBorder: isDark ? 'rgba(255,255,255,.1)'  : 'rgba(0,0,0,.08)',
    doughnutBorder:isDark ? '#18181b'               : '#f0f0f3',
};

// ── SHARED AXIS CONFIG ────────────────────────────────────────
const axisConfig = {
    x: {
        ticks:  { color: C.textTertiary, font: { family: 'Inter', size: 11 } },
        grid:   { color: C.grid, drawBorder: false },
        border: { display: false },
    },
    y: {
        ticks:  { color: C.textTertiary, font: { family: 'Inter', size: 11 } },
        grid:   { color: C.grid, drawBorder: false },
        border: { display: false },
        beginAtZero: true,
    }
};

// ── SHARED TOOLTIP CONFIG ─────────────────────────────────────
const tooltipConfig = {
    backgroundColor: C.tooltipBg,
    titleColor:      C.textPrimary,
    bodyColor:       C.textSecondary,
    borderColor:     C.tooltipBorder,
    borderWidth:     1,
    padding:         12,
    cornerRadius:    10,
    titleFont:       { family: 'Inter', weight: '700', size: 13 },
    bodyFont:        { family: 'Inter', size: 12 },
};

const baseOpts = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: {
        legend: { labels: { color: C.textSecondary, font: { family: 'Inter', size: 12 }, boxWidth: 10, padding: 16 } },
        tooltip: tooltipConfig,
    },
    scales: axisConfig,
};

// ── DATA ──────────────────────────────────────────────────────
const userGrowthData = @json(array_values($userGrowth));
const subGrowthData  = @json(array_values($subGrowth));
const cardGrowthData = @json(array_values($cardGrowth));
const chartLabels    = @json(array_keys($userGrowth));

const mo = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
const labels = chartLabels.map(m => {
    const [y, mn] = m.split('-');
    return mo[parseInt(mn) - 1] + " '" + y.slice(2);
});

// ── CHART: USERS (BAR) ────────────────────────────────────────
new Chart(document.getElementById('chartUsers'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Novos utilizadores',
            data: userGrowthData,
            backgroundColor: 'rgba(99,102,241,.55)',
            hoverBackgroundColor: 'rgba(99,102,241,.8)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: { ...baseOpts }
});

// ── CHART: SUBSCRIPTIONS (AREA LINE) ─────────────────────────
(function() {
    const canvas = document.getElementById('chartSubs');
    const ctx    = canvas.getContext('2d');
    const grad   = ctx.createLinearGradient(0, 0, 0, 220);
    grad.addColorStop(0, 'rgba(16,185,129,.28)');
    grad.addColorStop(1, 'rgba(16,185,129,.01)');
    new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Novas subscrições',
                data: subGrowthData,
                borderColor: '#10b981',
                backgroundColor: grad,
                fill: true,
                tension: 0.42,
                pointRadius: 3,
                pointBackgroundColor: '#10b981',
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#10b981',
                borderWidth: 2.5,
            }]
        },
        options: { ...baseOpts }
    });
})();

// ── CHART: CARDS (BAR) ────────────────────────────────────────
new Chart(document.getElementById('chartCards'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Cartões criados',
            data: cardGrowthData,
            backgroundColor: 'rgba(6,182,212,.5)',
            hoverBackgroundColor: 'rgba(6,182,212,.75)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: { ...baseOpts }
});

// ── CHART: SUBSCRIPTION STATUS (DOUGHNUT) ────────────────────
new Chart(document.getElementById('chartSubStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Ativas', 'Canceladas', 'Trial', 'Past Due'],
        datasets: [{
            data: [{{ $totalActive }}, {{ $totalCancelled }}, {{ $totalTrialing }}, {{ $totalPastDue }}],
            backgroundColor: ['#6366f1','#f43f5e','#10b981','#f59e0b'],
            borderColor: C.doughnutBorder,
            borderWidth: 3,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '68%',
        plugins: {
            legend: { position: 'bottom', labels: { color: C.textSecondary, font: { family: 'Inter', size: 11 }, padding: 12, boxWidth: 10 } },
            tooltip: tooltipConfig,
        }
    }
});

// ── CHART: USER TYPES (DOUGHNUT) ─────────────────────────────
new Chart(document.getElementById('chartUserTypes'), {
    type: 'doughnut',
    data: {
        labels: ['Utilizadores', 'Admin Empresa', 'Super Admin'],
        datasets: [{
            data: [
                {{ $usersByType['user'] ?? 0 }},
                {{ $usersByType['company_admin'] ?? 0 }},
                {{ $usersByType['super_admin'] ?? 0 }}
            ],
            backgroundColor: ['#a1a1aa','#22d3ee','#a78bfa'],
            borderColor: C.doughnutBorder,
            borderWidth: 3,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '68%',
        plugins: {
            legend: { position: 'bottom', labels: { color: C.textSecondary, font: { family: 'Inter', size: 11 }, padding: 12, boxWidth: 10 } },
            tooltip: tooltipConfig,
        }
    }
});
</script>
@endpush

@extends('layouts.dashboard')

@section('title', 'Analytics — CEO Dashboard')

@push('styles')
<style>
/* ═══ KPI CARDS ═══ */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.kpi-card {
    background: var(--bg-secondary, #1a1a2e);
    border: 1px solid var(--border, rgba(255,255,255,.08));
    border-radius: 14px;
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
    overflow: hidden;
}
.kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 14px 14px 0 0;
}
.kpi-card.blue::before   { background: linear-gradient(90deg,#6366f1,#818cf8); }
.kpi-card.green::before  { background: linear-gradient(90deg,#10b981,#34d399); }
.kpi-card.amber::before  { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
.kpi-card.rose::before   { background: linear-gradient(90deg,#f43f5e,#fb7185); }
.kpi-card.cyan::before   { background: linear-gradient(90deg,#06b6d4,#22d3ee); }
.kpi-card.violet::before { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
.kpi-card.teal::before   { background: linear-gradient(90deg,#14b8a6,#2dd4bf); }
.kpi-card.orange::before { background: linear-gradient(90deg,#f97316,#fb923c); }

.kpi-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-tertiary, #71717a);
}
.kpi-value {
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -1.5px;
    color: var(--text-primary, #fafafa);
    line-height: 1;
}
.kpi-sub {
    font-size: 12px;
    color: var(--text-tertiary, #71717a);
    margin-top: 2px;
}
.kpi-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    width: fit-content;
}
.kpi-badge.up   { background: rgba(16,185,129,.12); color: #10b981; }
.kpi-badge.down { background: rgba(244,63,94,.12);  color: #f43f5e; }
.kpi-badge.neutral { background: rgba(113,113,122,.12); color: #71717a; }

/* ═══ CHART SECTIONS ═══ */
.analytics-row {
    display: grid;
    gap: 20px;
    margin-bottom: 24px;
}
.analytics-row.cols-2 { grid-template-columns: 1fr 1fr; }
.analytics-row.cols-3 { grid-template-columns: 2fr 1fr; }
.analytics-row.cols-1 { grid-template-columns: 1fr; }

.chart-card {
    background: var(--bg-secondary, #1a1a2e);
    border: 1px solid var(--border, rgba(255,255,255,.08));
    border-radius: 14px;
    padding: 24px;
}
.chart-card-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #fafafa);
    margin-bottom: 4px;
}
.chart-card-sub {
    font-size: 12px;
    color: var(--text-tertiary, #71717a);
    margin-bottom: 20px;
}
.chart-wrap {
    position: relative;
    height: 240px;
}
.chart-wrap.sm { height: 190px; }

/* ═══ TABLES ═══ */
.analytics-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.analytics-table thead th {
    text-align: left;
    padding: 8px 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-tertiary, #71717a);
    border-bottom: 1px solid var(--border, rgba(255,255,255,.08));
}
.analytics-table tbody td {
    padding: 10px 12px;
    color: var(--text-secondary, #a1a1aa);
    border-bottom: 1px solid var(--border, rgba(255,255,255,.04));
}
.analytics-table tbody tr:last-child td { border-bottom: none; }
.analytics-table tbody tr:hover td { background: rgba(255,255,255,.02); }

/* ═══ SUB BREAKDOWN ═══ */
.sub-type-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--border, rgba(255,255,255,.06));
}
.sub-type-row:last-child { border-bottom: none; }
.sub-type-label { font-size: 13px; color: var(--text-secondary, #a1a1aa); display: flex; align-items: center; gap: 8px; }
.sub-dot { width: 10px; height: 10px; border-radius: 50%; }
.sub-type-val { font-size: 16px; font-weight: 700; color: var(--text-primary, #fafafa); }

/* ═══ STATUS BADGES ═══ */
.status-pill {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}
.status-active   { background: rgba(16,185,129,.12); color: #10b981; }
.status-inactive { background: rgba(244,63,94,.12);  color: #f43f5e; }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1100px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .analytics-row.cols-2,
    .analytics-row.cols-3 { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .kpi-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ───────────────────────────────────────── --}}
<div class="dashboard-header" style="margin-bottom:28px;">
    <div>
        <h1 class="page-title">📊 Analytics — CEO Dashboard</h1>
        <p class="page-subtitle">Métricas em tempo real da plataforma Cardifys · Atualizado agora</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        ← Voltar ao Painel
    </a>
</div>

{{-- ── KPI ROW 1: REVENUE ────────────────────────────────── --}}
<p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-tertiary);margin-bottom:10px;">💰 Receita</p>
<div class="kpi-grid">
    <div class="kpi-card green">
        <span class="kpi-label">MRR</span>
        <span class="kpi-value">€{{ number_format($mrr, 2) }}</span>
        <span class="kpi-sub">Receita mensal recorrente</span>
    </div>
    <div class="kpi-card blue">
        <span class="kpi-label">ARR</span>
        <span class="kpi-value">€{{ number_format($arr, 2) }}</span>
        <span class="kpi-sub">Receita anual recorrente (est.)</span>
    </div>
    <div class="kpi-card amber">
        <span class="kpi-label">Subscrições Ativas</span>
        <span class="kpi-value">{{ $totalActive }}</span>
        <span class="kpi-sub">{{ $monthlySubCount }} mensais · {{ $annualSubCount }} anuais</span>
    </div>
    <div class="kpi-card rose">
        <span class="kpi-label">Churn Rate</span>
        <span class="kpi-value">{{ $churnRate }}%</span>
        <span class="kpi-sub">{{ $churnedThisMonth }} cancelamentos este mês</span>
    </div>
</div>

{{-- ── KPI ROW 2: USERS & CARDS ──────────────────────────── --}}
<p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-tertiary);margin:20px 0 10px;">👥 Utilizadores & Cartões</p>
<div class="kpi-grid">
    <div class="kpi-card cyan">
        <span class="kpi-label">Total Utilizadores</span>
        <span class="kpi-value">{{ $totalUsers }}</span>
        <div style="display:flex;gap:8px;margin-top:4px;flex-wrap:wrap;">
            <span class="kpi-badge up">{{ $activeUsers }} ativos</span>
            <span class="kpi-badge down">{{ $inactiveUsers }} inativos</span>
        </div>
    </div>
    <div class="kpi-card violet">
        <span class="kpi-label">Novos este mês</span>
        <span class="kpi-value">{{ $newUsersThisMonth }}</span>
        @if($userGrowthPct >= 0)
            <span class="kpi-badge up">↑ {{ $userGrowthPct }}% vs mês anterior</span>
        @else
            <span class="kpi-badge down">↓ {{ abs($userGrowthPct) }}% vs mês anterior</span>
        @endif
    </div>
    <div class="kpi-card teal">
        <span class="kpi-label">Total Cartões</span>
        <span class="kpi-value">{{ $totalCards }}</span>
        <span class="kpi-sub">{{ $avgCardsPerUser }} cartões/utilizador (média) · {{ $newCardsThisMonth }} novos este mês</span>
    </div>
    <div class="kpi-card orange">
        <span class="kpi-label">Visualizações Totais</span>
        <span class="kpi-value">{{ number_format($totalViews) }}</span>
        <span class="kpi-sub">{{ number_format($totalQrScans) }} QR scans · {{ number_format($totalContacts) }} contactos salvos</span>
    </div>
</div>

{{-- ── CHARTS ROW 1: USER GROWTH + SUBSCRIPTION GROWTH ─── --}}
<div class="analytics-row cols-2">
    <div class="chart-card">
        <div class="chart-card-title">Novos Utilizadores</div>
        <div class="chart-card-sub">Registos mensais — últimos 12 meses</div>
        <div class="chart-wrap">
            <canvas id="chartUsers"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Novas Subscrições</div>
        <div class="chart-card-sub">Subscrições criadas por mês — últimos 12 meses</div>
        <div class="chart-wrap">
            <canvas id="chartSubs"></canvas>
        </div>
    </div>
</div>

{{-- ── CHARTS ROW 2: CARDS GROWTH + SUBSCRIPTION BREAKDOWN ─ --}}
<div class="analytics-row cols-3">
    <div class="chart-card">
        <div class="chart-card-title">Cartões Criados</div>
        <div class="chart-card-sub">Novos cartões por mês — últimos 12 meses</div>
        <div class="chart-wrap">
            <canvas id="chartCards"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Distribuição de Subscrições</div>
        <div class="chart-card-sub">Por estado e tipo de plano</div>

        <div class="chart-wrap sm">
            <canvas id="chartSubStatus"></canvas>
        </div>

        <div style="margin-top:16px;">
            <div class="sub-type-row">
                <span class="sub-type-label"><span class="sub-dot" style="background:#6366f1;"></span>Mensal (€10/mês)</span>
                <span class="sub-type-val">{{ $monthlySubCount }}</span>
            </div>
            <div class="sub-type-row">
                <span class="sub-type-label"><span class="sub-dot" style="background:#06b6d4;"></span>Anual (€84/ano)</span>
                <span class="sub-type-val">{{ $annualSubCount }}</span>
            </div>
            <div class="sub-type-row">
                <span class="sub-type-label"><span class="sub-dot" style="background:#10b981;"></span>Em trial</span>
                <span class="sub-type-val">{{ $totalTrialing }}</span>
            </div>
            <div class="sub-type-row">
                <span class="sub-type-label"><span class="sub-dot" style="background:#f43f5e;"></span>Canceladas</span>
                <span class="sub-type-val">{{ $totalCancelled }}</span>
            </div>
            <div class="sub-type-row">
                <span class="sub-type-label"><span class="sub-dot" style="background:#f59e0b;"></span>Past Due</span>
                <span class="sub-type-val">{{ $totalPastDue }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── CHARTS ROW 3: USER TYPES + COMPANY STATS ─────────── --}}
<div class="analytics-row cols-2" style="margin-bottom:24px;">
    <div class="chart-card">
        <div class="chart-card-title">Tipos de Utilizador</div>
        <div class="chart-card-sub">Distribuição por role na plataforma</div>
        <div class="chart-wrap sm">
            <canvas id="chartUserTypes"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">Métricas de Empresas</div>
        <div class="chart-card-sub">Estado das empresas registadas</div>
        <div style="display:flex;flex-direction:column;gap:16px;margin-top:8px;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--bg-tertiary, #18181b);border-radius:10px;">
                <span style="font-size:13px;color:var(--text-secondary);">Total Empresas</span>
                <span style="font-size:24px;font-weight:800;color:var(--text-primary);">{{ $totalCompanies }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--bg-tertiary, #18181b);border-radius:10px;">
                <span style="font-size:13px;color:var(--text-secondary);">Empresas Ativas</span>
                <span style="font-size:24px;font-weight:800;color:#10b981;">{{ $activeCompanies }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--bg-tertiary, #18181b);border-radius:10px;">
                <span style="font-size:13px;color:var(--text-secondary);">Empresas Inativas</span>
                <span style="font-size:24px;font-weight:800;color:#f43f5e;">{{ $totalCompanies - $activeCompanies }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--bg-tertiary, #18181b);border-radius:10px;">
                <span style="font-size:13px;color:var(--text-secondary);">Subscrições por confirmar</span>
                <span style="font-size:24px;font-weight:800;color:#f59e0b;">{{ $totalPastDue }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── TOP CARDS TABLE ────────────────────────────────────── --}}
<div class="analytics-row cols-1">
    <div class="chart-card">
        <div class="chart-card-title">🏆 Top 10 Cartões por Visualizações</div>
        <div class="chart-card-sub">Cartões com maior engagement na plataforma</div>
        <table class="analytics-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
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
                    <td style="font-weight:700;color:var(--text-primary);">{{ $i + 1 }}</td>
                    <td>
                        <a href="{{ route('card.public', $card->slug) }}" target="_blank"
                           style="color:var(--accent, #6366f1);text-decoration:none;font-weight:500;">
                            {{ $card->full_name }}
                        </a>
                        @if($card->position)
                            <div style="font-size:11px;color:var(--text-tertiary);">{{ $card->position }}</div>
                        @endif
                    </td>
                    <td>{{ $card->user?->name ?? '—' }}</td>
                    <td style="font-weight:700;color:var(--text-primary);">{{ number_format($card->views_count) }}</td>
                    <td>{{ number_format($card->qr_scans) }}</td>
                    <td>{{ number_format($card->contacts_saved) }}</td>
                    <td>
                        <span class="status-pill {{ $card->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $card->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-tertiary);padding:32px;">
                        Nenhum cartão encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── RECENT USERS TABLE ─────────────────────────────────── --}}
<div class="analytics-row cols-1">
    <div class="chart-card">
        <div class="chart-card-title">🆕 Registos Recentes</div>
        <div class="chart-card-sub">Últimos 8 utilizadores registados na plataforma</div>
        <table class="analytics-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Registado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $u)
                <tr>
                    <td style="font-weight:500;color:var(--text-primary);">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <span class="status-pill" style="
                            background: {{ $u->type === 'super_admin' ? 'rgba(139,92,246,.15)' : ($u->type === 'company_admin' ? 'rgba(6,182,212,.15)' : 'rgba(161,161,170,.1)') }};
                            color: {{ $u->type === 'super_admin' ? '#a78bfa' : ($u->type === 'company_admin' ? '#22d3ee' : '#a1a1aa') }};">
                            {{ $u->type === 'super_admin' ? 'Super Admin' : ($u->type === 'company_admin' ? 'Admin Empresa' : 'Utilizador') }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill {{ $u->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $u->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td style="color:var(--text-tertiary);">{{ $u->created_at->format('d M Y, H:i') }}</td>
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
// ── SHARED THEME ────────────────────────────────────────────
const chartDefaults = {
    color: '#a1a1aa',
    plugins: {
        legend: { labels: { color: '#a1a1aa', font: { family: 'Inter', size: 12 } } },
        tooltip: {
            backgroundColor: '#1f1f23',
            titleColor: '#fafafa',
            bodyColor: '#a1a1aa',
            borderColor: 'rgba(255,255,255,.08)',
            borderWidth: 1,
        }
    },
    scales: {
        x: {
            ticks: { color: '#71717a', font: { family: 'Inter', size: 11 } },
            grid: { color: 'rgba(255,255,255,.04)' }
        },
        y: {
            ticks: { color: '#71717a', font: { family: 'Inter', size: 11 } },
            grid: { color: 'rgba(255,255,255,.06)' },
            beginAtZero: true
        }
    }
};

// ── DATA FROM LARAVEL ───────────────────────────────────────
const userGrowthData    = @json(array_values($userGrowth));
const subGrowthData     = @json(array_values($subGrowth));
const cardGrowthData    = @json(array_values($cardGrowth));
const chartLabels       = @json(array_keys($userGrowth));

// Shorten labels: "2025-04" → "Abr '25"
const monthNames = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
const shortLabels = chartLabels.map(m => {
    const [y, mo] = m.split('-');
    return monthNames[parseInt(mo) - 1] + " '" + y.slice(2);
});

// ── CHART: USERS ─────────────────────────────────────────────
new Chart(document.getElementById('chartUsers'), {
    type: 'bar',
    data: {
        labels: shortLabels,
        datasets: [{
            label: 'Novos utilizadores',
            data: userGrowthData,
            backgroundColor: 'rgba(99,102,241,.5)',
            borderColor: '#6366f1',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: { ...chartDefaults, responsive: true, maintainAspectRatio: false }
});

// ── CHART: SUBSCRIPTIONS ─────────────────────────────────────
new Chart(document.getElementById('chartSubs'), {
    type: 'line',
    data: {
        labels: shortLabels,
        datasets: [{
            label: 'Novas subscrições',
            data: subGrowthData,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#10b981',
        }]
    },
    options: { ...chartDefaults, responsive: true, maintainAspectRatio: false }
});

// ── CHART: CARDS ─────────────────────────────────────────────
new Chart(document.getElementById('chartCards'), {
    type: 'bar',
    data: {
        labels: shortLabels,
        datasets: [{
            label: 'Cartões criados',
            data: cardGrowthData,
            backgroundColor: 'rgba(6,182,212,.45)',
            borderColor: '#06b6d4',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: { ...chartDefaults, responsive: true, maintainAspectRatio: false }
});

// ── CHART: SUBSCRIPTION STATUS (DOUGHNUT) ────────────────────
new Chart(document.getElementById('chartSubStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Ativas', 'Canceladas', 'Trial', 'Past Due'],
        datasets: [{
            data: [
                {{ $totalActive }},
                {{ $totalCancelled }},
                {{ $totalTrialing }},
                {{ $totalPastDue }}
            ],
            backgroundColor: ['#6366f1','#f43f5e','#10b981','#f59e0b'],
            borderColor: '#111113',
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 }, padding: 14 } },
            tooltip: {
                backgroundColor: '#1f1f23',
                titleColor: '#fafafa',
                bodyColor: '#a1a1aa',
                borderColor: 'rgba(255,255,255,.08)',
                borderWidth: 1,
            }
        }
    }
});

// ── CHART: USER TYPES (PIE) ───────────────────────────────────
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
            borderColor: '#111113',
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 }, padding: 14 } },
            tooltip: {
                backgroundColor: '#1f1f23',
                titleColor: '#fafafa',
                bodyColor: '#a1a1aa',
                borderColor: 'rgba(255,255,255,.08)',
                borderWidth: 1,
            }
        }
    }
});
</script>
@endpush

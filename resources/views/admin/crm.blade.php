@php
    // ── Local formatting helpers (pt-PT) ────────────────────────────────
    $eur  = fn ($n) => '€' . number_format((float) $n, 0, ',', '.');
    $eur2 = fn ($n) => '€' . number_format((float) $n, 2, ',', '.');
    $nf   = fn ($n) => number_format((float) $n, 0, ',', '.');
    $pct  = fn ($n) => ($n >= 0 ? '+' : '') . number_format((float) $n, 1, ',', '.') . '%';

    // ── MRR line chart geometry (12 months) ─────────────────────────────
    $cw = 640; $ch = 150; $pad = 6;
    $maxMrr = max(1, max($mrrSeries));
    $stepX  = count($mrrSeries) > 1 ? ($cw - $pad * 2) / (count($mrrSeries) - 1) : 0;
    $pts = [];
    foreach ($mrrSeries as $i => $v) {
        $x = $pad + $i * $stepX;
        $y = $ch - $pad - ($v / $maxMrr) * ($ch - $pad * 2);
        $pts[] = round($x, 1) . ',' . round($y, 1);
    }
    $linePath = implode(' ', $pts);
    $areaPath = $linePath . ' ' . round($pad + (count($mrrSeries) - 1) * $stepX, 1) . ',' . ($ch - $pad)
              . ' ' . $pad . ',' . ($ch - $pad);

    $maxSignup = max(1, max($signupSeries));
    $maxFunnel = max(1, $funnel[0]['value']);
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM — Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: oklch(0.13 0.012 290);
            --bg-2: oklch(0.165 0.014 290);
            --bg-3: oklch(0.195 0.016 290);
            --ink: oklch(0.97 0.01 290);
            --ink-dim: oklch(0.74 0.015 290);
            --ink-mute: oklch(0.54 0.012 290);
            --line: oklch(0.30 0.018 290 / 0.7);
            --line-soft: oklch(0.30 0.018 290 / 0.32);
            --purple: oklch(0.72 0.19 300);
            --purple-deep: oklch(0.55 0.19 300);
            --lavender: oklch(0.82 0.14 330);
            --amber: oklch(0.82 0.12 85);
            --green: oklch(0.78 0.15 162);
            --danger: oklch(0.68 0.19 22);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        .mono { font-family: 'Geist Mono', monospace; }
        a { color: inherit; text-decoration: none; }
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-thumb { background: oklch(0.3 0.02 290 / 0.6); border-radius: 99px; border: 3px solid var(--bg); }

        .layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .side { width: 232px; flex-shrink: 0; background: var(--bg-2); border-right: 1px solid var(--line-soft); display: flex; flex-direction: column; padding: 18px 14px; position: sticky; top: 0; height: 100vh; }
        .side-brand { display: flex; align-items: center; gap: 10px; padding: 4px 8px 18px; }
        .side-brand .mark { width: 30px; height: 30px; border-radius: 8px; background: radial-gradient(circle at 30% 30%, var(--purple), var(--purple-deep)); position: relative; }
        .side-brand .mark::after { content: ""; position: absolute; inset: 8px; border-radius: 4px; border: 1.5px solid var(--bg-2); border-top-color: transparent; border-right-color: transparent; }
        .side-brand b { font-size: 15px; font-weight: 600; }
        .side-tag { font-size: 9px; color: var(--ink-mute); letter-spacing: 0.12em; text-transform: uppercase; }
        .side-label { font-size: 9.5px; color: var(--ink-mute); letter-spacing: 0.14em; text-transform: uppercase; padding: 14px 10px 6px; }
        .nav-item { display: flex; align-items: center; gap: 11px; padding: 9px 11px; border-radius: 9px; color: var(--ink-dim); font-size: 13.5px; position: relative; transition: all .15s; }
        .nav-item:hover { background: var(--bg-3); color: var(--ink); }
        .nav-item.active { background: oklch(0.72 0.19 300 / 0.13); color: var(--ink); }
        .nav-item.active::before { content: ""; position: absolute; left: -14px; top: 50%; transform: translateY(-50%); width: 3px; height: 20px; background: var(--purple); border-radius: 0 3px 3px 0; box-shadow: 0 0 10px var(--purple); }
        .nav-item svg { width: 17px; height: 17px; }
        .nav-item.active svg { color: var(--purple); }

        /* Main */
        .main { flex: 1; min-width: 0; }
        .head { padding: 24px 32px 18px; border-bottom: 1px solid var(--line-soft); display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; }
        .bread { font-size: 10px; color: var(--ink-mute); letter-spacing: 0.14em; margin-bottom: 7px; }
        .page-title { font-size: 23px; font-weight: 600; letter-spacing: -0.02em; }
        .page-sub { font-size: 13px; color: var(--ink-dim); margin-top: 3px; }
        .real-badge { font-size: 10.5px; color: var(--green); background: oklch(0.78 0.15 162 / 0.12); border: 1px solid oklch(0.78 0.15 162 / 0.3); padding: 5px 11px; border-radius: 99px; white-space: nowrap; }

        .wrap { padding: 24px 32px 64px; }

        /* KPI grid */
        .kpi-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; margin-bottom: 22px; }
        .kpi { background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: 15px; padding: 15px 15px 13px; transition: border-color .2s, transform .2s; }
        .kpi:hover { border-color: var(--line); transform: translateY(-2px); }
        .kpi-label { font-size: 11px; color: var(--ink-dim); }
        .kpi-val { font-size: 25px; font-weight: 600; letter-spacing: -0.02em; margin: 7px 0 3px; }
        .kpi-sub { font-size: 10px; color: var(--ink-mute); }
        .kpi-delta { font-size: 11px; font-weight: 500; }
        .kpi-delta.good { color: var(--green); }
        .kpi-delta.bad { color: var(--danger); }

        /* Panels */
        .row { display: grid; gap: 16px; margin-bottom: 16px; }
        .row.c2 { grid-template-columns: 1.6fr 1fr; }
        .row.c2b { grid-template-columns: 1fr 1.6fr; }
        .panel { background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: 16px; padding: 18px 20px; }
        .panel-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-meta { font-size: 11px; color: var(--ink-mute); }

        /* Charts */
        .chart { width: 100%; height: auto; display: block; }
        .bars { display: flex; align-items: flex-end; gap: 5px; height: 90px; }
        .bar { flex: 1; background: oklch(0.72 0.19 300 / 0.25); border: 1px solid oklch(0.72 0.19 300 / 0.4); border-radius: 4px 4px 0 0; min-height: 3px; position: relative; }
        .bar-labels { display: flex; gap: 5px; margin-top: 6px; }
        .bar-label { flex: 1; text-align: center; font-size: 8.5px; color: var(--ink-mute); }

        /* Funnel */
        .funnel-row { margin-bottom: 12px; }
        .funnel-top { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 5px; }
        .funnel-top span:last-child { color: var(--ink-dim); }
        .funnel-track { height: 10px; background: var(--bg-3); border-radius: 99px; overflow: hidden; }
        .funnel-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--purple), var(--lavender)); }

        /* Plan distribution */
        .plan-row { display: flex; align-items: center; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid var(--line-soft); }
        .plan-row:last-child { border-bottom: none; }
        .plan-name { font-size: 13px; }
        .plan-meta { font-size: 11px; color: var(--ink-mute); }
        .plan-mrr { font-size: 13px; font-weight: 600; }

        /* Health pills */
        .health-bar { display: flex; gap: 8px; margin-bottom: 16px; }
        .health-cell { flex: 1; border-radius: 12px; padding: 12px 14px; border: 1px solid var(--line-soft); }
        .health-cell .n { font-size: 22px; font-weight: 600; }
        .health-cell .l { font-size: 11px; color: var(--ink-mute); }
        .h-healthy { background: oklch(0.78 0.15 162 / 0.08); border-color: oklch(0.78 0.15 162 / 0.3); }
        .h-healthy .n { color: var(--green); }
        .h-watch { background: oklch(0.82 0.12 85 / 0.08); border-color: oklch(0.82 0.12 85 / 0.3); }
        .h-watch .n { color: var(--amber); }
        .h-risk { background: oklch(0.68 0.19 22 / 0.08); border-color: oklch(0.68 0.19 22 / 0.3); }
        .h-risk .n { color: var(--danger); }

        /* Tables */
        .tbl { width: 100%; border-collapse: collapse; }
        .tbl th { text-align: left; font-size: 10px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-mute); padding: 0 12px 10px; }
        .tbl th.r, .tbl td.r { text-align: right; }
        .tbl td { padding: 11px 12px; font-size: 13px; border-top: 1px solid var(--line-soft); }
        .tbl tr:hover td { background: var(--bg-3); }
        .dot { display: inline-block; width: 7px; height: 7px; border-radius: 99px; margin-right: 7px; vertical-align: middle; }
        .dot.healthy { background: var(--green); box-shadow: 0 0 6px var(--green); }
        .dot.watch { background: var(--amber); box-shadow: 0 0 6px var(--amber); }
        .dot.risk { background: var(--danger); box-shadow: 0 0 6px var(--danger); }
        .muted { color: var(--ink-mute); }
        .name-cell b { font-weight: 500; }
        .name-cell small { display: block; font-size: 11px; color: var(--ink-mute); }

        .empty { text-align: center; padding: 40px; color: var(--ink-mute); font-size: 13px; }

        @media (max-width: 1100px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); }
            .row.c2, .row.c2b { grid-template-columns: 1fr; }
        }
        @media (max-width: 720px) {
            .side { display: none; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
<div class="layout">

    <!-- Sidebar -->
    <aside class="side">
        <div class="side-brand">
            <div class="mark"></div>
            <div>
                <b>Cardifys</b>
                <div class="side-tag">Founder Console</div>
            </div>
        </div>

        <div class="side-label">Negócio</div>
        <a href="{{ route('admin.crm') }}" class="nav-item active">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            <span>Visão geral</span>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            <span>Contas</span>
        </a>
        <a href="{{ route('admin.companies') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
            <span>Empresas</span>
        </a>
        <a href="{{ route('admin.business-cards') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>
            <span>Cartões</span>
        </a>

        <div class="side-label">Plataforma</div>
        <a href="{{ route('admin.analytics') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
            <span>Analytics (legado)</span>
        </a>
        <a href="{{ route('dashboard') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 010 12h-3"/></svg>
            <span>Voltar à app</span>
        </a>
    </aside>

    <!-- Main -->
    <main class="main">
        <div class="head">
            <div>
                <div class="bread mono">CARDIFYS / VISÃO GERAL</div>
                <div class="page-title">Visão geral do negócio</div>
                <div class="page-sub">Pulso da Cardifys em tempo real</div>
            </div>
            <div class="real-badge">● Dados reais · ao vivo</div>
        </div>

        <div class="wrap">

            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi">
                    <div class="kpi-label">MRR</div>
                    <div class="kpi-val">{{ $eur($mrr) }}</div>
                    <div class="kpi-sub">ARR {{ $eur($arr) }}</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Contas a pagar</div>
                    <div class="kpi-val">{{ $nf($payingAccounts) }}</div>
                    <div class="kpi-sub">{{ $nf($totalTrialing) }} em trial</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Novos registos</div>
                    <div class="kpi-val">{{ $nf($newUsersThisMonth) }}</div>
                    <div class="kpi-delta {{ $userGrowthPct >= 0 ? 'good' : 'bad' }}">{{ $pct($userGrowthPct) }} vs mês anterior</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Conversão scan→save</div>
                    <div class="kpi-val">{{ number_format($scanToSave, 1, ',', '.') }}%</div>
                    <div class="kpi-sub">{{ $nf($totalContacts) }} contactos guardados</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Churn (logo)</div>
                    <div class="kpi-val">{{ number_format($churnRate, 1, ',', '.') }}%</div>
                    <div class="kpi-sub">{{ $nf($churnedThisMonth) }} cancelaram este mês</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">ARPA</div>
                    <div class="kpi-val">{{ $eur2($arpa) }}</div>
                    <div class="kpi-sub">por conta / mês</div>
                </div>
            </div>

            <!-- MRR chart + plan distribution -->
            <div class="row c2">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">MRR — últimos 12 meses</div>
                        <div class="panel-meta">máx {{ $eur($maxMrr) }}</div>
                    </div>
                    <svg class="chart" viewBox="0 0 {{ $cw }} {{ $ch }}" preserveAspectRatio="none" style="height:160px;">
                        <defs>
                            <linearGradient id="mrrFill" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="oklch(0.72 0.19 300 / 0.35)"/>
                                <stop offset="100%" stop-color="oklch(0.72 0.19 300 / 0)"/>
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $areaPath }}" fill="url(#mrrFill)"/>
                        <polyline points="{{ $linePath }}" fill="none" stroke="var(--purple)" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                        @foreach($pts as $p)
                            <circle cx="{{ explode(',', $p)[0] }}" cy="{{ explode(',', $p)[1] }}" r="2.5" fill="var(--purple)"/>
                        @endforeach
                    </svg>
                    <div class="bar-labels">
                        @foreach($months as $m)
                            <div class="bar-label">{{ $m }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">MRR por plano</div>
                    </div>
                    @foreach($planBreakdown as $plan)
                        @if($plan['accounts'] > 0)
                        <div class="plan-row">
                            <div>
                                <div class="plan-name">{{ $plan['label'] }}</div>
                                <div class="plan-meta">{{ $nf($plan['accounts']) }} {{ $plan['accounts'] == 1 ? 'conta' : 'contas' }}</div>
                            </div>
                            <div class="plan-mrr">{{ $eur($plan['mrr']) }}</div>
                        </div>
                        @endif
                    @endforeach
                    @if($payingAccounts === 0)
                        <div class="empty">Ainda sem subscrições ativas.</div>
                    @endif
                </div>
            </div>

            <!-- Signups + funnel -->
            <div class="row c2b">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Registos / mês</div>
                        <div class="panel-meta">{{ $nf(array_sum($signupSeries)) }} no total (12m)</div>
                    </div>
                    <div class="bars">
                        @foreach($signupSeries as $s)
                            <div class="bar" style="height:{{ max(3, ($s / $maxSignup) * 90) }}px" title="{{ $s }}"></div>
                        @endforeach
                    </div>
                    <div class="bar-labels">
                        @foreach($months as $m)
                            <div class="bar-label">{{ $m }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Funil de engagement</div>
                        <div class="panel-meta">scans → vistos → guardados</div>
                    </div>
                    @foreach($funnel as $step)
                        <div class="funnel-row">
                            <div class="funnel-top">
                                <span>{{ $step['name'] }}</span>
                                <span>{{ $nf($step['value']) }}</span>
                            </div>
                            <div class="funnel-track">
                                <div class="funnel-fill" style="width:{{ max(2, ($step['value'] / $maxFunnel) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Accounts -->
            <div class="panel" style="margin-bottom:16px;">
                <div class="panel-head">
                    <div class="panel-title">Contas a pagar · saúde</div>
                    <div class="panel-meta">{{ $nf($payingAccounts) }} contas</div>
                </div>

                <div class="health-bar">
                    <div class="health-cell h-healthy"><div class="n">{{ $nf($healthCounts['healthy']) }}</div><div class="l">Saudáveis</div></div>
                    <div class="health-cell h-watch"><div class="n">{{ $nf($healthCounts['watch']) }}</div><div class="l">A vigiar</div></div>
                    <div class="health-cell h-risk"><div class="n">{{ $nf($healthCounts['risk']) }}</div><div class="l">Em risco</div></div>
                </div>

                @if($accounts->count())
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Conta</th>
                            <th>Plano</th>
                            <th class="r">MRR</th>
                            <th class="r">Cartões</th>
                            <th class="r">Views</th>
                            <th>Última atividade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts->take(15) as $a)
                        <tr>
                            <td class="name-cell">
                                <span class="dot {{ $a->health }}"></span><b>{{ $a->name }}</b>
                                <small>{{ $a->email }}</small>
                            </td>
                            <td class="muted">{{ $a->plan }}</td>
                            <td class="r">{{ $eur($a->mrr) }}</td>
                            <td class="r">{{ $nf($a->cards) }}</td>
                            <td class="r">{{ $nf($a->views) }}</td>
                            <td class="muted">
                                @if($a->days_inactive >= 999) nunca
                                @elseif($a->days_inactive === 0) hoje
                                @elseif($a->days_inactive === 1) ontem
                                @else há {{ $a->days_inactive }} dias @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="empty">Ainda sem contas a pagar. Quando as primeiras subscrições entrarem, aparecem aqui.</div>
                @endif
            </div>

            <!-- Top cards + recent signups -->
            <div class="row c2">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Cartões com melhor desempenho</div>
                        <div class="panel-meta">por views</div>
                    </div>
                    @if($topCards->count())
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Cartão</th>
                                <th class="r">Views</th>
                                <th class="r">Guardados</th>
                                <th class="r">Conv.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCards as $c)
                            <tr>
                                <td class="name-cell"><b>{{ $c->name }}</b><small>{{ $c->position ?: '—' }}</small></td>
                                <td class="r">{{ $nf($c->views) }}</td>
                                <td class="r">{{ $nf($c->saves) }}</td>
                                <td class="r">{{ $c->conv }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="empty">Ainda sem cartões com atividade.</div>
                    @endif
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title">Registos recentes</div>
                    </div>
                    @if($recentSignups->count())
                        @foreach($recentSignups as $u)
                        <div class="plan-row">
                            <div class="plan-name">{{ $u->name }}</div>
                            <div class="plan-meta">{{ $u->created_at->locale('pt')->diffForHumans() }}</div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty">Sem registos ainda.</div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>
</body>
</html>

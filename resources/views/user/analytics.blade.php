@extends('layouts.dashboard')

@section('title', 'Analytics')

@section('content')
@php
    $nf = fn ($n) => number_format((float) $n, 0, ',', '.');
    $maxDaily = max(1, max($daily));

    // Donut geometry
    $chTotal = array_sum($channels);
    $chMeta = [
        'qr'   => ['label' => 'QR Code', 'color' => 'oklch(0.72 0.19 300)'],
        'nfc'  => ['label' => 'NFC',     'color' => 'oklch(0.82 0.14 330)'],
        'link' => ['label' => 'Link',    'color' => 'oklch(0.70 0.14 245)'],
    ];
    $circ = 2 * M_PI * 42; // r = 42
    $offset = 0;
    $segments = [];
    foreach ($channels as $key => $count) {
        if ($chTotal > 0 && $count > 0) {
            $len = ($count / $chTotal) * $circ;
            $segments[] = ['color' => $chMeta[$key]['color'], 'len' => $len, 'offset' => $offset];
            $offset += $len;
        }
    }
@endphp

<div class="an-head">
    <div>
        <h1 class="page-title">O meu Analytics</h1>
        <p class="page-subtitle">Resumo rápido do desempenho dos teus cartões</p>
    </div>
</div>

{{-- KPIs --}}
<div class="an-kpis">
    <div class="an-kpi">
        <div class="an-kpi-label">Cartões ativos</div>
        <div class="an-kpi-val">{{ $nf($activeCards) }}</div>
    </div>
    <div class="an-kpi">
        <div class="an-kpi-label">Visualizações</div>
        <div class="an-kpi-val">{{ $nf($totalViews) }}</div>
    </div>
    <div class="an-kpi">
        <div class="an-kpi-label">Scans</div>
        <div class="an-kpi-val">{{ $nf($totalScans) }}</div>
        <div class="an-kpi-sub">{{ $nf($scans30) }} nos últimos 30 dias</div>
    </div>
    <div class="an-kpi">
        <div class="an-kpi-label">Contactos guardados</div>
        <div class="an-kpi-val">{{ $nf($totalSaves) }}</div>
    </div>
    <div class="an-kpi">
        <div class="an-kpi-label">Taxa de conversão</div>
        <div class="an-kpi-val">{{ number_format($conversion, 1, ',', '.') }}%</div>
        <div class="an-kpi-sub">scan → contacto guardado</div>
    </div>
</div>

<div class="an-row">
    {{-- Scan activity --}}
    <div class="an-panel">
        <div class="an-panel-head">
            <div class="an-panel-title">Atividade de scans</div>
            <div class="an-panel-meta">últimos 30 dias</div>
        </div>
        @if($scans30 > 0)
            <div class="an-bars">
                @foreach($daily as $i => $v)
                    <div class="an-bar" style="height: {{ max(2, ($v / $maxDaily) * 100) }}%" title="{{ $days[$i] }}: {{ $v }}"></div>
                @endforeach
            </div>
            <div class="an-bars-axis">
                <span>{{ $days[0] }}</span>
                <span>{{ $days[14] }}</span>
                <span>{{ $days[29] }}</span>
            </div>
        @else
            <div class="an-empty">
                Ainda sem scans registados nos últimos 30 dias.<br>
                <span>Partilha o teu cartão para começares a ver atividade aqui.</span>
            </div>
        @endif
    </div>

    {{-- Channel breakdown --}}
    <div class="an-panel">
        <div class="an-panel-head">
            <div class="an-panel-title">Canal de partilha</div>
            <div class="an-panel-meta">de onde vêm os scans</div>
        </div>
        @if($chTotal > 0)
            <div class="an-donut-wrap">
                <svg viewBox="0 0 100 100" class="an-donut">
                    <circle cx="50" cy="50" r="42" fill="none" stroke="oklch(0.30 0.018 290 / 0.4)" stroke-width="12"/>
                    @foreach($segments as $seg)
                        <circle cx="50" cy="50" r="42" fill="none"
                                stroke="{{ $seg['color'] }}" stroke-width="12"
                                stroke-dasharray="{{ $seg['len'] }} {{ $circ - $seg['len'] }}"
                                stroke-dashoffset="{{ -$seg['offset'] }}"
                                transform="rotate(-90 50 50)" stroke-linecap="butt"/>
                    @endforeach
                    <text x="50" y="47" text-anchor="middle" class="an-donut-num">{{ $nf($chTotal) }}</text>
                    <text x="50" y="58" text-anchor="middle" class="an-donut-lbl">scans</text>
                </svg>
                <div class="an-legend">
                    @foreach($chMeta as $key => $meta)
                        <div class="an-legend-item">
                            <span class="an-dot" style="background: {{ $meta['color'] }}"></span>
                            <span class="an-legend-name">{{ $meta['label'] }}</span>
                            <span class="an-legend-val">{{ $chTotal > 0 ? round(($channels[$key] / $chTotal) * 100) : 0 }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="an-empty">Sem dados de canais ainda.</div>
        @endif
    </div>
</div>

{{-- Per-card breakdown --}}
<div class="an-panel">
    <div class="an-panel-head">
        <div class="an-panel-title">Os meus cartões</div>
        <div class="an-panel-meta">desempenho por cartão</div>
    </div>
    @if($cardStats->isNotEmpty())
        <table class="an-table">
            <thead>
                <tr>
                    <th>Cartão</th>
                    <th class="r">Views</th>
                    <th class="r">Scans</th>
                    <th class="r">Guardados</th>
                    <th class="r">Conversão</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cardStats as $c)
                    <tr>
                        <td>
                            <a href="{{ route('card.public', $c->slug) }}" target="_blank" class="an-card-name">{{ $c->name }}</a>
                            @unless($c->active)<span class="an-inactive">inativo</span>@endunless
                        </td>
                        <td class="r">{{ $nf($c->views) }}</td>
                        <td class="r">{{ $nf($c->scans) }}</td>
                        <td class="r">{{ $nf($c->saves) }}</td>
                        <td class="r">{{ $c->conv }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="an-empty">
            Ainda não tens cartões.<br>
            <a href="{{ route('business-cards.create') }}" style="color: oklch(0.72 0.19 300); font-weight: 600;">Cria o teu primeiro cartão →</a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .an-head { margin-bottom: 22px; }
    .an-kpis { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 16px; }
    .an-kpi { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 15px; padding: 15px 16px 13px; }
    .an-kpi-label { font-size: 11.5px; color: var(--ink-dim, #a9a9b3); }
    .an-kpi-val { font-size: 26px; font-weight: 600; letter-spacing: -0.02em; margin: 6px 0 2px; }
    .an-kpi-sub { font-size: 10.5px; color: var(--ink-mute, #7a7a85); }

    .an-row { display: grid; grid-template-columns: 1.7fr 1fr; gap: 16px; margin-bottom: 16px; }
    .an-panel { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 16px; padding: 18px 20px; }
    .an-panel-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
    .an-panel-title { font-size: 14px; font-weight: 600; }
    .an-panel-meta { font-size: 11px; color: var(--ink-mute, #7a7a85); }

    .an-bars { display: flex; align-items: flex-end; gap: 4px; height: 150px; }
    .an-bar { flex: 1; background: linear-gradient(180deg, oklch(0.72 0.19 300), oklch(0.55 0.19 300)); border-radius: 3px 3px 0 0; min-height: 2px; opacity: 0.9; transition: opacity .15s; }
    .an-bar:hover { opacity: 1; }
    .an-bars-axis { display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: var(--ink-mute, #7a7a85); }

    .an-donut-wrap { display: flex; align-items: center; gap: 20px; }
    .an-donut { width: 130px; height: 130px; flex-shrink: 0; }
    .an-donut-num { font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 700; fill: var(--ink, #f0f0f3); }
    .an-donut-lbl { font-size: 6px; fill: var(--ink-mute, #7a7a85); text-transform: uppercase; letter-spacing: 0.1em; }
    .an-legend { flex: 1; display: flex; flex-direction: column; gap: 11px; }
    .an-legend-item { display: flex; align-items: center; gap: 9px; font-size: 13px; }
    .an-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
    .an-legend-name { flex: 1; color: var(--ink-dim, #a9a9b3); }
    .an-legend-val { font-weight: 600; }

    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th { text-align: left; font-size: 10px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-mute, #7a7a85); padding: 0 12px 10px; }
    .an-table th.r, .an-table td.r { text-align: right; }
    .an-table td { padding: 12px; font-size: 13px; border-top: 1px solid var(--line-soft, rgba(255,255,255,0.07)); }
    .an-card-name { color: var(--ink, #f0f0f3); text-decoration: none; font-weight: 500; }
    .an-card-name:hover { color: oklch(0.72 0.19 300); }
    .an-inactive { font-size: 10px; color: var(--ink-mute, #7a7a85); background: var(--bg-3, rgba(255,255,255,0.06)); padding: 1px 7px; border-radius: 99px; margin-left: 8px; }

    .an-empty { text-align: center; padding: 40px 20px; color: var(--ink-mute, #7a7a85); font-size: 13px; line-height: 1.7; }
    .an-empty span { font-size: 12px; opacity: 0.8; }

    @media (max-width: 900px) {
        .an-kpis { grid-template-columns: repeat(2, 1fr); }
        .an-row { grid-template-columns: 1fr; }
        .an-donut-wrap { flex-direction: column; }
    }
</style>
@endpush

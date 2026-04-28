@extends('layouts.dashboard')

@section('title', 'Gestão de Seats')

@section('content')

<div class="dashboard-header">
    <div>
        <h1 class="page-title">Gestão de Seats</h1>
        <p class="page-subtitle">Ajusta o número de utilizadores do plano Empresa</p>
    </div>
    <a href="{{ route('company.dashboard') }}" class="btn-back">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
</div>

<div class="seats-wrapper">

    {{-- STEP 1: Adjust --}}
    <div class="seat-step active" id="step-adjust">
        <div class="step-badge" id="label-adjust">Passo 1 de 2</div>
        <h2 class="step-title">Alterar número de utilizadores</h2>
        <p class="step-desc">Ajusta os seats do teu plano. O preço é atualizado imediatamente com proration calculada pelo Stripe.</p>

        <!-- Current state -->
        <div class="info-strip">
            <div class="info-cell">
                <span class="info-val" id="display-current-seats">{{ $currentSeats }}</span>
                <span class="info-label">Seats atuais</span>
            </div>
            <div class="info-divider"></div>
            <div class="info-cell">
                <span class="info-val">€{{ number_format($currentTier['price'], 2) }}</span>
                <span class="info-label">Preço/user</span>
            </div>
            <div class="info-divider"></div>
            <div class="info-cell">
                <span class="info-val">€{{ number_format($currentTier['price'] * $currentSeats, 2) }}</span>
                <span class="info-label">MRR atual</span>
            </div>
            <div class="info-divider"></div>
            <div class="info-cell">
                <span class="info-val">{{ $daysRemaining }}</span>
                <span class="info-label">Dias restantes</span>
            </div>
        </div>

        <!-- Seat slider -->
        <div class="slider-block">
            <div class="slider-row">
                <button class="seat-btn" id="btn-minus" aria-label="Diminuir">−</button>
                <div class="slider-track-wrap">
                    <input type="range" class="seat-slider" id="seat-slider" min="1" max="9999" value="{{ $currentSeats }}">
                </div>
                <button class="seat-btn" id="btn-plus" aria-label="Aumentar">+</button>
            </div>
            <div class="seat-input-row">
                <span class="seat-input-label">Número exato</span>
                <div class="seat-input-wrap">
                    <input type="number" class="seat-input" id="seat-input" min="1" max="10000" value="{{ $currentSeats }}">
                    <span class="seat-input-unit">seats</span>
                </div>
            </div>
        </div>

        <!-- Impact boxes -->
        <div id="impact-upgrade" class="impact-box upgrade" style="display:none">
            <div class="impact-header">
                <span class="impact-dot green"></span>
                <span class="impact-label green">Upgrade de seats</span>
            </div>
            <div class="impact-rows">
                <div class="impact-row"><span>Novo tier</span><span class="impact-val" id="up-tier"></span></div>
                <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="up-mrr"></span></div>
                <div class="impact-row"><span>Cobrado hoje (<span id="up-days">{{ $daysRemaining }}</span> dias restantes)</span><span class="impact-val green" id="up-proration"></span></div>
            </div>
        </div>

        <div id="impact-downgrade" class="impact-box downgrade" style="display:none">
            <div class="impact-header">
                <span class="impact-dot orange"></span>
                <span class="impact-label orange">Redução de seats</span>
            </div>
            <div class="impact-rows">
                <div class="impact-row"><span>Novo tier</span><span class="impact-val" id="dn-tier"></span></div>
                <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="dn-mrr"></span></div>
                <div class="impact-row"><span>Crédito na próxima fatura</span><span class="impact-val orange" id="dn-proration"></span></div>
                <div class="impact-row"><span>Utilizadores a desativar</span><span class="impact-val orange" id="dn-count"></span></div>
            </div>
        </div>

        <div id="impact-neutral" class="impact-box neutral">
            <div class="impact-header">
                <span class="impact-dot mute"></span>
                <span class="impact-label mute">Sem alterações</span>
            </div>
            <div class="impact-rows">
                <div class="impact-row"><span>Ajusta o slider para ver o impacto no plano.</span></div>
            </div>
        </div>

        <div class="step-actions">
            <button class="btn btn-primary" id="btn-adjust-next" disabled>Continuar</button>
            <a href="{{ route('company.dashboard') }}" class="btn btn-ghost">Cancelar</a>
        </div>
    </div>

    {{-- STEP 2: Select users to deactivate --}}
    <div class="seat-step" id="step-select-users">
        <div class="step-badge">Passo 2 de 3</div>
        <h2 class="step-title">Escolhe quem desativar</h2>
        <p class="step-desc" id="select-desc">Seleciona os utilizadores a desativar. Os cartões ficam arquivados — podes reativar a qualquer momento.</p>

        <div class="counter-bar">
            <span>Selecionados</span>
            <span class="counter-val"><span id="selected-count">0</span> / <span id="needed-count">0</span></span>
        </div>

        <div class="user-list" id="user-list"></div>

        <div class="step-actions">
            <button class="btn btn-primary" id="btn-select-next" disabled>
                Confirmar seleção (<span id="btn-selected">0</span>/<span id="btn-needed">0</span>)
            </button>
            <button class="btn btn-ghost" id="btn-select-back">Voltar</button>
        </div>
    </div>

    {{-- STEP 3: Confirm --}}
    <div class="seat-step" id="step-confirm">
        <div class="step-badge" id="label-confirm">Passo 2 de 2</div>
        <h2 class="step-title">Confirmar alteração</h2>
        <p class="step-desc">Revê o resumo antes de confirmar. A alteração é processada imediatamente pelo Stripe.</p>

        <div class="impact-box neutral">
            <div class="impact-rows">
                <div class="impact-row"><span>Seats anteriores</span><span class="impact-val" id="conf-old"></span></div>
                <div class="impact-row"><span>Novos seats</span><span class="impact-val" id="conf-new"></span></div>
                <div class="impact-row"><span>MRR anterior</span><span class="impact-val" id="conf-old-mrr"></span></div>
                <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="conf-new-mrr"></span></div>
                <div class="impact-divider"></div>
                <div class="impact-row">
                    <span id="conf-proration-label">Cobrado hoje</span>
                    <span class="impact-val" id="conf-proration"></span>
                </div>
                <div class="impact-row" id="conf-deactivated-row" style="display:none">
                    <span>Utilizadores arquivados</span>
                    <span class="impact-val orange" id="conf-deactivated"></span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('subscriptions.seats.update') }}" id="seats-form">
            @csrf
            <input type="hidden" name="new_seats" id="form-new-seats">
            <input type="hidden" name="deactivate_users" id="form-deactivate-users">
            <div class="step-actions">
                <button type="submit" class="btn btn-primary">Confirmar e aplicar</button>
                <button type="button" class="btn btn-ghost" id="btn-confirm-back">Voltar</button>
            </div>
        </form>
    </div>

</div>

<!-- Tier table -->
<div class="content-section" style="margin-top: 32px;">
    <div class="section-header">
        <h2 class="section-title">Tabela de Volume Pricing</h2>
    </div>
    <div class="tier-table-wrap">
        <table class="tier-table">
            <thead>
                <tr>
                    <th>Seats</th>
                    <th>€/seat/mês</th>
                    <th>Desconto</th>
                    <th>Exemplo (MRR)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tiers = [
                        ['min'=>1,    'max'=>50,    'price'=>9.50, 'discount'=>'5%'],
                        ['min'=>51,   'max'=>100,   'price'=>9.00, 'discount'=>'10%'],
                        ['min'=>101,  'max'=>250,   'price'=>8.00, 'discount'=>'20%'],
                        ['min'=>251,  'max'=>500,   'price'=>7.00, 'discount'=>'30%'],
                        ['min'=>501,  'max'=>750,   'price'=>6.50, 'discount'=>'35%'],
                        ['min'=>751,  'max'=>1000,  'price'=>6.00, 'discount'=>'40%'],
                        ['min'=>1001, 'max'=>2500,  'price'=>5.50, 'discount'=>'45%'],
                        ['min'=>2501, 'max'=>5000,  'price'=>5.00, 'discount'=>'50%'],
                        ['min'=>5001, 'max'=>7500,  'price'=>4.50, 'discount'=>'55%'],
                        ['min'=>7501, 'max'=>10000, 'price'=>4.00, 'discount'=>'60%'],
                    ];
                @endphp
                @foreach($tiers as $tier)
                    <tr class="{{ $currentSeats >= $tier['min'] && $currentSeats <= $tier['max'] ? 'active-tier' : '' }}">
                        <td>{{ number_format($tier['min']) }}–{{ number_format($tier['max']) }}</td>
                        <td><strong>€{{ number_format($tier['price'], 2) }}</strong></td>
                        <td><span class="discount-badge">{{ $tier['discount'] }}</span></td>
                        <td class="muted">€{{ number_format($tier['price'] * $tier['min'], 2) }} – €{{ number_format($tier['price'] * $tier['max'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>10.000+</td>
                    <td><strong>Custom</strong></td>
                    <td><span class="discount-badge enterprise">Negociado</span></td>
                    <td class="muted"><a href="{{ route('subscriptions.enterprise') }}" style="color:var(--purple)">Contactar →</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--ink-mute);
        text-decoration: none;
        padding: 8px 14px;
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-lg);
        transition: var(--transition);
        background: oklch(0.18 0.014 290 / 0.5);
    }
    .btn-back:hover { color: var(--ink); border-color: oklch(0.72 0.19 300 / 0.30); }

    .btn-ghost {
        padding: 12px 20px;
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-lg);
        background: transparent;
        color: var(--ink-mute);
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: var(--transition);
    }
    .btn-ghost:hover { color: var(--ink); border-color: oklch(0.28 0.018 290 / 0.60); }

    /* Wrapper */
    .seats-wrapper {
        max-width: 620px;
    }

    /* Steps */
    .seat-step { display: none; }
    .seat-step.active { display: block; }

    .step-badge {
        display: inline-block;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--purple);
        background: var(--purple-soft);
        border: 1px solid oklch(0.72 0.19 300 / 0.22);
        padding: 3px 12px;
        border-radius: 999px;
        margin-bottom: 14px;
        font-family: 'Geist Mono', monospace;
    }
    .step-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .step-desc {
        font-size: 13.5px;
        color: var(--ink-mute);
        line-height: 1.6;
        margin-bottom: 24px;
    }

    /* Info strip */
    .info-strip {
        display: flex;
        align-items: center;
        background: oklch(0.18 0.014 290 / 0.65);
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-xl);
        padding: 18px 24px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        gap: 0;
    }
    .info-cell {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }
    .info-divider {
        width: 1px;
        height: 36px;
        background: var(--line-soft);
        flex-shrink: 0;
    }
    .info-val {
        font-size: 20px;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
    }
    .info-label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--ink-mute);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-family: 'Geist Mono', monospace;
    }

    /* Slider block */
    .slider-block {
        background: oklch(0.18 0.014 290 / 0.65);
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-xl);
        padding: 22px 24px;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
    }
    .slider-row {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
    }
    .seat-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        border: 1px solid var(--line-soft);
        background: oklch(0.22 0.016 290 / 0.6);
        color: var(--ink);
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        flex-shrink: 0;
        line-height: 1;
        font-family: inherit;
    }
    .seat-btn:hover { background: oklch(0.28 0.018 290 / 0.6); border-color: oklch(0.72 0.19 300 / 0.30); }
    .seat-btn:disabled { opacity: 0.3; cursor: not-allowed; }

    .slider-track-wrap { flex: 1; }
    .seat-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 4px;
        border-radius: 2px;
        background: linear-gradient(
            to right,
            oklch(0.72 0.19 300) 0%,
            oklch(0.72 0.19 300) var(--val, 0%),
            oklch(0.28 0.018 290 / 0.40) var(--val, 0%),
            oklch(0.28 0.018 290 / 0.40) 100%
        );
        outline: none;
        cursor: pointer;
    }
    .seat-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--purple);
        cursor: pointer;
        box-shadow: 0 0 0 4px oklch(0.72 0.19 300 / 0.20);
    }
    .seat-slider::-moz-range-thumb {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--purple);
        border: none;
        cursor: pointer;
    }

    .seat-input-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .seat-input-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-mute);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-family: 'Geist Mono', monospace;
    }
    .seat-input-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        background: oklch(0.22 0.016 290 / 0.5);
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-lg);
        padding: 8px 14px;
        transition: var(--transition);
    }
    .seat-input-wrap:focus-within {
        border-color: oklch(0.72 0.19 300 / 0.40);
        background: oklch(0.20 0.018 300 / 0.30);
    }
    .seat-input {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
        background: transparent;
        border: none;
        outline: none;
        width: 70px;
        text-align: right;
        -moz-appearance: textfield;
        font-family: inherit;
    }
    .seat-input::-webkit-outer-spin-button,
    .seat-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .seat-input-unit { font-size: 13px; color: var(--ink-mute); }

    /* Impact boxes */
    .impact-box {
        border-radius: var(--radius-xl);
        padding: 18px 20px;
        margin-bottom: 20px;
        backdrop-filter: blur(8px);
    }
    .impact-box.upgrade { background: oklch(0.72 0.16 155 / 0.06); border: 1px solid oklch(0.72 0.16 155 / 0.22); }
    .impact-box.downgrade { background: oklch(0.72 0.16 35 / 0.06); border: 1px solid oklch(0.72 0.16 35 / 0.22); }
    .impact-box.neutral { background: oklch(0.18 0.014 290 / 0.65); border: 1px solid var(--line-soft); }

    .impact-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
    }
    .impact-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .impact-dot.green  { background: oklch(0.72 0.16 155); box-shadow: 0 0 6px oklch(0.72 0.16 155 / 0.6); }
    .impact-dot.orange { background: oklch(0.72 0.16 35);  box-shadow: 0 0 6px oklch(0.72 0.16 35 / 0.6);  }
    .impact-dot.mute   { background: var(--ink-mute); }

    .impact-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        font-family: 'Geist Mono', monospace;
    }
    .impact-label.green  { color: oklch(0.72 0.16 155); }
    .impact-label.orange { color: oklch(0.72 0.16 35); }
    .impact-label.mute   { color: var(--ink-mute); }

    .impact-rows { display: flex; flex-direction: column; gap: 0; }
    .impact-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--ink-mute);
        padding: 7px 0;
        border-bottom: 1px solid oklch(0.28 0.018 290 / 0.12);
    }
    .impact-row:last-child { border-bottom: none; padding-bottom: 0; }
    .impact-divider { border: none; border-top: 1px solid var(--line-soft); margin: 6px 0; }
    .impact-val { font-weight: 600; color: var(--ink); }
    .impact-val.green  { color: oklch(0.72 0.16 155); }
    .impact-val.orange { color: oklch(0.72 0.16 35); }

    /* Actions */
    .step-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 8px;
    }

    /* Counter bar */
    .counter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 16px;
        background: oklch(0.72 0.16 35 / 0.06);
        border: 1px solid oklch(0.72 0.16 35 / 0.20);
        border-radius: var(--radius-lg);
        margin-bottom: 16px;
        font-size: 13px;
        color: var(--ink-mute);
    }
    .counter-val { font-weight: 700; color: oklch(0.72 0.16 35); }

    /* User list */
    .user-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }

    .user-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        border-radius: var(--radius-xl);
        border: 1px solid var(--line-soft);
        cursor: pointer;
        transition: var(--transition);
        background: oklch(0.18 0.014 290 / 0.50);
        backdrop-filter: blur(8px);
    }
    .user-item:hover { background: oklch(0.20 0.016 290 / 0.70); border-color: oklch(0.28 0.018 290 / 0.60); }
    .user-item.selected { background: oklch(0.72 0.16 35 / 0.07); border-color: oklch(0.72 0.16 35 / 0.28); }

    .user-checkbox {
        width: 20px; height: 20px;
        border-radius: 6px;
        border: 1px solid var(--line);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 11px;
        transition: var(--transition);
    }
    .user-checkbox.checked { background: oklch(0.72 0.16 35); border-color: oklch(0.72 0.16 35); color: oklch(0.12 0.01 290); font-weight: 700; }

    .user-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--purple-soft);
        border: 1px solid oklch(0.72 0.19 300 / 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: var(--purple);
        flex-shrink: 0;
    }
    .user-item.selected .user-avatar { background: oklch(0.72 0.16 35 / 0.18); border-color: oklch(0.72 0.16 35 / 0.28); color: oklch(0.72 0.16 35); }

    .user-info { flex: 1; min-width: 0; }
    .user-name { font-size: 13.5px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
    .user-meta { font-size: 12px; color: var(--ink-mute); }

    .login-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 999px;
    }
    .login-never  { background: oklch(0.72 0.16 35 / 0.12); color: oklch(0.72 0.16 35);  border: 1px solid oklch(0.72 0.16 35 / 0.22); }
    .login-old    { background: oklch(0.28 0.018 290 / 0.5); color: var(--ink-mute); border: 1px solid var(--line-soft); }
    .login-recent { background: oklch(0.72 0.16 155 / 0.10); color: oklch(0.72 0.16 155); border: 1px solid oklch(0.72 0.16 155 / 0.20); }

    /* Tier table */
    .tier-table-wrap {
        border-radius: var(--radius-xl);
        border: 1px solid var(--line-soft);
        overflow: hidden;
    }
    .tier-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    .tier-table thead th {
        padding: 12px 20px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--ink-mute);
        background: var(--bg-2);
        border-bottom: 1px solid var(--line-soft);
        font-family: 'Geist Mono', monospace;
    }
    .tier-table tbody td {
        padding: 12px 20px;
        border-bottom: 1px solid oklch(0.28 0.018 290 / 0.10);
        color: var(--ink-dim);
    }
    .tier-table tbody tr:last-child td { border-bottom: none; }
    .tier-table tbody tr:hover td { background: oklch(0.22 0.016 290 / 0.40); }
    .tier-table tbody tr.active-tier td {
        background: oklch(0.20 0.018 300 / 0.30);
        color: var(--ink);
    }
    .tier-table tbody tr.active-tier td:first-child::before {
        content: '→ ';
        color: var(--purple);
        font-weight: 700;
    }
    .tier-table strong { color: var(--ink); font-weight: 700; }
    .muted { color: var(--ink-mute); font-size: 12.5px; }

    .discount-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 999px;
        background: var(--purple-soft);
        color: var(--purple);
        border: 1px solid oklch(0.72 0.19 300 / 0.22);
        font-family: 'Geist Mono', monospace;
    }
    .discount-badge.enterprise {
        background: oklch(0.72 0.16 155 / 0.12);
        color: oklch(0.72 0.16 155);
        border-color: oklch(0.72 0.16 155 / 0.22);
    }
</style>

<script>
    const TIERS = [
        { min: 1,     max: 50,    price: 9.50 },
        { min: 51,    max: 100,   price: 9.00 },
        { min: 101,   max: 250,   price: 8.00 },
        { min: 251,   max: 500,   price: 7.00 },
        { min: 501,   max: 750,   price: 6.50 },
        { min: 751,   max: 1000,  price: 6.00 },
        { min: 1001,  max: 2500,  price: 5.50 },
        { min: 2501,  max: 5000,  price: 5.00 },
        { min: 5001,  max: 7500,  price: 4.50 },
        { min: 7501,  max: 10000, price: 4.00 },
    ];

    const CURRENT_SEATS  = {{ $currentSeats }};
    const DAYS_REMAINING = {{ $daysRemaining }};
    const DAYS_IN_MONTH  = 30;
    const USERS          = @json($members);

    let newSeats = CURRENT_SEATS;
    let selectedToDeactivate = [];

    function getTier(n) {
        return TIERS.find(t => n >= t.min && n <= t.max) || TIERS[TIERS.length - 1];
    }

    function fmt(n) { return '€' + n.toFixed(2); }

    function tierLabel(t) {
        return `${t.min.toLocaleString('pt')}–${t.max.toLocaleString('pt')} seats · €${t.price.toFixed(2)}/seat`;
    }

    function updateSlider(val) {
        const pct = ((Math.min(val, 9999) / 9999) * 100).toFixed(2) + '%';
        document.getElementById('seat-slider').style.setProperty('--val', pct);
    }

    function syncSeats(val) {
        val = Math.max(1, parseInt(val) || 1);
        newSeats = val;
        document.getElementById('seat-slider').value = Math.min(val, 9999);
        document.getElementById('seat-input').value  = val;
        updateSlider(val);
        renderImpact();
    }

    function renderImpact() {
        const newTier    = getTier(newSeats);
        const currTier   = getTier(CURRENT_SEATS);
        const currentMRR = currTier.price * CURRENT_SEATS;
        const newMRR     = newTier.price * newSeats;
        const proration  = ((newMRR - currentMRR) * DAYS_REMAINING) / DAYS_IN_MONTH;
        const toDeact    = Math.max(0, CURRENT_SEATS - newSeats);
        const isUpgrade  = newSeats > CURRENT_SEATS;
        const isDowngrade= newSeats < CURRENT_SEATS;

        document.getElementById('impact-upgrade').style.display   = isUpgrade   ? 'block' : 'none';
        document.getElementById('impact-downgrade').style.display = isDowngrade ? 'block' : 'none';
        document.getElementById('impact-neutral').style.display   = (!isUpgrade && !isDowngrade) ? 'block' : 'none';

        if (isUpgrade) {
            document.getElementById('up-tier').textContent      = tierLabel(newTier);
            document.getElementById('up-mrr').textContent       = fmt(newMRR) + '/mês';
            document.getElementById('up-proration').textContent = '+' + fmt(proration);
        }
        if (isDowngrade) {
            document.getElementById('dn-tier').textContent      = tierLabel(newTier);
            document.getElementById('dn-mrr').textContent       = fmt(newMRR) + '/mês';
            document.getElementById('dn-proration').textContent = '-' + fmt(Math.abs(proration));
            document.getElementById('dn-count').textContent     = toDeact + ' users';
        }

        document.getElementById('label-adjust').textContent = 'Passo 1 de ' + (isDowngrade ? '3' : '2');

        const btn = document.getElementById('btn-adjust-next');
        btn.disabled = !isUpgrade && !isDowngrade;
        btn.textContent = isUpgrade
            ? 'Confirmar upgrade →'
            : isDowngrade
            ? 'Escolher quem desativar →'
            : 'Continuar';
    }

    function goTo(id) {
        document.querySelectorAll('.seat-step').forEach(s => s.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function buildUserList() {
        const toDeact = Math.max(0, CURRENT_SEATS - newSeats);
        const sorted  = [...USERS].sort((a, b) => b.days_ago - a.days_ago);
        selectedToDeactivate = sorted.slice(0, toDeact).map(u => u.id);

        document.getElementById('needed-count').textContent = toDeact;
        document.getElementById('btn-needed').textContent   = toDeact;
        document.getElementById('select-desc').textContent  =
            `Seleciona ${toDeact} utilizador${toDeact !== 1 ? 'es' : ''} a desativar. Os cartões ficam arquivados e podes reativar a qualquer momento.`;

        const list = document.getElementById('user-list');
        list.innerHTML = '';

        sorted.forEach((user, i) => {
            const isSuggested = i < toDeact;
            const isSelected  = selectedToDeactivate.includes(user.id);
            const loginClass  = user.days_ago >= 999 ? 'login-never' : user.days_ago > 14 ? 'login-old' : 'login-recent';

            const item = document.createElement('div');
            item.className = 'user-item' + (isSelected ? ' selected' : '');
            item.dataset.id = user.id;
            item.innerHTML = `
                <div class="user-checkbox ${isSelected ? 'checked' : ''}">${isSelected ? '✓' : ''}</div>
                <div class="user-avatar">${user.initials}</div>
                <div class="user-info">
                    <div class="user-name">${user.name}</div>
                    <div class="user-meta">${user.role ?? '—'}</div>
                </div>
                <span class="login-badge ${loginClass}">${user.last_login_label}</span>
            `;
            item.addEventListener('click', () => toggleUser(user.id, toDeact, sorted));
            list.appendChild(item);
        });

        updateCounter();
    }

    function toggleUser(id, toDeact, sorted) {
        if (selectedToDeactivate.includes(id)) {
            selectedToDeactivate = selectedToDeactivate.filter(u => u !== id);
        } else if (selectedToDeactivate.length < toDeact) {
            selectedToDeactivate.push(id);
        }
        sorted.forEach(user => {
            const item = document.querySelector(`.user-item[data-id="${user.id}"]`);
            if (!item) return;
            const sel = selectedToDeactivate.includes(user.id);
            item.className = 'user-item' + (sel ? ' selected' : '');
            item.querySelector('.user-checkbox').className   = 'user-checkbox' + (sel ? ' checked' : '');
            item.querySelector('.user-checkbox').textContent = sel ? '✓' : '';
        });
        updateCounter();
    }

    function updateCounter() {
        const toDeact = Math.max(0, CURRENT_SEATS - newSeats);
        document.getElementById('selected-count').textContent = selectedToDeactivate.length;
        document.getElementById('btn-selected').textContent   = selectedToDeactivate.length;
        document.getElementById('btn-select-next').disabled   = selectedToDeactivate.length !== toDeact;
    }

    function buildConfirm() {
        const currTier   = getTier(CURRENT_SEATS);
        const newTier    = getTier(newSeats);
        const currentMRR = currTier.price * CURRENT_SEATS;
        const newMRR     = newTier.price * newSeats;
        const proration  = ((newMRR - currentMRR) * DAYS_REMAINING) / DAYS_IN_MONTH;
        const isUpgrade  = newSeats > CURRENT_SEATS;
        const isDowngrade= newSeats < CURRENT_SEATS;

        document.getElementById('label-confirm').textContent  = 'Passo ' + (isDowngrade ? '3 de 3' : '2 de 2');
        document.getElementById('conf-old').textContent       = `${CURRENT_SEATS} seats · €${currTier.price.toFixed(2)}/seat`;
        document.getElementById('conf-new').textContent       = `${newSeats} seats · €${newTier.price.toFixed(2)}/seat`;
        document.getElementById('conf-old-mrr').textContent   = fmt(currentMRR) + '/mês';
        document.getElementById('conf-new-mrr').textContent   = fmt(newMRR) + '/mês';
        document.getElementById('conf-new-mrr').className     = 'impact-val ' + (isUpgrade ? 'green' : 'orange');
        document.getElementById('conf-proration-label').textContent = isUpgrade ? 'Cobrado hoje' : 'Crédito na próxima fatura';
        document.getElementById('conf-proration').textContent = (isUpgrade ? '+' : '-') + fmt(Math.abs(proration));
        document.getElementById('conf-proration').className   = 'impact-val ' + (isUpgrade ? 'green' : 'orange');

        const deactRow = document.getElementById('conf-deactivated-row');
        if (isDowngrade) {
            deactRow.style.display = 'flex';
            document.getElementById('conf-deactivated').textContent = selectedToDeactivate.length + ' arquivados';
        } else {
            deactRow.style.display = 'none';
        }

        document.getElementById('form-new-seats').value        = newSeats;
        document.getElementById('form-deactivate-users').value = JSON.stringify(selectedToDeactivate);
    }

    // Event listeners
    document.getElementById('seat-slider').addEventListener('input', e => syncSeats(e.target.value));
    document.getElementById('seat-input').addEventListener('input',  e => syncSeats(e.target.value));
    document.getElementById('btn-minus').addEventListener('click', () => syncSeats(newSeats - 1));
    document.getElementById('btn-plus').addEventListener('click',  () => syncSeats(newSeats + 1));

    document.getElementById('btn-adjust-next').addEventListener('click', () => {
        if (newSeats < CURRENT_SEATS) {
            buildUserList();
            goTo('step-select-users');
        } else {
            buildConfirm();
            goTo('step-confirm');
        }
    });

    document.getElementById('btn-select-next').addEventListener('click', () => {
        buildConfirm();
        goTo('step-confirm');
    });

    document.getElementById('btn-select-back').addEventListener('click', () => goTo('step-adjust'));
    document.getElementById('btn-confirm-back').addEventListener('click', () => {
        goTo(newSeats < CURRENT_SEATS ? 'step-select-users' : 'step-adjust');
    });

    // Init
    updateSlider(CURRENT_SEATS);
    renderImpact();
</script>

@endsection

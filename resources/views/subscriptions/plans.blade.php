<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planos — Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#9b6dff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:           oklch(0.15 0.012 290);
            --bg-2:         oklch(0.19 0.015 290);
            --bg-3:         oklch(0.23 0.018 290);
            --ink:          oklch(0.97 0.010 290);
            --ink-dim:      oklch(0.72 0.015 290);
            --ink-mute:     oklch(0.52 0.012 290);
            --line:         oklch(0.28 0.018 290 / 0.70);
            --line-soft:    oklch(0.28 0.018 290 / 0.35);
            --purple:       oklch(0.72 0.19  300);
            --purple-deep:  oklch(0.52 0.19  300);
            --purple-soft:  oklch(0.72 0.19  300 / 0.12);
            --lavender:     oklch(0.82 0.14  330);
            --amber:        oklch(0.82 0.12   85);
            --green:        oklch(0.78 0.17  160);
            --red:          oklch(0.65 0.22   25);
            --green-soft:   oklch(0.78 0.17  160 / 0.14);
            --red-soft:     oklch(0.65 0.22   25 / 0.14);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 22px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body { background: var(--bg); color: var(--ink); }

        body {
            font-family: 'Geist', ui-sans-serif, system-ui, sans-serif;
            font-feature-settings: "ss01", "cv11";
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 55% 45% at 90% 15%, oklch(0.72 0.19 300 / 0.07), transparent 60%),
                radial-gradient(ellipse 40% 40% at  5% 85%, oklch(0.82 0.14 330 / 0.04), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed; inset: 0;
            background-image:
                linear-gradient(to right,  var(--line-soft) 1px, transparent 1px),
                linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 72px 72px;
            background-position: -1px -1px;
            mask-image: radial-gradient(ellipse 60% 100% at 20% center, rgba(0,0,0,0.35), transparent 70%);
            pointer-events: none;
            z-index: 0;
            opacity: 0.35;
        }

        /* ── Topbar ─────────────────────────────────────────── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            height: 60px;
            background: oklch(0.15 0.012 290 / 0.85);
            border-bottom: 1px solid var(--line-soft);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: -0.01em;
            text-decoration: none;
            color: var(--ink);
        }

        .logo .mark {
            width: 26px; height: 26px;
            border-radius: 7px;
            flex-shrink: 0;
            box-shadow: 0 0 14px oklch(0.72 0.19 300 / 0.35);
        }

        .topbar-actions { display: flex; gap: 8px; align-items: center; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            line-height: 1;
        }

        .btn-secondary {
            background: oklch(0.22 0.016 290 / 0.65);
            color: var(--ink);
            border-color: var(--line-soft);
        }
        .btn-secondary:hover {
            background: oklch(0.26 0.018 290 / 0.75);
            border-color: var(--line);
        }

        .btn-primary {
            background: var(--purple);
            color: oklch(0.12 0.01 290);
        }
        .btn-primary:hover {
            background: oklch(0.78 0.19 300);
            transform: translateY(-1px);
        }

        /* ── Page wrapper ───────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 48px 24px 64px;
        }

        /* ── Page header ────────────────────────────────────── */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 15px;
            color: var(--ink-dim);
        }

        .alert-success {
            background: oklch(0.72 0.16 155 / 0.12);
            border: 1px solid oklch(0.72 0.16 155 / 0.35);
            color: oklch(0.72 0.16 155);
            padding: 12px 16px;
            border-radius: var(--radius-lg);
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
        }
        .alert-error {
            background: oklch(0.65 0.22 25 / 0.12);
            border: 1px solid oklch(0.65 0.22 25 / 0.35);
            color: oklch(0.65 0.22 25);
            padding: 12px 16px;
            border-radius: var(--radius-lg);
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
        }

        /* Billing toggle */
        .billing-toggle-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
        }
        .billing-toggle {
            display: flex;
            gap: 4px;
            background: var(--bg-2);
            padding: 4px;
            border-radius: 999px;
            border: 1px solid var(--line-soft);
        }
        .toggle-btn {
            padding: 8px 22px;
            border: none;
            background: transparent;
            color: var(--ink-mute);
            font-size: 13.5px;
            font-weight: 600;
            border-radius: 999px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
        }
        .toggle-btn:hover { color: var(--ink-dim); }
        .toggle-btn.active { background: var(--purple); color: oklch(0.12 0.01 290); }
        .save-badge {
            background: oklch(0.72 0.16 155 / 0.18);
            color: oklch(0.72 0.16 155);
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }
        .toggle-btn.active .save-badge {
            background: oklch(0.12 0.01 290 / 0.25);
            color: oklch(0.12 0.01 290);
        }

        /* Pricing grid */
        .pricing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 8px;
        }
        @media (max-width: 700px) { .pricing-grid { grid-template-columns: 1fr; } }

        .p-card {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 0;
            position: relative;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }
        .p-card:hover {
            border-color: oklch(0.72 0.19 300 / 0.25);
            transform: translateY(-2px);
        }
        .p-card.featured {
            border-color: oklch(0.72 0.19 300 / 0.40);
            background: oklch(0.20 0.018 300 / 0.70);
        }
        .p-card-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--purple);
            color: oklch(0.12 0.01 290);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 16px;
            border-radius: 999px;
            white-space: nowrap;
            letter-spacing: 0.04em;
        }

        .card-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink-mute);
            margin-bottom: 16px;
            font-family: 'Geist Mono', monospace;
        }
        .p-card.featured .card-label { color: var(--purple); }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: 2px;
            margin-bottom: 6px;
        }
        .price-currency {
            font-size: 22px;
            font-weight: 600;
            color: var(--ink-dim);
            margin-bottom: 4px;
        }
        .price-amount {
            font-size: 56px;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
            color: var(--ink);
        }
        .price-period {
            font-size: 13px;
            color: var(--ink-mute);
            margin-left: 4px;
        }
        .yearly-note {
            font-size: 12.5px;
            color: oklch(0.72 0.16 155);
            margin-bottom: 4px;
            font-weight: 500;
        }
        .card-desc {
            font-size: 13.5px;
            color: var(--ink-dim);
            margin: 14px 0 22px;
            padding-bottom: 22px;
            border-bottom: 1px solid var(--line-soft);
            line-height: 1.6;
        }

        .feat-list {
            list-style: none;
            margin-bottom: 28px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .feat-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: var(--ink-dim);
            padding: 7px 0;
            border-bottom: 1px solid oklch(0.28 0.018 290 / 0.15);
        }
        .feat-list li:last-child { border-bottom: none; }
        .feat-list li strong { color: var(--ink); font-weight: 600; }
        .check-icon {
            color: var(--purple);
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            width: 18px;
        }

        .plan-cta {
            width: 100%;
            padding: 13px;
            font-size: 14px;
            font-weight: 700;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-family: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: auto;
        }
        .plan-cta-primary {
            background: var(--purple);
            color: oklch(0.12 0.01 290);
        }
        .plan-cta-primary:hover {
            background: oklch(0.78 0.19 300);
            transform: translateY(-1px);
        }
        .plan-cta-secondary {
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--line);
        }
        .plan-cta-secondary:hover {
            background: var(--bg-2);
            border-color: oklch(0.72 0.19 300 / 0.30);
        }
        .pricing-example-note {
            margin-top: 12px;
            text-align: center;
            font-size: 12px;
            color: var(--ink-mute);
            background: var(--purple-soft);
            padding: 8px 14px;
            border-radius: var(--radius-lg);
        }
        .pricing-example-note strong { color: var(--ink-dim); }

        /* Comparison table */
        .content-section { margin-top: 32px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .section-title { font-size: 16px; font-weight: 600; color: var(--ink); letter-spacing: -0.015em; }

        .comp-table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-xl);
            border: 1px solid var(--line-soft);
        }
        .comp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        .comp-table thead th {
            padding: 14px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--ink-mute);
            background: var(--bg-2);
            border-bottom: 1px solid var(--line-soft);
            font-family: 'Geist Mono', monospace;
        }
        .comp-table thead th.col-featured {
            background: oklch(0.20 0.018 300 / 0.50);
            color: var(--purple);
        }
        .comp-table tbody td {
            padding: 12px 20px;
            border-bottom: 1px solid oklch(0.28 0.018 290 / 0.12);
            color: var(--ink-dim);
        }
        .comp-table tbody td.col-featured {
            background: oklch(0.20 0.018 300 / 0.18);
            text-align: center;
        }
        .comp-table tbody td:not(:first-child):not(.col-featured) { text-align: center; }
        .comp-table tbody tr:hover td { background: oklch(0.22 0.016 290 / 0.40); }
        .comp-table tbody tr:hover td.col-featured { background: oklch(0.22 0.018 300 / 0.30); }
        .group-header td {
            background: var(--bg-3) !important;
            font-size: 10.5px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--ink-mute) !important;
            padding: 8px 20px !important;
            font-family: 'Geist Mono', monospace;
        }
        .yes { color: var(--purple); font-weight: 700; }
        .no { color: var(--ink-mute); opacity: 0.45; }
        .partial { font-size: 12px; color: var(--ink-dim); }

        /* FAQ */
        .faq-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 20px;
        }
        @media (max-width: 700px) { .faq-grid { grid-template-columns: 1fr; } }

        .faq-item {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 22px 24px;
            cursor: pointer;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }
        .faq-item:hover { border-color: oklch(0.72 0.19 300 / 0.25); }
        .faq-item.open { border-color: oklch(0.72 0.19 300 / 0.40); }

        .faq-q {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }
        .faq-icon {
            font-size: 20px;
            color: var(--ink-mute);
            line-height: 1;
            transition: var(--transition);
            flex-shrink: 0;
        }
        .faq-item.open .faq-icon {
            transform: rotate(45deg);
            color: var(--purple);
        }
        .faq-a {
            font-size: 13.5px;
            color: var(--ink-dim);
            line-height: 1.65;
            margin-top: 14px;
            display: none;
        }
        .faq-item.open .faq-a { display: block; }

        @media (max-width: 600px) {
            .topbar { padding: 0 20px; }
            .page-wrap { padding: 32px 16px 48px; }
            .page-title { font-size: 26px; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<header class="topbar">
    <a href="{{ route('home') }}" class="logo">
        <img src="/icon.svg" alt="Cardifys" class="mark">
        Cardifys
    </a>
    <div class="topbar-actions">
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-secondary">Entrar</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Criar conta</a>
        @endauth
    </div>
</header>

<div class="page-wrap">

    <div class="page-header">
        <h1 class="page-title">Planos simples, sem surpresas</h1>
        <p class="page-subtitle">Escolhe o plano certo para o teu perfil. Cancela a qualquer momento.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <!-- Billing toggle -->
    <div class="billing-toggle-wrap">
        <div class="billing-toggle">
            <button class="toggle-btn active" data-period="monthly">Mensal</button>
            <button class="toggle-btn" data-period="yearly">
                Anual
                <span class="save-badge">Poupa 20%</span>
            </button>
        </div>
    </div>

    <!-- Pricing cards -->
    <div class="pricing-grid">

        <!-- Individual -->
        <div class="p-card featured">
            <div class="p-card-badge">Mais Popular</div>
            <div class="card-label">Individual</div>
            <div class="price-row" id="ind-price-row">
                <span class="price-currency">€</span>
                <span class="price-amount" id="ind-amount">10</span>
                <span class="price-period">/mês</span>
            </div>
            <p class="yearly-note" id="ind-yearly-note" style="display:none;">Faturado anualmente · <strong>€84/ano</strong> — poupa €36</p>
            <p class="card-desc">O teu cartão digital profissional. Tudo o que precisas para um networking moderno e eficaz.</p>
            <ul class="feat-list">
                <li><span class="check-icon">✓</span><span>Cartão digital profissional</span></li>
                <li><span class="check-icon">✓</span><span>QR Code personalizado</span></li>
                <li><span class="check-icon">✓</span><span>Partilha via NFC</span></li>
                <li><span class="check-icon">✓</span><span>Analytics completos em tempo real</span></li>
                <li><span class="check-icon">✓</span><span>Links ilimitados</span></li>
                <li><span class="check-icon">✓</span><span>Design <strong>100% personalizável</strong></span></li>
                <li><span class="check-icon">✓</span><span>Exportação vCard</span></li>
                <li><span class="check-icon">✓</span><span>Cancela a qualquer momento</span></li>
            </ul>
            @auth
                @if(Auth::user()->subscribed('default'))
                    <a href="{{ route('dashboard') }}" class="plan-cta plan-cta-primary">
                        Plano Ativo
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                @else
                    <form method="POST" action="{{ route('subscriptions.checkout') }}" style="width:100%;">
                        @csrf
                        <input type="hidden" name="price" id="ind-price-input" value="price_1TFgXeCcmLy5PiLsbrLtDCfP">
                        <button type="submit" class="plan-cta plan-cta-primary">
                            Começar Agora
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('register') }}" class="plan-cta plan-cta-primary">
                    Criar conta para começar
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            @endauth
        </div>

        <!-- Empresas -->
        <div class="p-card">
            <div class="card-label">Empresas</div>
            <div class="price-row">
                <span class="price-currency">€</span>
                <span class="price-amount">50</span>
                <span class="price-period"> setup + €1/colaborador/mês</span>
            </div>
            <p class="yearly-note">Setup único · escala com a tua equipa</p>
            <p class="card-desc">Gestão centralizada para equipas. Branding corporativo consistente em toda a empresa.</p>
            <ul class="feat-list">
                <li><span class="check-icon">✓</span><span>Tudo do plano Individual</span></li>
                <li><span class="check-icon">✓</span><span>Colaboradores <strong>ilimitados</strong></span></li>
                <li><span class="check-icon">✓</span><span>Painel de administração central</span></li>
                <li><span class="check-icon">✓</span><span>Branding e cores corporativas</span></li>
                <li><span class="check-icon">✓</span><span>Dashboard de analytics por equipa</span></li>
                <li><span class="check-icon">✓</span><span>Suporte prioritário</span></li>
                <li><span class="check-icon">✓</span><span>Acesso à API</span></li>
                <li><span class="check-icon">✓</span><span>Relatórios exportáveis (CSV, PDF)</span></li>
            </ul>
            <a href="mailto:hello@cardifys.com" class="plan-cta plan-cta-secondary">Falar Connosco</a>
            <p class="pricing-example-note">Ex: equipa de 20 pessoas = €50 + €20 = <strong>€70/mês</strong></p>
        </div>

    </div>

    <!-- Comparison table -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">Comparação de Planos</h2>
        </div>

        <div class="comp-table-wrap">
            <table class="comp-table">
                <thead>
                    <tr>
                        <th style="width:45%; text-align:left;">Funcionalidade</th>
                        <th style="width:27.5%">Individual</th>
                        <th style="width:27.5%" class="col-featured">Empresas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="group-header"><td colspan="3">Cartão Digital</td></tr>
                    <tr><td>Cartão de visita digital</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>QR Code personalizado</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Partilha via NFC</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Exportação vCard</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Links ilimitados</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr class="group-header"><td colspan="3">Personalização</td></tr>
                    <tr><td>Temas e cores personalizáveis</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Branding corporativo unificado</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Logo da empresa em todos os cartões</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr class="group-header"><td colspan="3">Analytics</td></tr>
                    <tr><td>Visualizações do cartão</td><td><span class="yes">✓</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Dashboard por equipa</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Exportação de relatórios</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr class="group-header"><td colspan="3">Equipa & Gestão</td></tr>
                    <tr><td>Utilizadores</td><td><span class="partial">1 utilizador</span></td><td class="col-featured"><span class="partial">Ilimitados</span></td></tr>
                    <tr><td>Painel de administração</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Acesso à API</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                    <tr><td>Suporte prioritário</td><td><span class="no">—</span></td><td class="col-featured"><span class="yes">✓</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FAQ -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">Perguntas Frequentes</h2>
        </div>
        <div class="faq-grid">
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Posso cancelar a qualquer momento?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-a">Sim, sempre. Não há contratos de permanência, nem penalizações. O teu cartão continua ativo até ao fim do período já pago.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>O que acontece aos meus dados se cancelar?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-a">Os teus dados permanecem na plataforma por 30 dias após o cancelamento. Após esse período, todos os dados são removidos permanentemente.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Posso mudar de plano Individual para Empresas?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-a">Sim, a qualquer momento. O valor já pago no plano Individual é descontado proporcionalmente na primeira fatura do plano Empresas.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Emitem fatura com IVA português?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-a">Sim. Todos os pagamentos incluem fatura legal com IVA português a 23%, enviada automaticamente após cada pagamento.</div>
            </div>
        </div>
    </div>

</div>

<script>
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    const monthlyPrice = 'price_1TFgXeCcmLy5PiLsbrLtDCfP';
    const yearlyPrice  = 'price_1TFgXKCcmLy5PiLs5xZdP87O';

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            toggleBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const yearly = btn.dataset.period === 'yearly';
            document.getElementById('ind-amount').textContent = yearly ? '7' : '10';
            const note = document.getElementById('ind-yearly-note');
            if (note) note.style.display = yearly ? 'block' : 'none';
            const priceInput = document.getElementById('ind-price-input');
            if (priceInput) priceInput.value = yearly ? yearlyPrice : monthlyPrice;
        });
    });

    function toggleFaq(el) {
        const wasOpen = el.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!wasOpen) el.classList.add('open');
    }
</script>
</body>
</html>

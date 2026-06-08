<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sessão expirada · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:        oklch(0.15 0.012 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --purple:    oklch(0.72 0.19  300);
            --amber:     oklch(0.82 0.12   85);
        }

        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Geist', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 50% 40% at 75% 20%, oklch(0.82 0.12 85 / 0.07), transparent 55%),
                radial-gradient(ellipse 40% 40% at 20% 85%, oklch(0.72 0.19 300 / 0.05), transparent 55%);
            pointer-events: none;
        }

        body::after {
            content: "";
            position: fixed; inset: 0;
            background-image:
                linear-gradient(to right,  var(--line-soft) 1px, transparent 1px),
                linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(0,0,0,0.2), transparent 70%);
            pointer-events: none;
            opacity: 0.3;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            text-align: center;
        }

        .clock-wrap {
            position: relative;
            margin-bottom: 36px;
        }

        .clock-outer {
            width: 80px;
            height: 80px;
            background: oklch(0.82 0.12 85 / 0.08);
            border: 1px solid oklch(0.82 0.12 85 / 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .clock-outer svg {
            width: 38px;
            height: 38px;
            color: var(--amber);
        }

        .ring {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 1px solid oklch(0.82 0.12 85 / 0.15);
            animation: ring-pulse 3s ease-out infinite;
        }

        .ring-2 {
            inset: -16px;
            border-color: oklch(0.82 0.12 85 / 0.08);
            animation-delay: 0.6s;
        }

        @keyframes ring-pulse {
            0%   { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(1.3); }
        }

        .timer {
            position: absolute;
            top: -10px;
            right: -12px;
            background: oklch(0.82 0.12 85 / 0.12);
            border: 1px solid oklch(0.82 0.12 85 / 0.35);
            border-radius: 8px;
            padding: 3px 8px;
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            color: oklch(0.82 0.12 85);
            font-weight: 600;
        }

        h1 {
            font-size: clamp(22px, 4vw, 28px);
            font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            position: relative;
        }

        p {
            font-size: 15px;
            color: var(--ink-dim);
            max-width: 380px;
            line-height: 1.6;
            margin-bottom: 36px;
            position: relative;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
        }

        .btn-primary {
            padding: 11px 22px;
            background: oklch(0.72 0.19 300 / 0.1);
            border: 1px solid oklch(0.72 0.19 300 / 0.3);
            border-radius: 10px;
            color: oklch(0.72 0.19 300);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            font-family: inherit;
            background-color: oklch(0.72 0.19 300 / 0.1);
            border-width: 1px;
            border-style: solid;
        }

        .btn-primary:hover { background: oklch(0.72 0.19 300 / 0.18); }

        .btn-ghost {
            padding: 11px 22px;
            background: transparent;
            border: 1px solid oklch(0.28 0.018 290 / 0.5);
            border-radius: 10px;
            color: oklch(0.72 0.015 290);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-ghost:hover { border-color: oklch(0.28 0.018 290); color: var(--ink); }

        .brand {
            position: fixed;
            top: 24px;
            left: 28px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--ink);
            font-size: 15px;
            font-weight: 600;
        }

        .brand img { width: 26px; height: 26px; border-radius: 7px; }
    </style>
</head>
<body>
    <a href="/" class="brand">
        <img src="/icon.svg" alt="Cardifys">
        Cardifys
    </a>

    <div class="page">
        <div class="clock-wrap">
            <div class="ring"></div>
            <div class="ring ring-2"></div>
            <div class="clock-outer">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="timer">00:00</span>
        </div>

        <h1>Sessão expirada</h1>
        <p>A tua sessão expirou por inatividade. Por segurança, volta à página anterior e tenta de novo.</p>

        <div class="actions">
            <button onclick="history.back()" class="btn-primary">Voltar e tentar de novo</button>
            <a href="{{ route('login') }}" class="btn-ghost">Entrar na conta</a>
        </div>
    </div>
</body>
</html>

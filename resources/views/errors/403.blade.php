<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Acesso negado · Cardifys</title>
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
            --red:       oklch(0.65 0.22   25);
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
                radial-gradient(ellipse 50% 40% at 80% 20%, oklch(0.65 0.22 25 / 0.06), transparent 55%),
                radial-gradient(ellipse 45% 45% at 15% 80%, oklch(0.72 0.19 300 / 0.05), transparent 55%);
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

        .code {
            font-family: 'Geist Mono', monospace;
            font-size: clamp(100px, 20vw, 180px);
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, oklch(0.65 0.22 25), oklch(0.72 0.19 300));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0.16;
            position: absolute;
            pointer-events: none;
            user-select: none;
        }

        .lock-wrap {
            position: relative;
            margin-bottom: 36px;
        }

        .lock-outer {
            width: 80px;
            height: 80px;
            background: oklch(0.65 0.22 25 / 0.08);
            border: 1px solid oklch(0.65 0.22 25 / 0.25);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: jiggle 4s ease-in-out infinite;
        }

        .lock-outer svg { width: 36px; height: 36px; color: var(--red); }

        .badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: oklch(0.65 0.22 25 / 0.15);
            border: 1px solid oklch(0.65 0.22 25 / 0.4);
            border-radius: 6px;
            padding: 2px 6px;
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            color: oklch(0.75 0.18 25);
            font-weight: 500;
        }

        @keyframes jiggle {
            0%, 85%, 100% { transform: rotate(0deg); }
            87% { transform: rotate(-5deg); }
            89% { transform: rotate(5deg); }
            91% { transform: rotate(-3deg); }
            93% { transform: rotate(3deg); }
            95% { transform: rotate(0deg); }
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
            max-width: 360px;
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
        <span class="code">403</span>

        <div class="lock-wrap">
            <div class="lock-outer">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>
            <span class="badge">DENIED</span>
        </div>

        <h1>Acesso não autorizado</h1>
        <p>Não tens permissões para ver esta página. Se achares que é um engano, entra na tua conta.</p>

        <div class="actions">
            <a href="{{ route('login') }}" class="btn-primary">Entrar na conta</a>
            <a href="/" class="btn-ghost">Voltar ao início</a>
        </div>
    </div>
</body>
</html>

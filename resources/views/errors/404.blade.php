<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Página não encontrada · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:          oklch(0.15 0.012 290);
            --ink:         oklch(0.97 0.010 290);
            --ink-dim:     oklch(0.72 0.015 290);
            --ink-mute:    oklch(0.52 0.012 290);
            --line-soft:   oklch(0.28 0.018 290 / 0.35);
            --purple:      oklch(0.72 0.19  300);
            --purple-soft: oklch(0.72 0.19  300 / 0.12);
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
                radial-gradient(ellipse 55% 45% at 80% 10%, oklch(0.72 0.19 300 / 0.08), transparent 60%),
                radial-gradient(ellipse 40% 40% at 10% 90%, oklch(0.82 0.14 330 / 0.05), transparent 60%);
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
            background: linear-gradient(135deg, oklch(0.72 0.19 300), oklch(0.82 0.14 330));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0.18;
            position: absolute;
            pointer-events: none;
            user-select: none;
        }

        .card-visual {
            position: relative;
            margin-bottom: 40px;
        }

        .floating-card {
            width: 220px;
            height: 132px;
            background: oklch(0.19 0.015 290);
            border: 1px solid oklch(0.28 0.018 290 / 0.6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            animation: float 4s ease-in-out infinite;
            box-shadow: 0 24px 60px oklch(0 0 0 / 0.4), 0 0 0 1px oklch(0.72 0.19 300 / 0.1);
        }

        .floating-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, oklch(0.72 0.19 300 / 0.06), transparent 60%);
        }

        .card-lines {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 20px;
            width: 100%;
        }

        .card-line {
            height: 8px;
            border-radius: 4px;
            background: oklch(0.28 0.018 290 / 0.6);
        }
        .card-line.short { width: 40%; }
        .card-line.medium { width: 65%; }
        .card-line.long { width: 85%; }

        .question-mark {
            position: absolute;
            top: -16px;
            right: -16px;
            width: 40px;
            height: 40px;
            background: var(--bg);
            border: 1px solid oklch(0.28 0.018 290 / 0.5);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Geist Mono', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--purple);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50%       { transform: translateY(-12px) rotate(1deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(0.95); }
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
            background: var(--purple-soft);
            border: 1px solid oklch(0.72 0.19 300 / 0.3);
            border-radius: 10px;
            color: var(--purple);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: oklch(0.72 0.19 300 / 0.18);
            border-color: oklch(0.72 0.19 300 / 0.5);
        }

        .btn-ghost {
            padding: 11px 22px;
            background: transparent;
            border: 1px solid oklch(0.28 0.018 290 / 0.5);
            border-radius: 10px;
            color: var(--ink-dim);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-ghost:hover {
            border-color: oklch(0.28 0.018 290);
            color: var(--ink);
        }

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
        <span class="code">404</span>

        <div class="card-visual">
            <div class="floating-card">
                <div class="card-lines">
                    <div class="card-line short"></div>
                    <div class="card-line medium"></div>
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                </div>
            </div>
            <div class="question-mark">?</div>
        </div>

        <h1>Cartão não encontrado</h1>
        <p>A página que procuras não existe, foi movida ou o link está incorreto.</p>

        <div class="actions">
            <a href="/" class="btn-primary">Voltar ao início</a>
            <a href="javascript:history.back()" class="btn-ghost">Página anterior</a>
        </div>
    </div>
</body>
</html>

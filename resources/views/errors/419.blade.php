<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sessão expirada · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        oklch(0.15 0.012 290);
            --bg-2:      oklch(0.19 0.015 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --ink-mute:  oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --purple:    oklch(0.72 0.19 300);
            --amber:     oklch(0.82 0.12 85);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Geist', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background: radial-gradient(ellipse 50% 50% at 50% 40%, oklch(0.82 0.12 85 / 0.05), transparent 65%);
            pointer-events: none;
        }

        /* ── Clock scene ── */
        .scene {
            position: relative;
            margin-bottom: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Pulsing rings */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1.5px solid var(--amber);
            animation: pulse-ring 2.4s ease-out infinite;
        }

        .ring-1 { width: 100px; height: 100px; animation-delay: 0s; }
        .ring-2 { width: 130px; height: 130px; animation-delay: 0.6s; }
        .ring-3 { width: 160px; height: 160px; animation-delay: 1.2s; }

        @keyframes pulse-ring {
            0%   { transform: scale(0.85); opacity: 0.5; }
            70%  { transform: scale(1);    opacity: 0; }
            100% { transform: scale(1);    opacity: 0; }
        }

        /* Clock face */
        .clock {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(145deg, oklch(0.22 0.018 290), oklch(0.18 0.014 290));
            border: 2px solid oklch(0.82 0.12 85 / 0.45);
            box-shadow:
                0 20px 40px oklch(0 0 0 / 0.45),
                0 0 30px oklch(0.82 0.12 85 / 0.10),
                inset 0 1px 0 oklch(1 0 0 / 0.06);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        /* Clock center dot */
        .clock::before {
            content: "";
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--amber);
            position: absolute;
            z-index: 3;
        }

        /* Hour hand */
        .hand-hour {
            position: absolute;
            bottom: 50%;
            left: 50%;
            width: 2px;
            height: 22px;
            background: var(--ink-dim);
            border-radius: 2px;
            transform-origin: bottom center;
            transform: translateX(-50%) rotate(-60deg);
            z-index: 2;
        }

        /* Minute hand — sweeping forward */
        .hand-minute {
            position: absolute;
            bottom: 50%;
            left: 50%;
            width: 2px;
            height: 28px;
            background: var(--amber);
            border-radius: 2px;
            transform-origin: bottom center;
            transform: translateX(-50%) rotate(0deg);
            animation: sweep 3s linear infinite;
            z-index: 2;
        }

        @keyframes sweep {
            from { transform: translateX(-50%) rotate(0deg); }
            to   { transform: translateX(-50%) rotate(360deg); }
        }

        /* Clock tick marks */
        .ticks {
            position: absolute;
            width: 100%; height: 100%;
            border-radius: 50%;
        }

        .tick {
            position: absolute;
            width: 2px;
            background: oklch(0.82 0.12 85 / 0.30);
            left: 50%;
            transform-origin: bottom center;
            border-radius: 1px;
        }

        /* ── Text ── */
        .content { text-align: center; }

        .code {
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--amber);
            margin-bottom: 12px;
        }

        h1 { font-size: 28px; font-weight: 700; color: var(--ink); letter-spacing: -0.02em; margin-bottom: 10px; }

        p { font-size: 15px; color: var(--ink-dim); max-width: 340px; line-height: 1.6; margin: 0 auto 28px; }

        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 20px; border-radius: 999px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            text-decoration: none; transition: all 0.2s; border: none; cursor: pointer;
        }
        .btn-primary { background: var(--purple); color: oklch(0.12 0.01 290); }
        .btn-primary:hover { background: oklch(0.78 0.19 300); transform: translateY(-1px); }
        .btn-secondary { background: var(--bg-2); color: var(--ink-dim); border: 1px solid var(--line-soft); }
        .btn-secondary:hover { color: var(--ink); }
    </style>
</head>
<body>
    <div class="scene">
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="clock">
            <div class="hand-hour"></div>
            <div class="hand-minute"></div>
        </div>
    </div>

    <div class="content">
        <div class="code">Erro 419</div>
        <h1>Sessão expirada</h1>
        <p>A tua sessão expirou por inatividade. Volta à página anterior e tenta de novo.</p>
        <div class="actions">
            <a href="javascript:history.back()" class="btn btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 14l-4-4 4-4"/><path d="M5 10h11a4 4 0 010 8h-1"/></svg>
                Voltar e tentar de novo
            </a>
            <a href="/" class="btn btn-secondary">Ir para o início</a>
        </div>
    </div>
</body>
</html>

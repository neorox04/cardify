<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Página não encontrada · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        oklch(0.15 0.012 290);
            --bg-2:      oklch(0.19 0.015 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --ink-mute:  oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --purple:    oklch(0.72 0.19 300);
            --purple-soft: oklch(0.72 0.19 300 / 0.12);
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
            background:
                radial-gradient(ellipse 55% 45% at 80% 20%, oklch(0.72 0.19 300 / 0.06), transparent 60%),
                radial-gradient(ellipse 40% 40% at 20% 80%, oklch(0.82 0.14 330 / 0.04), transparent 60%);
            pointer-events: none;
        }

        /* ── Card flutuante ── */
        .scene {
            position: relative;
            margin-bottom: 40px;
        }

        .card {
            width: 260px;
            height: 155px;
            background: linear-gradient(135deg, oklch(0.22 0.018 290), oklch(0.18 0.014 290));
            border: 1px solid oklch(0.72 0.19 300 / 0.30);
            border-radius: 18px;
            box-shadow:
                0 30px 60px oklch(0 0 0 / 0.50),
                0 0 0 1px oklch(0.72 0.19 300 / 0.10),
                inset 0 1px 0 oklch(1 0 0 / 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50%       { transform: translateY(-18px) rotate(2deg); }
        }

        /* Chip */
        .card::before {
            content: "";
            position: absolute;
            top: 22px; left: 22px;
            width: 36px; height: 28px;
            background: linear-gradient(135deg, oklch(0.82 0.12 85 / 0.7), oklch(0.72 0.09 85 / 0.5));
            border-radius: 5px;
            border: 1px solid oklch(0.82 0.12 85 / 0.3);
        }

        /* Stripe */
        .card::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 40px;
            background: oklch(0.72 0.19 300 / 0.12);
            border-radius: 0 0 18px 18px;
            border-top: 1px solid oklch(0.72 0.19 300 / 0.15);
        }

        .question-mark {
            font-size: 72px;
            font-weight: 800;
            color: var(--purple);
            line-height: 1;
            text-shadow: 0 0 40px oklch(0.72 0.19 300 / 0.5);
            animation: question-pulse 3s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes question-pulse {
            0%, 100% { transform: scale(1);       opacity: 1;    }
            30%       { transform: scale(1.08);    opacity: 0.85; }
            60%       { transform: scale(0.96);    opacity: 1;    }
        }

        /* Shadow under card */
        .card-shadow {
            width: 200px;
            height: 20px;
            background: oklch(0 0 0 / 0.4);
            border-radius: 50%;
            filter: blur(14px);
            margin: 0 auto;
            animation: shadow-float 4s ease-in-out infinite;
        }

        @keyframes shadow-float {
            0%, 100% { transform: scaleX(1);    opacity: 0.4; }
            50%       { transform: scaleX(0.75); opacity: 0.2; }
        }

        /* ── Text ── */
        .content { text-align: center; }

        .code {
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 12px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        p {
            font-size: 15px;
            color: var(--ink-dim);
            max-width: 340px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: var(--purple);
            color: oklch(0.12 0.01 290);
        }
        .btn-primary:hover { background: oklch(0.78 0.19 300); transform: translateY(-1px); }
        .btn-secondary {
            background: var(--bg-2);
            color: var(--ink-dim);
            border: 1px solid var(--line-soft);
        }
        .btn-secondary:hover { color: var(--ink); border-color: oklch(0.72 0.19 300 / 0.30); }
    </style>
</head>
<body>
    <div class="scene">
        <div class="card">
            <span class="question-mark">?</span>
        </div>
        <div class="card-shadow"></div>
    </div>

    <div class="content">
        <div class="code">Erro 404</div>
        <h1>Página não encontrada</h1>
        <p>O cartão que procuras parece ter desaparecido. Pode ter sido movido, eliminado, ou nunca ter existido.</p>
        <div class="actions">
            <a href="/" class="btn btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Voltar ao início
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">Página anterior</a>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Acesso negado · Cardifys</title>
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
            --red:       oklch(0.65 0.22 25);
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
            background: radial-gradient(ellipse 50% 50% at 50% 40%, oklch(0.65 0.22 25 / 0.06), transparent 65%);
            pointer-events: none;
        }

        /* ── Lock scene ── */
        .scene {
            position: relative;
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .lock-wrap {
            position: relative;
            animation: jiggle 3.5s ease-in-out infinite;
        }

        @keyframes jiggle {
            0%, 55%, 100%  { transform: rotate(0deg); }
            57%            { transform: rotate(-8deg); }
            59%            { transform: rotate(8deg); }
            61%            { transform: rotate(-6deg); }
            63%            { transform: rotate(6deg); }
            65%            { transform: rotate(-3deg); }
            67%            { transform: rotate(3deg); }
            69%            { transform: rotate(0deg); }
        }

        /* Lock SVG custom */
        .lock-body {
            width: 80px;
            height: 70px;
            background: linear-gradient(160deg, oklch(0.25 0.018 290), oklch(0.20 0.014 290));
            border: 2px solid oklch(0.65 0.22 25 / 0.60);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 20px 40px oklch(0.65 0.22 25 / 0.15),
                0 0 0 1px oklch(0.65 0.22 25 / 0.10);
            position: relative;
        }

        .lock-hole {
            width: 20px; height: 20px;
            background: oklch(0.65 0.22 25 / 0.20);
            border: 2px solid oklch(0.65 0.22 25 / 0.50);
            border-radius: 50%;
            position: relative;
        }

        .lock-hole::after {
            content: "";
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, 0);
            width: 3px;
            height: 10px;
            background: oklch(0.65 0.22 25 / 0.50);
            border-radius: 0 0 2px 2px;
        }

        .lock-shackle {
            position: absolute;
            top: -32px; left: 50%;
            transform: translateX(-50%);
            width: 44px; height: 36px;
            border: 6px solid oklch(0.65 0.22 25 / 0.70);
            border-bottom: none;
            border-radius: 22px 22px 0 0;
        }

        /* DENIED badge */
        .denied-badge {
            position: absolute;
            bottom: -14px;
            right: -20px;
            background: var(--red);
            color: white;
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            padding: 4px 10px;
            border-radius: 999px;
            border: 2px solid var(--bg);
            animation: badge-pop 3.5s ease-in-out infinite;
            white-space: nowrap;
        }

        @keyframes badge-pop {
            0%, 54%, 72%, 100% { transform: scale(1); }
            57%                { transform: scale(1.15); }
            60%                { transform: scale(0.95); }
            63%                { transform: scale(1.10); }
            66%                { transform: scale(1); }
        }

        /* ── Text ── */
        .content { text-align: center; }

        .code {
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--red);
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
        <div class="lock-wrap">
            <div class="lock-shackle"></div>
            <div class="lock-body">
                <div class="lock-hole"></div>
            </div>
            <span class="denied-badge">ACCESS DENIED</span>
        </div>
    </div>

    <div class="content">
        <div class="code">Erro 403</div>
        <h1>Acesso negado</h1>
        <p>Não tens permissão para aceder a esta página. Se achares que é um erro, contacta o administrador.</p>
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

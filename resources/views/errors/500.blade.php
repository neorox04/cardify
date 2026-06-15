<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Erro interno · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500;600&display=swap" rel="stylesheet">
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
            --red-soft:  oklch(0.65 0.22 25 / 0.12);
            --green-term: #4ade80;
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
            background: radial-gradient(ellipse 50% 50% at 50% 40%, oklch(0.65 0.22 25 / 0.05), transparent 65%);
            pointer-events: none;
        }

        /* ── Terminal ── */
        .terminal {
            width: 480px;
            max-width: calc(100vw - 40px);
            background: oklch(0.11 0.010 290);
            border: 1px solid oklch(0.28 0.018 290 / 0.60);
            border-radius: 14px;
            box-shadow:
                0 40px 80px oklch(0 0 0 / 0.55),
                0 0 0 1px oklch(0 0 0 / 0.20);
            overflow: hidden;
            margin-bottom: 36px;
        }

        /* Title bar */
        .terminal-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: oklch(0.17 0.013 290);
            border-bottom: 1px solid oklch(0.28 0.018 290 / 0.40);
        }

        .dot {
            width: 12px; height: 12px;
            border-radius: 50%;
        }
        .dot-red    { background: #ff5f57; }
        .dot-yellow { background: #febc2e; }
        .dot-green  { background: #28c840; }

        .terminal-title {
            flex: 1;
            text-align: center;
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            color: var(--ink-mute);
            margin-right: 36px;
        }

        /* Body */
        .terminal-body {
            padding: 20px 22px;
            font-family: 'Geist Mono', monospace;
            font-size: 13px;
            line-height: 1.9;
        }

        .line { display: flex; gap: 8px; }

        .prompt { color: var(--green-term); font-weight: 600; }
        .cmd    { color: var(--ink-dim); }
        .out    { color: var(--ink-mute); padding-left: 0; }
        .err    { color: var(--red); font-weight: 600; }
        .warn   { color: oklch(0.82 0.12 85); }

        .cursor-line {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }

        .cursor {
            display: inline-block;
            width: 8px;
            height: 16px;
            background: var(--green-term);
            animation: blink 1.1s step-end infinite;
            vertical-align: text-bottom;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
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

        h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        p {
            font-size: 15px;
            color: var(--ink-dim);
            max-width: 360px;
            line-height: 1.6;
            margin: 0 auto 28px;
        }

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
    <div class="terminal">
        <div class="terminal-bar">
            <span class="dot dot-red"></span>
            <span class="dot dot-yellow"></span>
            <span class="dot dot-green"></span>
            <span class="terminal-title">cardifys — bash</span>
        </div>
        <div class="terminal-body">
            <div class="line"><span class="prompt">~</span><span class="cmd">$ php artisan serve --port=8000</span></div>
            <div class="line"><span class="out">Starting server on http://localhost:8000</span></div>
            <div class="line"><span class="out">Press Ctrl+C to stop.</span></div>
            <div class="line" style="margin-top:4px;"><span class="warn">⚠  Uncaught exception in Handler.php</span></div>
            <div class="line"><span class="err">✗  HTTP 500 — Internal Server Error</span></div>
            <div class="line"><span class="out">Stack trace logged to storage/logs/laravel.log</span></div>
            <div class="line"><span class="out">The team has been notified. Hang tight.</span></div>
            <div class="cursor-line"><span class="prompt">~</span><span class="cmd">$ </span><span class="cursor"></span></div>
        </div>
    </div>

    <div class="content">
        <div class="code">Erro 500</div>
        <h1>Algo correu mal</h1>
        <p>O servidor encontrou um problema inesperado. Já estamos a trabalhar nisso.</p>
        <div class="actions">
            <a href="/" class="btn btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Voltar ao início
            </a>
            <a href="javascript:location.reload()" class="btn btn-secondary">Tentar novamente</a>
        </div>
    </div>
</body>
</html>

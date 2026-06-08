<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Erro no servidor · Cardifys</title>
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
                radial-gradient(ellipse 50% 40% at 85% 15%, oklch(0.82 0.12 85 / 0.06), transparent 55%),
                radial-gradient(ellipse 45% 45% at 15% 85%, oklch(0.72 0.19 300 / 0.05), transparent 55%);
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
            background: linear-gradient(135deg, oklch(0.82 0.12 85), oklch(0.72 0.19 300));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0.16;
            position: absolute;
            pointer-events: none;
            user-select: none;
        }

        .icon-wrap {
            width: 80px;
            height: 80px;
            background: oklch(0.82 0.12 85 / 0.08);
            border: 1px solid oklch(0.82 0.12 85 / 0.25);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            position: relative;
            animation: shake 5s ease-in-out infinite;
        }

        .icon-wrap svg { width: 36px; height: 36px; color: var(--amber); }

        .dot {
            position: absolute;
            border-radius: 50%;
            animation: blink 1.4s ease-in-out infinite;
        }
        .dot-1 { width: 8px; height: 8px; background: oklch(0.82 0.12 85 / 0.4); top: -4px; right: -4px; animation-delay: 0s; }
        .dot-2 { width: 6px; height: 6px; background: oklch(0.72 0.19 300 / 0.4); bottom: -3px; left: -3px; animation-delay: 0.5s; }

        @keyframes shake {
            0%, 90%, 100% { transform: rotate(0deg); }
            92%            { transform: rotate(-3deg); }
            94%            { transform: rotate(3deg); }
            96%            { transform: rotate(-2deg); }
            98%            { transform: rotate(2deg); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.3; transform: scale(0.7); }
        }

        .terminal {
            background: oklch(0.11 0.010 290);
            border: 1px solid oklch(0.28 0.018 290 / 0.5);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 32px;
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            color: oklch(0.52 0.012 290);
            text-align: left;
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        .terminal-dots {
            display: flex;
            gap: 6px;
            margin-bottom: 12px;
        }

        .terminal-dots span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .terminal-dots .r { background: oklch(0.65 0.22 25 / 0.6); }
        .terminal-dots .y { background: oklch(0.82 0.12 85 / 0.6); }
        .terminal-dots .g { background: oklch(0.78 0.17 160 / 0.6); }

        .terminal-line { line-height: 1.8; }
        .terminal-line .prompt { color: oklch(0.72 0.19 300 / 0.7); }
        .terminal-line .error  { color: oklch(0.82 0.12 85 / 0.8); }
        .terminal-line .cursor {
            display: inline-block;
            width: 8px;
            height: 13px;
            background: oklch(0.72 0.19 300 / 0.7);
            vertical-align: middle;
            animation: blink-cursor 1s step-end infinite;
        }

        @keyframes blink-cursor {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
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
            cursor: pointer;
            font-family: inherit;
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
        <span class="code">500</span>

        <div class="icon-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <span class="dot dot-1"></span>
            <span class="dot dot-2"></span>
        </div>

        <div class="terminal">
            <div class="terminal-dots">
                <span class="r"></span><span class="y"></span><span class="g"></span>
            </div>
            <div class="terminal-line"><span class="prompt">$ </span>cardifys --status</div>
            <div class="terminal-line"><span class="error">✗ Internal server error (500)</span></div>
            <div class="terminal-line"><span class="prompt">$ </span><span class="cursor"></span></div>
        </div>

        <h1>Algo correu mal</h1>
        <p>O servidor encontrou um erro inesperado. Já estamos a trabalhar nisso — tenta de novo em alguns instantes.</p>

        <div class="actions">
            <button onclick="location.reload()" class="btn-ghost">Tentar novamente</button>
            <a href="/" class="btn-primary">Voltar ao início</a>
        </div>
    </div>
</body>
</html>

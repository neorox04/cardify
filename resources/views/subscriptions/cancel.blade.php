<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento cancelado · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: oklch(0.15 0.012 290); --bg-3: oklch(0.23 0.018 290); --ink: oklch(0.97 0.010 290); --ink-dim: oklch(0.72 0.015 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35); --line: oklch(0.30 0.018 290 / 0.7); --purple: oklch(0.72 0.19 300); --amber: oklch(0.82 0.12 85);
        }
        html, body { height: 100%; background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        body::before { content: ""; position: fixed; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse 55% 45% at 50% 10%, oklch(0.82 0.12 85 / 0.06), transparent 60%), radial-gradient(ellipse 40% 40% at 15% 90%, oklch(0.72 0.19 300 / 0.05), transparent 60%); }
        body::after { content: ""; position: fixed; inset: 0; pointer-events: none; opacity: 0.3;
            background-image: linear-gradient(to right, var(--line-soft) 1px, transparent 1px), linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 72px 72px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(0,0,0,0.2), transparent 70%); }
        .page { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 24px; text-align: center; }
        .icon-wrap { width: 82px; height: 82px; border-radius: 22px; background: oklch(0.82 0.12 85 / 0.1); border: 1px solid oklch(0.82 0.12 85 / 0.28); display: flex; align-items: center; justify-content: center; margin-bottom: 30px; }
        .icon-wrap svg { width: 38px; height: 38px; color: var(--amber); }
        h1 { font-size: clamp(24px, 4vw, 30px); font-weight: 600; letter-spacing: -0.02em; margin-bottom: 12px; }
        p { font-size: 15px; color: var(--ink-dim); max-width: 400px; line-height: 1.6; margin-bottom: 34px; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
        .btn-primary { display: inline-flex; align-items: center; gap: 9px; padding: 12px 24px; border-radius: 11px; font-size: 14px; font-weight: 600; text-decoration: none;
            background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.3); color: var(--purple); transition: all .15s; }
        .btn-primary:hover { background: oklch(0.72 0.19 300 / 0.2); }
        .btn-ghost { display: inline-flex; align-items: center; padding: 12px 24px; border-radius: 11px; font-size: 14px; font-weight: 500; text-decoration: none;
            background: transparent; border: 1px solid var(--line-soft); color: var(--ink-dim); transition: all .15s; }
        .btn-ghost:hover { border-color: var(--line); color: var(--ink); }
        .brand { position: fixed; top: 24px; left: 28px; display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--ink); font-size: 15px; font-weight: 600; }
        .brand img { width: 26px; height: 26px; border-radius: 7px; }
    </style>
</head>
<body>
    <a href="/" class="brand"><img src="/icon.svg" alt="Cardifys">Cardifys</a>
    <div class="page">
        <div class="icon-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1>Pagamento cancelado</h1>
        <p>O pagamento não foi concluído — não te preocupes, não foi cobrado nada. Podes tentar de novo quando quiseres.</p>
        <div class="actions">
            <a href="{{ route('subscriptions.plans') }}" class="btn-primary">Escolher plano</a>
            <a href="{{ route('home') }}" class="btn-ghost">Voltar ao início</a>
        </div>
    </div>
</body>
</html>

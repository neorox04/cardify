<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento bem-sucedido · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: oklch(0.15 0.012 290); --ink: oklch(0.97 0.010 290); --ink-dim: oklch(0.72 0.015 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35); --purple: oklch(0.72 0.19 300); --green: oklch(0.78 0.15 162);
        }
        html, body { height: 100%; background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        body::before { content: ""; position: fixed; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse 55% 45% at 50% 10%, oklch(0.78 0.15 162 / 0.08), transparent 60%), radial-gradient(ellipse 40% 40% at 15% 90%, oklch(0.72 0.19 300 / 0.05), transparent 60%); }
        body::after { content: ""; position: fixed; inset: 0; pointer-events: none; opacity: 0.3;
            background-image: linear-gradient(to right, var(--line-soft) 1px, transparent 1px), linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 72px 72px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(0,0,0,0.2), transparent 70%); }
        .page { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 24px; text-align: center; }
        .icon-wrap { width: 82px; height: 82px; border-radius: 50%; background: oklch(0.78 0.15 162 / 0.12); border: 1px solid oklch(0.78 0.15 162 / 0.3); display: flex; align-items: center; justify-content: center; margin-bottom: 30px; animation: pop .5s cubic-bezier(0.34,1.56,0.64,1) both; }
        .icon-wrap svg { width: 40px; height: 40px; color: var(--green); }
        @keyframes pop { from { opacity: 0; transform: scale(0.6); } to { opacity: 1; transform: scale(1); } }
        h1 { font-size: clamp(24px, 4vw, 30px); font-weight: 600; letter-spacing: -0.02em; margin-bottom: 12px; }
        p { font-size: 15px; color: var(--ink-dim); max-width: 400px; line-height: 1.6; margin-bottom: 34px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 9px; padding: 13px 26px; border-radius: 12px; font-size: 15px; font-weight: 600; text-decoration: none;
            background: linear-gradient(135deg, oklch(0.75 0.19 300), oklch(0.6 0.19 300)); color: #fff; box-shadow: 0 8px 24px oklch(0.72 0.19 300 / 0.35); transition: transform .15s, box-shadow .15s; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 30px oklch(0.72 0.19 300 / 0.45); }
        .brand { position: fixed; top: 24px; left: 28px; display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--ink); font-size: 15px; font-weight: 600; }
        .brand img { width: 26px; height: 26px; border-radius: 7px; }
    </style>
</head>
<body>
    <a href="/" class="brand"><img src="/icon.svg" alt="Cardifys">Cardifys</a>
    <div class="page">
        <div class="icon-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1>Pagamento concluído! 🎉</h1>
        <p>A tua subscrição está ativa. Obrigado por escolheres a Cardifys — já podes criar e partilhar o teu cartão.</p>
        <a href="{{ route('dashboard') }}" class="btn-primary">
            Ir para o dashboard
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</body>
</html>

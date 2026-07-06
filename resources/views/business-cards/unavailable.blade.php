<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartão indisponível · Cardifys</title>
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
            --ink-mute:  oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --purple:    oklch(0.72 0.19  300);
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
                radial-gradient(ellipse 55% 45% at 80% 12%, oklch(0.72 0.19 300 / 0.06), transparent 60%),
                radial-gradient(ellipse 40% 40% at 12% 88%, oklch(0.82 0.14 330 / 0.04), transparent 60%);
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
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 40px 24px; text-align: center;
        }
        .icon-wrap {
            width: 76px; height: 76px;
            background: oklch(0.72 0.19 300 / 0.08);
            border: 1px solid oklch(0.72 0.19 300 / 0.22);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 30px;
        }
        .icon-wrap svg { width: 34px; height: 34px; color: var(--purple); }
        h1 {
            font-size: clamp(21px, 4vw, 26px);
            font-weight: 600; letter-spacing: -0.02em;
            margin-bottom: 12px;
        }
        p { font-size: 15px; color: var(--ink-dim); max-width: 380px; line-height: 1.6; margin-bottom: 32px; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
        .btn-primary {
            padding: 11px 22px;
            background: oklch(0.72 0.19 300 / 0.12);
            border: 1px solid oklch(0.72 0.19 300 / 0.3);
            border-radius: 10px;
            color: var(--purple);
            font-size: 14px; font-weight: 500; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary:hover { background: oklch(0.72 0.19 300 / 0.2); }
        .btn-ghost {
            padding: 11px 22px;
            background: transparent;
            border: 1px solid oklch(0.28 0.018 290 / 0.5);
            border-radius: 10px;
            color: var(--ink-dim);
            font-size: 14px; font-weight: 500; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-ghost:hover { border-color: oklch(0.28 0.018 290); color: var(--ink); }
        .brand {
            position: fixed; top: 24px; left: 28px;
            display: flex; align-items: center; gap: 8px;
            text-decoration: none; color: var(--ink);
            font-size: 15px; font-weight: 600;
        }
        .brand img { width: 26px; height: 26px; border-radius: 7px; }
        .owner-note {
            margin-top: 28px;
            font-size: 12px; color: var(--ink-mute);
            max-width: 360px; line-height: 1.6;
        }
    </style>
</head>
<body>
    <a href="/" class="brand">
        <img src="/icon.svg" alt="Cardifys">
        Cardifys
    </a>

    <div class="page">
        <div class="icon-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
            </svg>
        </div>

        <h1>Este cartão não está disponível</h1>
        <p>O cartão que procuras já não está ativo. Pode ter sido desativado pelo seu dono ou a subscrição associada expirou.</p>

        <div class="actions">
            <a href="/" class="btn-primary">Conhecer a Cardifys</a>
            <a href="{{ route('card.demo') }}" class="btn-ghost">Ver cartão de exemplo</a>
        </div>

        @auth
            @if(isset($businessCard) && $businessCard->user_id === auth()->id())
            <p class="owner-note">
                És o dono deste cartão? Ele voltará a ficar público assim que reativares a tua subscrição.
                <br><a href="{{ route('subscriptions.plans') }}" style="color:var(--purple);">Reativar subscrição →</a>
            </p>
            @endif
        @endauth
    </div>
</body>
</html>

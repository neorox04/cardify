<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Legal') · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg:        oklch(0.15 0.012 290);
            --bg-2:      oklch(0.19 0.015 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --ink-mute:  oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --line:      oklch(0.30 0.018 290 / 0.7);
            --purple:    oklch(0.72 0.19  300);
        }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; min-height: 100vh; }
        body::before {
            content: ""; position: fixed; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse 60% 40% at 50% 0%, oklch(0.72 0.19 300 / 0.07), transparent 60%);
        }

        .topbar {
            position: relative; z-index: 1; max-width: 760px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 26px 24px 0;
        }
        .brand { display: inline-flex; align-items: center; gap: 9px; text-decoration: none; color: var(--ink); font-size: 16px; font-weight: 600; }
        .brand img { width: 26px; height: 26px; border-radius: 7px; }
        .who { display: flex; align-items: center; gap: 12px; }
        .who span { font-size: 13px; color: var(--ink-dim); }
        .logout-btn { background: var(--bg-2); border: 1px solid var(--line-soft); color: var(--ink-dim); padding: 7px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; font-family: inherit; cursor: pointer; transition: all .15s; }
        .logout-btn:hover { border-color: var(--line); color: var(--ink); }

        .doc {
            position: relative; z-index: 1; max-width: 760px; margin: 28px auto 64px;
            background: var(--bg-2); border: 1px solid var(--line-soft);
            border-radius: 20px; padding: 44px 44px 40px;
        }
        .doc h1 { font-size: 30px; font-weight: 600; letter-spacing: -0.025em; margin-bottom: 8px; }
        .doc h2 { font-size: 18px; font-weight: 600; letter-spacing: -0.01em; margin: 30px 0 10px; color: var(--ink); }
        .doc p, .doc li { font-size: 15px; line-height: 1.7; color: var(--ink-dim); }
        .doc p { margin-bottom: 12px; }
        .doc ul { margin: 10px 0 12px; padding-left: 22px; }
        .doc li { margin-bottom: 6px; }
        .doc a { color: var(--purple); text-decoration: none; }
        .doc a:hover { text-decoration: underline; }
        .doc strong { color: var(--ink); font-weight: 600; }

        /* Status/CTA buttons (used by success/cancel or inline CTAs) */
        .btn, .btn-primary {
            display: inline-flex; align-items: center; gap: 8px; margin-top: 18px;
            padding: 11px 22px; border-radius: 10px; font-size: 14px; font-weight: 600;
            text-decoration: none; background: oklch(0.72 0.19 300 / 0.12);
            border: 1px solid oklch(0.72 0.19 300 / 0.3); color: var(--purple); transition: all .15s;
        }
        .btn:hover, .btn-primary:hover { background: oklch(0.72 0.19 300 / 0.2); }

        @media (max-width: 600px) {
            .doc { padding: 28px 22px; margin: 18px 14px 40px; border-radius: 16px; }
            .topbar { padding: 20px 18px 0; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <a href="{{ route('home') }}" class="brand">
            <img src="/icon.svg" alt="Cardifys">
            Cardifys
        </a>
        @auth
            <div class="who">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Sair</button>
                </form>
            </div>
        @endauth
    </header>

    <main class="doc">
        @yield('content')
    </main>
</body>
</html>

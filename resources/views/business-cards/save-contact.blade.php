<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar contacto · {{ $businessCard->full_name }}</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg:        oklch(0.15 0.012 290);
            --bg-2:      oklch(0.19 0.015 290);
            --bg-3:      oklch(0.23 0.018 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --ink-mute:  oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --line:      oklch(0.30 0.018 290 / 0.7);
            --purple:    oklch(0.72 0.19  300);
            --purple-deep: oklch(0.52 0.19 300);
            --green:     oklch(0.78 0.15 162);
        }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; min-height: 100vh; }
        body::before {
            content: ""; position: fixed; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse 60% 40% at 50% 0%, oklch(0.72 0.19 300 / 0.1), transparent 60%);
        }
        .wrap { position: relative; z-index: 1; max-width: 400px; margin: 0 auto; padding: 48px 22px 32px; text-align: center; }

        .card {
            background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: 24px;
            padding: 34px 26px 28px; box-shadow: 0 24px 60px oklch(0 0 0 / 0.4);
            animation: rise .5s ease both;
        }
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        .check {
            width: 54px; height: 54px; border-radius: 50%; margin: 0 auto 18px;
            background: oklch(0.78 0.15 162 / 0.12); border: 1px solid oklch(0.78 0.15 162 / 0.3);
            display: flex; align-items: center; justify-content: center;
        }
        .check svg { width: 26px; height: 26px; color: var(--green); }

        .avatar-wrap { width: 84px; margin: 0 auto 14px; }
        .name { font-size: 21px; font-weight: 600; letter-spacing: -0.02em; }
        .position { font-size: 14px; color: var(--ink-dim); margin-top: 3px; }
        .company {
            display: inline-block; margin-top: 9px; padding: 4px 12px;
            background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.25);
            border-radius: 999px; font-size: 12px; font-weight: 500; color: var(--purple);
        }
        .note { font-size: 13px; color: var(--ink-mute); margin: 18px 0 22px; line-height: 1.6; }

        .btn {
            display: flex; align-items: center; justify-content: center; gap: 9px;
            height: 50px; border-radius: 13px; font-size: 15px; font-weight: 600;
            text-decoration: none; transition: all .15s; font-family: inherit; margin-bottom: 10px;
        }
        .btn svg { width: 18px; height: 18px; }
        .btn-primary {
            background: linear-gradient(135deg, oklch(0.75 0.19 300), oklch(0.6 0.19 300));
            color: #fff; box-shadow: 0 8px 24px oklch(0.72 0.19 300 / 0.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 30px oklch(0.72 0.19 300 / 0.45); }
        .btn-ghost { background: var(--bg-3); border: 1px solid var(--line-soft); color: var(--ink); }
        .btn-ghost:hover { border-color: var(--line); }

        .powered { margin-top: 22px; font-size: 12px; color: var(--ink-mute); }
        .powered a { color: var(--ink-dim); font-weight: 600; text-decoration: none; }
        .powered a:hover { color: var(--purple); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="check">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
            </div>

            <div class="avatar-wrap">
                <x-avatar :name="$businessCard->full_name" :photo="$businessCard->avatar" :style="$businessCard->user?->avatar_style" :size="84" />
            </div>

            <h1 class="name">{{ $businessCard->full_name }}</h1>
            @if($businessCard->position)<p class="position">{{ $businessCard->position }}</p>@endif
            @if($businessCard->company)<span class="company">{{ $businessCard->company->name }}</span>@endif

            <p class="note">📥 O contacto vai ser transferido automaticamente. Se não começar, usa o botão abaixo.</p>

            <a href="{{ route('card.vcard', $businessCard) }}" class="btn btn-primary" id="downloadBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Guardar contacto
            </a>

            <a href="{{ route('card.public', $businessCard->slug) }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Ver cartão completo
            </a>
        </div>

        <p class="powered">Criado com <a href="{{ route('home') }}">Cardifys</a></p>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('card.vcard', $businessCard) }}";
        }, 1500);
    </script>
</body>
</html>

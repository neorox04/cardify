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

        <style>
            .share-card { text-align: left; margin-top: 14px; padding: 22px 22px 20px; }
            .share-title { font-size: 16px; font-weight: 600; }
            .share-sub { font-size: 12.5px; color: var(--ink-mute); margin: 4px 0 16px; line-height: 1.5; }
            .s-input { width: 100%; height: 44px; padding: 0 14px; margin-bottom: 9px; background: var(--bg-3); border: 1.5px solid var(--line-soft); border-radius: 10px; color: var(--ink); font-family: inherit; font-size: 14px; outline: none; transition: border-color .15s; }
            .s-input::placeholder { color: var(--ink-mute); }
            .s-input:focus { border-color: oklch(0.72 0.19 300 / 0.6); }
            .s-err { font-size: 12px; color: oklch(0.68 0.19 22); margin: -4px 0 8px; }
            .s-actions { display: flex; flex-direction: column; gap: 9px; margin-top: 6px; }
            .share-done { text-align: center; }
            .share-done .check { margin-bottom: 14px; }
        </style>

        @if(session('shared_ok') === 'email')
            <div class="card share-done">
                <div class="check">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <h1 class="name">Contacto enviado! 🎉</h1>
                <p class="note">Enviámos o teu contacto a {{ $businessCard->full_name }}. Ficam ligados.</p>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Cria o teu cartão Cardifys
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        @else
            <div class="card share-card">
                <div class="share-title">Partilha o teu contacto também</div>
                <div class="share-sub">{{ $businessCard->full_name }} fica com o teu contacto e ligam-se — sem trocar números à mão.</div>

                <form method="POST" action="{{ route('card.share', $businessCard) }}" id="shareForm">
                    @csrf
                    <input type="hidden" name="method" id="shareMethod" value="">
                    <input class="s-input" name="full_name" placeholder="O teu nome" required value="{{ old('full_name') }}">
                    <input class="s-input" name="phone" placeholder="Telemóvel" required value="{{ old('phone') }}">
                    <input class="s-input" type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                    @error('full_name')<div class="s-err">{{ $message }}</div>@enderror
                    @error('phone')<div class="s-err">{{ $message }}</div>@enderror
                    @error('email')<div class="s-err">{{ $message }}</div>@enderror

                    <div class="s-actions">
                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('shareMethod').value='email'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Enviar por email
                        </button>
                        <button type="submit" class="btn btn-ghost" onclick="document.getElementById('shareMethod').value='qr'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3M21 21v.01M17 21h.01M21 17h.01"/></svg>
                            QR ao vivo (5 min)
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <p class="powered">Criado com <a href="{{ route('home') }}">Cardifys</a></p>
    </div>

    <script>
        // Auto-download the owner's contact — but not if the visitor is busy
        // filling in the share-back form.
        var shareForm = document.getElementById('shareForm');
        var autoDl = setTimeout(function () {
            window.location.href = "{{ route('card.vcard', $businessCard) }}";
        }, 1800);
        if (shareForm) {
            shareForm.addEventListener('focusin', function () { clearTimeout(autoDl); });
        }
    </script>
</body>
</html>

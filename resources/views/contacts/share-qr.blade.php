<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partilha o teu contacto · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: oklch(0.15 0.012 290); --bg-2: oklch(0.19 0.015 290); --bg-3: oklch(0.23 0.018 290);
            --ink: oklch(0.97 0.010 290); --ink-dim: oklch(0.72 0.015 290); --ink-mute: oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35); --purple: oklch(0.72 0.19 300); --green: oklch(0.78 0.15 162); --danger: oklch(0.68 0.19 22);
        }
        html, body { min-height: 100vh; background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        body::before { content: ""; position: fixed; inset: 0; pointer-events: none; background: radial-gradient(ellipse 60% 40% at 50% 0%, oklch(0.72 0.19 300 / 0.1), transparent 60%); }
        .wrap { position: relative; z-index: 1; max-width: 400px; margin: 0 auto; padding: 48px 22px 32px; text-align: center; }
        .card { background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: 24px; padding: 30px 26px; box-shadow: 0 24px 60px oklch(0 0 0 / 0.4); }
        h1 { font-size: 20px; font-weight: 600; letter-spacing: -0.02em; margin-bottom: 6px; }
        .sub { font-size: 13px; color: var(--ink-dim); margin-bottom: 22px; line-height: 1.5; }
        .qr-box { display: inline-block; padding: 14px; background: #fff; border-radius: 18px; box-shadow: 0 8px 24px oklch(0 0 0 / 0.35); }
        .qr-box img { display: block; width: 200px; height: 200px; }
        .who { margin-top: 18px; font-size: 14px; font-weight: 600; }
        .countdown { margin-top: 16px; display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.25); font-size: 14px; font-weight: 600; color: var(--purple); }
        .countdown.expired { background: oklch(0.68 0.19 22 / 0.12); border-color: oklch(0.68 0.19 22 / 0.3); color: var(--danger); }
        .hint { margin-top: 20px; font-size: 12px; color: var(--ink-mute); line-height: 1.6; }
        .cta { display: inline-flex; align-items: center; gap: 8px; margin-top: 22px; padding: 12px 22px; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.3); color: var(--purple); }
        .powered { margin-top: 22px; font-size: 12px; color: var(--ink-mute); }
        .powered a { color: var(--ink-dim); font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1>Mostra este QR</h1>
            <p class="sub">Pede a {{ $shared->businessCard->full_name ?? 'quem partilhaste' }} para ler este código — fica logo com o teu contacto.</p>

            <div class="qr-box">
                <img id="qrimg" src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode(route('contact.vcard', $shared->token)) }}" alt="QR do contacto">
            </div>

            <div class="who">{{ $shared->full_name }}</div>

            <div class="countdown" id="countdown">Válido por <span id="timer">5:00</span></div>

            <p class="hint">Assim que lerem o código, o teu contacto é guardado no telemóvel deles.</p>

            <a href="{{ route('register') }}" class="cta">
                Cria o teu cartão Cardifys
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
        <p class="powered">Criado com <a href="{{ route('home') }}">Cardifys</a></p>
    </div>

    <script>
        var expires = new Date("{{ optional($shared->expires_at)->toIso8601String() }}").getTime();
        var timerEl = document.getElementById('timer');
        var box = document.getElementById('countdown');
        function tick() {
            var left = Math.max(0, Math.floor((expires - Date.now()) / 1000));
            var m = Math.floor(left / 60), s = left % 60;
            timerEl.textContent = m + ':' + (s < 10 ? '0' : '') + s;
            if (left <= 0) {
                box.classList.add('expired');
                box.innerHTML = 'QR expirado — gera um novo';
                clearInterval(iv);
            }
        }
        tick();
        var iv = setInterval(tick, 1000);
    </script>
</body>
</html>

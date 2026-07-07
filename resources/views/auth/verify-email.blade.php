<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica o teu email — Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#7c3aed">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; overflow: hidden; background: #08070c; }

        .layout { display: grid; grid-template-columns: 1fr 1fr; height: 100vh; }

        /* LEFT */
        .side-l { display: flex; flex-direction: column; padding: 36px 52px; position: relative; background: radial-gradient(ellipse at 28% 60%, rgba(130,70,255,0.30) 0%, transparent 58%); }
        .l-nav { display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-name { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: #fff; letter-spacing: -0.02em; }
        .l-hero { flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .slide-tag { display: flex; align-items: center; gap: 14px; margin-bottom: 32px; }
        .slide-num { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.28); letter-spacing: 0.02em; }
        .slide-rule { width: 44px; height: 1px; background: rgba(255,255,255,0.14); flex-shrink: 0; }
        .slide-lbl { font-size: 10px; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(255,255,255,0.28); white-space: nowrap; }
        .hero-heading { font-family: 'Playfair Display', serif; font-style: italic; font-size: clamp(56px, 5.8vw, 76px); font-weight: 400; line-height: 1.08; color: rgba(255,255,255,0.88); margin-bottom: 22px; letter-spacing: -0.015em; }
        .hero-sub { font-size: 14px; color: rgba(255,255,255,0.52); }
        .l-footer { display: flex; align-items: center; justify-content: flex-end; flex-shrink: 0; }
        .copy { font-family: 'Syne', sans-serif; font-size: 11.5px; color: rgba(255,255,255,0.2); letter-spacing: 0.04em; }

        /* RIGHT */
        .side-r { display: flex; align-items: center; justify-content: center; padding: 40px 52px 40px 32px; }
        .form-card { width: 100%; max-width: 390px; background: #0d0c12; border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 36px 32px 32px; box-shadow: 0 0 0 1px rgba(165,107,255,0.06), 0 32px 72px rgba(0,0,0,0.5); animation: rise .5s ease .05s both; }

        .fc-icon { width: 46px; height: 46px; border-radius: 12px; background: rgba(165,107,255,0.1); border: 1px solid rgba(165,107,255,0.22); display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .fc-icon svg { width: 22px; height: 22px; color: #a56bff; }

        .fc-title { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; color: #f0ecff; letter-spacing: -0.04em; margin-bottom: 6px; }
        .fc-sub { font-size: 14px; color: rgba(255,255,255,0.42); margin-bottom: 20px; line-height: 1.55; }
        .fc-sub b { color: #c084fc; font-weight: 600; }

        .banner-ok { display: flex; align-items: flex-start; gap: 8px; background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.22); border-radius: 10px; padding: 11px 14px; font-size: 13px; font-weight: 500; color: #34d399; margin-bottom: 16px; line-height: 1.5; }
        .banner-ok svg { flex-shrink: 0; margin-top: 2px; }

        .btn-go { width: 100%; height: 48px; background: linear-gradient(135deg, #c084fc 0%, #a855f7 45%, #7c3aed 100%); border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 28px rgba(165,107,255,0.38); transition: transform 0.15s, box-shadow 0.15s; text-decoration: none; }
        .btn-go:hover { transform: translateY(-1px); box-shadow: 0 12px 36px rgba(165,107,255,0.5); }

        .btn-sec { width: 100%; height: 46px; background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.09); border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 600; color: #f0ecff; cursor: pointer; margin-top: 10px; transition: all 0.15s; }
        .btn-sec:hover { background: rgba(255,255,255,0.1); border-color: rgba(165,107,255,0.4); }

        .btn-ghost { width: 100%; height: 42px; background: none; border: none; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.42); cursor: pointer; margin-top: 8px; transition: color 0.15s; }
        .btn-ghost:hover { color: #f87171; }

        form { margin: 0; }

        .note { font-size: 12px; color: rgba(255,255,255,0.3); text-align: center; margin-top: 16px; line-height: 1.5; }

        .polling { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 18px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: rgba(255,255,255,0.42); }
        .dot { width: 7px; height: 7px; border-radius: 99px; background: #34d399; box-shadow: 0 0 8px #34d399; animation: pulse 1.4s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            body { overflow: auto; }
            .layout { grid-template-columns: 1fr; height: auto; }
            .side-l { display: none; }
            .side-r { min-height: 100vh; padding: 40px 24px; }
        }
    </style>
</head>
<body>
<div class="layout">

    <aside class="side-l">
        <nav class="l-nav">
            <a href="/" class="logo">
                <svg width="30" height="30" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="7" fill="#1a0a3a"/>
                    <path d="M20.8 21.2C17.99 24.01 13.43 24.01 10.62 21.2C7.81 18.39 7.81 13.83 10.62 11.02C13.43 8.21 17.99 8.21 20.8 11.02" stroke="#F2F2EE" stroke-width="2" stroke-linecap="round"/>
                    <path d="M13.85 13.45L17.65 16L13.85 18.55" stroke="#B08CFF" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="logo-name">Cardifys</span>
            </a>
        </nav>

        <div class="l-hero">
            <div class="slide-tag">
                <span class="slide-num">01/01</span>
                <span class="slide-rule"></span>
                <span class="slide-lbl">Quase dentro</span>
            </div>
            <h1 class="hero-heading">Um clique<br>e estás lá.</h1>
            <p class="hero-sub">Confirma o teu email para ativares a conta e começares.</p>
        </div>

        <footer class="l-footer">
            <span class="copy">© 2026 Cardifys</span>
        </footer>
    </aside>

    <main class="side-r">
        <div class="form-card">
            <div class="fc-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            </div>

            <h2 class="fc-title">Verifica o teu email</h2>
            <p class="fc-sub">Enviámos um link de verificação para <b>{{ auth()->user()->email }}</b>. Abre o email e clica no link para ativar a conta.</p>

            @if(session('success'))
                <div class="banner-ok">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('verification.notice') }}" class="btn-go">
                Já verifiquei — Continuar
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-sec">Reenviar email de verificação</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-ghost">Sair da conta</button>
            </form>

            <p class="note">Não encontras o email? Vê a pasta de spam ou lixo.</p>

            <div class="polling">
                <span class="dot"></span>
                A verificar automaticamente…
            </div>
        </div>
    </main>

</div>
<script>
    // Deteta verificação feita noutro dispositivo — polling a cada 4s
    setInterval(function () {
        fetch('{{ route('verification.status') }}', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) { if (data.verified) window.location.href = '{{ route('dashboard') }}'; })
        .catch(function () {});
    }, 4000);
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova palavra-passe — Cardifys</title>
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
        .fc-sub { font-size: 14px; color: rgba(255,255,255,0.42); margin-bottom: 24px; line-height: 1.5; }

        .alert-error { display: flex; align-items: flex-start; gap: 8px; background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.22); border-radius: 10px; padding: 11px 14px; font-size: 13px; font-weight: 500; color: #f87171; margin-bottom: 18px; line-height: 1.5; }
        .alert-error svg { flex-shrink: 0; margin-top: 1px; }

        .field { margin-bottom: 13px; }
        .field-top { margin-bottom: 7px; }
        .f-lbl { font-size: 10.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.42); }
        .inp-wrap { position: relative; }
        .f-input { width: 100%; height: 46px; padding: 0 15px; background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.09); border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 500; color: #f0ecff; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s; -webkit-appearance: none; }
        .f-input::placeholder { color: rgba(255,255,255,0.22); }
        .f-input:focus { outline: none; border-color: rgba(165,107,255,0.65); box-shadow: 0 0 0 3px rgba(165,107,255,0.12); background: rgba(255,255,255,0.08); }
        .f-input.is-err { border-color: rgba(248,113,113,0.7); box-shadow: 0 0 0 3px rgba(248,113,113,0.1); }
        .f-input.has-r { padding-right: 44px; }
        .pw-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,0.3); cursor: pointer; padding: 4px; display: flex; align-items: center; transition: color 0.15s; }
        .pw-btn:hover { color: rgba(255,255,255,0.7); }
        .f-err { display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; color: #f87171; margin-top: 5px; }

        .btn-go { width: 100%; height: 48px; background: linear-gradient(135deg, #c084fc 0%, #a855f7 45%, #7c3aed 100%); border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px; margin-bottom: 18px; box-shadow: 0 8px 28px rgba(165,107,255,0.38); transition: transform 0.15s, box-shadow 0.15s; }
        .btn-go:hover { transform: translateY(-1px); box-shadow: 0 12px 36px rgba(165,107,255,0.5); }
        .btn-go:active { transform: translateY(0); }

        .fc-footer { text-align: center; font-size: 13.5px; color: rgba(255,255,255,0.38); }
        .fc-footer a { color: #fff; font-weight: 700; text-decoration: underline; text-underline-offset: 2px; transition: color 0.15s; }
        .fc-footer a:hover { color: #c084fc; }

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
                <span class="slide-lbl">Nova palavra-passe</span>
            </div>
            <h1 class="hero-heading">Quase lá.<br>Define e entra.</h1>
            <p class="hero-sub">Escolhe uma palavra-passe forte e volta à tua conta.</p>
        </div>

        <footer class="l-footer">
            <span class="copy">© 2026 Cardifys</span>
        </footer>
    </aside>

    <main class="side-r">
        <div class="form-card">
            <div class="fc-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            </div>

            <h2 class="fc-title">Nova palavra-passe</h2>
            <p class="fc-sub">Escolhe uma nova palavra-passe para a tua conta.</p>

            @if($errors->any())
                <div class="alert-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <div class="field-top">
                        <label for="email" class="f-lbl">Email</label>
                    </div>
                    <input type="email" id="email" name="email"
                        class="f-input @error('email') is-err @enderror"
                        value="{{ old('email', $email) }}" required autofocus
                        placeholder="rodrigo@empresa.com">
                    @error('email')
                        <span class="f-err">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <div class="field-top">
                        <label for="password" class="f-lbl">Nova palavra-passe</label>
                    </div>
                    <div class="inp-wrap">
                        <input type="password" id="password" name="password"
                            class="f-input has-r @error('password') is-err @enderror"
                            required minlength="6" placeholder="Mínimo 6 caracteres">
                        <button type="button" class="pw-btn" data-toggle="password" aria-label="Mostrar palavra-passe">
                            <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="f-err">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <div class="field-top">
                        <label for="password_confirmation" class="f-lbl">Confirmar palavra-passe</label>
                    </div>
                    <div class="inp-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="f-input has-r" required placeholder="Repete a palavra-passe">
                        <button type="button" class="pw-btn" data-toggle="password_confirmation" aria-label="Mostrar palavra-passe">
                            <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-go">
                    Redefinir palavra-passe
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </form>

            <p class="fc-footer">Voltar ao <a href="{{ route('login') }}">login</a></p>
        </div>
    </main>

</div>
<script>
    document.querySelectorAll('.pw-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.toggle);
            var show  = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.querySelector('.eye-show').style.display = show ? 'none'  : 'block';
            btn.querySelector('.eye-hide').style.display = show ? 'block' : 'none';
        });
    });
</script>
</body>
</html>

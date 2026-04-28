<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="theme-color" content="#7c3aed">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
            background: #08070c;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
        }

        /* ══════════════════════════════
           LEFT — carousel side
        ══════════════════════════════ */
        .side-l {
            display: flex;
            flex-direction: column;
            padding: 36px 52px;
            position: relative;
            background: radial-gradient(ellipse at 28% 60%, rgba(130,70,255,0.30) 0%, transparent 58%);
        }

        .l-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-name {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .lang-sw {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
        }
        .lang-btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: rgba(255,255,255,0.35);
            background: none;
            border: none;
            border-radius: 5px;
            padding: 4px 10px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .lang-btn.active { background: rgba(255,255,255,0.11); color: #fff; }

        /* HERO / CAROUSEL */
        .l-hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .slide-tag {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
            transition: opacity 0.35s ease;
        }
        .slide-num {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,0.28);
            white-space: nowrap;
            letter-spacing: 0.02em;
        }
        .slide-num em { font-style: normal; color: #f97316; }
        .slide-rule {
            width: 44px;
            height: 1px;
            background: rgba(255,255,255,0.14);
            flex-shrink: 0;
        }
        .slide-lbl {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.28);
            white-space: nowrap;
        }

        .hero-heading {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: clamp(56px, 5.8vw, 76px);
            font-weight: 400;
            line-height: 1.08;
            color: rgba(255,255,255,0.88);
            margin-bottom: 22px;
            letter-spacing: -0.015em;
            transition: opacity 0.35s ease;
        }
        .hero-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.52);
            font-weight: 400;
            transition: opacity 0.35s ease;
        }

        /* FOOTER */
        .l-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .nav-pills {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .npill {
            height: 3px;
            border-radius: 99px;
            background: rgba(255,255,255,0.16);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .npill.active  { width: 26px; background: rgba(255,255,255,0.46); }
        .npill:not(.active) { width: 14px; }

        .copy {
            font-family: 'Syne', sans-serif;
            font-size: 11.5px;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.04em;
        }

        /* ══════════════════════════════
           RIGHT — form card
        ══════════════════════════════ */
        .side-r {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 52px 40px 32px;
        }

        .form-card {
            width: 100%;
            max-width: 390px;
            background: #0d0c12;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 36px 32px 32px;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            box-shadow: 0 0 0 1px rgba(165,107,255,0.06), 0 32px 72px rgba(0,0,0,0.5);
            animation: rise .5s ease .05s both;
        }

        .fc-title {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #f0ecff;
            letter-spacing: -0.045em;
            margin-bottom: 6px;
        }
        .fc-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.42);
            margin-bottom: 24px;
        }

        /* Google — dark */
        .btn-google {
            width: 100%;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.11);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #f0ecff;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            margin-bottom: 16px;
        }
        .btn-google:hover {
            background: rgba(255,255,255,0.11);
            border-color: rgba(255,255,255,0.18);
        }

        /* OR */
        .or-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .or-row::before, .or-row::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.09);
        }
        .or-row span {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.25);
            letter-spacing: 0.05em;
        }

        /* Success banner */
        .banner-ok {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(52,211,153,0.08);
            border: 1px solid rgba(52,211,153,0.22);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #34d399;
            margin-bottom: 14px;
        }

        /* Fields */
        .field { margin-bottom: 13px; }
        .field-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px;
        }
        .f-lbl {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.42);
        }
        .f-forgot {
            font-size: 13px;
            font-weight: 600;
            color: #a56bff;
            text-decoration: none;
            transition: color 0.15s;
        }
        .f-forgot:hover { color: #c084fc; }

        .inp-wrap { position: relative; }
        .f-input {
            width: 100%;
            height: 46px;
            padding: 0 15px;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.09);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #f0ecff;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            -webkit-appearance: none;
        }
        .f-input::placeholder { color: rgba(255,255,255,0.22); }
        .f-input:focus {
            outline: none;
            border-color: rgba(165,107,255,0.65);
            box-shadow: 0 0 0 3px rgba(165,107,255,0.12);
            background: rgba(255,255,255,0.08);
        }
        .f-input.is-err {
            border-color: rgba(248,113,113,0.7);
            box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
        }
        .f-input.has-r { padding-right: 44px; }

        .pw-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.3);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }
        .pw-btn:hover { color: rgba(255,255,255,0.7); }

        .f-err {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #f87171;
            margin-top: 5px;
        }

        /* Submit */
        .btn-go {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 45%, #7c3aed 100%);
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
            margin-bottom: 18px;
            box-shadow: 0 8px 28px rgba(165,107,255,0.38);
            transition: transform 0.15s, box-shadow 0.15s;
            letter-spacing: 0.01em;
        }
        .btn-go:hover  { transform: translateY(-1px); box-shadow: 0 12px 36px rgba(165,107,255,0.5); }
        .btn-go:active { transform: translateY(0); }

        .fc-footer {
            text-align: center;
            font-size: 13.5px;
            color: rgba(255,255,255,0.38);
        }
        .fc-footer a {
            color: #fff;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 2px;
            transition: color 0.15s;
        }
        .fc-footer a:hover { color: #c084fc; }

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            body { overflow: auto; }
            .layout { grid-template-columns: 1fr; height: auto; }
            .side-l  { display: none; }
            .side-r  { min-height: 100vh; padding: 40px 24px; }
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- ── LEFT — carousel ── --}}
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
            <div class="lang-sw">
                <button class="lang-btn active" type="button">PT</button>
                <button class="lang-btn" type="button">EN</button>
            </div>
        </nav>

        <div class="l-hero">
            <div class="slide-tag" id="slide-tag">
                <span class="slide-num"><em id="slide-n">01</em>/03</span>
                <span class="slide-rule"></span>
                <span class="slide-lbl" id="slide-lbl">Por que escolher Cardifys</span>
            </div>
            <h1 class="hero-heading" id="hero-heading">Card always<br>ready.</h1>
            <p class="hero-sub" id="hero-sub">Point the camera — contact saved.</p>
        </div>

        <footer class="l-footer">
            <div class="nav-pills" id="nav-pills">
                <span class="npill active" data-i="0"></span>
                <span class="npill" data-i="1"></span>
                <span class="npill" data-i="2"></span>
            </div>
            <span class="copy">© 2026 Cardifys</span>
        </footer>
    </aside>

    {{-- ── RIGHT — form ── --}}
    <main class="side-r">
        <div class="form-card">
            <h2 class="fc-title">Welcome back.</h2>
            <p class="fc-sub">Sign in to your account to continue.</p>

            <button type="button" class="btn-google">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span id="google-txt">Continue with Google</span>
            </button>

            <div class="or-row"><span id="or-txt">or</span></div>

            @if (session('success'))
                <div class="banner-ok">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <div class="field-top">
                        <label for="email" class="f-lbl" id="lbl-email">Email</label>
                    </div>
                    <input type="email" id="email" name="email"
                        class="f-input @error('email') is-err @enderror"
                        value="{{ old('email') }}" required autofocus
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
                        <label for="password" class="f-lbl" id="lbl-pass">Password</label>
                        <a href="{{ route('password.request') }}" class="f-forgot" id="lbl-forgot">Forgot?</a>
                    </div>
                    <div class="inp-wrap">
                        <input type="password" id="password" name="password"
                            class="f-input has-r @error('password') is-err @enderror"
                            required placeholder="••••••••">
                        <button type="button" class="pw-btn" id="pw-toggle" aria-label="Mostrar palavra-passe">
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

                <button type="submit" class="btn-go">
                    <span id="btn-submit-txt">Sign in</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </form>

            <p class="fc-footer"><span id="footer-txt">No account yet?</span> <a href="{{ route('register') }}" id="footer-link">Create one</a></p>
        </div>
    </main>

</div>
<script>
    /* ── PASSWORD TOGGLE ── */
    const pwBtn = document.getElementById('pw-toggle');
    const pwInp = document.getElementById('password');
    pwBtn.addEventListener('click', () => {
        const show = pwInp.type === 'password';
        pwInp.type = show ? 'text' : 'password';
        pwBtn.querySelector('.eye-show').style.display = show ? 'none'  : 'block';
        pwBtn.querySelector('.eye-hide').style.display = show ? 'block' : 'none';
    });

    /* ── TRANSLATIONS ── */
    const I18N = {
        pt: {
            fcTitle:    'Bem-vindo de volta.',
            fcSub:      'Inicia sessão para continuar.',
            googleBtn:  'Continuar com o Google',
            orTxt:      'ou',
            lblEmail:   'Email',
            lblPass:    'Palavra-passe',
            forgot:     'Esqueceu-se?',
            submit:     'Entrar',
            footerTxt:  'Ainda não tem conta?',
            footerLink: 'Criar conta',
            slides: [
                { n:'01', lbl:'Por que escolher Cardifys', h:'Card always<br>ready.',   s:'Aponta a câmara — contacto guardado.' },
                { n:'02', lbl:'Partilha instantânea',       h:'Partilha num<br>toque.', s:'Sem digitar — só digitalizar e ligar.' },
                { n:'03', lbl:'Sempre atualizado',          h:'Sempre em<br>dia.',      s:'Atualiza uma vez, todos veem a mudança.' },
            ],
        },
        en: {
            fcTitle:    'Welcome back.',
            fcSub:      'Sign in to your account to continue.',
            googleBtn:  'Continue with Google',
            orTxt:      'or',
            lblEmail:   'Email',
            lblPass:    'Password',
            forgot:     'Forgot?',
            submit:     'Sign in',
            footerTxt:  'No account yet?',
            footerLink: 'Create one',
            slides: [
                { n:'01', lbl:'Why choose Cardifys',  h:'Card always<br>ready.',  s:'Point the camera — contact saved.' },
                { n:'02', lbl:'Instant sharing',       h:'Share in<br>one tap.',  s:'No more typing — just scan and connect.' },
                { n:'03', lbl:'Always up to date',     h:'Stay always<br>fresh.', s:'Update once, everyone sees the change.' },
            ],
        },
    };

    /* ── CAROUSEL ── */
    const elTag  = document.getElementById('slide-tag');
    const elN    = document.getElementById('slide-n');
    const elLbl  = document.getElementById('slide-lbl');
    const elH    = document.getElementById('hero-heading');
    const elS    = document.getElementById('hero-sub');
    const pills  = document.querySelectorAll('.npill');
    let current  = 0;
    let lang     = localStorage.getItem('cardifys_lang') || 'pt';

    function goTo(i, instant) {
        const fadeEls = [elTag, elH, elS];
        if (!instant) fadeEls.forEach(el => el.style.opacity = '0');

        const apply = () => {
            const slide = I18N[lang].slides[i];
            elN.textContent   = slide.n;
            elLbl.textContent = slide.lbl;
            elH.innerHTML     = slide.h;
            elS.textContent   = slide.s;
            pills.forEach((p, j) => p.classList.toggle('active', j === i));
            fadeEls.forEach(el => el.style.opacity = '1');
            current = i;
        };

        instant ? apply() : setTimeout(apply, 350);
    }

    pills.forEach(p => p.addEventListener('click', () => goTo(+p.dataset.i)));
    setInterval(() => goTo((current + 1) % I18N[lang].slides.length), 4500);

    /* ── LANGUAGE SWITCHER ── */
    function applyLang(l) {
        lang = l;
        localStorage.setItem('cardifys_lang', l);
        const t = I18N[l];

        document.querySelectorAll('.lang-btn').forEach(b => {
            b.classList.toggle('active', b.textContent.toLowerCase() === l);
        });

        document.querySelector('.fc-title').textContent        = t.fcTitle;
        document.querySelector('.fc-sub').textContent          = t.fcSub;
        document.getElementById('google-txt').textContent      = t.googleBtn;
        document.getElementById('or-txt').textContent          = t.orTxt;
        document.getElementById('lbl-email').textContent       = t.lblEmail;
        document.getElementById('lbl-pass').textContent        = t.lblPass;
        document.getElementById('lbl-forgot').textContent      = t.forgot;
        document.getElementById('btn-submit-txt').textContent  = t.submit;
        document.getElementById('footer-txt').textContent      = t.footerTxt;
        document.getElementById('footer-link').textContent     = t.footerLink;

        goTo(current, true);
    }

    document.querySelectorAll('.lang-btn').forEach(b => {
        b.addEventListener('click', () => applyLang(b.textContent.toLowerCase()));
    });

    applyLang(lang);
</script>
</body>
</html>

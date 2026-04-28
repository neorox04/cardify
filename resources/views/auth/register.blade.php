<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Cardifys</title>
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
            background: #08070c;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ══════════════════════════════
           LEFT — carousel side
        ══════════════════════════════ */
        .side-l {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 36px 52px;
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
           RIGHT — form
        ══════════════════════════════ */
        .side-r {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 52px 40px 32px;
            min-height: 100vh;
        }

        .form-card {
            width: 100%;
            max-width: 460px;
            background: #0d0c12;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 32px 28px 28px;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            box-shadow: 0 0 0 1px rgba(165,107,255,0.06), 0 32px 72px rgba(0,0,0,0.5);
            animation: rise .5s ease .05s both;
        }

        .fc-title {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #f0ecff;
            letter-spacing: -0.045em;
            margin-bottom: 5px;
        }
        .fc-sub {
            font-size: 13.5px;
            color: rgba(255,255,255,0.38);
            margin-bottom: 20px;
        }
        .fc-sub a {
            color: #fff;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 2px;
            transition: color 0.15s;
        }
        .fc-sub a:hover { color: #c084fc; }

        /* Type selector */
        .type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 18px;
        }
        .type-card {
            background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(255,255,255,0.09);
            border-radius: 12px;
            padding: 11px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-align: left;
            transition: border-color 0.2s, background 0.2s;
        }
        .type-card:hover { border-color: rgba(255,255,255,0.15); }
        .type-card.is-on {
            border-color: rgba(165,107,255,0.65);
            background: rgba(165,107,255,0.08);
        }
        .tc-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(165,107,255,0.07);
            border: 1px solid rgba(165,107,255,0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.25);
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .type-card.is-on .tc-icon {
            background: rgba(165,107,255,0.18);
            border-color: rgba(165,107,255,0.35);
            color: #c084fc;
        }
        .tc-name {
            font-size: 13px;
            font-weight: 700;
            color: rgba(255,255,255,0.5);
            display: block;
            transition: color 0.2s;
        }
        .type-card.is-on .tc-name { color: #f0ecff; }
        .tc-desc { font-size: 11px; color: rgba(255,255,255,0.22); display: block; }

        /* Form grid */
        .fg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .fg-full { grid-column: 1 / -1; }

        /* Field */
        .field-lbl {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.40);
            margin-bottom: 6px;
        }
        .opt {
            font-weight: 500;
            font-size: 9.5px;
            text-transform: none;
            letter-spacing: normal;
            color: rgba(255,255,255,0.22);
            margin-left: 3px;
        }

        .inp-wrap { position: relative; }
        .inp-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.2);
            pointer-events: none;
            transition: color 0.15s;
        }
        .inp-wrap:focus-within .inp-ico { color: rgba(165,107,255,0.65); }

        .f-input, .f-select {
            width: 100%;
            height: 44px;
            padding: 0 13px 0 40px;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.09);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            color: #f0ecff;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            -webkit-appearance: none;
        }
        .f-input::placeholder { color: rgba(255,255,255,0.2); }
        .f-input:focus, .f-select:focus {
            outline: none;
            border-color: rgba(165,107,255,0.65);
            box-shadow: 0 0 0 3px rgba(165,107,255,0.12);
            background: rgba(255,255,255,0.07);
        }
        .f-input.is-err {
            border-color: rgba(248,113,113,0.7);
            box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
        }
        .f-input.has-r { padding-right: 40px; }

        .f-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            background-color: rgba(255,255,255,0.05);
            padding-right: 32px;
        }
        .f-select option { background: #0d0c12; color: #f0ecff; }

        .pw-btn {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.3);
            cursor: pointer;
            padding: 3px;
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
            margin-top: 4px;
        }
        .f-hint { font-size: 11px; color: rgba(255,255,255,0.25); margin-top: 4px; }

        /* Section separator */
        .sep { display: flex; align-items: center; gap: 8px; }
        .sep::before, .sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }
        .sep span {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.22);
            white-space: nowrap;
        }

        /* Logo upload */
        .logo-row { display: flex; align-items: center; gap: 12px; }
        .logo-thumb {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            flex-shrink: 0;
            border: 1.5px dashed rgba(165,107,255,0.25);
            background: rgba(255,255,255,0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: rgba(255,255,255,0.2);
        }
        .logo-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .logo-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 11px;
            border: 1.5px solid rgba(255,255,255,0.09);
            border-radius: 999px;
            background: rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
            margin-bottom: 4px;
        }
        .logo-upload-btn:hover { border-color: rgba(255,255,255,0.18); color: #f0ecff; }
        .logo-note { font-size: 10.5px; color: rgba(255,255,255,0.2); }

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
            box-shadow: 0 8px 28px rgba(165,107,255,0.38);
            transition: transform 0.15s, box-shadow 0.15s;
            letter-spacing: 0.01em;
        }
        .btn-go:hover  { transform: translateY(-1px); box-shadow: 0 12px 36px rgba(165,107,255,0.5); }
        .btn-go:active { transform: translateY(0); }

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .layout { grid-template-columns: 1fr; }
            .side-l { display: none; }
            .side-r { min-height: 100vh; padding: 40px 24px; }
            .fg { grid-template-columns: 1fr; }
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

    {{-- ── RIGHT — register form ── --}}
    <main class="side-r">
        <div class="form-card">
            <h2 class="fc-title" id="fc-title">Crie a sua conta.</h2>
            <p class="fc-sub"><span id="footer-txt">Já tem conta?</span> <a href="{{ route('login') }}" id="footer-link">Entrar</a></p>

            {{-- Type selector --}}
            <div class="type-grid">
                <button type="button" class="type-card is-on" id="btn-individual" onclick="setType('individual')">
                    <span class="tc-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </span>
                    <span class="tc-text">
                        <span class="tc-name" id="typ-ind-name">Individual</span>
                        <span class="tc-desc" id="typ-ind-desc">Profissional solo</span>
                    </span>
                </button>
                <button type="button" class="type-card" id="btn-company" onclick="setType('company')">
                    <span class="tc-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </span>
                    <span class="tc-text">
                        <span class="tc-name" id="typ-co-name">Empresa</span>
                        <span class="tc-desc" id="typ-co-desc">Para equipas</span>
                    </span>
                </button>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'individual') }}">

                <div class="fg">

                    {{-- Name --}}
                    <div class="field fg-full">
                        <label for="name" class="field-lbl" id="label-name">Nome completo</label>
                        <div class="inp-wrap">
                            <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></span>
                            <input type="text" id="name" name="name"
                                class="f-input @error('name') is-err @enderror"
                                value="{{ old('name') }}" required autofocus placeholder="João Silva">
                        </div>
                        <p class="f-hint" id="name-hint" style="display:none">O seu nome pessoal, não o da empresa.</p>
                        @error('name')
                            <span class="f-err">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Company separator --}}
                    <div class="sep fg-full company-only"><span id="sep-company">Empresa</span></div>

                    {{-- Company name + NIF --}}
                    <div class="field fg-full company-only" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="field">
                            <label for="company_name" class="field-lbl" id="lbl-company-name">Nome da empresa</label>
                            <div class="inp-wrap">
                                <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></span>
                                <input type="text" id="company_name" name="company_name"
                                    class="f-input @error('company_name') is-err @enderror"
                                    value="{{ old('company_name') }}" placeholder="Cardifys, Lda.">
                            </div>
                            @error('company_name')<span class="f-err">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="nif" class="field-lbl"><span id="lbl-nif">NIF</span> <span class="opt">(opcional)</span></label>
                            <div class="inp-wrap">
                                <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><line x1="9" y1="15" x2="12" y2="15"/></svg></span>
                                <input type="text" id="nif" name="nif"
                                    class="f-input @error('nif') is-err @enderror"
                                    value="{{ old('nif') }}" placeholder="PT123456789" maxlength="20">
                            </div>
                            @error('nif')<span class="f-err">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- Industry + Website --}}
                    <div class="field fg-full company-only" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="field">
                            <label for="industry" class="field-lbl"><span id="lbl-industry">Indústria</span> <span class="opt">(opcional)</span></label>
                            <div class="inp-wrap">
                                <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></span>
                                <select id="industry" name="industry" class="f-select">
                                    <option value="">Seleciona o setor</option>
                                    <option value="tecnologia"  {{ old('industry')==='tecnologia'  ?'selected':'' }}>Tecnologia</option>
                                    <option value="saude"       {{ old('industry')==='saude'       ?'selected':'' }}>Saúde</option>
                                    <option value="financas"    {{ old('industry')==='financas'    ?'selected':'' }}>Finanças & Banca</option>
                                    <option value="educacao"    {{ old('industry')==='educacao'    ?'selected':'' }}>Educação</option>
                                    <option value="retalho"     {{ old('industry')==='retalho'     ?'selected':'' }}>Retalho & E-commerce</option>
                                    <option value="imobiliario" {{ old('industry')==='imobiliario' ?'selected':'' }}>Imobiliário</option>
                                    <option value="construcao"  {{ old('industry')==='construcao'  ?'selected':'' }}>Construção</option>
                                    <option value="juridico"    {{ old('industry')==='juridico'    ?'selected':'' }}>Jurídico</option>
                                    <option value="marketing"   {{ old('industry')==='marketing'   ?'selected':'' }}>Marketing</option>
                                    <option value="media"       {{ old('industry')==='media'       ?'selected':'' }}>Media</option>
                                    <option value="logistica"   {{ old('industry')==='logistica'   ?'selected':'' }}>Logística</option>
                                    <option value="alimentacao" {{ old('industry')==='alimentacao' ?'selected':'' }}>Restauração</option>
                                    <option value="turismo"     {{ old('industry')==='turismo'     ?'selected':'' }}>Turismo</option>
                                    <option value="industria"   {{ old('industry')==='industria'   ?'selected':'' }}>Indústria</option>
                                    <option value="energia"     {{ old('industry')==='energia'     ?'selected':'' }}>Energia</option>
                                    <option value="outro"       {{ old('industry')==='outro'       ?'selected':'' }}>Outro</option>
                                </select>
                            </div>
                            @error('industry')<span class="f-err">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="website" class="field-lbl"><span id="lbl-website">Website</span> <span class="opt">(opcional)</span></label>
                            <div class="inp-wrap">
                                <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                                <input type="url" id="website" name="website"
                                    class="f-input @error('website') is-err @enderror"
                                    value="{{ old('website') }}" placeholder="https://empresa.pt">
                            </div>
                            @error('website')<span class="f-err">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div class="field fg-full company-only">
                        <label class="field-lbl">Logo <span class="opt">(opcional)</span></label>
                        <div class="logo-row">
                            <div class="logo-thumb" id="logo-thumb">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                            </div>
                            <div>
                                <label for="logo" class="logo-upload-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span id="logo-upload-txt">Carregar logo</span>
                                </label>
                                <input type="file" id="logo" name="logo" accept="image/*" style="display:none">
                                <p class="logo-note">PNG, JPG · máx. 2MB · 200×200px</p>
                            </div>
                        </div>
                        @error('logo')<span class="f-err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Access separator --}}
                    <div class="sep fg-full"><span id="sep-access">Acesso</span></div>

                    {{-- Email --}}
                    <div class="field fg-full">
                        <label for="email" class="field-lbl" id="lbl-email">Email</label>
                        <div class="inp-wrap">
                            <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>
                            <input type="email" id="email" name="email"
                                class="f-input @error('email') is-err @enderror"
                                value="{{ old('email') }}" required placeholder="nome@empresa.pt">
                        </div>
                        @error('email')
                            <span class="f-err">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="password" class="field-lbl" id="lbl-password">Palavra-passe</label>
                        <div class="inp-wrap">
                            <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                            <input type="password" id="password" name="password"
                                class="f-input has-r @error('password') is-err @enderror"
                                required placeholder="Mínimo 6 caracteres">
                            <button type="button" class="pw-btn" id="pw1" aria-label="Mostrar">
                                <svg class="eye-show" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="f-err">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Confirm password --}}
                    <div class="field">
                        <label for="password_confirmation" class="field-lbl" id="lbl-confirm">Confirmar</label>
                        <div class="inp-wrap">
                            <span class="inp-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="f-input has-r" required placeholder="Repetir">
                            <button type="button" class="pw-btn" id="pw2" aria-label="Mostrar">
                                <svg class="eye-show" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="fg-full" style="margin-top:4px;">
                        <button type="submit" class="btn-go">
                            <span id="btn-submit-txt">Criar conta grátis</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                    </div>

                </div>{{-- /fg --}}
            </form>
        </div>
    </main>

</div>
<script>
    /* ── TRANSLATIONS ── */
    const I18N = {
        pt: {
            fcTitle:    'Crie a sua conta.',
            footerTxt:  'Já tem conta?',
            footerLink: 'Entrar',
            typIndName: 'Individual',
            typIndDesc: 'Profissional solo',
            typCoName:  'Empresa',
            typCoDesc:  'Para equipas',
            lblNameInd: 'Nome completo',
            lblNameCo:  'Nome do responsável',
            nameHint:   'O seu nome pessoal, não o da empresa.',
            sepCompany: 'Empresa',
            lblCoName:  'Nome da empresa',
            lblNif:     'NIF',
            lblIndustry:'Indústria',
            lblWebsite: 'Website',
            logoUpload: 'Carregar logo',
            sepAccess:  'Acesso',
            lblEmail:   'Email',
            lblPass:    'Palavra-passe',
            lblConfirm: 'Confirmar',
            submit:     'Criar conta grátis',
            slides: [
                { n:'01', lbl:'Por que escolher Cardifys', h:'Card always<br>ready.',   s:'Aponta a câmara — contacto guardado.' },
                { n:'02', lbl:'Partilha instantânea',       h:'Partilha num<br>toque.', s:'Sem digitar — só digitalizar e ligar.' },
                { n:'03', lbl:'Sempre atualizado',          h:'Sempre em<br>dia.',      s:'Atualiza uma vez, todos veem a mudança.' },
            ],
        },
        en: {
            fcTitle:    'Create your account.',
            footerTxt:  'Already have one?',
            footerLink: 'Sign in',
            typIndName: 'Individual',
            typIndDesc: 'Solo professional',
            typCoName:  'Company',
            typCoDesc:  'For teams',
            lblNameInd: 'Full name',
            lblNameCo:  'Manager name',
            nameHint:   'Your personal name, not the company\'s.',
            sepCompany: 'Company',
            lblCoName:  'Company name',
            lblNif:     'Tax ID',
            lblIndustry:'Industry',
            lblWebsite: 'Website',
            logoUpload: 'Upload logo',
            sepAccess:  'Access',
            lblEmail:   'Email',
            lblPass:    'Password',
            lblConfirm: 'Confirm',
            submit:     'Create free account',
            slides: [
                { n:'01', lbl:'Why choose Cardifys',  h:'Card always<br>ready.',  s:'Point the camera — contact saved.' },
                { n:'02', lbl:'Instant sharing',       h:'Share in<br>one tap.',  s:'No more typing — just scan and connect.' },
                { n:'03', lbl:'Always up to date',     h:'Stay always<br>fresh.', s:'Update once, everyone sees the change.' },
            ],
        },
    };

    /* ── CAROUSEL ── */
    const elTag = document.getElementById('slide-tag');
    const elN   = document.getElementById('slide-n');
    const elLbl = document.getElementById('slide-lbl');
    const elH   = document.getElementById('hero-heading');
    const elS   = document.getElementById('hero-sub');
    const pills = document.querySelectorAll('.npill');
    let current     = 0;
    let lang        = localStorage.getItem('cardifys_lang') || 'pt';
    let currentType = document.getElementById('account_type').value || 'individual';

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

        document.getElementById('fc-title').textContent         = t.fcTitle;
        document.getElementById('footer-txt').textContent       = t.footerTxt;
        document.getElementById('footer-link').textContent      = t.footerLink;
        document.getElementById('typ-ind-name').textContent     = t.typIndName;
        document.getElementById('typ-ind-desc').textContent     = t.typIndDesc;
        document.getElementById('typ-co-name').textContent      = t.typCoName;
        document.getElementById('typ-co-desc').textContent      = t.typCoDesc;
        document.getElementById('sep-company').textContent      = t.sepCompany;
        document.getElementById('lbl-company-name').textContent = t.lblCoName;
        document.getElementById('lbl-nif').textContent          = t.lblNif;
        document.getElementById('lbl-industry').textContent     = t.lblIndustry;
        document.getElementById('lbl-website').textContent      = t.lblWebsite;
        document.getElementById('logo-upload-txt').textContent  = t.logoUpload;
        document.getElementById('sep-access').textContent       = t.sepAccess;
        document.getElementById('lbl-email').textContent        = t.lblEmail;
        document.getElementById('lbl-password').textContent     = t.lblPass;
        document.getElementById('lbl-confirm').textContent      = t.lblConfirm;
        document.getElementById('btn-submit-txt').textContent   = t.submit;

        const isCo = currentType === 'company';
        document.getElementById('label-name').textContent  = isCo ? t.lblNameCo : t.lblNameInd;
        document.getElementById('name-hint').textContent   = t.nameHint;

        goTo(current, true);
    }

    document.querySelectorAll('.lang-btn').forEach(b => {
        b.addEventListener('click', () => applyLang(b.textContent.toLowerCase()));
    });

    /* ── ACCOUNT TYPE ── */
    const accountTypeInput = document.getElementById('account_type');
    const coNameInput      = document.getElementById('company_name');

    function setType(type) {
        currentType = type;
        accountTypeInput.value = type;
        const isCo = type === 'company';

        document.getElementById('btn-individual').classList.toggle('is-on', !isCo);
        document.getElementById('btn-company').classList.toggle('is-on', isCo);
        if (coNameInput) coNameInput.required = isCo;

        const t = I18N[lang];
        document.getElementById('label-name').textContent  = isCo ? t.lblNameCo : t.lblNameInd;
        document.getElementById('name-hint').style.display = isCo ? 'block' : 'none';

        document.querySelectorAll('.company-only').forEach(el => {
            el.style.display = isCo ? '' : 'none';
            el.querySelectorAll('input, select, textarea').forEach(ctrl => {
                ctrl.disabled = !isCo;
            });
        });
    }

    setType(currentType);
    applyLang(lang);

    /* ── LOGO PREVIEW ── */
    document.getElementById('logo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.getElementById('logo-thumb');
            thumb.innerHTML = `<img src="${e.target.result}" alt="Logo">`;
        };
        reader.readAsDataURL(file);
    });

    /* ── PASSWORD TOGGLES ── */
    function makePwToggle(btnId, inputId) {
        const btn = document.getElementById(btnId);
        const inp = document.getElementById(inputId);
        if (!btn || !inp) return;
        btn.addEventListener('click', () => {
            const show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            btn.querySelector('.eye-show').style.display = show ? 'none'  : 'block';
            btn.querySelector('.eye-hide').style.display = show ? 'block' : 'none';
        });
    }
    makePwToggle('pw1', 'password');
    makePwToggle('pw2', 'password_confirmation');
</script>
</body>
</html>

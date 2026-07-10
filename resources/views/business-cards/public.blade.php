<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $businessCard->full_name }} · Cardifys</title>
    <meta name="description" content="{{ $businessCard->position ? $businessCard->position . ' — ' : '' }}{{ $businessCard->company ? $businessCard->company->name : '' }}">
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg:        oklch(0.15 0.012 290);
            --bg-2:      oklch(0.19 0.015 290);
            --bg-3:      oklch(0.23 0.018 290);
            --ink:       oklch(0.97 0.010 290);
            --ink-dim:   oklch(0.72 0.015 290);
            --ink-mute:  oklch(0.52 0.012 290);
            --line:      oklch(0.30 0.018 290 / 0.7);
            --line-soft: oklch(0.28 0.018 290 / 0.35);
            --purple:    oklch(0.72 0.19  300);
            --purple-deep: oklch(0.52 0.19 300);
            --green:     oklch(0.78 0.15 162);
        }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; min-height: 100vh; }
        body::before {
            content: ""; position: fixed; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 40% at 50% 0%, oklch(0.72 0.19 300 / 0.10), transparent 60%),
                radial-gradient(ellipse 50% 40% at 100% 100%, oklch(0.82 0.14 330 / 0.05), transparent 60%);
        }
        body::after {
            content: ""; position: fixed; inset: 0; pointer-events: none; opacity: 0.25;
            background-image:
                linear-gradient(to right, var(--line-soft) 1px, transparent 1px),
                linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 64px 64px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 30%, rgba(0,0,0,0.3), transparent 75%);
        }

        .wrap { position: relative; z-index: 1; max-width: 440px; margin: 0 auto; padding: 40px 20px 32px; }

        .vcard {
            background: var(--bg-2);
            border: 1px solid var(--line-soft);
            border-radius: 24px;
            padding: 34px 26px 26px;
            box-shadow: 0 24px 60px oklch(0 0 0 / 0.4);
            animation: rise .5s ease both;
        }
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        /* Profile */
        .profile { text-align: center; }
        .avatar-wrap { width: 96px; margin: 0 auto 16px; }
        .name { font-size: 23px; font-weight: 600; letter-spacing: -0.02em; }
        .position { font-size: 14px; color: var(--ink-dim); margin-top: 4px; }
        .company {
            display: inline-block; margin-top: 10px; padding: 4px 12px;
            background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.25);
            border-radius: 999px; font-size: 12px; font-weight: 500; color: var(--purple);
        }
        .bio { font-size: 14px; color: var(--ink-dim); line-height: 1.6; margin-top: 16px; }

        /* QR */
        .qr-section { margin: 24px 0 4px; text-align: center; }
        .qr-box {
            display: inline-block; padding: 12px; background: #fff; border-radius: 16px;
            box-shadow: 0 8px 24px oklch(0 0 0 / 0.35);
        }
        .qr-box img { display: block; width: 140px; height: 140px; }
        .qr-hint { font-size: 12px; color: var(--ink-mute); margin-top: 10px; }

        /* Divider */
        .divider { height: 1px; background: var(--line-soft); margin: 24px 0; }

        /* Contact rows */
        .contact { display: flex; flex-direction: column; gap: 4px; }
        .info-item {
            display: flex; align-items: center; gap: 13px; padding: 11px 12px;
            border-radius: 12px; text-decoration: none; color: var(--ink);
            transition: background .15s;
        }
        .info-item:hover { background: var(--bg-3); }
        .info-icon {
            width: 38px; height: 38px; flex-shrink: 0; border-radius: 10px;
            background: oklch(0.72 0.19 300 / 0.1); border: 1px solid oklch(0.72 0.19 300 / 0.2);
            display: flex; align-items: center; justify-content: center;
        }
        .info-icon svg { width: 18px; height: 18px; color: var(--purple); }
        .info-text { font-size: 14px; color: var(--ink); word-break: break-word; }
        .info-item .lbl { font-size: 11px; color: var(--ink-mute); display: block; margin-bottom: 1px; }

        /* Social */
        .social { display: flex; justify-content: center; gap: 12px; margin: 20px 0 4px; }
        .social a {
            width: 42px; height: 42px; border-radius: 12px;
            background: var(--bg-3); border: 1px solid var(--line-soft);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-dim); transition: all .15s;
        }
        .social a:hover { color: var(--purple); border-color: oklch(0.72 0.19 300 / 0.4); transform: translateY(-2px); }
        .social a svg { width: 20px; height: 20px; }

        /* Actions */
        .actions { display: flex; flex-direction: column; gap: 10px; margin-top: 24px; }
        .btn {
            display: flex; align-items: center; justify-content: center; gap: 9px;
            height: 50px; border-radius: 13px; font-size: 15px; font-weight: 600;
            text-decoration: none; transition: all .15s; cursor: pointer; border: none;
            font-family: inherit;
        }
        .btn svg { width: 18px; height: 18px; }
        .btn-primary {
            background: linear-gradient(135deg, oklch(0.75 0.19 300), oklch(0.6 0.19 300));
            color: #fff; box-shadow: 0 8px 24px oklch(0.72 0.19 300 / 0.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 30px oklch(0.72 0.19 300 / 0.45); }
        .btn-row { display: flex; gap: 10px; }
        .btn-row .btn { flex: 1; }
        .btn-ghost { background: var(--bg-3); border: 1px solid var(--line-soft); color: var(--ink); }
        .btn-ghost:hover { border-color: var(--line); background: oklch(0.26 0.018 290); }

        .powered {
            text-align: center; margin-top: 26px; font-size: 12px; color: var(--ink-mute);
        }
        .powered a { color: var(--ink-dim); font-weight: 600; text-decoration: none; }
        .powered a:hover { color: var(--purple); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="vcard">

            <div class="profile">
                <div class="avatar-wrap">
                    <x-avatar :name="$businessCard->full_name" :photo="$businessCard->avatar" :style="$businessCard->user?->avatar_style" :size="96" />
                </div>

                <h1 class="name">{{ $businessCard->full_name }}</h1>
                @if($businessCard->position)<p class="position">{{ $businessCard->position }}</p>@endif
                @if($businessCard->company)<span class="company">{{ $businessCard->company->name }}</span>@endif
                @if($businessCard->bio)<p class="bio">{{ $businessCard->bio }}</p>@endif
            </div>

            <div class="qr-section">
                <div class="qr-box">
                    @if(isset($isDemo))
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('card.demo')) }}" alt="QR Code">
                    @else
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('card.save', $businessCard)) }}" alt="QR Code">
                    @endif
                </div>
                <p class="qr-hint">Lê o QR Code para guardar o contacto</p>
            </div>

            <div class="divider"></div>

            <div class="contact">
                <a href="mailto:{{ $businessCard->email }}" class="info-item">
                    <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
                    <span class="info-text"><span class="lbl">Email</span>{{ $businessCard->email }}</span>
                </a>

                @if($businessCard->phone)
                    <a href="tel:{{ $businessCard->phone }}" class="info-item">
                        <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
                        <span class="info-text"><span class="lbl">Telefone</span>{{ $businessCard->phone }}</span>
                    </a>
                @endif

                @if($businessCard->mobile)
                    <a href="tel:{{ $businessCard->mobile }}" class="info-item">
                        <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></span>
                        <span class="info-text"><span class="lbl">Telemóvel</span>{{ $businessCard->mobile }}</span>
                    </a>
                @endif

                @if($businessCard->website)
                    <a href="{{ $businessCard->website }}" target="_blank" rel="noopener" class="info-item">
                        <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                        <span class="info-text"><span class="lbl">Website</span>{{ str_replace(['http://', 'https://'], '', $businessCard->website) }}</span>
                    </a>
                @endif

                @if($businessCard->address)
                    <div class="info-item">
                        <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                        <span class="info-text"><span class="lbl">Morada</span>{{ $businessCard->address }}</span>
                    </div>
                @endif
            </div>

            @if($businessCard->linkedin_url || $businessCard->twitter_url || $businessCard->instagram_url || $businessCard->github_url)
                <div class="social">
                    @if($businessCard->linkedin_url)
                        <a href="{{ $businessCard->linkedin_url }}" target="_blank" rel="noopener" title="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                    @endif
                    @if($businessCard->twitter_url)
                        <a href="{{ $businessCard->twitter_url }}" target="_blank" rel="noopener" title="Twitter/X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    @endif
                    @if($businessCard->instagram_url)
                        <a href="{{ $businessCard->instagram_url }}" target="_blank" rel="noopener" title="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    @endif
                    @if($businessCard->github_url)
                        <a href="{{ $businessCard->github_url }}" target="_blank" rel="noopener" title="GitHub"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
                    @endif
                </div>
            @endif

            <div class="actions">
                @if(isset($isDemo))
                    <a href="{{ route('card.demo.vcard') }}" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Guardar contacto
                    </a>
                @else
                    <a href="{{ route('card.vcard', $businessCard) }}" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Guardar contacto
                    </a>
                @endif

                <div class="btn-row">
                    @if($businessCard->phone)
                        <a href="tel:{{ $businessCard->phone }}" class="btn btn-ghost">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Ligar
                        </a>
                    @endif
                    <a href="mailto:{{ $businessCard->email }}" class="btn btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                    </a>
                </div>
            </div>

        </div>

        <p class="powered">Criado com <a href="{{ route('home') }}">Cardifys</a></p>
    </div>
</body>
</html>

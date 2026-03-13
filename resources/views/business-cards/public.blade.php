<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $businessCard->full_name }} - Cardify</title>
    <meta name="description" content="{{ $businessCard->position ? $businessCard->position . ' - ' : '' }}{{ $businessCard->company ? $businessCard->company->name : '' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-dark: #09090b;
            --bg-card: #18181b;
            --bg-card-hover: #27272a;
            --border: #27272a;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --text-muted: #71717a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 440px;
            margin: 0 auto;
        }

        .vcard {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
        }

        /* QR Code Section - Below Name */
        .qr-section {
            margin: 24px auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-container {
            background: white;
            border-radius: 16px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        #qrcode canvas {
            display: block;
        }

        .qr-hint {
            margin-top: 12px;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Profile Section */
        .profile-section {
            padding: 32px 32px 28px;
            text-align: center;
        }

        .profile-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 18px;
            object-fit: cover;
            border: 3px solid var(--border);
        }

        .profile-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 18px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            color: white;
        }

        .vcard-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .vcard-title {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .vcard-company {
            font-size: 14px;
            color: var(--primary);
            font-weight: 500;
        }

        .vcard-bio {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-muted);
            margin-top: 16px;
            padding: 0 8px;
        }

        /* Contact Info Section */
        .contact-section {
            padding: 0 24px 24px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: var(--bg-dark);
            border-radius: 12px;
            margin-bottom: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .info-item:hover {
            background: var(--bg-card-hover);
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 20px;
            height: 20px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .info-text {
            font-size: 14px;
            color: var(--text-primary);
        }

        /* Social Links */
        .social-section {
            padding: 0 24px 24px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-link {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
        }

        .social-link svg {
            width: 20px;
            height: 20px;
        }

        /* Action Buttons */
        .action-section {
            padding: 0 24px 28px;
        }

        .quick-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .btn-action {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-action svg {
            width: 18px;
            height: 18px;
        }

        .btn-call {
            background: #22c55e;
            color: white;
        }

        .btn-call:hover {
            background: #16a34a;
            transform: translateY(-1px);
        }

        .btn-email {
            background: var(--bg-dark);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-email:hover {
            background: var(--bg-card-hover);
            transform: translateY(-1px);
        }

        .btn-save {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            background: var(--primary);
            color: white;
        }

        .btn-save:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-save svg {
            width: 20px;
            height: 20px;
        }

        /* Powered by */
        .powered-by {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .powered-by a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .powered-by a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 20px 16px;
            }

            .profile-section {
                padding: 28px 24px 24px;
            }

            .vcard-name {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="vcard">
            <!-- Profile Section -->
            <div class="profile-section">
                @if($businessCard->avatar)
                    <img src="{{ Storage::url($businessCard->avatar) }}" alt="{{ $businessCard->full_name }}" class="profile-photo">
                @else
                    <div class="profile-placeholder">{{ substr($businessCard->full_name, 0, 1) }}</div>
                @endif

                <h1 class="vcard-name">{{ $businessCard->full_name }}</h1>
                
                @if($businessCard->position)
                    <p class="vcard-title">{{ $businessCard->position }}</p>
                @endif
                
                @if($businessCard->company)
                    <p class="vcard-company">{{ $businessCard->company->name }}</p>
                @endif

                <!-- QR Code Section - Below Name -->
                <div class="qr-section">
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('card.save', $businessCard)) }}" alt="QR Code" width="140" height="140">
                    </div>
                    <p class="qr-hint">Lê o QR Code para guardar o contacto</p>
                </div>

                @if($businessCard->bio)
                    <p class="vcard-bio">{{ $businessCard->bio }}</p>
                @endif
            </div>

            <!-- Contact Info Section -->
            <div class="contact-section">
                <a href="mailto:{{ $businessCard->email }}" class="info-item">
                    <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <span class="info-text">{{ $businessCard->email }}</span>
                </a>

                @if($businessCard->phone)
                    <a href="tel:{{ $businessCard->phone }}" class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span class="info-text">{{ $businessCard->phone }}</span>
                    </a>
                @endif

                @if($businessCard->mobile)
                    <a href="tel:{{ $businessCard->mobile }}" class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                            <line x1="12" y1="18" x2="12.01" y2="18"/>
                        </svg>
                        <span class="info-text">{{ $businessCard->mobile }}</span>
                    </a>
                @endif

                @if($businessCard->website)
                    <a href="{{ $businessCard->website }}" target="_blank" class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <span class="info-text">{{ str_replace(['http://', 'https://'], '', $businessCard->website) }}</span>
                    </a>
                @endif

                @if($businessCard->address)
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span class="info-text">{{ $businessCard->address }}</span>
                    </div>
                @endif
            </div>

            <!-- Social Links -->
            @if($businessCard->linkedin_url || $businessCard->twitter_url || $businessCard->instagram_url || $businessCard->github_url)
                <div class="social-section">
                    <div class="social-links">
                        @if($businessCard->linkedin_url)
                            <a href="{{ $businessCard->linkedin_url }}" target="_blank" class="social-link" title="LinkedIn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                        @if($businessCard->twitter_url)
                            <a href="{{ $businessCard->twitter_url }}" target="_blank" class="social-link" title="Twitter/X">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                        @endif
                        @if($businessCard->instagram_url)
                            <a href="{{ $businessCard->instagram_url }}" target="_blank" class="social-link" title="Instagram">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif
                        @if($businessCard->github_url)
                            <a href="{{ $businessCard->github_url }}" target="_blank" class="social-link" title="GitHub">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-section">
                <!-- Quick Actions: Call & Email -->
                <div class="quick-actions">
                    @if($businessCard->phone)
                        <a href="tel:{{ $businessCard->phone }}" class="btn-action btn-call">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            Ligar
                        </a>
                    @endif
                    <a href="mailto:{{ $businessCard->email }}" class="btn-action btn-email">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Email
                    </a>
                </div>
            </div>
        </div>

        <div class="powered-by">
            Criado com <a href="{{ route('home') }}">Cardify</a>
        </div>
    </div>
</body>
</html>

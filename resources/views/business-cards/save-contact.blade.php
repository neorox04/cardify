<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Contacto - {{ $businessCard->full_name }}</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="theme-color" content="#6366f1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-dark: #09090b;
            --bg-card: #18181b;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --success: #22c55e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text-primary);
        }

        .container {
            max-width: 380px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: pulse 2s infinite;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            margin-bottom: 20px;
        }

        .profile-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 700;
            color: white;
            margin: 0 auto 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .position {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .company {
            font-size: 14px;
            color: var(--primary);
            margin-bottom: 32px;
        }

        .message {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            margin-bottom: 12px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: #27272a;
        }

        .btn svg {
            width: 20px;
            height: 20px;
        }

        .powered-by {
            margin-top: 40px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .powered-by a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Auto-download notice */
        .auto-download {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .auto-download p {
            font-size: 14px;
            color: var(--success);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        @if($businessCard->avatar)
            <img src="{{ Storage::url($businessCard->avatar) }}" alt="{{ $businessCard->full_name }}" class="profile-photo">
        @else
            <div class="profile-placeholder">{{ substr($businessCard->full_name, 0, 1) }}</div>
        @endif

        <h1>{{ $businessCard->full_name }}</h1>
        
        @if($businessCard->position)
            <p class="position">{{ $businessCard->position }}</p>
        @endif
        
        @if($businessCard->company)
            <p class="company">{{ $businessCard->company->name }}</p>
        @endif

        <div class="auto-download">
            <p>📥 O contacto será transferido automaticamente</p>
            <div class="metrics" style="margin-top: 12px; color: #a1a1aa; font-size: 13px;">
                <span>👁️ Visualizações: {{ $businessCard->views_count ?? 0 }}</span> |
                <span>📱 QR Scans: {{ $businessCard->qr_scans ?? 0 }}</span> |
                <span>💾 Contacts Saved: {{ $businessCard->contacts_saved ?? 0 }}</span>
            </div>
        </div>

        <p class="message">
            Obrigado por guardar o meu contacto! Estou disponível para qualquer questão.
        </p>

        <a href="{{ route('card.vcard', $businessCard) }}" class="btn btn-primary" id="downloadBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Guardar Contacto
        </a>

        <a href="{{ route('card.public', $businessCard->slug) }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            Ver Cartão Completo
        </a>

        <div class="powered-by">
            Criado com <a href="{{ route('home') }}">Cardify</a>
        </div>
    </div>

    <script>
        // Auto-download vCard after a short delay
        setTimeout(function() {
            window.location.href = "{{ route('card.vcard', $businessCard) }}";
        }, 1500);
    </script>
</body>
</html>

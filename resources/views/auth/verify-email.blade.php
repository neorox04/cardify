<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica o teu Email - Cardify</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="theme-color" content="#6366f1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #09090b;
            --bg-secondary: #18181b;
            --bg-tertiary: #27272a;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --text-tertiary: #71717a;
            --border: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.15);
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --gradient-1: linear-gradient(135deg, #6366f1, #8b5cf6, #06b6d4);
            --radius-md: 12px;
            --radius-lg: 16px;
            --success: #10b981;
            --success-subtle: rgba(16, 185, 129, 0.1);
            --warning: #f59e0b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .container {
            width: 100%;
            max-width: 460px;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
            text-decoration: none;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
            text-align: center;
        }
        .icon-wrap {
            width: 72px;
            height: 72px;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
            letter-spacing: -0.3px;
        }
        p {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
        }
        .email-highlight {
            color: var(--text-primary);
            font-weight: 600;
        }
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 28px 0;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 13px;
            background: var(--gradient-1);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 12px;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.9; }
        .btn-ghost {
            display: block;
            width: 100%;
            padding: 13px;
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-ghost:hover {
            border-color: var(--border-hover);
            color: var(--text-primary);
        }
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        .alert-success {
            background: var(--success-subtle);
            border: 1px solid rgba(16,185,129,0.2);
            color: var(--success);
        }
        .note {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-top: 20px;
        }
        form { margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <rect x="2" y="5" width="20" height="14" rx="3" fill="white" fill-opacity="0.9"/>
                    <rect x="2" y="9" width="20" height="2" fill="#6366f1" fill-opacity="0.5"/>
                    <circle cx="7" cy="14" r="1.5" fill="#6366f1" fill-opacity="0.8"/>
                </svg>
            </div>
            <span class="logo-text">Cardify</span>
        </a>

        <div class="card">
            <div class="icon-wrap">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="1.5">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h1>Verifica o teu email</h1>
            <p>
                Enviámos um link de verificação para
                <span class="email-highlight">{{ auth()->user()->email }}</span>.
                Abre o email e clica no link para ativar a tua conta.
            </p>

            @if(session('success'))
                <hr class="divider">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <hr class="divider">

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn">Reenviar Email de Verificação</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-ghost">Sair da conta</button>
            </form>

            <p class="note">Não encontras o email? Verifica a pasta de spam ou lixo.</p>
        </div>
    </div>
</body>
</html>

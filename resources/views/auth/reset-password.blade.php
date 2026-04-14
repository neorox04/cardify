<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Password - Cardify</title>
    <link rel="icon" type="image/png" href="/icon-192.png">
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
            --gradient-1: linear-gradient(135deg, #6366f1, #8b5cf6, #06b6d4);
            --radius-md: 12px;
            --radius-lg: 16px;
            --error: #ef4444;
            --success: #10b981;
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
        .container { width: 100%; max-width: 420px; }
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
        .logo-text { font-size: 22px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px; }
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
        }
        h1 { font-size: 22px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.3px; }
        .subtitle { color: var(--text-secondary); font-size: 14px; margin-bottom: 28px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-secondary); margin-bottom: 6px; }
        input {
            width: 100%;
            padding: 11px 14px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        input:focus { border-color: var(--accent); }
        .form-group { margin-bottom: 20px; }
        .btn {
            width: 100%;
            padding: 13px;
            background: var(--gradient-1);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 4px;
            transition: opacity 0.2s;
            font-family: inherit;
        }
        .btn:hover { opacity: 0.9; }
        .error { color: var(--error); font-size: 13px; margin-top: 6px; }
        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.2);
            color: var(--error);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 20px;
        }
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
            <h1>Nova password</h1>
            <p class="subtitle">Escolhe uma nova password para a tua conta.</p>

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required autofocus>
                    @error('email')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Nova password</label>
                    <input type="password" id="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres">
                    @error('password')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repete a password">
                </div>

                <button type="submit" class="btn">Redefinir Password</button>
            </form>
        </div>
    </div>
</body>
</html>

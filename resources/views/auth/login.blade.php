<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Cardify</title>
    <meta name="theme-color" content="#6366f1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Cardify">
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/icon.svg">
    <link rel="manifest" href="/manifest.json">
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
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --error: #ef4444;
            --success: #10b981;
        }

        [data-theme="light"] {
            --bg-primary: #fafafa;
            --bg-secondary: #f0f0f3;
            --bg-tertiary: #e8e8ec;
            --text-primary: #09090b;
            --text-secondary: #52525b;
            --text-tertiary: #71717a;
            --border: rgba(0, 0, 0, 0.08);
            --border-hover: rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .auth-container {
            width: 100%;
            max-width: 400px;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 28px;
            font-weight: 800;
            text-decoration: none;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            font-size: 15px;
            color: var(--text-secondary);
        }

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            font-family: inherit;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .form-input::placeholder {
            color: var(--text-tertiary);
        }

        .form-input:hover {
            border-color: var(--border-hover);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .error-message {
            color: var(--error);
            font-size: 13px;
            margin-top: 8px;
            font-weight: 500;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 14px;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--accent-hover);
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            color: var(--accent-hover);
        }

        .theme-toggle {
            position: fixed;
            top: 24px;
            right: 24px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .theme-toggle svg {
            width: 18px;
            height: 18px;
        }

        .theme-toggle .sun { display: none; }
        .theme-toggle .moon { display: block; }
        [data-theme="light"] .theme-toggle .sun { display: block; }
        [data-theme="light"] .theme-toggle .moon { display: none; }
    </style>
</head>
<body>
    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
        <svg class="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <svg class="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <div class="auth-container">
        <div class="auth-brand">
            <a href="/" class="logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#06b6d4"/>
                            <stop offset="100%" style="stop-color:#6366f1"/>
                        </linearGradient>
                    </defs>
                    <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14c2.5 0 4.5-0.5 6.5-1.5" stroke="url(#logoGradient)" stroke-width="3" stroke-linecap="round" fill="none"/>
                    <path d="M22 8l4 4-4 4" stroke="url(#logoGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
                Cardify
            </a>
        </div>

        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Bem-vindo de volta</h1>
                <p class="auth-subtitle">Entre na sua conta para continuar</p>
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') error @enderror"
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="nome@empresa.pt"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Palavra-passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') error @enderror"
                        required
                        placeholder="Introduza a sua palavra-passe"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" class="checkbox">
                        <label for="remember">Manter sessão</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Esqueceu-se?</a>
                </div>

                <button type="submit" class="btn btn-primary">
                    Entrar
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </form>
        </div>

        <div class="auth-footer">
            Ainda não tem conta? <a href="{{ route('register') }}">Criar conta grátis</a>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        
        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-theme', savedTheme);
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>

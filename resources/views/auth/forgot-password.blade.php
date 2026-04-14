<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Password - Cardify</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066FF;
            --primary-dark: #0052CC;
            --neutral-50: #FAFAFA;
            --neutral-100: #F5F5F5;
            --neutral-200: #E5E5E5;
            --neutral-300: #D4D4D4;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-900: #171717;
            --error: #EF4444;
            --success: #10B981;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Onest', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--neutral-50);
            color: var(--neutral-900);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            padding: 24px;
        }

        .auth-card {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 48px 40px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--neutral-600);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 32px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--neutral-900);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .auth-subtitle {
            font-size: 15px;
            color: var(--neutral-600);
        }

        .success-message {
            background: #F0FDF4;
            border: 1px solid #86EFAC;
            color: #166534;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 1.5px solid var(--neutral-300);
            border-radius: var(--radius-md);
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-input:hover {
            border-color: var(--neutral-400);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            margin-bottom: 24px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.24);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .auth-link {
            text-align: center;
            font-size: 14px;
            color: var(--neutral-600);
        }

        .auth-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <a href="{{ route('login') }}" class="back-link">
                ← Voltar ao login
            </a>

            <div class="auth-header">
                <div class="logo">DBsCard</div>
                <h1 class="auth-title">Recuperar palavra-passe</h1>
                <p class="auth-subtitle">Enviaremos um link de recuperação para o seu email</p>
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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

                <button type="submit" class="btn btn-primary">
                    Enviar Link de Recuperação
                </button>
            </form>

            <div class="auth-link">
                Lembrou-se da palavra-passe? <a href="{{ route('login') }}">Entrar</a>
            </div>
        </div>
    </div>
</body>
</html>
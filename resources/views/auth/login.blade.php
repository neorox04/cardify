<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - DBsCard</title>
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

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            font-size: 14px;
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
            gap: 8px;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--neutral-300);
            border-radius: 4px;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 14px;
            color: var(--neutral-700);
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
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

            .form-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">DBsCard</div>
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
                        <label for="remember">Manter sessão iniciada</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Esqueci-me</a>
                </div>

                <button type="submit" class="btn btn-primary">
                    Entrar
                </button>
            </form>

            <div class="auth-link">
                Ainda não tem conta? <a href="{{ route('register') }}">Criar conta grátis</a>
            </div>
        </div>
    </div>
</body>
</html>
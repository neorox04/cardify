<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - DBsCard</title>
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

        .form-hint {
            font-size: 13px;
            color: var(--neutral-500);
            margin-top: 6px;
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
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">DBsCard</div>
                <h1 class="auth-title">Criar conta grátis</h1>
                <p class="auth-subtitle">Comece a modernizar o seu networking hoje</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nome completo</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input @error('name') error @enderror"
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        placeholder="João Silva"
                    >
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') error @enderror"
                        value="{{ old('email') }}" 
                        required
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
                        placeholder="Mínimo 6 caracteres"
                    >
                    <div class="form-hint">Use pelo menos 6 caracteres</div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar palavra-passe</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input"
                        required
                        placeholder="Repita a palavra-passe"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Criar Conta
                </button>
            </form>

            <div class="auth-link">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </div>
        </div>
    </div>
</body>
</html>
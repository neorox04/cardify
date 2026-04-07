<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Legal') - Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #09090b;
            color: #fafafa;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .legal-header {
            width: 100%;
            padding: 32px 0 24px 0;
            text-align: center;
        }
        .legal-header a {
            color: #6366f1;
            font-size: 2.2rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 2px;
            transition: color 0.2s;
        }
        .legal-header a:hover {
            color: #818cf8;
        }
        .legal-content {
            max-width: 700px;
            margin: 0 auto;
            background: #18181b;
            border-radius: 16px;
            padding: 40px 32px 32px 32px;
            box-shadow: 0 4px 32px 0 rgba(0,0,0,0.18);
            margin-bottom: 48px;
        }
        .legal-content h1, .legal-content h2 {
            text-align: center;
        }
        .legal-content ul {
            margin-left: 0;
            padding-left: 1.2em;
        }
        .legal-content p, .legal-content li {
            text-align: center;
        }
        @media (max-width: 600px) {
            .legal-content {
                padding: 24px 8px;
            }
            .legal-header {
                padding: 24px 0 16px 0;
            }
        }
    </style>
</head>
<body>
    <div class="legal-header">
        <a href="{{ route('welcome') }}">Cardifys</a>
        @auth
            <div style="margin-top:16px;display:flex;justify-content:center;align-items:center;gap:16px;">
                <span style="color:#a5b4fc;font-size:1.1rem;font-weight:600;">Bem-vindo {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="background:#18181b;color:#fff;border:1px solid #6366f1;padding:8px 20px;border-radius:8px;font-weight:600;cursor:pointer;">Logout</button>
                </form>
            </div>
        @endauth
    </div>
    <div class="legal-content">
        @yield('content')
    </div>
</body>
</html>

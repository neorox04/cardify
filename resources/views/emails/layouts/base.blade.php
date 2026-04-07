<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $subject ?? 'Cardify' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #09090b;
            color: #fafafa;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: #fafafa;
            letter-spacing: -0.5px;
        }
        .card {
            background: #18181b;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 24px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #fafafa;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        h2 {
            font-size: 18px;
            font-weight: 600;
            color: #fafafa;
            margin-bottom: 8px;
        }
        p {
            color: #a1a1aa;
            font-size: 15px;
            margin-bottom: 16px;
        }
        p:last-child { margin-bottom: 0; }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            margin: 24px 0;
            text-align: center;
        }
        .btn-outline {
            display: inline-block;
            padding: 12px 24px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.15);
            color: #fafafa !important;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
        }
        .btn-center {
            text-align: center;
            margin: 28px 0;
        }
        .divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 28px 0;
        }
        .info-box {
            background: rgba(99,102,241,0.08);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .info-box p { color: #a1a1aa; margin: 0; font-size: 14px; }
        .warning-box {
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .warning-box p { color: #d97706; margin: 0; font-size: 14px; }
        .success-box {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .success-box p { color: #10b981; margin: 0; font-size: 14px; }
        .url-box {
            background: #27272a;
            border-radius: 8px;
            padding: 12px 16px;
            word-break: break-all;
            font-size: 13px;
            color: #6366f1;
            margin: 16px 0;
            font-family: monospace;
        }
        .footer {
            text-align: center;
            padding-top: 8px;
        }
        .footer p {
            font-size: 13px;
            color: #52525b;
            margin-bottom: 8px;
        }
        .footer a { color: #6366f1; text-decoration: none; }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(99,102,241,0.15);
            color: #818cf8;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        @media only screen and (max-width: 600px) {
            .card { padding: 28px 20px; }
            h1 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <span class="logo">
                <span class="logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="5" width="20" height="14" rx="3" fill="white" fill-opacity="0.9"/>
                        <rect x="2" y="9" width="20" height="2" fill="#6366f1" fill-opacity="0.5"/>
                        <circle cx="7" cy="14" r="1.5" fill="#6366f1" fill-opacity="0.8"/>
                    </svg>
                </span>
                <span class="logo-text">Cardify</span>
            </span>
        </div>

        <div class="card">
            @yield('content')
        </div>

        <div class="footer">
            <p>Recebeste este email porque tens uma conta no <strong style="color:#71717a">Cardify</strong>.</p>
            <p>Se não reconheces esta atividade, podes ignorar este email.</p>
            <p style="margin-top:12px">
                &copy; {{ date('Y') }} Cardify &mdash; Cartões de Visita Digitais
            </p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="pt" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="dark">
    <meta name="supported-color-schemes" content="dark">
    <title>{{ $subject ?? 'Cardifys' }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #0b0a12; -webkit-font-smoothing: antialiased; }
        table { border-collapse: collapse; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; }
        a { text-decoration: none; }

        .email-font { font-family: 'Geist', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }

        h1 { font-size: 24px; font-weight: 700; color: #f4f1fb; margin: 0 0 12px; letter-spacing: -0.4px; line-height: 1.25; }
        h2 { font-size: 17px; font-weight: 600; color: #f4f1fb; margin: 0 0 8px; letter-spacing: -0.2px; }
        p  { color: #a7a3b3; font-size: 15px; line-height: 1.65; margin: 0 0 16px; }
        p:last-child { margin-bottom: 0; }
        strong { color: #f4f1fb; }

        .badge { display: inline-block; padding: 5px 12px; background: rgba(184,132,255,0.14); color: #c9a6ff; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 18px; }

        .btn { display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #a56bff 0%, #7c3aed 100%); background-color: #7c3aed; color: #ffffff !important; border-radius: 12px; font-weight: 700; font-size: 15px; letter-spacing: 0.2px; }
        .btn-center { text-align: center; margin: 28px 0 8px; }

        .divider { border: none; border-top: 1px solid rgba(255,255,255,0.08); margin: 28px 0; }

        .info-box { background: rgba(184,132,255,0.07); border: 1px solid rgba(184,132,255,0.2); border-radius: 12px; padding: 15px 18px; margin: 20px 0; }
        .info-box p { color: #b9b4c7; margin: 0; font-size: 14px; }
        .warning-box { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.22); border-radius: 12px; padding: 15px 18px; margin: 20px 0; }
        .warning-box p { color: #e0a43a; margin: 0; font-size: 14px; }
        .success-box { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.22); border-radius: 12px; padding: 15px 18px; margin: 20px 0; }
        .success-box p { color: #4ade9f; margin: 0; font-size: 14px; }

        .url-box { background: #201d29; border: 1px solid rgba(255,255,255,0.06); border-radius: 9px; padding: 12px 16px; word-break: break-all; font-size: 13px; color: #c9a6ff; margin: 14px 0; font-family: 'Geist Mono', ui-monospace, SFMono-Regular, Menlo, monospace; }

        @media only screen and (max-width: 600px) {
            .card-pad { padding: 28px 22px !important; }
            h1 { font-size: 21px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#0b0a12;">
    <!-- Preheader (hidden) -->
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $subject ?? 'Cardifys — cartões de visita digitais' }}</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0b0a12;">
        <tr>
            <td align="center" style="padding:40px 20px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

                    <!-- Header / brand -->
                    <tr>
                        <td align="center" style="padding-bottom:28px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <div style="width:38px;height:38px;background:linear-gradient(135deg,#a56bff,#7c3aed);background-color:#7c3aed;border-radius:10px;text-align:center;">
                                            <span class="email-font" style="color:#ffffff;font-size:20px;font-weight:800;line-height:38px;">C</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;padding-left:11px;">
                                        <span class="email-font" style="font-size:19px;font-weight:700;color:#f4f1fb;letter-spacing:-0.3px;">Cardifys</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content card -->
                    <tr>
                        <td class="card-pad email-font" style="background:#17151f;border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:40px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-font" style="text-align:center;padding:24px 12px 0;">
                            <p style="font-size:13px;color:#615d6e;margin:0 0 6px;">Recebeste este email porque tens uma conta na <strong style="color:#8b8797;">Cardifys</strong>.</p>
                            <p style="font-size:13px;color:#615d6e;margin:0 0 12px;">Se não reconheces esta atividade, podes ignorar este email.</p>
                            <p style="font-size:12px;color:#4c4956;margin:0;">
                                &copy; {{ date('Y') }} Cardifys &mdash; Cartões de visita digitais
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

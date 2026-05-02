<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardifys para Empresas — Plano Empresas</title>
    <link rel="icon" type="image/png" href="/icon-192.png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="theme-color" content="#9b6dff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #09090b;
            --panel: #141418;
            --panel-2: #1a1a20;
            --text: #f5f5f7;
            --muted: #a1a1aa;
            --line: #2a2a32;
            --purple: #b08cff;
            --purple-2: #9b6dff;
            --success: #22c55e;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Geist', system-ui, sans-serif;
            background: radial-gradient(circle at 10% 5%, rgba(176,140,255,0.12), transparent 35%), var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 24px;
        }
        .container { max-width: 1100px; margin: 0 auto; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
            gap: 12px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
        }
        .brand .mark {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: #070915;
            box-shadow: 0 0 0 1px rgba(176,140,255,.5), 0 8px 20px rgba(176,140,255,.18);
            overflow: hidden;
        }
        .brand .mark img { width: 100%; height: 100%; display: block; }
        .actions { display: flex; gap: 10px; }
        .btn {
            border: 1px solid var(--line);
            background: var(--panel);
            color: var(--text);
            border-radius: 12px;
            padding: 10px 14px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }
        .btn.primary {
            background: linear-gradient(135deg, var(--purple), var(--purple-2));
            border: none;
            color: #120b22;
        }

        /* Hero */
        .hero {
            text-align: center;
            padding: 48px 0 40px;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(176,140,255,0.12);
            border: 1px solid rgba(176,140,255,0.25);
            color: var(--purple);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 16px;
        }
        .hero h1 span { color: var(--purple); }
        .hero p {
            color: var(--muted);
            font-size: 17px;
            max-width: 580px;
            margin: 0 auto 28px;
            line-height: 1.6;
        }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .hero-actions a {
            border-radius: 14px;
            padding: 13px 24px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
        }
        .hero-actions .cta-primary {
            background: linear-gradient(135deg, var(--purple), var(--purple-2));
            color: #120b22;
        }
        .hero-actions .cta-ghost {
            border: 1px solid var(--line);
            background: var(--panel);
            color: var(--text);
        }

        /* Pricing highlight */
        .pricing-highlight {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        .price-card {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 28px 32px;
            text-align: center;
            flex: 1;
            min-width: 220px;
            max-width: 280px;
        }
        .price-card.featured {
            border-color: rgba(176,140,255,.55);
            box-shadow: 0 20px 45px rgba(176,140,255,.14);
        }
        .price-card .label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 12px;
        }
        .price-card .amount {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .price-card .amount small {
            font-size: 15px;
            color: var(--muted);
            font-weight: 500;
        }
        .price-card .note {
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
        }

        /* Features grid */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin-bottom: 48px;
        }
        .feature-item {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 22px;
        }
        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .feature-item h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .feature-item p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        /* Contact form */
        .form-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 48px;
            align-items: start;
        }
        @media (max-width: 760px) { .form-section { grid-template-columns: 1fr; } }

        .form-info h2 { font-size: 26px; font-weight: 700; margin-bottom: 12px; }
        .form-info p { color: var(--muted); line-height: 1.6; margin-bottom: 20px; }
        .contact-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 10px;
        }
        .contact-detail span:first-child { font-size: 18px; }

        .form-box {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 32px;
        }
        .form-box h3 { font-size: 18px; font-weight: 700; margin-bottom: 24px; }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Geist', system-ui, sans-serif;
            font-size: 14px;
            padding: 10px 14px;
            transition: border-color .15s;
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: rgba(176,140,255,.5);
        }
        .form-group select option { background: #141418; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--purple), var(--purple-2));
            color: #120b22;
            border: none;
            border-radius: 14px;
            padding: 13px 20px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Geist', system-ui, sans-serif;
            margin-top: 6px;
        }
        .submit-btn:hover { opacity: .9; }

        /* Alert */
        .alert {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .alert.success {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            color: #4ade80;
        }
        .alert.error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 13px;
        }
        .footer a { color: var(--purple); text-decoration: none; }
    </style>
</head>
<body>
<div class="container">

    <div class="topbar">
        <a href="{{ route('home') }}" class="brand">
            <span class="mark"><img src="/icon.svg" alt="Cardifys"></span>
            <span>Cardifys</span>
        </a>
        <div class="actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn">Entrar</a>
                <a href="{{ route('register') }}" class="btn primary">Criar conta</a>
            @endauth
        </div>
    </div>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-badge">Plano Empresas</div>
        <h1>Cartões digitais para<br><span>toda a tua equipa</span></h1>
        <p>Gestão centralizada, branding corporativo unificado e analytics por equipa. Escala com a tua empresa.</p>
        <div class="hero-actions">
            <a href="#contacto" class="cta-primary">Falar com a equipa</a>
            <a href="{{ route('subscriptions.plans') }}" class="cta-ghost">Ver todos os planos</a>
        </div>
    </section>

    <!-- Pricing -->
    <div class="pricing-highlight">
        <div class="price-card">
            <div class="label">Setup único</div>
            <div class="amount">50€ <small></small></div>
            <div class="note">Configuração inicial da empresa</div>
        </div>
        <div class="price-card featured">
            <div class="label">Por colaborador</div>
            <div class="amount">1€ <small>/mês</small></div>
            <div class="note">Sem limite de colaboradores</div>
        </div>
        <div class="price-card">
            <div class="label">Exemplo — 50 pessoas</div>
            <div class="amount">50€ <small>/mês</small></div>
            <div class="note">+ 50€ setup (apenas uma vez)</div>
        </div>
    </div>

    <!-- Features -->
    <section style="margin-bottom: 48px;">
        <h2 class="section-title">O que está incluído</h2>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">🏢</div>
                <h3>Painel de administração</h3>
                <p>Gere todos os colaboradores, cartões e permissões num único lugar.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🎨</div>
                <h3>Branding corporativo</h3>
                <p>Logo e cores da empresa aplicados automaticamente em todos os cartões da equipa.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">👥</div>
                <h3>Colaboradores ilimitados</h3>
                <p>Convida quantos colaboradores precisares. Pagas apenas 1€ por pessoa por mês.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📊</div>
                <h3>Analytics por equipa</h3>
                <p>Relatórios consolidados de visualizações e interações de todos os cartões.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">⚡</div>
                <h3>Suporte prioritário</h3>
                <p>Acesso direto à nossa equipa com resposta garantida em menos de 24h.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔌</div>
                <h3>Acesso à API</h3>
                <p>Integra o Cardifys com os teus sistemas internos via API REST.</p>
            </div>
        </div>
    </section>

    <!-- Contact section -->
    <section class="form-section" id="contacto">
        <div class="form-info">
            <h2>Vamos conversar</h2>
            <p>Conta-nos um pouco sobre a tua empresa e entraremos em contacto em menos de 24 horas para agendar uma demonstração.</p>
            <div class="contact-detail">
                <span>✉️</span>
                <span>hello@cardifys.com</span>
            </div>
            <div class="contact-detail">
                <span>⏱️</span>
                <span>Resposta em menos de 24h</span>
            </div>
            <div class="contact-detail">
                <span>🎯</span>
                <span>Demo personalizada incluída</span>
            </div>
        </div>

        <div class="form-box">
            <h3>Pede uma demonstração</h3>

            @if(session('enterprise_success'))
                <div class="alert success">
                    ✓ Mensagem enviada! Entraremos em contacto em breve.
                </div>
            @endif

            @if(session('enterprise_error'))
                <div class="alert error">
                    Erro ao enviar. Por favor tenta de novo ou escreve-nos diretamente para hello@cardifys.com.
                </div>
            @endif

            <form method="POST" action="{{ route('enterprise.contact') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Nome *</label>
                        <input type="text" name="name" required placeholder="O teu nome" value="{{ old('name') }}">
                        @error('name')<span style="color:#f87171;font-size:12px;">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Empresa *</label>
                        <input type="text" name="company" required placeholder="Nome da empresa" value="{{ old('company') }}">
                        @error('company')<span style="color:#f87171;font-size:12px;">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Email profissional *</label>
                    <input type="email" name="email" required placeholder="tu@empresa.com" value="{{ old('email') }}">
                    @error('email')<span style="color:#f87171;font-size:12px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Número de colaboradores *</label>
                    <select name="employees" required>
                        <option value="" disabled {{ old('employees') ? '' : 'selected' }}>Seleciona um intervalo</option>
                        <option value="1-10" {{ old('employees') == '1-10' ? 'selected' : '' }}>1 – 10</option>
                        <option value="11-50" {{ old('employees') == '11-50' ? 'selected' : '' }}>11 – 50</option>
                        <option value="51-200" {{ old('employees') == '51-200' ? 'selected' : '' }}>51 – 200</option>
                        <option value="201-500" {{ old('employees') == '201-500' ? 'selected' : '' }}>201 – 500</option>
                        <option value="500+" {{ old('employees') == '500+' ? 'selected' : '' }}>Mais de 500</option>
                    </select>
                    @error('employees')<span style="color:#f87171;font-size:12px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Mensagem (opcional)</label>
                    <textarea name="message" placeholder="Conta-nos o que procuras...">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="submit-btn">Enviar pedido →</button>
            </form>
        </div>
    </section>

    <div class="footer">
        <p><a href="{{ route('subscriptions.plans') }}">← Ver todos os planos</a> &nbsp;•&nbsp; <a href="{{ route('home') }}">Início</a></p>
    </div>

</div>
</body>
</html>

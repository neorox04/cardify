<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardifys para Empresas — Pricing por Seats</title>
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

        /* Topbar */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px; gap: 12px; }
        .brand { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text); font-weight: 600; }
        .brand .mark { width: 30px; height: 30px; border-radius: 9px; background: #070915; box-shadow: 0 0 0 1px rgba(176,140,255,.5), 0 8px 20px rgba(176,140,255,.18); overflow: hidden; }
        .brand .mark img { width: 100%; height: 100%; display: block; }
        .actions { display: flex; gap: 10px; }
        .btn { border: 1px solid var(--line); background: var(--panel); color: var(--text); border-radius: 12px; padding: 10px 14px; text-decoration: none; font-size: 14px; font-weight: 600; }
        .btn.primary { background: linear-gradient(135deg, var(--purple), var(--purple-2)); border: none; color: #120b22; }

        /* Hero */
        .hero { text-align: center; padding: 48px 0 40px; }
        .hero-badge { display: inline-block; background: rgba(176,140,255,0.12); border: 1px solid rgba(176,140,255,0.25); color: var(--purple); font-size: 12px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; padding: 5px 14px; border-radius: 999px; margin-bottom: 20px; }
        .hero h1 { font-size: clamp(32px, 5vw, 52px); font-weight: 700; line-height: 1.1; margin-bottom: 16px; }
        .hero h1 span { color: var(--purple); }
        .hero p { color: var(--muted); font-size: 17px; max-width: 580px; margin: 0 auto 28px; line-height: 1.6; }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .hero-actions a { border-radius: 14px; padding: 13px 24px; font-size: 15px; font-weight: 700; text-decoration: none; }
        .cta-primary { background: linear-gradient(135deg, var(--purple), var(--purple-2)); color: #120b22; }
        .cta-ghost { border: 1px solid var(--line); background: var(--panel); color: var(--text); }

        /* Calculator */
        .calc-section { background: linear-gradient(180deg, var(--panel), var(--panel-2)); border: 1px solid rgba(176,140,255,.4); border-radius: 24px; padding: 36px; margin-bottom: 40px; box-shadow: 0 20px 45px rgba(176,140,255,.10); }
        .calc-section h2 { font-size: 20px; font-weight: 700; margin-bottom: 6px; }
        .calc-section > p { color: var(--muted); font-size: 14px; margin-bottom: 28px; }

        .calc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start; }
        @media (max-width: 680px) { .calc-grid { grid-template-columns: 1fr; } }

        .slider-label { font-size: 13px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .07em; margin-bottom: 14px; }
        .slider-row { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        .seat-btn { width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--line); background: rgba(255,255,255,0.05); color: var(--text); font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; line-height: 1; font-family: inherit; }
        .seat-btn:hover { background: rgba(176,140,255,.12); border-color: rgba(176,140,255,.4); }
        .seat-slider { -webkit-appearance: none; flex: 1; height: 4px; border-radius: 2px; background: linear-gradient(to right, var(--purple) 0%, var(--purple) var(--val, 0%), rgba(255,255,255,.1) var(--val, 0%), rgba(255,255,255,.1) 100%); outline: none; cursor: pointer; }
        .seat-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%; background: var(--purple); cursor: pointer; box-shadow: 0 0 0 4px rgba(176,140,255,.2); }
        .seat-slider::-moz-range-thumb { width: 18px; height: 18px; border-radius: 50%; background: var(--purple); border: none; cursor: pointer; }

        .seat-input-row { display: flex; align-items: center; gap: 10px; }
        .seat-input-wrap { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,.04); border: 1px solid var(--line); border-radius: 12px; padding: 10px 16px; }
        .seat-input-wrap:focus-within { border-color: rgba(176,140,255,.5); }
        .seat-input { font-size: 18px; font-weight: 700; color: var(--text); background: transparent; border: none; outline: none; width: 80px; text-align: right; -moz-appearance: textfield; font-family: inherit; }
        .seat-input::-webkit-outer-spin-button, .seat-input::-webkit-inner-spin-button { -webkit-appearance: none; }
        .seat-unit { color: var(--muted); font-size: 14px; }

        .calc-result { background: rgba(255,255,255,.03); border: 1px solid var(--line); border-radius: 16px; padding: 24px; }
        .calc-result-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.06); font-size: 14px; color: var(--muted); }
        .calc-result-row:last-child { border-bottom: none; padding-bottom: 0; }
        .calc-result-row .val { font-weight: 700; color: var(--text); }
        .calc-result-row .val.purple { color: var(--purple); font-size: 22px; }
        .enterprise-note { background: rgba(176,140,255,.08); border: 1px solid rgba(176,140,255,.25); border-radius: 12px; padding: 14px 18px; font-size: 13px; color: var(--muted); margin-top: 14px; display: none; }
        .enterprise-note a { color: var(--purple); text-decoration: none; }

        /* Tier table */
        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
        .tier-wrap { background: linear-gradient(180deg, var(--panel), var(--panel-2)); border: 1px solid var(--line); border-radius: 22px; overflow: hidden; margin-bottom: 40px; }
        .tier-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .tier-table thead th { padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); background: rgba(0,0,0,.3); border-bottom: 1px solid var(--line); }
        .tier-table tbody td { padding: 13px 20px; border-bottom: 1px solid rgba(255,255,255,.05); color: var(--muted); }
        .tier-table tbody tr:last-child td { border-bottom: none; }
        .tier-table tbody tr:hover td { background: rgba(176,140,255,.04); }
        .tier-table tbody tr.active-tier td { background: rgba(176,140,255,.07); color: var(--text); }
        .tier-table strong { color: var(--text); }
        .discount-badge { display: inline-block; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 999px; background: rgba(176,140,255,.12); color: var(--purple); border: 1px solid rgba(176,140,255,.22); }
        .discount-badge.enterprise { background: rgba(34,197,94,.1); color: var(--success); border-color: rgba(34,197,94,.22); }

        /* Features */
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 48px; }
        .feature-item { background: linear-gradient(180deg, var(--panel), var(--panel-2)); border: 1px solid var(--line); border-radius: 16px; padding: 22px; }
        .feature-icon { font-size: 24px; margin-bottom: 10px; }
        .feature-item h3 { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
        .feature-item p { color: var(--muted); font-size: 13px; line-height: 1.6; }

        /* Contact */
        .form-section { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 48px; align-items: start; }
        @media (max-width: 760px) { .form-section { grid-template-columns: 1fr; } }
        .form-info h2 { font-size: 26px; font-weight: 700; margin-bottom: 12px; }
        .form-info p { color: var(--muted); line-height: 1.6; margin-bottom: 20px; }
        .contact-detail { display: flex; align-items: center; gap: 10px; color: var(--muted); font-size: 14px; margin-bottom: 10px; }

        .form-box { background: linear-gradient(180deg, var(--panel), var(--panel-2)); border: 1px solid var(--line); border-radius: 22px; padding: 32px; }
        .form-box h3 { font-size: 18px; font-weight: 700; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--muted); margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; background: var(--bg); border: 1px solid var(--line); border-radius: 10px; color: var(--text); font-family: 'Geist', system-ui, sans-serif; font-size: 14px; padding: 10px 14px; outline: none; transition: border-color .15s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: rgba(176,140,255,.5); }
        .form-group select option { background: #141418; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }
        .submit-btn { width: 100%; background: linear-gradient(135deg, var(--purple), var(--purple-2)); color: #120b22; border: none; border-radius: 14px; padding: 13px 20px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: 'Geist', system-ui, sans-serif; margin-top: 6px; }
        .submit-btn:hover { opacity: .9; }

        .alert { border-radius: 12px; padding: 14px 18px; font-size: 14px; margin-bottom: 20px; }
        .alert.success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; }
        .alert.error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }

        .footer { text-align: center; padding: 24px; border-top: 1px solid var(--line); color: var(--muted); font-size: 13px; }
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
        <h1>Preços que escalam<br><span>com a tua equipa</span></h1>
        <p>Volume pricing automático — quanto maior a equipa, menor o custo por pessoa. Sem taxas de setup.</p>
        <div class="hero-actions">
            <a href="#contacto" class="cta-primary">Falar com a equipa →</a>
            <a href="{{ route('subscriptions.plans') }}" class="cta-ghost">Ver todos os planos</a>
        </div>
    </section>

    <!-- Calculator -->
    <section class="calc-section">
        <h2>Calcula o teu custo</h2>
        <p>Arrasta o slider ou introduz o número de colaboradores para ver o preço exato.</p>
        <div class="calc-grid">
            <div>
                <div class="slider-label">Número de colaboradores</div>
                <div class="slider-row">
                    <button class="seat-btn" id="btn-minus">−</button>
                    <input type="range" class="seat-slider" id="seat-slider" min="1" max="10000" value="25">
                    <button class="seat-btn" id="btn-plus">+</button>
                </div>
                <div class="seat-input-row">
                    <div class="seat-input-wrap">
                        <input type="number" class="seat-input" id="seat-input" min="1" max="10000" value="25">
                        <span class="seat-unit">seats</span>
                    </div>
                </div>
                <div class="enterprise-note" id="enterprise-note">
                    Para equipas com mais de 10 000 colaboradores, o preço é negociado.<br>
                    <a href="#contacto">Fala connosco →</a>
                </div>
            </div>
            <div class="calc-result">
                <div class="calc-result-row">
                    <span>Seats</span>
                    <span class="val" id="res-seats">25</span>
                </div>
                <div class="calc-result-row">
                    <span>Tier de preço</span>
                    <span class="val" id="res-tier">1 – 50</span>
                </div>
                <div class="calc-result-row">
                    <span>Preço por seat/mês</span>
                    <span class="val" id="res-unit">€9.50</span>
                </div>
                <div class="calc-result-row">
                    <span>Total mensal</span>
                    <span class="val purple" id="res-total">€237.50</span>
                </div>
                <div class="calc-result-row">
                    <span>Total anual</span>
                    <span class="val" id="res-annual">€2 850.00</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Tier table -->
    <section style="margin-bottom: 48px;">
        <h2 class="section-title">Tabela de Volume Pricing</h2>
        <div class="tier-wrap">
            <table class="tier-table" id="tier-table">
                <thead>
                    <tr>
                        <th>Seats</th>
                        <th>€/seat/mês</th>
                        <th>Desconto</th>
                        <th>Exemplo de custo mensal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-min="1" data-max="50">
                        <td>1 – 50</td>
                        <td><strong>€9.50</strong></td>
                        <td><span class="discount-badge">base</span></td>
                        <td style="color:var(--muted);font-size:13px;">€9.50 – €475.00</td>
                    </tr>
                    <tr data-min="51" data-max="100">
                        <td>51 – 100</td>
                        <td><strong>€9.00</strong></td>
                        <td><span class="discount-badge">−5%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€459.00 – €900.00</td>
                    </tr>
                    <tr data-min="101" data-max="250">
                        <td>101 – 250</td>
                        <td><strong>€8.00</strong></td>
                        <td><span class="discount-badge">−16%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€808.00 – €2 000.00</td>
                    </tr>
                    <tr data-min="251" data-max="500">
                        <td>251 – 500</td>
                        <td><strong>€7.00</strong></td>
                        <td><span class="discount-badge">−26%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€1 757.00 – €3 500.00</td>
                    </tr>
                    <tr data-min="501" data-max="750">
                        <td>501 – 750</td>
                        <td><strong>€6.50</strong></td>
                        <td><span class="discount-badge">−32%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€3 256.50 – €4 875.00</td>
                    </tr>
                    <tr data-min="751" data-max="1000">
                        <td>751 – 1 000</td>
                        <td><strong>€6.00</strong></td>
                        <td><span class="discount-badge">−37%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€4 506.00 – €6 000.00</td>
                    </tr>
                    <tr data-min="1001" data-max="2500">
                        <td>1 001 – 2 500</td>
                        <td><strong>€5.50</strong></td>
                        <td><span class="discount-badge">−42%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€5 505.50 – €13 750.00</td>
                    </tr>
                    <tr data-min="2501" data-max="5000">
                        <td>2 501 – 5 000</td>
                        <td><strong>€5.00</strong></td>
                        <td><span class="discount-badge">−47%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€12 505.00 – €25 000.00</td>
                    </tr>
                    <tr data-min="5001" data-max="7500">
                        <td>5 001 – 7 500</td>
                        <td><strong>€4.50</strong></td>
                        <td><span class="discount-badge">−53%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€22 504.50 – €33 750.00</td>
                    </tr>
                    <tr data-min="7501" data-max="10000">
                        <td>7 501 – 10 000</td>
                        <td><strong>€4.00</strong></td>
                        <td><span class="discount-badge">−58%</span></td>
                        <td style="color:var(--muted);font-size:13px;">€30 004.00 – €40 000.00</td>
                    </tr>
                    <tr>
                        <td><strong>10 000+</strong></td>
                        <td><strong>Custom</strong></td>
                        <td><span class="discount-badge enterprise">Negociado</span></td>
                        <td style="color:var(--muted);font-size:13px;"><a href="#contacto" style="color:var(--purple);text-decoration:none;">Falar connosco →</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

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
                <h3>Seats escaláveis</h3>
                <p>Adiciona ou remove colaboradores a qualquer momento. O preço ajusta-se com proration automática.</p>
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

    <!-- Contact -->
    <section class="form-section" id="contacto">
        <div class="form-info">
            <h2>Vamos conversar</h2>
            <p>Para equipas com mais de 10 000 colaboradores ou para uma demonstração personalizada, entra em contacto. Respondemos em menos de 24 horas.</p>
            <div class="contact-detail"><span>✉️</span><span>hello@cardifys.com</span></div>
            <div class="contact-detail"><span>⏱️</span><span>Resposta em menos de 24h</span></div>
            <div class="contact-detail"><span>🎯</span><span>Demo personalizada incluída</span></div>
        </div>

        <div class="form-box">
            <h3>Pede uma demonstração</h3>

            @if(session('enterprise_success'))
                <div class="alert success">✓ Mensagem enviada! Entraremos em contacto em breve.</div>
            @endif
            @if(session('enterprise_error'))
                <div class="alert error">Erro ao enviar. Escreve-nos diretamente para hello@cardifys.com.</div>
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
                        <option value="1-50"       {{ old('employees') == '1-50'       ? 'selected' : '' }}>1 – 50 (€9.50/seat)</option>
                        <option value="51-100"     {{ old('employees') == '51-100'     ? 'selected' : '' }}>51 – 100 (€9.00/seat)</option>
                        <option value="101-250"    {{ old('employees') == '101-250'    ? 'selected' : '' }}>101 – 250 (€8.00/seat)</option>
                        <option value="251-500"    {{ old('employees') == '251-500'    ? 'selected' : '' }}>251 – 500 (€7.00/seat)</option>
                        <option value="501-1000"   {{ old('employees') == '501-1000'   ? 'selected' : '' }}>501 – 1 000 (€6.00–6.50/seat)</option>
                        <option value="1001-5000"  {{ old('employees') == '1001-5000'  ? 'selected' : '' }}>1 001 – 5 000 (€5.00–5.50/seat)</option>
                        <option value="5001-10000" {{ old('employees') == '5001-10000' ? 'selected' : '' }}>5 001 – 10 000 (€4.00–4.50/seat)</option>
                        <option value="10000+"     {{ old('employees') == '10000+'     ? 'selected' : '' }}>Mais de 10 000 (preço custom)</option>
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

<script>
    const TIERS = [
        { min: 1,     max: 50,    price: 9.50 },
        { min: 51,    max: 100,   price: 9.00 },
        { min: 101,   max: 250,   price: 8.00 },
        { min: 251,   max: 500,   price: 7.00 },
        { min: 501,   max: 750,   price: 6.50 },
        { min: 751,   max: 1000,  price: 6.00 },
        { min: 1001,  max: 2500,  price: 5.50 },
        { min: 2501,  max: 5000,  price: 5.00 },
        { min: 5001,  max: 7500,  price: 4.50 },
        { min: 7501,  max: 10000, price: 4.00 },
    ];

    function getTier(n) {
        return TIERS.find(t => n >= t.min && n <= t.max) || null;
    }

    function fmt(n) {
        return '€' + n.toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function updateCalc(seats) {
        const tier = getTier(seats);
        const isEnterprise = seats > 10000;

        document.getElementById('res-seats').textContent  = seats.toLocaleString('pt-PT');
        document.getElementById('enterprise-note').style.display = isEnterprise ? 'block' : 'none';

        if (isEnterprise || !tier) {
            document.getElementById('res-tier').textContent   = '10 000+';
            document.getElementById('res-unit').textContent   = 'Custom';
            document.getElementById('res-total').textContent  = '—';
            document.getElementById('res-annual').textContent = '—';
        } else {
            const total = tier.price * seats;
            document.getElementById('res-tier').textContent   = tier.min.toLocaleString('pt-PT') + ' – ' + tier.max.toLocaleString('pt-PT');
            document.getElementById('res-unit').textContent   = fmt(tier.price);
            document.getElementById('res-total').textContent  = fmt(total);
            document.getElementById('res-annual').textContent = fmt(total * 12);
        }

        // Highlight active tier row
        document.querySelectorAll('#tier-table tbody tr[data-min]').forEach(row => {
            const min = parseInt(row.dataset.min);
            const max = parseInt(row.dataset.max);
            row.classList.toggle('active-tier', seats >= min && seats <= max);
        });

        // Slider fill
        const pct = (Math.min(seats, 10000) / 10000 * 100).toFixed(2) + '%';
        document.getElementById('seat-slider').style.setProperty('--val', pct);
    }

    function syncSeats(val) {
        val = Math.max(1, parseInt(val) || 1);
        document.getElementById('seat-slider').value = Math.min(val, 10000);
        document.getElementById('seat-input').value  = val;
        updateCalc(val);
    }

    document.getElementById('seat-slider').addEventListener('input', e => syncSeats(e.target.value));
    document.getElementById('seat-input').addEventListener('input',  e => syncSeats(e.target.value));
    document.getElementById('btn-minus').addEventListener('click', () => syncSeats(parseInt(document.getElementById('seat-input').value) - 1));
    document.getElementById('btn-plus').addEventListener('click',  () => syncSeats(parseInt(document.getElementById('seat-input').value) + 1));

    updateCalc(25);
</script>
</body>
</html>

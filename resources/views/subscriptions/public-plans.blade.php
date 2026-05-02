<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planos — Cardifys</title>
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
        .container { max-width: 1200px; margin: 0 auto; }
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
        }
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
        .hero {
            text-align: center;
            margin: 22px 0 28px;
        }
        .hero h1 { font-size: clamp(28px, 4vw, 42px); margin-bottom: 10px; }
        .hero p { color: var(--muted); max-width: 700px; margin: 0 auto; }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }

        .card {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 28px;
        }
        .card.featured {
            border-color: rgba(176,140,255,.55);
            box-shadow: 0 20px 45px rgba(176,140,255,.14);
        }
        .label { color: var(--muted); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; }
        .price { font-size: 40px; font-weight: 700; margin: 8px 0 4px; }
        .price small { font-size: 16px; color: var(--muted); font-weight: 500; }
        .desc { color: var(--muted); margin-bottom: 16px; }
        .list { list-style: none; display: grid; gap: 8px; margin-bottom: 18px; }
        .list li { color: #e7e7ee; font-size: 14px; }
        .ok { color: var(--success); margin-right: 8px; }

        .cta {
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        .cta.primary { background: linear-gradient(135deg, var(--purple), var(--purple-2)); color: #120b22; }
        .cta.secondary { background: #22222a; color: var(--text); border: 1px solid var(--line); }

        .switch {
            margin: 0 auto 18px;
            display: inline-flex;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 4px;
            background: var(--panel);
        }
        .switch button {
            border: none;
            background: transparent;
            color: var(--muted);
            padding: 7px 14px;
            border-radius: 999px;
            font-weight: 600;
            cursor: pointer;
        }
        .switch button.active { background: #2a2239; color: #dbc8ff; }
        .note { color: var(--muted); font-size: 13px; margin-top: 8px; }

        /* Comparison table */
        .comparison {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 22px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .comp-table {
            width: 100%;
            border-collapse: collapse;
        }

        .comp-table thead {
            background: rgba(0,0,0,0.3);
            border-bottom: 1px solid var(--line);
        }

        .comp-table th {
            text-align: left;
            padding: 16px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .comp-table th:nth-child(1) { width: 40%; }

        .comp-table td {
            padding: 14px 20px;
            font-size: 14px;
            color: var(--text);
            border-top: 1px solid var(--line);
        }

        .comp-table tbody tr:hover { background: rgba(176,140,255,0.04); }

        .comp-table td.label {
            font-weight: 600;
            color: var(--muted);
            font-size: 12px;
        }

        .check { color: var(--success); }
        .cross { color: #888; }

        .faq {
            margin-bottom: 28px;
        }

        .faq-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 18px;
        }

        .faq-item {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
        }

        .faq-q {
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text);
        }

        .faq-a {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            display: none;
        }

        .faq-item.open .faq-a { display: block; }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 13px;
        }

        .footer a { color: var(--purple); text-decoration: none; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <a href="{{ route('home') }}" class="brand">
            <span class="mark"></span>
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

    <header class="hero">
        <h1>Planos simples para crescer</h1>
        <p>Escolhe o plano certo para ti ou para a tua equipa. Sem compromissos, cancela quando quiseres.</p>
    </header>

    <div style="text-align:center;">
        <div class="switch">
            <button type="button" class="active" data-period="monthly">Mensal</button>
            <button type="button" data-period="yearly">Anual (‑20%)</button>
        </div>
    </div>

    <!-- Pricing Cards -->
    <section class="grid">
        <article class="card featured">
            <div class="label">Individual</div>
            <div class="price"><span id="price-amount">10</span>€ <small id="price-period">/mês</small></div>
            <p class="desc">Para profissionais que querem partilhar o cartão digital com estilo e profissionalismo.</p>

            <ul class="list">
                <li><span class="ok">✓</span>Cartão digital profissional</li>
                <li><span class="ok">✓</span>QR Code personalizado</li>
                <li><span class="ok">✓</span>Partilha via NFC</li>
                <li><span class="ok">✓</span>Analytics em tempo real</li>
                <li><span class="ok">✓</span>Links ilimitados</li>
                <li><span class="ok">✓</span>Design 100% personalizável</li>
            </ul>

            @auth
                @if($user && $user->subscribed('default'))
                    <a href="{{ route('dashboard') }}" class="cta secondary">Plano ativo</a>
                @else
                    <form method="POST" action="{{ route('subscriptions.checkout') }}">
                        @csrf
                        <input type="hidden" name="price" id="price-input" value="price_1TFgXeCcmLy5PiLsbrLtDCfP">
                        <button type="submit" class="cta primary">Começar agora</button>
                    </form>
                @endif
            @else
                <a href="{{ route('register') }}" class="cta primary">Criar conta para começar</a>
                <p class="note">Precisas de conta para finalizar checkout.</p>
            @endauth
        </article>

        <article class="card">
            <div class="label">Empresas</div>
            <div class="price">9.50€ <small>/seat/mês</small></div>
            <p class="desc">Volume pricing automático — quanto maior a equipa, menor o custo por seat. Desde 4€/seat para grandes equipas.</p>

            <ul class="list">
                <li><span class="ok">✓</span>Tudo do plano Individual</li>
                <li><span class="ok">✓</span>Seats escaláveis</li>
                <li><span class="ok">✓</span>Painel de administração</li>
                <li><span class="ok">✓</span>Branding corporativo</li>
                <li><span class="ok">✓</span>Suporte prioritário</li>
                <li><span class="ok">✓</span>Acesso à API</li>
            </ul>

            <a href="{{ route('enterprise') }}" class="cta secondary">Ver preços por equipa →</a>
        </article>
    </section>

    <!-- Comparison Table -->
    <section>
        <h2 class="faq-title">Comparação Completa</h2>
        <div class="comparison">
            <table class="comp-table">
                <thead>
                    <tr>
                        <th>Funcionalidade</th>
                        <th>Individual</th>
                        <th>Empresas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label">💳 Cartão Digital</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>QR Code personalizado</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Partilha via NFC</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Exportação vCard</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Links ilimitados</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td class="label">🎨 Personalização</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Temas e cores personalizáveis</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Branding corporativo unificado</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Logo da empresa em todos os cartões</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td class="label">📊 Analytics</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Visualizações do cartão em tempo real</td>
                        <td class="check">✓</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Dashboard por equipa</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Exportação de relatórios (CSV, PDF)</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td class="label">👥 Equipa & Gestão</td>
                        <td>1</td>
                        <td>Ilimitados</td>
                    </tr>
                    <tr>
                        <td>Painel de administração</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Convites de colaboradores</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Gestão de permissões</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td class="label">⚙️ Extras</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Acesso à API</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>Suporte prioritário</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                    <tr>
                        <td>SLA de disponibilidade 99.9%</td>
                        <td class="cross">—</td>
                        <td class="check">✓</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq">
        <h2 class="faq-title">Perguntas Frequentes</h2>
        <div class="faq-grid">
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">Posso cancelar a qualquer momento?</div>
                <div class="faq-a">Sim, sempre. Não há contratos de permanência ou penalizações. O teu cartão continua ativo até ao fim do período já pago.</div>
            </div>
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">O que acontece aos meus dados se cancelar?</div>
                <div class="faq-a">Os teus dados permanecem na plataforma por 30 dias após o cancelamento. Após esse período, todos os dados são removidos permanentemente.</div>
            </div>
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">Posso mudar de plano?</div>
                <div class="faq-a">Sim, a qualquer momento. Se fizeres upgrade, pagas apenas a diferença. Se fizeres downgrade, o valor já pago é descontado proporcionalmente.</div>
            </div>
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">Precisam de fatura com IVA?</div>
                <div class="faq-a">Sim. Todos os pagamentos incluem fatura legal com IVA português a 23%, enviada automaticamente após cada pagamento.</div>
            </div>
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">Como funciona o plano Empresas?</div>
                <div class="faq-a">O plano começa com um setup de 50€ único. Depois, pagas 1€ por colaborador, por mês. Escala conforme a tua equipa cresce.</div>
            </div>
            <div class="faq-item" onclick="this.classList.toggle('open')">
                <div class="faq-q">Qual é o limite de cartões?</div>
                <div class="faq-a">No Individual, podes criar cartões ilimitados. No plano Empresas, não há limite — cada colaborador pode ter múltiplos cartões.</div>
            </div>
        </div>
    </section>

    <div class="footer">
        <p>Dúvidas? <a href="mailto:hello@cardifys.com">Contacta-nos</a> • <a href="{{ route('home') }}">Voltar ao início</a></p>
    </div>
</div>

<script>
    const monthlyPriceId = 'price_1TFgXeCcmLy5PiLsbrLtDCfP';
    const yearlyPriceId = 'price_1TFgXKCcmLy5PiLs5xZdP87O';

    const buttons = document.querySelectorAll('[data-period]');
    const amount = document.getElementById('price-amount');
    const period = document.getElementById('price-period');
    const priceInput = document.getElementById('price-input');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (btn.dataset.period === 'yearly') {
                amount.textContent = '84';
                period.textContent = '/ano';
                if (priceInput) priceInput.value = yearlyPriceId;
            } else {
                amount.textContent = '10';
                period.textContent = '/mês';
                if (priceInput) priceInput.value = monthlyPriceId;
            }
        });
    });
</script>
</body>
</html>

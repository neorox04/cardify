<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Seats — Cardify</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/icon.svg">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#6366f1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Cardify">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: #0d0d12;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 60px 20px;
            font-family: 'DM Sans', sans-serif;
            color: #e8e4df;
        }

        .card {
            width: 100%;
            max-width: 580px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 36px 40px;
        }

        .step-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #5a5550;
            margin-bottom: 8px;
        }

        h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #e8e4df;
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .desc {
            font-size: 14px;
            color: #5a5550;
            font-weight: 300;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .current-info {
            display: flex;
            justify-content: space-between;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }

        .info-item { text-align: center; }

        .info-val {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #e8e4df;
            margin-bottom: 3px;
        }

        .info-label {
            font-size: 11px;
            color: #4a4550;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .seats-control { margin-bottom: 28px; }

        .slider-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .seat-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: #e8e4df;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
            flex-shrink: 0;
            line-height: 1;
        }
        .seat-btn:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
        .seat-btn:disabled { opacity: 0.3; cursor: not-allowed; }

        .seat-slider {
            -webkit-appearance: none;
            flex: 1;
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(to right, #63d9a8 0%, #63d9a8 var(--val, 0%), rgba(255,255,255,0.1) var(--val, 0%), rgba(255,255,255,0.1) 100%);
            outline: none;
            cursor: pointer;
        }
        .seat-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #63d9a8;
            cursor: pointer;
            box-shadow: 0 0 0 4px rgba(99,217,168,0.2);
        }

        .manual-input-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 12px 16px;
            transition: border-color 0.2s;
        }
        .manual-input-wrap:focus-within {
            border-color: rgba(99,217,168,0.4);
            background: rgba(99,217,168,0.04);
        }

        .manual-input-label {
            font-size: 12px;
            color: #5a5550;
            font-weight: 500;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .seat-input {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #e8e4df;
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            text-align: right;
            width: 80px;
            -moz-appearance: textfield;
        }
        .seat-input::-webkit-outer-spin-button,
        .seat-input::-webkit-inner-spin-button { -webkit-appearance: none; }

        .seat-input-unit { font-size: 13px; color: #4a4550; white-space: nowrap; }

        .impact-box {
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 28px;
        }
        .impact-box.upgrade { background: rgba(99,217,168,0.06); border: 1px solid rgba(99,217,168,0.18); }
        .impact-box.downgrade { background: rgba(251,146,60,0.06); border: 1px solid rgba(251,146,60,0.18); }
        .impact-box.neutral { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); }

        .impact-title {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .impact-title.green { color: #63d9a8; }
        .impact-title.orange { color: #fb923c; }
        .impact-title.grey { color: #5a5550; }

        .impact-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #6a6460;
            margin-bottom: 8px;
        }
        .impact-row:last-child { margin-bottom: 0; }
        .impact-val { font-weight: 500; color: #e8e4df; }
        .impact-val.green { color: #63d9a8; }
        .impact-val.orange { color: #fb923c; }

        .divider { border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 12px 0; }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            border: none;
            background: #e8e4df;
            color: #0d0d12;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }
        .btn-primary:disabled { opacity: 0.3; cursor: not-allowed; }

        .btn-secondary {
            width: 100%;
            padding: 13px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.1);
            background: transparent;
            color: #6a6460;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
        }
        .btn-secondary:hover { border-color: rgba(255,255,255,0.2); color: #e8e4df; }

        .user-list { margin-bottom: 24px; }

        .user-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.06);
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.15s;
            background: rgba(255,255,255,0.02);
        }
        .user-item:hover { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.1); }
        .user-item.selected { background: rgba(251,146,60,0.07); border-color: rgba(251,146,60,0.25); }
        .user-item.suggested { background: rgba(251,146,60,0.04); border-color: rgba(251,146,60,0.15); }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: #8a8480;
            flex-shrink: 0;
        }
        .avatar.selected { background: rgba(251,146,60,0.15); color: #fb923c; }

        .user-info { flex: 1; }
        .user-name { font-size: 14px; font-weight: 500; color: #e8e4df; margin-bottom: 2px; }
        .user-meta { font-size: 12px; color: #5a5550; }

        .user-login {
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 100px;
        }
        .login-never { background: rgba(251,146,60,0.1); color: #fb923c; border: 1px solid rgba(251,146,60,0.2); }
        .login-old { background: rgba(255,255,255,0.04); color: #5a5550; border: 1px solid rgba(255,255,255,0.07); }
        .login-recent { background: rgba(99,217,168,0.06); color: #63d9a8; border: 1px solid rgba(99,217,168,0.15); }

        .checkbox {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.12);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 11px;
        }
        .checkbox.checked { background: #fb923c; border-color: #fb923c; color: #0d0d12; }

        .counter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: rgba(251,146,60,0.06);
            border: 1px solid rgba(251,146,60,0.15);
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .counter-text { color: #6a6460; }
        .counter-val { font-weight: 600; color: #fb923c; }

        .done-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: rgba(99,217,168,0.1);
            border: 1px solid rgba(99,217,168,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 24px;
        }

        .tag-suggest {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fb923c;
            background: rgba(251,146,60,0.1);
            border: 1px solid rgba(251,146,60,0.15);
            padding: 2px 8px;
            border-radius: 100px;
        }

        .step { display: none; }
        .step.active { display: block; }

        .user-badges {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }
    </style>
</head>
<body>
<div class="card">

    {{-- STEP 1: Adjust --}}
    <div class="step active" id="step-adjust">
        <div class="step-label" id="label-adjust">Gestão de Seats · Passo 1 de 2</div>
        <h2>Alterar número de utilizadores</h2>
        <p class="desc">Ajusta o número de seats do teu plano. O preço é atualizado imediatamente com proration.</p>

        <div class="current-info">
            <div class="info-item">
                <div class="info-val" id="display-current-seats">{{ $currentSeats }}</div>
                <div class="info-label">Seats atuais</div>
            </div>
            <div class="info-item">
                <div class="info-val" id="display-current-price">€{{ number_format($currentTier['price'], 2) }}</div>
                <div class="info-label">Preço/user</div>
            </div>
            <div class="info-item">
                <div class="info-val">{{ $daysRemaining }}</div>
                <div class="info-label">Dias restantes</div>
            </div>
        </div>

        <div class="seats-control">
            <div class="slider-row">
                <button class="seat-btn" id="btn-minus">−</button>
                <input type="range" class="seat-slider" id="seat-slider" min="1" max="9999" value="{{ $currentSeats }}">
                <button class="seat-btn" id="btn-plus">+</button>
            </div>
            <div class="manual-input-wrap">
                <span class="manual-input-label">Nº exato de seats</span>
                <input type="number" class="seat-input" id="seat-input" min="1" value="{{ $currentSeats }}">
                <span class="seat-input-unit">utilizadores</span>
            </div>
        </div>

        <div id="impact-upgrade" class="impact-box upgrade" style="display:none">
            <div class="impact-title green">↑ Upgrade de seats</div>
            <div class="impact-row"><span>Novo tier</span><span class="impact-val" id="up-tier"></span></div>
            <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="up-mrr"></span></div>
            <div class="impact-row"><span>Cobrado hoje (<span id="up-days">{{ $daysRemaining }}</span> dias restantes)</span><span class="impact-val green" id="up-proration"></span></div>
        </div>

        <div id="impact-downgrade" class="impact-box downgrade" style="display:none">
            <div class="impact-title orange">↓ Redução de seats</div>
            <div class="impact-row"><span>Novo tier</span><span class="impact-val" id="dn-tier"></span></div>
            <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="dn-mrr"></span></div>
            <div class="impact-row"><span>Crédito aplicado na próxima fatura</span><span class="impact-val orange" id="dn-proration"></span></div>
            <div class="impact-row"><span>Utilizadores a desativar</span><span class="impact-val orange" id="dn-count"></span></div>
        </div>

        <div id="impact-neutral" class="impact-box neutral">
            <div class="impact-title grey">Sem alterações</div>
            <div class="impact-row"><span>Ajusta o número de seats para continuar.</span></div>
        </div>

        <button class="btn-primary" id="btn-adjust-next" disabled>Continuar</button>
        <button class="btn-secondary" id="btn-adjust-cancel">Cancelar</button>
    </div>

    {{-- STEP 2: Select users to deactivate --}}
    <div class="step" id="step-select-users">
        <div class="step-label">Gestão de Seats · Passo 2 de 3</div>
        <h2>Escolhe quem desativar</h2>
        <p class="desc" id="select-desc">Seleciona os utilizadores a desativar. Os cartões ficam arquivados — podes reativar a qualquer momento.</p>

        <div class="counter-bar">
            <span class="counter-text">Selecionados</span>
            <span><span class="counter-val" id="selected-count">0</span> / <span id="needed-count">0</span></span>
        </div>

        <div class="user-list" id="user-list"></div>

        <button class="btn-primary" id="btn-select-next" disabled>Confirmar seleção (<span id="btn-selected">0</span>/<span id="btn-needed">0</span>) →</button>
        <button class="btn-secondary" id="btn-select-back">← Voltar</button>
    </div>

    {{-- STEP 3: Confirm --}}
    <div class="step" id="step-confirm">
        <div class="step-label" id="label-confirm">Gestão de Seats · Passo 2 de 2</div>
        <h2>Confirmar alteração</h2>
        <p class="desc">Revê o resumo antes de confirmar. A alteração é imediata.</p>

        <div class="impact-box neutral">
            <div class="impact-row"><span>Seats anteriores</span><span class="impact-val" id="conf-old"></span></div>
            <div class="impact-row"><span>Novos seats</span><span class="impact-val" id="conf-new"></span></div>
            <div class="impact-row"><span>MRR anterior</span><span class="impact-val" id="conf-old-mrr"></span></div>
            <div class="impact-row"><span>Novo MRR</span><span class="impact-val" id="conf-new-mrr"></span></div>
            <hr class="divider">
            <div class="impact-row">
                <span id="conf-proration-label">Cobrado hoje</span>
                <span class="impact-val" id="conf-proration"></span>
            </div>
            <div class="impact-row" id="conf-deactivated-row" style="display:none">
                <span>Utilizadores desativados</span>
                <span class="impact-val orange" id="conf-deactivated"></span>
            </div>
        </div>

        <form method="POST" action="{{ route('subscriptions.seats.update') }}" id="seats-form">
            @csrf
            <input type="hidden" name="new_seats" id="form-new-seats">
            <input type="hidden" name="deactivate_users" id="form-deactivate-users">
            <button type="submit" class="btn-primary">✓ Confirmar e aplicar agora</button>
        </form>
        <button class="btn-secondary" id="btn-confirm-back">← Voltar</button>
    </div>

    {{-- DONE --}}
    <div class="step" id="step-done">
        <div style="text-align:center">
            <div class="done-icon">✓</div>
            <h2 style="margin-bottom:10px">Alteração aplicada</h2>
            <p class="desc" id="done-msg" style="margin: 0 auto 32px; max-width:380px"></p>
            <a href="{{ route('company.dashboard') }}" class="btn-primary" style="display:block;text-align:center;text-decoration:none">
                Voltar ao dashboard
            </a>
        </div>
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

    const CURRENT_SEATS   = {{ $currentSeats }};
    const DAYS_REMAINING  = {{ $daysRemaining }};
    const DAYS_IN_MONTH   = 30;
    const USERS           = @json($members);

    let newSeats = CURRENT_SEATS;
    let selectedToDeactivate = [];

    function getTier(n) {
        return TIERS.find(t => n >= t.min && n <= t.max) || TIERS[TIERS.length - 1];
    }

    function fmt(n) { return '€' + n.toFixed(2); }

    function tierLabel(t) {
        return `${t.min}–${t.max === 10000 ? '10.000' : t.max} users · €${t.price.toFixed(2)}/user`;
    }

    function updateSlider(val) {
        const pct = ((Math.min(val, 9999) / 9999) * 100).toFixed(2) + '%';
        document.getElementById('seat-slider').style.setProperty('--val', pct);
    }

    function syncSeats(val) {
        val = Math.max(1, parseInt(val) || 1);
        newSeats = val;
        document.getElementById('seat-slider').value = Math.min(val, 9999);
        document.getElementById('seat-input').value = val;
        updateSlider(val);
        renderImpact();
    }

    function renderImpact() {
        const currentTier  = getTier(CURRENT_SEATS);
        const newTier      = getTier(newSeats);
        const currentMRR   = currentTier.price * CURRENT_SEATS;
        const newMRR       = newTier.price * newSeats;
        const proration    = ((newMRR - currentMRR) * DAYS_REMAINING) / DAYS_IN_MONTH;
        const toDeactivate = Math.max(0, CURRENT_SEATS - newSeats);
        const isUpgrade    = newSeats > CURRENT_SEATS;
        const isDowngrade  = newSeats < CURRENT_SEATS;

        document.getElementById('impact-upgrade').style.display  = isUpgrade  ? 'block' : 'none';
        document.getElementById('impact-downgrade').style.display = isDowngrade ? 'block' : 'none';
        document.getElementById('impact-neutral').style.display   = (!isUpgrade && !isDowngrade) ? 'block' : 'none';

        if (isUpgrade) {
            document.getElementById('up-tier').textContent      = tierLabel(newTier);
            document.getElementById('up-mrr').textContent       = fmt(newMRR) + '/mês';
            document.getElementById('up-proration').textContent = '+' + fmt(proration);
        }
        if (isDowngrade) {
            document.getElementById('dn-tier').textContent      = tierLabel(newTier);
            document.getElementById('dn-mrr').textContent       = fmt(newMRR) + '/mês';
            document.getElementById('dn-proration').textContent = '-' + fmt(Math.abs(proration));
            document.getElementById('dn-count').textContent     = toDeactivate + ' users';
        }

        // Step label
        document.getElementById('label-adjust').textContent =
            'Gestão de Seats · Passo 1 de ' + (isDowngrade ? '3' : '2');

        // Next button
        const btn = document.getElementById('btn-adjust-next');
        btn.disabled = !isUpgrade && !isDowngrade;
        btn.textContent = isUpgrade
            ? 'Confirmar upgrade →'
            : isDowngrade
            ? 'Escolher quem desativar →'
            : 'Continuar';
    }

    function goTo(stepId) {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.getElementById(stepId).classList.add('active');
    }

    function buildUserList() {
        const toDeactivate = Math.max(0, CURRENT_SEATS - newSeats);
        // Sort: never logged in first, then by most days ago
        const sorted = [...USERS].sort((a, b) => b.days_ago - a.days_ago);

        // Pre-select suggested
        selectedToDeactivate = sorted.slice(0, toDeactivate).map(u => u.id);

        document.getElementById('needed-count').textContent = toDeactivate;
        document.getElementById('btn-needed').textContent   = toDeactivate;
        document.getElementById('select-desc').textContent  =
            `Seleciona ${toDeactivate} utilizador${toDeactivate !== 1 ? 'es' : ''} a desativar. Os cartões ficam arquivados — podes reativar a qualquer momento.`;

        const list = document.getElementById('user-list');
        list.innerHTML = '';

        sorted.forEach((user, i) => {
            const isSuggested = i < toDeactivate;
            const loginClass = user.days_ago >= 999
                ? 'login-never'
                : user.days_ago > 14
                ? 'login-old'
                : 'login-recent';

            const item = document.createElement('div');
            item.className = 'user-item' + (isSuggested ? ' suggested' : '');
            item.dataset.id = user.id;
            item.innerHTML = `
                <div class="checkbox ${selectedToDeactivate.includes(user.id) ? 'checked' : ''}">${selectedToDeactivate.includes(user.id) ? '✓' : ''}</div>
                <div class="avatar ${selectedToDeactivate.includes(user.id) ? 'selected' : ''}">${user.initials}</div>
                <div class="user-info">
                    <div class="user-name">${user.name}</div>
                    <div class="user-meta">${user.role ?? '—'}</div>
                </div>
                <div class="user-badges">
                    <span class="user-login ${loginClass}">${user.last_login_label}</span>
                    ${isSuggested && !selectedToDeactivate.includes(user.id) ? '<span class="tag-suggest">sugerido</span>' : ''}
                </div>
            `;
            item.addEventListener('click', () => toggleUser(user.id, toDeactivate, sorted));
            list.appendChild(item);
        });

        updateCounter();
    }

    function toggleUser(id, toDeactivate, sorted) {
        if (selectedToDeactivate.includes(id)) {
            selectedToDeactivate = selectedToDeactivate.filter(u => u !== id);
        } else if (selectedToDeactivate.length < toDeactivate) {
            selectedToDeactivate.push(id);
        }
        // Re-render list items
        sorted.forEach(user => {
            const item = document.querySelector(`.user-item[data-id="${user.id}"]`);
            if (!item) return;
            const isSelected = selectedToDeactivate.includes(user.id);
            item.className = 'user-item' + (isSelected ? ' selected' : '');
            item.querySelector('.checkbox').className    = 'checkbox' + (isSelected ? ' checked' : '');
            item.querySelector('.checkbox').textContent  = isSelected ? '✓' : '';
            item.querySelector('.avatar').className      = 'avatar' + (isSelected ? ' selected' : '');
        });
        updateCounter();
    }

    function updateCounter() {
        const toDeactivate = Math.max(0, CURRENT_SEATS - newSeats);
        document.getElementById('selected-count').textContent = selectedToDeactivate.length;
        document.getElementById('btn-selected').textContent   = selectedToDeactivate.length;
        const btn = document.getElementById('btn-select-next');
        btn.disabled = selectedToDeactivate.length !== toDeactivate;
    }

    function buildConfirm() {
        const currentTier = getTier(CURRENT_SEATS);
        const newTier     = getTier(newSeats);
        const currentMRR  = currentTier.price * CURRENT_SEATS;
        const newMRR      = newTier.price * newSeats;
        const proration   = ((newMRR - currentMRR) * DAYS_REMAINING) / DAYS_IN_MONTH;
        const isUpgrade   = newSeats > CURRENT_SEATS;
        const isDowngrade = newSeats < CURRENT_SEATS;

        document.getElementById('label-confirm').textContent  = 'Gestão de Seats · Passo ' + (isDowngrade ? '3 de 3' : '2 de 2');
        document.getElementById('conf-old').textContent       = `${CURRENT_SEATS} users · €${currentTier.price.toFixed(2)}/user`;
        document.getElementById('conf-new').textContent       = `${newSeats} users · €${newTier.price.toFixed(2)}/user`;
        document.getElementById('conf-old-mrr').textContent   = fmt(currentMRR) + '/mês';
        document.getElementById('conf-new-mrr').textContent   = fmt(newMRR) + '/mês';
        document.getElementById('conf-new-mrr').style.color   = isUpgrade ? '#63d9a8' : '#fb923c';
        document.getElementById('conf-proration-label').textContent = isUpgrade ? 'Cobrado hoje' : 'Crédito na próxima fatura';
        document.getElementById('conf-proration').textContent = (isUpgrade ? '+' : '-') + fmt(Math.abs(proration));
        document.getElementById('conf-proration').style.color = isUpgrade ? '#63d9a8' : '#fb923c';

        const deactivatedRow = document.getElementById('conf-deactivated-row');
        if (isDowngrade) {
            deactivatedRow.style.display = 'flex';
            document.getElementById('conf-deactivated').textContent = selectedToDeactivate.length + ' arquivados';
        } else {
            deactivatedRow.style.display = 'none';
        }

        // Populate hidden form fields
        document.getElementById('form-new-seats').value       = newSeats;
        document.getElementById('form-deactivate-users').value = JSON.stringify(selectedToDeactivate);
    }

    // ── Event listeners ──

    document.getElementById('seat-slider').addEventListener('input', e => syncSeats(e.target.value));
    document.getElementById('seat-input').addEventListener('input', e => syncSeats(e.target.value));
    document.getElementById('btn-minus').addEventListener('click', () => syncSeats(newSeats - 1));
    document.getElementById('btn-plus').addEventListener('click', () => syncSeats(newSeats + 1));

    document.getElementById('btn-adjust-next').addEventListener('click', () => {
        if (newSeats < CURRENT_SEATS) {
            buildUserList();
            goTo('step-select-users');
        } else {
            buildConfirm();
            goTo('step-confirm');
        }
    });

    document.getElementById('btn-adjust-cancel').addEventListener('click', () => {
        syncSeats(CURRENT_SEATS);
        @if(session('from') === 'dashboard')
        window.location.href = '{{ route("company.dashboard") }}';
        @endif
    });

    document.getElementById('btn-select-next').addEventListener('click', () => {
        buildConfirm();
        goTo('step-confirm');
    });

    document.getElementById('btn-select-back').addEventListener('click', () => goTo('step-adjust'));
    document.getElementById('btn-confirm-back').addEventListener('click', () => {
        if (newSeats < CURRENT_SEATS) goTo('step-select-users');
        else goTo('step-adjust');
    });

    // Init
    updateSlider(CURRENT_SEATS);
    renderImpact();
</script>
</body>
</html>

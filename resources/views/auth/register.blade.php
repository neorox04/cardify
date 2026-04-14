<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Cardify</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="theme-color" content="#6366f1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #09090b;
            --bg-secondary: #18181b;
            --bg-tertiary: #27272a;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --text-tertiary: #71717a;
            --border: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.15);
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --gradient-1: linear-gradient(135deg, #6366f1, #8b5cf6, #06b6d4);
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --error: #ef4444;
            --success: #10b981;
        }

        [data-theme="light"] {
            --bg-primary: #fafafa;
            --bg-secondary: #f0f0f3;
            --bg-tertiary: #e8e8ec;
            --text-primary: #09090b;
            --text-secondary: #52525b;
            --text-tertiary: #71717a;
            --border: rgba(0, 0, 0, 0.08);
            --border-hover: rgba(0, 0, 0, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-container { width: 100%; max-width: 420px; }

        .auth-brand { text-align: center; margin-bottom: 40px; }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 28px;
            font-weight: 800;
            text-decoration: none;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
        }

        .auth-header { text-align: center; margin-bottom: 28px; }

        .auth-title { font-size: 24px; font-weight: 700; letter-spacing: -0.5px; margin-bottom: 8px; }

        .auth-subtitle { font-size: 15px; color: var(--text-secondary); }

        /* ── Account type toggle ── */
        .type-toggle {
            display: flex;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 4px;
            margin-bottom: 28px;
            gap: 4px;
        }

        .type-btn {
            flex: 1;
            padding: 10px 12px;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            background: transparent;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .type-btn.active {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 2px 8px rgba(99,102,241,0.35);
        }

        .type-btn svg { flex-shrink: 0; }

        /* ── Form fields ── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-label .optional {
            font-weight: 400;
            color: var(--text-tertiary);
            font-size: 12px;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px;
            font-size: 15px;
            font-family: inherit;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .form-input::placeholder { color: var(--text-tertiary); }
        .form-input:hover { border-color: var(--border-hover); }
        .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .form-input.error { border-color: var(--error); }

        .error-message { color: var(--error); font-size: 13px; margin-top: 6px; font-weight: 500; }
        .form-hint { font-size: 13px; color: var(--text-tertiary); margin-top: 6px; }

        /* Company fields - hidden by default */
        .company-fields {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.3s ease;
        }
        .company-fields.visible {
            max-height: 700px;
            opacity: 1;
        }

        /* Logo upload */
        .logo-upload-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }

        .logo-preview {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            border: 1px dashed var(--border);
            background: var(--bg-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            transition: var(--transition);
        }

        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 13px;
        }

        .logo-preview svg { color: var(--text-tertiary); }

        .logo-upload-info { flex: 1; }

        .logo-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 4px;
        }
        .logo-upload-btn:hover { border-color: var(--border-hover); color: var(--text-primary); }

        .logo-hint { font-size: 12px; color: var(--text-tertiary); }

        /* Industry select */
        .form-select {
            width: 100%;
            padding: 13px 16px;
            font-size: 15px;
            font-family: inherit;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            transition: var(--transition);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2371717a' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
            cursor: pointer;
        }
        .form-select:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .form-select option { background: #18181b; }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }
        .section-divider span {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }
        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .btn {
            width: 100%;
            padding: 14px 24px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(99,102,241,0.3);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-secondary);
        }
        .auth-footer a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { color: var(--accent-hover); }

        .theme-toggle {
            position: fixed;
            top: 24px;
            right: 24px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .theme-toggle:hover { border-color: var(--border-hover); color: var(--text-primary); }
        .theme-toggle svg { width: 18px; height: 18px; }
        .theme-toggle .sun { display: none; }
        .theme-toggle .moon { display: block; }
        [data-theme="light"] .theme-toggle .sun { display: block; }
        [data-theme="light"] .theme-toggle .moon { display: none; }
    </style>
</head>
<body>
    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
        <svg class="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <svg class="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
    </button>

    <div class="auth-container">
        <div class="auth-brand">
            <a href="/" class="logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#06b6d4"/>
                            <stop offset="100%" style="stop-color:#6366f1"/>
                        </linearGradient>
                    </defs>
                    <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14c2.5 0 4.5-0.5 6.5-1.5" stroke="url(#logoGradient)" stroke-width="3" stroke-linecap="round" fill="none"/>
                    <path d="M22 8l4 4-4 4" stroke="url(#logoGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
                Cardify
            </a>
        </div>

        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Criar conta</h1>
                <p class="auth-subtitle">Comece a modernizar o seu networking</p>
            </div>

            {{-- Account type toggle --}}
            <div class="type-toggle">
                <button type="button" class="type-btn active" id="btn-individual" onclick="setType('individual')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Individual
                </button>
                <button type="button" class="type-btn" id="btn-company" onclick="setType('company')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    Empresa
                </button>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'individual') }}">

                {{-- Nome --}}
                <div class="form-group">
                    <label for="name" class="form-label" id="label-name">Nome completo</label>
                    <input type="text" id="name" name="name"
                        class="form-input @error('name') error @enderror"
                        value="{{ old('name') }}" required autofocus
                        placeholder="João Silva">
                    @error('name')<div class="error-message">{{ $message }}</div>@enderror
                    <p class="form-hint" id="name-hint" style="display:none">O teu nome pessoal, não o da empresa.</p>
                </div>

                {{-- Campos de empresa --}}
                <div class="company-fields {{ old('account_type') === 'company' ? 'visible' : '' }}" id="company-fields">
                    <div class="section-divider"><span>Dados da empresa</span></div>

                    <div class="form-group">
                        <label for="company_name" class="form-label">Nome da empresa</label>
                        <input type="text" id="company_name" name="company_name"
                            class="form-input @error('company_name') error @enderror"
                            value="{{ old('company_name') }}"
                            placeholder="Cardify, Lda.">
                        @error('company_name')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="nif" class="form-label">
                            NIF <span class="optional">(opcional)</span>
                        </label>
                        <input type="text" id="nif" name="nif"
                            class="form-input @error('nif') error @enderror"
                            value="{{ old('nif') }}"
                            placeholder="PT123456789"
                            maxlength="20">
                        @error('nif')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    {{-- Logo --}}
                    <div class="form-group">
                        <label class="form-label">
                            Logo <span class="optional">(opcional)</span>
                        </label>
                        <div class="logo-upload-wrap">
                            <div class="logo-preview" id="logo-preview">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                            </div>
                            <div class="logo-upload-info">
                                <label for="logo" class="logo-upload-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Carregar logo
                                </label>
                                <input type="file" id="logo" name="logo" accept="image/*" style="display:none">
                                <p class="logo-hint">PNG, JPG até 2MB. Recomendado 200×200px.</p>
                            </div>
                        </div>
                        @error('logo')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    {{-- Indústria --}}
                    <div class="form-group">
                        <label for="industry" class="form-label">
                            Indústria <span class="optional">(opcional)</span>
                        </label>
                        <select id="industry" name="industry" class="form-select">
                            <option value="">Seleciona o setor</option>
                            <option value="tecnologia"         {{ old('industry') === 'tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                            <option value="saude"              {{ old('industry') === 'saude' ? 'selected' : '' }}>Saúde</option>
                            <option value="financas"           {{ old('industry') === 'financas' ? 'selected' : '' }}>Finanças & Banca</option>
                            <option value="educacao"           {{ old('industry') === 'educacao' ? 'selected' : '' }}>Educação</option>
                            <option value="retalho"            {{ old('industry') === 'retalho' ? 'selected' : '' }}>Retalho & E-commerce</option>
                            <option value="imobiliario"        {{ old('industry') === 'imobiliario' ? 'selected' : '' }}>Imobiliário</option>
                            <option value="construcao"         {{ old('industry') === 'construcao' ? 'selected' : '' }}>Construção & Engenharia</option>
                            <option value="juridico"           {{ old('industry') === 'juridico' ? 'selected' : '' }}>Jurídico & Consultoria</option>
                            <option value="marketing"          {{ old('industry') === 'marketing' ? 'selected' : '' }}>Marketing & Publicidade</option>
                            <option value="media"              {{ old('industry') === 'media' ? 'selected' : '' }}>Media & Entretenimento</option>
                            <option value="logistica"          {{ old('industry') === 'logistica' ? 'selected' : '' }}>Logística & Transportes</option>
                            <option value="alimentacao"        {{ old('industry') === 'alimentacao' ? 'selected' : '' }}>Alimentação & Restauração</option>
                            <option value="turismo"            {{ old('industry') === 'turismo' ? 'selected' : '' }}>Turismo & Hotelaria</option>
                            <option value="industria"          {{ old('industry') === 'industria' ? 'selected' : '' }}>Indústria & Manufactura</option>
                            <option value="energia"            {{ old('industry') === 'energia' ? 'selected' : '' }}>Energia & Ambiente</option>
                            <option value="outro"              {{ old('industry') === 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('industry')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    {{-- Website --}}
                    <div class="form-group">
                        <label for="website" class="form-label">
                            Website <span class="optional">(opcional)</span>
                        </label>
                        <input type="url" id="website" name="website"
                            class="form-input @error('website') error @enderror"
                            value="{{ old('website') }}"
                            placeholder="https://empresa.pt">
                        @error('website')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-input @error('email') error @enderror"
                        value="{{ old('email') }}" required
                        placeholder="nome@empresa.pt">
                    @error('email')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Palavra-passe</label>
                    <input type="password" id="password" name="password"
                        class="form-input @error('password') error @enderror"
                        required placeholder="Mínimo 6 caracteres">
                    <div class="form-hint">Use pelo menos 6 caracteres</div>
                    @error('password')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                {{-- Confirm password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar palavra-passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-input" required placeholder="Repita a palavra-passe">
                </div>

                <button type="submit" class="btn btn-primary" id="submit-btn">
                    Criar Conta
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </form>
        </div>

        <div class="auth-footer">
            Já tem conta? <a href="{{ route('login') }}">Entrar</a>
        </div>
    </div>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        html.setAttribute('data-theme', localStorage.getItem('theme') || 'dark');
        themeToggle.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });

        // Account type toggle
        const companyFields    = document.getElementById('company-fields');
        const companyNameInput = document.getElementById('company_name');
        const accountTypeInput = document.getElementById('account_type');
        const labelName        = document.getElementById('label-name');

        function setType(type) {
            accountTypeInput.value = type;

            document.getElementById('btn-individual').classList.toggle('active', type === 'individual');
            document.getElementById('btn-company').classList.toggle('active', type === 'company');

            const isCompany = type === 'company';
            companyFields.classList.toggle('visible', isCompany);
            companyNameInput.required = isCompany;
            labelName.textContent = isCompany ? 'Nome do responsável' : 'Nome completo';
            document.getElementById('name-hint').style.display = isCompany ? 'block' : 'none';
        }

        // Logo preview
        document.getElementById('logo').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('logo-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Logo">`;
                preview.style.border = '1px solid var(--border)';
            };
            reader.readAsDataURL(file);
        });

        // Restore state on validation error
        const savedType = document.getElementById('account_type').value;
        if (savedType === 'company') setType('company');
    </script>
</body>
</html>

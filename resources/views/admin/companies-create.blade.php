@extends('layouts.dashboard')

@section('title', 'Nova Empresa')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Nova Empresa</h1>
        <p class="page-subtitle">Adicionar uma nova empresa à plataforma</p>
    </div>
    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Voltar
    </a>
</div>

@if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="content-section">
    <form action="{{ route('admin.companies.store') }}" method="POST" class="company-form">
        @csrf
        
        <div class="form-section">
            <h3 class="form-section-title">Informações Básicas</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">Nome da Empresa *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Ex: Empresa XYZ">
                </div>
                
                <div class="form-group">
                    <label for="slug" class="form-label">Slug (URL) *</label>
                    <input type="text" id="slug" name="slug" class="form-input" value="{{ old('slug') }}" required placeholder="ex: empresa-xyz">
                    <small class="form-hint">Identificador único para URLs (sem espaços, apenas letras minúsculas e hífens)</small>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Descrição</label>
                <textarea id="description" name="description" class="form-input form-textarea" rows="3" placeholder="Breve descrição da empresa...">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Contactos</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="contacto@empresa.com">
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="+351 912 345 678">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" id="website" name="website" class="form-input" value="{{ old('website') }}" placeholder="https://www.empresa.com">
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Morada</label>
                    <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}" placeholder="Rua Exemplo, 123, Lisboa">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Detalhes da Empresa</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="industry" class="form-label">Indústria</label>
                    <select id="industry" name="industry" class="form-input">
                        <option value="">Selecionar...</option>
                        <option value="Tecnologia" {{ old('industry') === 'Tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                        <option value="Saúde" {{ old('industry') === 'Saúde' ? 'selected' : '' }}>Saúde</option>
                        <option value="Educação" {{ old('industry') === 'Educação' ? 'selected' : '' }}>Educação</option>
                        <option value="Finanças" {{ old('industry') === 'Finanças' ? 'selected' : '' }}>Finanças</option>
                        <option value="Retalho" {{ old('industry') === 'Retalho' ? 'selected' : '' }}>Retalho</option>
                        <option value="Indústria" {{ old('industry') === 'Indústria' ? 'selected' : '' }}>Indústria</option>
                        <option value="Serviços" {{ old('industry') === 'Serviços' ? 'selected' : '' }}>Serviços</option>
                        <option value="Consultoria" {{ old('industry') === 'Consultoria' ? 'selected' : '' }}>Consultoria</option>
                        <option value="Marketing" {{ old('industry') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Imobiliário" {{ old('industry') === 'Imobiliário' ? 'selected' : '' }}>Imobiliário</option>
                        <option value="Outro" {{ old('industry') === 'Outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="size" class="form-label">Tamanho</label>
                    <select id="size" name="size" class="form-input">
                        <option value="">Selecionar...</option>
                        <option value="startup" {{ old('size') === 'startup' ? 'selected' : '' }}>Startup (1-10 colaboradores)</option>
                        <option value="small" {{ old('size') === 'small' ? 'selected' : '' }}>Pequena (11-50 colaboradores)</option>
                        <option value="medium" {{ old('size') === 'medium' ? 'selected' : '' }}>Média (51-200 colaboradores)</option>
                        <option value="large" {{ old('size') === 'large' ? 'selected' : '' }}>Grande (201-1000 colaboradores)</option>
                        <option value="enterprise" {{ old('size') === 'enterprise' ? 'selected' : '' }}>Enterprise (1000+ colaboradores)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="founded_year" class="form-label">Ano de Fundação</label>
                    <input type="number" id="founded_year" name="founded_year" class="form-input" value="{{ old('founded_year') }}" min="1800" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.companies') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Criar Empresa
            </button>
        </div>
    </form>
</div>

<style>
    .company-form {
        max-width: 800px;
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--border);
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 14px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        font-size: 14px;
        transition: var(--transition);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-subtle);
    }

    .form-input::placeholder {
        color: var(--text-tertiary);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-hint {
        display: block;
        font-size: 12px;
        color: var(--text-tertiary);
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding-top: 20px;
    }

    .alert {
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: var(--error-subtle);
        color: var(--error);
        border: 1px solid var(--error);
    }
</style>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Remove accents
            .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single
            .trim();
        document.getElementById('slug').value = slug;
    });
</script>
@endsection

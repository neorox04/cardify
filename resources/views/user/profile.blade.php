@extends('layouts.dashboard')

@section('title', 'Perfil')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">O Meu Perfil</h1>
        <p class="page-subtitle">Gerir as suas informações pessoais</p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('user.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Informações Pessoais</h3>
            
            <div class="form-group">
                <label for="name" class="form-label">Nome</label>
                <input 
                    type="text" 
                    id="name" 
                    class="form-input"
                    value="{{ $user->name }}" 
                    disabled
                >
                <p style="font-size: 12px; color: var(--text-tertiary); margin-top: 6px;">O nome não pode ser alterado. Contacta o suporte se precisares de ajuda.</p>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email *</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input @error('email') error @enderror"
                    value="{{ old('email', $user->email) }}"
                    required
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Alterar Palavra-passe</h3>
            <p style="font-size: 14px; color: #737373; margin-bottom: 20px;">Deixe em branco se não deseja alterar</p>
            
            <div class="form-group">
                <label for="current_password" class="form-label">Palavra-passe Atual</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="form-input @error('current_password') error @enderror"
                >
                @error('current_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Nova Palavra-passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input @error('password') error @enderror"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar Nova Palavra-passe</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input"
                >
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Avatar</h3>
            <p style="font-size:13px;color:var(--ink-mute,#8b8b93);margin:-4px 0 16px;">
                Escolhe o estilo do teu avatar. É usado nos teus cartões quando não tens foto carregada.
            </p>
            <div class="avatar-picker">
                @foreach(\App\Support\Avatar::STYLES as $key => $label)
                    <label class="avatar-tile {{ old('avatar_style', $user->avatar_style ?? \App\Support\Avatar::DEFAULT_STYLE) === $key ? 'selected' : '' }}">
                        <input type="radio" name="avatar_style" value="{{ $key }}"
                               {{ old('avatar_style', $user->avatar_style ?? \App\Support\Avatar::DEFAULT_STYLE) === $key ? 'checked' : '' }}>
                        <span class="avatar-tile-av"><x-avatar :name="$user->name" :style="$key" :size="72" /></span>
                        <span class="avatar-tile-label">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .avatar-picker { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .avatar-tile { background: var(--bg-2, #0f1117); border: 2px solid var(--line-soft, rgba(255,255,255,0.09)); border-radius: 14px; padding: 14px 8px 10px; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 9px; transition: all .15s; }
    .avatar-tile:hover { border-color: rgba(184,132,255,0.45); }
    .avatar-tile.selected { border-color: #B884FF; box-shadow: 0 0 0 3px rgba(184,132,255,0.15); }
    .avatar-tile input { position: absolute; opacity: 0; pointer-events: none; }
    .avatar-tile-label { font-size: 12px; font-weight: 600; color: var(--ink-dim, #c9c9d1); }
    .avatar-tile.selected .avatar-tile-label { color: var(--ink, #fff); }
    @media (max-width: 520px) { .avatar-picker { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.avatar-picker input[type=radio]').forEach(function (input) {
        input.addEventListener('change', function () {
            document.querySelectorAll('.avatar-tile').forEach(function (t) { t.classList.remove('selected'); });
            input.closest('.avatar-tile').classList.add('selected');
        });
    });
</script>
@endpush
@endsection

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

        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
        </div>
    </form>
</div>
@endsection

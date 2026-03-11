@extends('layouts.dashboard')

@section('title', 'Criar Cartão')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Criar Cartão de Visita</h1>
        <p class="page-subtitle">Preencha os dados do seu novo cartão digital</p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('business-cards.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">Informações Pessoais</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name" class="form-label">Nome Completo *</label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        class="form-input @error('full_name') error @enderror"
                        value="{{ old('full_name') }}" 
                        required
                    >
                    @error('full_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="job_title" class="form-label">Cargo *</label>
                    <input 
                        type="text" 
                        id="job_title" 
                        name="job_title" 
                        class="form-input @error('job_title') error @enderror"
                        value="{{ old('job_title') }}"
                        required
                    >
                    @error('job_title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') error @enderror"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Telefone</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        class="form-input @error('phone') error @enderror"
                        value="{{ old('phone') }}"
                    >
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="company_id" class="form-label">Empresa</label>
                <select id="company_id" name="company_id" class="form-input @error('company_id') error @enderror">
                    <option value="">Selecione uma empresa</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Endereço</h3>
            
            <div class="form-group">
                <label for="address" class="form-label">Morada</label>
                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                    class="form-input @error('address') error @enderror"
                    value="{{ old('address') }}"
                >
                @error('address')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city" class="form-label">Cidade</label>
                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        class="form-input @error('city') error @enderror"
                        value="{{ old('city') }}"
                    >
                    @error('city')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country" class="form-label">País</label>
                    <input 
                        type="text" 
                        id="country" 
                        name="country" 
                        class="form-input @error('country') error @enderror"
                        value="{{ old('country', 'Portugal') }}"
                    >
                    @error('country')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Outros</h3>
            
            <div class="form-group">
                <label for="website" class="form-label">Website</label>
                <input 
                    type="url" 
                    id="website" 
                    name="website" 
                    class="form-input @error('website') error @enderror"
                    value="{{ old('website') }}"
                    placeholder="https://"
                >
                @error('website')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio" class="form-label">Biografia</label>
                <textarea 
                    id="bio" 
                    name="bio" 
                    class="form-input @error('bio') error @enderror"
                    rows="4"
                >{{ old('bio') }}</textarea>
                @error('bio')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_photo" class="form-label">Foto de Perfil</label>
                <input 
                    type="file" 
                    id="profile_photo" 
                    name="profile_photo" 
                    class="form-input @error('profile_photo') error @enderror"
                    accept="image/*"
                >
                @error('profile_photo')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Criar Cartão</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Editar ' . $company->name)

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Editar Empresa</h1>
        <p class="page-subtitle">Atualizar dados de {{ $company->name }}</p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('company.update', $company) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Informações da Empresa</h3>
            
            <div class="form-group">
                <label for="name" class="form-label">Nome da Empresa *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') error @enderror"
                    value="{{ old('name', $company->name) }}" 
                    required
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Descrição</label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-input @error('description') error @enderror"
                    rows="4"
                >{{ old('description', $company->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if($company->logo)
                <div class="form-group">
                    <label class="form-label">Logotipo Atual</label>
                    <img src="{{ Storage::url($company->logo) }}" alt="Logo" style="max-width: 150px;">
                </div>
            @endif

            <div class="form-group">
                <label for="logo" class="form-label">{{ $company->logo ? 'Alterar Logotipo' : 'Logotipo' }}</label>
                <input 
                    type="file" 
                    id="logo" 
                    name="logo" 
                    class="form-input @error('logo') error @enderror"
                    accept="image/*"
                >
                @error('logo')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('company.show', $company) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
        </div>
    </form>
</div>
@endsection

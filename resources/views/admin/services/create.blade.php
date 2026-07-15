@extends('layouts.admin')

@section('title', isset($service) && $service->exists ? __('messages.adm_edit_service') : __('messages.adm_create_service'))
@section('page-title', isset($service) && $service->exists ? __('messages.adm_edit_service') : __('messages.adm_create_service'))
@section('page-subtitle', __('messages.adm_service_management'))

@section('content')

<style>
    .service-form {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-section h4 {
        color: var(--text);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: var(--text);
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        color: var(--text);
    }

    .btn-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    @media (max-width:768px){
        .form-row{grid-template-columns:1fr;}
    }
</style>

<div class="service-form">

    {{-- SUCCÈS --}}
    @if(session('success'))
        <div class="alert alert-success">
            <strong>{{ __('messages.adm_success') }} :</strong>
            {{ session('success') }}
        </div>
    @endif

    {{-- ERREURS --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('messages.adm_errors') }} :</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULAIRE --}}
    <form 
        action="{{ isset($service) && $service->exists 
            ? route('admin.services.update', $service->id) 
            : route('admin.services.store') }}" 
        method="POST" 
        enctype="multipart/form-data">

        @csrf

        @if(isset($service) && $service->exists)
            @method('PATCH')
        @endif

        {{-- INFORMATIONS --}}
        <div class="form-section">
            <h4>📋 Informations générales</h4>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.adm_name') }} *</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $service->name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.salons') }} *</label>
                    <select name="salon_id" class="form-control" required>
                        <option value="">Choisir un salon</option>
                        @foreach($salons as $salon)
                            <option value="{{ $salon->id }}"
                                {{ old('salon_id', $service->salon_id ?? '') == $salon->id ? 'selected' : '' }}>
                                {{ $salon->name ?? $salon->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('messages.adm_category') }} *</label>
                <select name="categorie_id" class="form-control" required>
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}"
                            {{ old('categorie_id', $service->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('messages.adm_description') }}</label>
                <textarea name="description" class="form-control">
                    {{ old('description', $service->description ?? '') }}
                </textarea>
            </div>
        </div>

        {{-- DUREE --}}
        <div class="form-section">
            <h4>{{ __('messages.adm_duration') }}</h4>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.adm_duration') }} (min)</label>
                    <input type="number" name="duration" class="form-control"
                        value="{{ old('duration', $service->duration ?? '') }}" required>
                </div>
            </div>
        </div>

        {{-- MEDIA --}}
        <div class="form-section">
            <h4>Média</h4>

            <div class="form-group">
                <label class="form-label">Emoji (max 4 caractères)</label>
                <input type="text" name="emoji" class="form-control"
                    value="{{ old('emoji', $service->emoji ?? '') }}" maxlength="4">
                @error('emoji')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('messages.adm_image') }}</label>
                <input type="file" name="image" class="form-control">

                @if(isset($service) && $service->image)
                    <img src="{{ asset('storage/'.$service->image) }}" width="120">
                @endif
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                    {{ __('messages.active') }}
                </label>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="btn-group">
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                {{ __('messages.btn_cancel') }}
            </a>

            <button type="submit" class="btn btn-primary">
                {{ isset($service) && $service->exists ? __('messages.btn_update') : __('messages.btn_create') }}
            </button>
        </div>

    </form>
</div>

@endsection
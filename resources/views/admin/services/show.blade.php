@extends('layouts.admin')

@section('title', __('messages.adm_service_details'))

@section('page-title', __('messages.adm_service_details'))
@section('page-subtitle', __('messages.adm_service_management'))

@section('content')

<style>
    /* ===== TON CSS INCHANGÉ ===== */
    .service-details {
        max-width: 800px;
        margin: 0 auto;
    }

    .detail-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .detail-section h4 {
        color: var(--text);
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .detail-item {
        margin-bottom: 16px;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: var(--text);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        color: var(--text);
        font-size: 16px;
        font-weight: 400;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .detail-textarea {
        min-height: 80px;
        resize: vertical;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text);
        font-size: 14px;
        width: 100%;
        margin-top: 8px;
    }

    .image-preview {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 10px;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .emoji-display {
        font-size: 24px;
        margin-right: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 77, 109, 0.3);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 12px 24px;
        border-radius: 8px;
        color: var(--text);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<div class="service-details">

    <!-- Informations générales -->
    <div class="detail-section">
        <h4><i class="fa-solid fa-clipboard-list"></i> {{ __('messages.adm_general_info') }}</h4>

        <div class="detail-row">
            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_service_name') }}</span>
                <div class="detail-value">
                    <span class="emoji-display">{{ $service->emoji }}</span>
                    {{ $service->name }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_category') }}</span>
                <div class="detail-value">{{ $service->categorie?->name ?? __('messages.adm_no_desc') }}</div>
            </div>
        </div>

        @if($service->description)
        <div class="detail-item">
            <span class="detail-label">{{ __('messages.adm_description') }}</span>
            <div class="detail-textarea" readonly>{{ $service->description }}</div>
        </div>
        @endif
    </div>

    <!-- Prix et durée -->
    <div class="detail-section">
        <h4><i class="fa-solid fa-coins"></i> {{ __('messages.adm_price') }} & {{ __('messages.adm_duration') }}</h4>

        <div class="detail-row">
            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_price') }}</span>
                <div class="detail-value">{{ number_format($service->price ?? 0, 0, ',', ' ') }}</div>
            </div>

            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_duration') }}</span>
                <div class="detail-value">{{ $service->duration ?? 0 }} minutes</div>
            </div>
        </div>
    </div>

    <!-- Image -->
    @if($service->image)
    <div class="detail-section">
        <h4><i class="fa-solid fa-image"></i> {{ __('messages.adm_image') }}</h4>
        <img src="{{ asset('storage/' . $service->image) }}" class="image-preview" alt="Image du service">
    </div>
    @endif

    <!-- Statut -->
    <div class="detail-section">
        <h4><i class="fa-solid fa-gear"></i> {{ __('messages.adm_status') }}</h4>

        <div class="detail-item">
            <span class="detail-label">{{ __('messages.adm_service_status') }}</span>
            <div class="detail-value">
                @if($service->is_active)
                    <span class="status-badge status-active">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ __('messages.adm_service_active') }}
                    </span>
                @else
                    <span class="status-badge status-inactive">
                        <i class="fa-solid fa-circle-xmark"></i>
                        {{ __('messages.adm_service_disabled') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Dates -->
    <div class="detail-section">
        <h4><i class="fa-solid fa-calendar"></i> {{ __('messages.adm_temporal_info') }}</h4>

        <div class="detail-row">
            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_created_at') }}</span>
                <div class="detail-value">{{ $service->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="detail-item">
                <span class="detail-label">{{ __('messages.adm_modified_at') }}</span>
                <div class="detail-value">{{ $service->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="detail-section">
        <div style="display:flex; justify-content:flex-end; gap:12px;">
            <a href="{{ route('admin.inventaire') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> {{ __('messages.adm_back_inventory') }}
            </a>

            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('messages.btn_edit') }}
            </a>
        </div>
    </div>

</div>

@endsection
@extends('layouts.admin')

@section('title', __('messages.adm_create_salon_title'))
@section('page-title', __('messages.adm_create_salon_title'))
@section('page-subtitle', __('messages.adm_salon_management'))

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap');

    :root{
        --gold:#d4af37;
        --gold-light:#f5deb3;
        --dark:#0f172a;
        --muted:#94a3b8;
        --border:rgba(255,255,255,0.08);
        --glass:rgba(255,255,255,0.04);
        --danger:#ef4444;
    }

    .salon-create-page{
        font-family:'Inter',sans-serif;
    }

    /* ================= HEADER ================= */

    .create-header{
        margin-bottom:32px;
        display:flex;
        align-items:flex-end;
        justify-content:space-between;
        gap:20px;
        flex-wrap:wrap;
    }

    .create-eyebrow{
        display:inline-flex;
        align-items:center;
        gap:8px;
        font-size:11px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.14em;
        color:var(--gold);
        margin-bottom:12px;
    }

    .create-title{
        font-family:'Cormorant Garamond',serif;
        font-size:42px;
        line-height:1;
        font-weight:700;
        color:#fff;
        margin:0;
    }

    .create-subtitle{
        margin-top:12px;
        color:var(--muted);
        font-size:14px;
        max-width:680px;
    }

    /* ================= CARD ================= */

    .create-card{
        background:linear-gradient(
            180deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.025)
        );

        border:1px solid var(--border);
        border-radius:28px;
        overflow:hidden;
        backdrop-filter:blur(12px);
        box-shadow:
            0 20px 60px rgba(0,0,0,.35),
            inset 0 1px 0 rgba(255,255,255,.04);
    }

    .card-top{
        padding:28px 32px;
        border-bottom:1px solid rgba(255,255,255,0.06);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
        flex-wrap:wrap;
    }

    .card-top-title{
        font-size:18px;
        font-weight:700;
        color:#fff;
        display:flex;
        align-items:center;
        gap:12px;
    }

    .card-top-title i{
        width:42px;
        height:42px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:rgba(212,175,55,0.12);
        color:var(--gold);
        font-size:17px;
    }

    .card-top-text{
        color:var(--muted);
        font-size:13px;
        margin-top:5px;
    }

    /* ================= FORM ================= */

    .form-body{
        padding:32px;
    }

    .section-title{
        display:flex;
        align-items:center;
        gap:10px;
        margin-bottom:20px;
        color:#fff;
        font-weight:700;
        font-size:15px;
    }

    .section-title i{
        color:var(--gold);
    }

    .glass-block{
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.06);
        border-radius:22px;
        padding:24px;
        margin-bottom:24px;
    }

    .form-label{
        color:#e2e8f0;
        font-size:13px;
        font-weight:600;
        margin-bottom:8px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .form-label i{
        color:var(--gold);
        font-size:12px;
    }

    .form-control{
        width:100%;
        background:rgba(255,255,255,0.08);
        border:1px solid rgba(255,255,255,0.15);
        border-radius:16px;
        padding:14px 16px;
        color:#ffffff;
        font-size:14px;
        transition:.2s ease;
    }

    .form-control::placeholder{
        color:#94a3b8;
    }

    .form-control:focus{
        outline:none;
        border-color:rgba(212,175,55,0.8);
        box-shadow:0 0 0 4px rgba(212,175,55,0.15);
        background:rgba(255,255,255,0.12);
        color:#ffffff;
    }

    textarea.form-control{
        min-height:120px;
        resize:none;
    }

    /* ================= LOGO ================= */

    .logo-upload{
        display:flex;
        align-items:center;
        gap:22px;
        flex-wrap:wrap;
    }

    .logo-preview{
        width:130px;
        height:130px;
        border-radius:24px;
        background:rgba(255,255,255,0.04);
        border:1px dashed rgba(212,175,55,0.35);
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
        flex-shrink:0;
    }

    .logo-preview img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .logo-placeholder{
        text-align:center;
        color:#64748b;
    }

    .logo-placeholder i{
        font-size:34px;
        margin-bottom:8px;
        color:var(--gold);
    }

    .upload-btn{
        position:relative;
        overflow:hidden;
        display:inline-flex;
        align-items:center;
        gap:10px;
        background:rgba(212,175,55,0.12);
        color:var(--gold-light);
        padding:13px 18px;
        border-radius:14px;
        font-size:13px;
        font-weight:700;
        cursor:pointer;
        transition:.2s;
        border:1px solid rgba(212,175,55,0.15);
    }

    .upload-btn:hover{
        transform:translateY(-2px);
        background:rgba(212,175,55,0.18);
    }

    .upload-btn input{
        display:none;
    }

    .upload-info{
        margin-top:10px;
        color:#64748b;
        font-size:12px;
    }

    /* ================= HOURS ================= */

    .hours-grid{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:18px;
    }

    .hour-item{
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.06);
        border-radius:18px;
        padding:16px;
    }

    .day-label{
        color:#fff;
        font-size:13px;
        font-weight:700;
        margin-bottom:10px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .day-label i{
        color:var(--gold);
        font-size:12px;
    }

    /* ================= ALERT ================= */

    .alert-danger{
        background:rgba(239,68,68,0.08);
        border:1px solid rgba(239,68,68,0.18);
        color:#fecaca;
        border-radius:18px;
        padding:18px 20px;
        margin-bottom:24px;
    }

    .alert-danger ul{
        margin:10px 0 0;
        padding-left:20px;
    }

    /* ================= ACTIONS ================= */

    .form-actions{
        display:flex;
        align-items:center;
        gap:14px;
        flex-wrap:wrap;
        margin-top:32px;
    }

    .btn-save{
        border:none;
        display:inline-flex;
        align-items:center;
        gap:10px;
        background:linear-gradient(135deg,#d4af37,#f4d06f);
        color:#111827;
        font-weight:700;
        font-size:14px;
        padding:15px 24px;
        border-radius:16px;
        transition:.2s;
        box-shadow:0 12px 30px rgba(212,175,55,0.25);
    }

    .btn-save:hover{
        transform:translateY(-2px);
    }

    .btn-cancel{
        display:inline-flex;
        align-items:center;
        gap:10px;
        background:rgba(255,255,255,0.05);
        border:1px solid rgba(255,255,255,0.08);
        color:#e2e8f0;
        padding:15px 22px;
        border-radius:16px;
        text-decoration:none;
        transition:.2s;
        font-weight:600;
    }

    .btn-cancel:hover{
        background:rgba(255,255,255,0.08);
        color:#fff;
    }

    /* ================= RESPONSIVE ================= */

    @media(max-width:768px){

        .create-title{
            font-size:32px;
        }

        .form-body,
        .card-top{
            padding:22px;
        }

        .hours-grid{
            grid-template-columns:1fr;
        }

        .logo-upload{
            flex-direction:column;
            align-items:flex-start;
        }

    }

</style>

<div class="salon-create-page">

    {{-- HEADER --}}
    <div class="create-header">

        <div>

            <div class="create-eyebrow">
                <i class="fa-solid fa-building"></i>
                {{ __('messages.adm_salon_admin') }}
            </div>

            <h1 class="create-title">
                {{ __('messages.adm_create_salon_title') }}
            </h1>

            <p class="create-subtitle">
                {{ __('messages.adm_create_salon_desc') }}
            </p>

        </div>

    </div>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert-danger">
            <strong>
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Des erreurs empêchent l'enregistrement :
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD --}}
    <div class="create-card">

        {{-- TOP --}}
        <div class="card-top">

            <div>

                <div class="card-top-title">
                    <i class="fa-solid fa-shop"></i>
                    {{ __('messages.adm_salon_config') }}
                </div>

                <div class="card-top-text">
                    {{ __('messages.adm_salon_config_desc') }}
                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="form-body">

            <form method="POST"
                  action="{{ route('admin.salons.store') }}"
                  enctype="multipart/form-data">

                @csrf

                {{-- INFOS --}}
                <div class="glass-block">

                    <div class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        {{ __('messages.adm_general_info') }}
                    </div>

                    <div class="row">

                        <div class="col-lg-6 mb-4">

                            <label class="form-label">
                                <i class="fa-solid fa-shop"></i>
                                {{ __('messages.adm_salon_name') }} *
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   placeholder="Ex : Luxury Hair Studio"
                                   required>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <label class="form-label">
                                <i class="fa-solid fa-envelope"></i>
                                {{ __('messages.adm_email_address') }} *
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   placeholder="contact@salon.com"
                                   required>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <label class="form-label">
                                <i class="fa-solid fa-phone"></i>
                                {{ __('messages.phone') }} *
                            </label>

                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone') }}"
                                   placeholder="+225 07 00 00 00 00"
                                   required>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <label class="form-label">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ __('messages.adm_city') }} *
                            </label>

                            <input type="text"
                                   name="city"
                                   class="form-control"
                                   value="{{ old('city') }}"
                                   placeholder="Abidjan"
                                   required>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            <i class="fa-solid fa-map-location-dot"></i>
                            {{ __('messages.adm_full_address') }} *
                        </label>

                        <input type="text"
                               name="address"
                               class="form-control"
                               value="{{ old('address') }}"
                               placeholder="Cocody Deux-Plateaux..."
                               required>

                    </div>

                    <div>

                        <label class="form-label">
                            <i class="fa-solid fa-align-left"></i>
                            {{ __('messages.adm_description') }}
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  placeholder="Décrivez le salon, son ambiance, ses spécialités...">{{ old('description') }}</textarea>

                    </div>

                </div>

                {{-- LOGO --}}
                <div class="glass-block">

                    <div class="section-title">
                        <i class="fa-solid fa-image"></i>
                        {{ __('messages.adm_visual_identity') }}
                    </div>

                    <div class="logo-upload">

                        <div class="logo-preview" id="logoPreview">

                            <div class="logo-placeholder">
                                <i class="fa-solid fa-camera"></i>
                                <div>Logo</div>
                            </div>

                        </div>

                        <div>

                            <label class="upload-btn">

                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                {{ __('messages.adm_choose_logo') }}

                                <input type="file"
                                       name="logo"
                                       id="logoInput"
                                       accept="image/*">

                            </label>

                            <div class="upload-info">
                                PNG, JPG ou WEBP — Max 2MB
                            </div>

                        </div>

                    </div>

                </div>

                {{-- HORAIRES --}}
                <div class="glass-block">

                    <div class="section-title">
                        <i class="fa-solid fa-clock"></i>
                        {{ __('messages.adm_opening_hours_title') }}
                    </div>

                    <div class="hours-grid">

                        @php
                            $days = [
                                'Lundi',
                                'Mardi',
                                'Mercredi',
                                'Jeudi',
                                'Vendredi',
                                'Samedi',
                                'Dimanche'
                            ];
                        @endphp

                        @foreach($days as $day)

                            <div class="hour-item">

                                <div class="day-label">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $day }}
                                </div>

                                <input type="text"
                                       name="opening_hours[{{ $day }}]"
                                       class="form-control"
                                       placeholder="{{ $day === 'Dimanche' ? 'Fermé' : '09:00 - 18:00' }}"
                                       value="{{ old('opening_hours.' . $day) }}">

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="form-actions">

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ __('messages.adm_create_salon_btn') }}
                    </button>

                    <a href="{{ route('admin.salons') }}"
                       class="btn-cancel">

                        <i class="fa-solid fa-arrow-left"></i>
                        {{ __('messages.btn_back') }}

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- PREVIEW --}}
<script>

    const logoInput = document.getElementById('logoInput');
    const logoPreview = document.getElementById('logoPreview');

    logoInput.addEventListener('change', function(e){

        const file = e.target.files[0];

        if(!file) return;

        const reader = new FileReader();

        reader.onload = function(event){

            logoPreview.innerHTML = `
                <img src="${event.target.result}" alt="Logo Preview">
            `;

        }

        reader.readAsDataURL(file);

    });

</script>

@endsection
{{-- @extends('layouts.admin')
@section('title', 'Info Salon')
@section('page-title', 'Informations du salon')
@section('page-subtitle', "Mettez à jour l'identité et les informations de contact du salon")

@section('content')
<div class="admin-card">
    <h3>Profil du salon</h3>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="p-4" style="border-radius:18px;background:rgba(255,255,255,0.04);border:1px solid rgba(148,163,184,0.12);">
                <h5>{{ $salon->nom ?? 'Salon Marol Hair' }}</h5>
                <p class="text-muted">{{ $salon->description ?? 'Salon premium de coiffure et tressage 100% luxe.' }}</p>
                <ul class="list-unstyled text-muted mt-3">
                    <li><strong>Adresse :</strong> {{ $salon->address ?? 'Non renseignée' }}</li>
                    <li><strong>Téléphone :</strong> {{ $salon->phone ?? 'Non renseigné' }}</li>
                    <li><strong>Email :</strong> {{ $salon->email ?? 'Non renseigné' }}</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="p-4" style="border-radius:18px;background:rgba(255,255,255,0.03);border:1px solid rgba(148,163,184,0.12);">
                <h5>Détails supplémentaires</h5>
                <p class="text-muted">Contrôlez facilement l'affichage public du salon et les informations de prise de contact.</p>
                <button class="btn btn-admin mt-3">{{ __('messages.adm_info_salon_btn') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.admin')

@section('title', __('messages.salon_info_title'))
@section('page-title', __('messages.salon_info_profile_title'))
@section('page-subtitle', __('messages.salon_info_subtitle'))

@section('content')

<style>
    .salon-wrapper{
        display:grid;
        grid-template-columns:380px 1fr;
        gap:28px;
    }

    .salon-card{
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(148,163,184,0.12);
        border-radius:24px;
        overflow:hidden;
        backdrop-filter:blur(10px);
    }

    .salon-cover{
        height:140px;
        background:
            linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.35)),
            url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=1400&auto=format&fit=crop');
        background-size:cover;
        background-position:center;
        position:relative;
    }

    .salon-avatar{
        width:95px;
        height:95px;
        border-radius:24px;
        background:linear-gradient(135deg,#ff4d6d,#ff7a59);
        border:5px solid #0f172a;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:34px;
        font-weight:700;
        color:#fff;
        position:absolute;
        left:24px;
        bottom:-45px;
        box-shadow:0 10px 30px rgba(0,0,0,.25);
    }

    .salon-body{
        padding:65px 24px 24px;
    }

    .salon-name{
        font-size:24px;
        font-weight:700;
        color:#fff;
        margin-bottom:8px;
    }

    .salon-desc{
        color:#94a3b8;
        line-height:1.7;
        margin-bottom:22px;
        font-size:14px;
    }

    .info-list{
        display:flex;
        flex-direction:column;
        gap:16px;
    }

    .info-item{
        display:flex;
        align-items:flex-start;
        gap:14px;
        padding:14px;
        border-radius:16px;
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(148,163,184,0.08);
    }

    .info-icon{
        width:42px;
        height:42px;
        border-radius:12px;
        background:rgba(255,77,109,.12);
        color:#ff4d6d;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        flex-shrink:0;
    }

    .info-label{
        font-size:12px;
        color:#94a3b8;
        margin-bottom:3px;
    }

    .info-value{
        color:#fff;
        font-size:14px;
        font-weight:600;
        word-break:break-word;
    }

    .form-card{
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(148,163,184,0.12);
        border-radius:24px;
        padding:30px;
    }

    .form-title{
        font-size:22px;
        font-weight:700;
        color:#fff;
        margin-bottom:8px;
    }

    .form-subtitle{
        color:#94a3b8;
        margin-bottom:28px;
        font-size:14px;
    }

    .form-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    }

    .form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .form-group.full{
        grid-column:1 / -1;
    }

    .form-label{
        font-size:13px;
        font-weight:600;
        color:#cbd5e1;
    }

    .form-control{
        width:100%;
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(148,163,184,0.12);
        border-radius:14px;
        padding:14px 16px;
        color:#fff;
        font-size:14px;
        transition:.2s ease;
    }

    .form-control:focus{
        outline:none;
        border-color:#ff4d6d;
        box-shadow:0 0 0 4px rgba(255,77,109,.10);
    }

    textarea.form-control{
        resize:none;
        min-height:130px;
    }

    .save-btn{
        border:none;
        background:linear-gradient(135deg,#ff4d6d,#ff7a59);
        color:#fff;
        font-weight:700;
        padding:14px 22px;
        border-radius:14px;
        display:inline-flex;
        align-items:center;
        gap:10px;
        margin-top:28px;
        transition:.2s ease;
        box-shadow:0 10px 25px rgba(255,77,109,.25);
    }

    .save-btn:hover{
        transform:translateY(-2px);
    }

    .alert-success{
        background:rgba(16,185,129,.10);
        border:1px solid rgba(16,185,129,.20);
        color:#10b981;
        padding:14px 18px;
        border-radius:14px;
        margin-bottom:22px;
    }

    @media(max-width:1100px){
        .salon-wrapper{
            grid-template-columns:1fr;
        }
    }

    @media(max-width:768px){

        .form-grid{
            grid-template-columns:1fr;
        }

        .form-card{
            padding:22px;
        }

        .salon-body{
            padding:65px 18px 18px;
        }
    }
</style>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="salon-wrapper">

    {{-- PROFIL --}}
    <div class="salon-card">

        <div class="salon-cover">

            <div class="salon-avatar">
                {{ strtoupper(substr($salon->name ?? 'S',0,1)) }}
            </div>

        </div>

        <div class="salon-body">

            <div class="salon-name">
                {{ $salon->name ?? 'Salon Marol Hair' }}
            </div>

            <div class="salon-desc">
                {{ $salon->description ?? 'Salon premium de coiffure et tressage 100% luxe.' }}
            </div>

            <div class="info-list">

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>

                    <div>
                        <div class="info-label">{{ __('messages.salon_info_address') }}</div>
                        <div class="info-value">
                            {{ $salon->address ?? __('messages.salon_info_not_set') }}
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>

                    <div>
                        <div class="info-label">{{ __('messages.salon_info_phone') }}</div>
                        <div class="info-value">
                            {{ $salon->phone ?? __('messages.salon_info_not_set') }}
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div>
                        <div class="info-label">{{ __('messages.salon_info_email') }}</div>
                        <div class="info-value">
                            {{ $salon->email ?? __('messages.salon_info_not_set') }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- FORMULAIRE --}}
    <div class="form-card">

        <div class="form-title">
            {{ __('messages.salon_info_form_title') }}
        </div>

        <div class="form-subtitle">
            {{ __('messages.salon_info_form_sub') }}
        </div>

        <form action="{{ route('admin.salons.status', $salon) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-grid">

                {{-- NOM --}}
                <div class="form-group">
                    <label class="form-label">
                        {{ __('messages.salon_info_field_name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $salon->name) }}"
                        placeholder="{{ __('messages.salon_info_name_ph') }}"
                    >
                </div>

                {{-- TELEPHONE --}}
                <div class="form-group">
                    <label class="form-label">
                        {{ __('messages.salon_info_field_phone') }}
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $salon->phone) }}"
                        placeholder="{{ __('messages.salon_info_phone_ph') }}"
                    >
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label class="form-label">
                        {{ __('messages.salon_info_field_email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $salon->email) }}"
                        placeholder="{{ __('messages.salon_info_email_ph') }}"
                    >
                </div>

                {{-- ADRESSE --}}
                <div class="form-group">
                    <label class="form-label">
                        {{ __('messages.salon_info_field_address') }}
                    </label>

                    <input
                        type="text"
                        name="address"
                        class="form-control"
                        value="{{ old('address', $salon->address) }}"
                        placeholder="{{ __('messages.salon_info_address_ph') }}"
                    >
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group full">
                    <label class="form-label">
                        {{ __('messages.salon_info_field_desc') }}
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        placeholder="{{ __('messages.salon_info_desc_ph') }}"
                    >{{ old('description', $salon->description) }}</textarea>
                </div>

            </div>

            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i>
                {{ __('messages.salon_info_save_btn') }}
            </button>

        </form>

    </div>

</div>

@endsection
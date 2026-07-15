<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

@extends('layouts.admin')

@section('page-title', __('messages.adm_add_employee'))
@section('page-subtitle', __('messages.adm_employee_management'))

@section('content')

<style>
    /* ===== HEADER ===== */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 32px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-eyebrow {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #ff4d6d;
        margin-bottom: 5px;
    }

    .page-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0;
        line-height: 1.2;
    }

    .page-header p {
        font-size: 14px;
        color: #9ca3af;
        margin: 4px 0 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #111827);
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.11);
        color: var(--text, #111827);
        text-decoration: none;
    }

    /* ===== LAYOUT ===== */
    .form-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    /* ===== SECTION CARD ===== */
    .form-section {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 18px;
        padding: 24px 28px;
        margin-bottom: 20px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 700;
        color: var(--text, #111827);
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .section-title .section-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .si-pink  { background: rgba(255,77,109,0.12); color:#ff4d6d; }
    .si-blue  { background: rgba(59,130,246,0.12); color:#3b82f6; }
    .si-purple{ background: rgba(139,92,246,0.12); color:#8b5cf6; }
    .si-green { background: rgba(16,185,129,0.12); color:#10b981; }

    /* ===== FORM GRID ===== */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    /* ===== LABEL ===== */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #374151);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .required {
        color: #ff4d6d;
        font-size: 14px;
        line-height: 1;
    }

    /* ===== INPUT ===== */
    .form-control,
    .form-select {
        width: 100%;
        padding: 11px 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 10px;
        color: var(--text);
        font-size: 14px;
        transition: border-color 0.18s, box-shadow 0.18s;
        box-sizing: border-box;
    }

    .form-control::placeholder { color: #6b7280; }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #ff4d6d;
        box-shadow: 0 0 0 3px rgba(255,77,109,0.12);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 90px;
    }

    .invalid-feedback {
        font-size: 12px;
        color: #ef4444;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ===== PASSWORD TOGGLE ===== */
    .password-wrap {
        position: relative;
    }

    .password-wrap .form-control {
        padding-right: 44px;
    }

    .toggle-pw {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .toggle-pw i {
        font-size: 15px;
    }

    .toggle-pw:hover { color: #ff4d6d; }

    /* ===== ALERT ===== */
    .alert-err {
        display: flex;
        gap: 10px;
        background: rgba(239,68,68,0.07);
        border: 1px solid rgba(239,68,68,0.18);
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 22px;
        color: #ef4444;
    }

    .alert-err ul {
        margin: 0;
        padding: 0 0 0 16px;
        font-size: 13px;
    }

    /* ===== SUBMIT AREA ===== */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.07);
        margin-top: 4px;
    }

    .btn-cancel {
        padding: 11px 20px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text, #374151);
        text-decoration: none;
        transition: background 0.15s;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background: rgba(255,255,255,0.10);
        color: var(--text, #374151);
        text-decoration: none;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: linear-gradient(135deg, #ff4d6d, #ff758f);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(255,77,109,0.28);
        transition: transform 0.18s, box-shadow 0.18s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255,77,109,0.38);
    }

    /* ===== SIDEBAR ===== */
    .sidebar-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 18px;
        padding: 24px;
        position: sticky;
        top: 24px;
    }

    .sidebar-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,77,109,0.18), rgba(255,117,143,0.10));
        border: 2px solid rgba(255,77,109,0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: #ff4d6d;
        margin: 0 auto 16px;
        text-transform: uppercase;
        transition: all 0.2s;
        overflow: hidden;
    }

    .sidebar-name {
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        color: var(--text, #111827);
        margin-bottom: 4px;
        min-height: 22px;
    }

    .sidebar-spec {
        text-align: center;
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 20px;
        min-height: 18px;
    }

    .sidebar-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.08);
        margin: 0 0 18px;
    }

    .sidebar-tip {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.6;
        background: rgba(255,77,109,0.05);
        border: 1px solid rgba(255,77,109,0.10);
        border-radius: 10px;
        padding: 12px 14px;
    }

    .sidebar-tip strong {
        color: #ff4d6d;
        display: block;
        margin-bottom: 4px;
        font-size: 12px;
    }

    /* ===== CHECKBOXES ===== */
    input[type="checkbox"] {
        accent-color: #ff4d6d;
    }

    label input[type="checkbox"]:checked {
        accent-color: #ff4d6d;
    }

    /* ===== SELECT VISIBILITY ===== */
    .form-select,
    select {
        background: #1e293b !important;
        color: #f1f5f9 !important;
        border: 1px solid rgba(255,255,255,0.18) !important;
    }

    .form-select option,
    select option {
        background: #1e293b;
        color: #f1f5f9;
    }

    .form-select:focus,
    select:focus {
        border-color: #ff4d6d !important;
        box-shadow: 0 0 0 3px rgba(255,77,109,0.12) !important;
    }

    /* ===== SELECT-ALL BAR ===== */
    .select-all-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 14px;
        background: rgba(255,77,109,0.06);
        border: 1px solid rgba(255,77,109,0.15);
        border-radius: 10px;
        margin-bottom: 14px;
    }

    .select-all-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #f1f5f9);
        cursor: pointer;
    }

    .select-all-label input[type="checkbox"] {
        width: 17px;
        height: 17px;
        cursor: pointer;
    }

    .select-all-count {
        font-size: 12px;
        color: #9ca3af;
    }

    /* ===== IMAGE UPLOAD ===== */
    .image-upload {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .image-box {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .image-preview {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255,77,109,0.08);
        border: 2px dashed rgba(255,77,109,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ff4d6d;
        overflow: hidden;
        flex-shrink: 0;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255,77,109,0.08);
        border: 1px solid rgba(255,77,109,0.25);
        border-radius: 10px;
        color: #ff4d6d;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-btn:hover {
        background: rgba(255,77,109,0.15);
    }

    .upload-btn input[type="file"] {
        display: none;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .form-layout { grid-template-columns: 1fr; }
        .sidebar-card { display: none; }
    }

    @media (max-width: 600px) {
        .form-grid-2 { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .form-footer { flex-direction: column; }
        .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">{{ __('messages.adm_team') }}</div>
        <h1>{{ __('messages.adm_add_employee') }}</h1>
        <p>{{ __('messages.adm_employee_management') }}</p>
    </div>

    <a href="{{ route('admin.employees.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        {{ __('messages.adm_back_to_list') }}
    </a>
</div>

{{-- ERRORS --}}
@if($errors->any())
    <div class="alert-err">
        <i class="fa-solid fa-circle-exclamation"></i>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-layout">

    {{-- FORMULAIRE --}}
    <div>

        <form method="POST" action="{{ route('admin.employees.store') }}" id="empForm" enctype="multipart/form-data">
            @csrf

            {{-- PHOTO DE PROFIL --}}
            <div class="form-section">

                <div class="section-title">
                    <div class="section-icon si-green">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    {{ __('messages.adm_profile_photo') }}
                </div>

                <div class="image-upload">
                    <div class="image-box">

                        <div class="image-preview" id="imgPreview">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <label class="upload-btn">
                            <i class="fa-solid fa-upload"></i>
                            {{ __('messages.adm_choose_image') }}
                            <input type="file" name="photo" id="imageInput" accept="image/jpeg,image/png,image/webp">
                        </label>

                    </div>

                    @error('photo')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            {{-- INFORMATIONS PERSONNELLES --}}
            <div class="form-section">

                <div class="section-title">
                    <div class="section-icon si-pink">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    {{ __('messages.adm_personal_info') }}
                </div>

                <div class="form-grid-2">

                    <div class="form-group full">
                        <label class="form-label">
                            {{ __('messages.adm_full_name') }} <span class="required">*</span>
                        </label>

                        <input id="nameInput"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Ex : Sarah Dupont">

                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            {{ __('messages.adm_email_address') }} <span class="required">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="sarah@example.com">

                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('messages.phone') }}</label>

                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror"
                               placeholder="+225 07 00 00 00 00">

                        @error('phone')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SALON --}}
            <div class="form-section">

                <div class="section-title">
                    <div class="section-icon si-blue">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    {{ __('messages.adm_salon_specialty') }}
                </div>

                <div class="form-grid-2">

                    <div class="form-group">
                        <label class="form-label">
                            Salon <span class="required">*</span>
                        </label>

                        <select name="salon_id"
                                class="form-select @error('salon_id') is-invalid @enderror">

                            <option value="">— Choisir un salon —</option>

                            @foreach($salons as $salon)
                                <option value="{{ $salon->id }}"
                                    {{ old('salon_id') == $salon->id ? 'selected' : '' }}>
                                    {{ $salon->nom ?? $salon->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('salon_id')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('messages.adm_specialty') }}</label>

                        <input id="specInput"
                               type="text"
                               name="specialty"
                               value="{{ old('specialty') }}"
                               class="form-control @error('specialty') is-invalid @enderror"
                               placeholder="Coupe, coloration, tresses...">

                        @error('specialty')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label">{{ __('messages.adm_bio') }}</label>

                        <textarea name="bio"
                                  class="form-control @error('bio') is-invalid @enderror"
                                  placeholder="Présentation de l'employé">{{ old('bio') }}</textarea>

                        @error('bio')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SERVICES --}}
            <div class="form-section">

                <div class="section-title">
                    <div class="section-icon si-blue">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    {{ __('messages.adm_services_spec') }}
                </div>

                <div class="form-group full">
                    <label class="form-label">
                        {{ __('messages.adm_select_services') }}
                    </label>

                    {{-- Barre "Tout sélectionner" --}}
                    <div class="select-all-bar">
                        <label class="select-all-label" for="checkAll">
                            <input type="checkbox" id="checkAll">
                            {{ __('messages.adm_select_all') ?? 'Tout sélectionner' }}
                        </label>
                        <span class="select-all-count" id="checkedCount">
                            0 / {{ count($services) }} sélectionné(s)
                        </span>
                    </div>

                    <div id="servicesGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:12px;">

                        @foreach($services as $service)

                            <label class="service-check-item" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:10px; cursor:pointer; transition:all 0.2s;">

                                <input type="checkbox"
                                       name="services[]"
                                       value="{{ $service->id }}"
                                       class="service-cb"
                                       {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                       style="width:18px; height:18px; cursor:pointer; accent-color:#ff4d6d;">

                                <div>
                                    <div style="font-weight:600; color:var(--text, #f1f5f9); font-size:14px;">
                                        {{ $service->name }}
                                    </div>
                                    <div style="font-size:12px; color:#9ca3af;">
                                        {{ $service->formatted_price }}
                                    </div>
                                </div>

                            </label>

                        @endforeach

                    </div>

                    @error('services')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            {{-- SECURITE --}}
            <div class="form-section">

                <div class="section-title">
                    <div class="section-icon si-purple">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    {{ __('messages.adm_security') }}
                </div>

                <div class="form-grid-2">

                    <div class="form-group">
                        <label class="form-label">
                            {{ __('messages.adm_password') }} <span class="required">*</span>
                        </label>

                        <div class="password-wrap">
                            <input id="pwField"
                                   type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 caractères">

                            <button type="button" class="toggle-pw" onclick="togglePw()">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            {{ __('messages.adm_confirm_password') }} <span class="required">*</span>
                        </label>

                        <div class="password-wrap">
                            <input id="pwConfirm"
                                   type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirmez le mot de passe">

                            <button type="button" class="toggle-pw" onclick="togglePwC()">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="form-footer">

                <a href="{{ route('admin.employees.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i>
                    {{ __('messages.btn_cancel') }}
                </a>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i>
                    {{ __('messages.adm_create_employee') }}
                </button>

            </div>

        </form>
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="sidebar-card">

            <div class="sidebar-avatar" id="previewAvatar">
                <i class="fa-solid fa-user"></i>
            </div>

            {{-- ✅ Décommenté pour éviter l'erreur JS --}}
            <div class="sidebar-name" id="previewName">
                {{ __('messages.adm_full_name') }}
            </div>

            <div class="sidebar-spec" id="previewSpec">
                {{ __('messages.adm_specialty') }}
            </div>

            <hr class="sidebar-divider">

            <div class="sidebar-tip">
                <strong>
                    <i class="fa-solid fa-lightbulb"></i>
                </strong>
                {{ __('messages.adm_tip_specialty') }}
            </div>

        </div>
    </div>

</div>

<script>
    const nameInput  = document.getElementById('nameInput');
    const specInput  = document.getElementById('specInput');
    const imageInput = document.getElementById('imageInput');
    const imgPreview = document.getElementById('imgPreview');

    const previewName   = document.getElementById('previewName');
    const previewSpec   = document.getElementById('previewSpec');
    const previewAvatar = document.getElementById('previewAvatar');

    nameInput?.addEventListener('input', function () {
        const val = this.value.trim();

        // ✅ Vérification null avant utilisation
        if (previewName) {
            previewName.textContent = val || "Nom de l'employé";
        }

        if (val) {
            const initials = val
                .split(' ')
                .map(w => w[0])
                .slice(0, 2)
                .join('');

            // Ne remplacer les initiales que si pas d'image déjà choisie
            if (!imgPreview.querySelector('img')) {
                previewAvatar.textContent = initials.toUpperCase();
            }
        } else {
            if (!imgPreview.querySelector('img')) {
                previewAvatar.innerHTML = '<i class="fa-solid fa-user"></i>';
            }
        }
    });

    specInput?.addEventListener('input', function () {
        previewSpec.textContent = this.value.trim() || 'Spécialité';
    });

    // ✅ Prévisualisation image dans la sidebar ET dans imgPreview
    imageInput?.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Aperçu dans le cercle de la section photo
                imgPreview.innerHTML = `
                    <img src="${e.target.result}" alt="preview"
                         style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                `;
                // Aperçu dans la sidebar
                previewAvatar.innerHTML = `
                    <img src="${e.target.result}" alt="preview"
                         style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                `;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            imgPreview.innerHTML = '<i class="fa-solid fa-user"></i>';
            previewAvatar.innerHTML = '<i class="fa-solid fa-user"></i>';
        }
    });

    function togglePw() {
        const field = document.getElementById('pwField');
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    function togglePwC() {
        const field = document.getElementById('pwConfirm');
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    // ── Tout sélectionner / décocher ─────────────────────────────
    (function () {
        const checkAll   = document.getElementById('checkAll');
        const cbs        = document.querySelectorAll('.service-cb');
        const countLabel = document.getElementById('checkedCount');
        const total      = cbs.length;

        function updateCount() {
            const n = document.querySelectorAll('.service-cb:checked').length;
            countLabel.textContent = n + ' / ' + total + ' sélectionné(s)';
            checkAll.indeterminate = n > 0 && n < total;
            checkAll.checked       = n === total;
        }

        checkAll.addEventListener('change', function () {
            cbs.forEach(cb => {
                cb.checked = this.checked;
                const item = cb.closest('.service-check-item');
                if (item) item.style.borderColor = this.checked ? 'rgba(255,77,109,0.4)' : 'rgba(255,255,255,0.08)';
                if (item) item.style.background  = this.checked ? 'rgba(255,77,109,0.08)' : 'rgba(255,255,255,0.03)';
            });
            updateCount();
        });

        cbs.forEach(cb => {
            cb.addEventListener('change', function () {
                const item = this.closest('.service-check-item');
                if (item) item.style.borderColor = this.checked ? 'rgba(255,77,109,0.4)' : 'rgba(255,255,255,0.08)';
                if (item) item.style.background  = this.checked ? 'rgba(255,77,109,0.08)' : 'rgba(255,255,255,0.03)';
                updateCount();
            });
            // Initialiser l'état visuel pour les anciennes valeurs (old())
            if (cb.checked) {
                const item = cb.closest('.service-check-item');
                if (item) item.style.borderColor = 'rgba(255,77,109,0.4)';
                if (item) item.style.background  = 'rgba(255,77,109,0.08)';
            }
        });

        updateCount();
    })();
</script>

@endsection
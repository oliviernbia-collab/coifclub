@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('page-title', __('messages.adm_modify'))
@section('page-subtitle', __('messages.adm_employee_management'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
    :root{
        --primary:#ff4d6d;
        --primary-light:#ff758f;
        --dark:#0f172a;
        --card:#111827;
        --card-light:#1f2937;
        --border:rgba(255,255,255,.08);
        --text:#f9fafb;
        --muted:#9ca3af;
        --input:#0b1220;
        --danger:#ef4444;
    }

    *{
        box-sizing:border-box;
    }

    .employee-page{
        width:100%;
        color:var(--text);
    }

    /* ===== HEADER ===== */
    .page-header{
        display:flex;
        align-items:flex-end;
        justify-content:space-between;
        gap:20px;
        margin-bottom:28px;
        flex-wrap:wrap;
    }

    .page-eyebrow{
        font-size:12px;
        font-weight:700;
        letter-spacing:.08em;
        text-transform:uppercase;
        color:var(--primary);
        margin-bottom:6px;
    }

    .page-header h1{
        margin:0;
        font-size:30px;
        font-weight:800;
        color:#fff;
        line-height:1.2;
    }

    .page-header p{
        margin:5px 0 0;
        font-size:14px;
        color:var(--muted);
    }

    .btn-back{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:12px 18px;
        border-radius:14px;
        border:1px solid var(--border);
        background:rgba(255,255,255,.04);
        color:#fff;
        text-decoration:none;
        font-size:13px;
        font-weight:700;
        transition:.2s ease;
    }

    .btn-back:hover{
        background:rgba(255,255,255,.08);
        color:#fff;
        transform:translateY(-2px);
        text-decoration:none;
    }

    .btn-back svg{
        width:15px;
        height:15px;
        stroke-width:2.5;
    }

    /* ===== LAYOUT ===== */
    .form-layout{
        display:grid;
        grid-template-columns:minmax(0,1fr) 360px;
        gap:24px;
        align-items:start;
    }

    /* ===== CARDS ===== */
    .form-section,
    .sidebar-card{
        background:linear-gradient(
            180deg,
            rgba(17,24,39,.95),
            rgba(15,23,42,.96)
        );
        border:1px solid var(--border);
        border-radius:24px;
        padding:28px;
        box-shadow:
            0 10px 35px rgba(0,0,0,.28),
            inset 0 1px 0 rgba(255,255,255,.03);
        overflow:hidden;
    }

    .form-section{
        margin-bottom:22px;
    }

    .section-title{
        display:flex;
        align-items:center;
        gap:12px;
        padding-bottom:18px;
        margin-bottom:24px;
        border-bottom:1px solid rgba(255,255,255,.06);
        color:#fff;
        font-size:15px;
        font-weight:800;
    }

    .section-icon{
        width:38px;
        height:38px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:17px;
        flex-shrink:0;
    }

    .si-pink{ background:rgba(255,77,109,.16); }
    .si-blue{ background:rgba(59,130,246,.16); }
    .si-purple{ background:rgba(139,92,246,.16); }
    .si-green{ background:rgba(16,185,129,.16); }

    /* ===== GRID ===== */
    .form-grid-2{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px;
    }

    .form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
        min-width:0;
    }

    .form-group.full{
        grid-column:1 / -1;
    }

    /* ===== LABEL ===== */
    .form-label{
        color:#f3f4f6;
        font-size:13px;
        font-weight:700;
    }

    .required{
        color:var(--primary);
    }

    /* ===== INPUT ===== */
    .form-control,
    .form-select{
        width:100%;
        min-height:52px;
        padding:14px 16px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.10);
        background:var(--input);
        color:#fff !important;
        font-size:14px;
        font-weight:500;
        transition:.2s ease;
    }

    .form-control::placeholder{
        color:#94a3b8;
    }

    .form-control:focus,
    .form-select:focus{
        outline:none;
        border-color:var(--primary);
        box-shadow:0 0 0 4px rgba(255,77,109,.15);
        background:#0b1220;
        color:#fff;
    }

    .form-control.is-invalid,
    .form-select.is-invalid{
        border-color:var(--danger);
        box-shadow:0 0 0 4px rgba(239,68,68,.12);
    }

    textarea.form-control{
        min-height:120px;
        resize:vertical;
    }

    select.form-select option{
        background:#111827;
        color:#fff;
    }

    .invalid-feedback{
        color:#f87171;
        font-size:12px;
        font-weight:600;
    }

    /* ===== PASSWORD ===== */
    .password-wrap{
        position:relative;
    }

    .password-wrap .form-control{
        padding-right:50px;
    }

    .toggle-pw{
        position:absolute;
        top:50%;
        right:14px;
        transform:translateY(-50%);
        border:none;
        background:none;
        color:#9ca3af;
        cursor:pointer;
        transition:.2s;
    }

    .toggle-pw:hover{
        color:var(--primary);
    }

    .toggle-pw svg{
        width:17px;
        height:17px;
        stroke-width:2.3;
    }

    /* ===== ALERT ===== */
    .alert-err{
        display:flex;
        gap:14px;
        padding:18px;
        border-radius:18px;
        margin-bottom:24px;
        background:rgba(239,68,68,.10);
        border:1px solid rgba(239,68,68,.20);
        color:#fecaca;
    }

    .alert-err svg{
        width:18px;
        height:18px;
        flex-shrink:0;
        stroke:#ef4444;
        stroke-width:2;
        margin-top:2px;
    }

    .alert-err ul{
        margin:0;
        padding-left:18px;
        font-size:13px;
    }

    /* ===== FOOTER ===== */
    .form-footer{
        display:flex;
        justify-content:flex-end;
        gap:14px;
        margin-top:26px;
        padding-top:22px;
        border-top:1px solid rgba(255,255,255,.06);
    }

    .btn-cancel{
        padding:13px 22px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.10);
        background:rgba(255,255,255,.04);
        color:#fff;
        text-decoration:none;
        font-size:14px;
        font-weight:700;
        transition:.2s;
    }

    .btn-cancel:hover{
        background:rgba(255,255,255,.08);
        color:#fff;
        text-decoration:none;
    }

    .btn-submit{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding:13px 24px;
        border:none;
        border-radius:14px;
        background:linear-gradient(135deg,var(--primary),var(--primary-light));
        color:#fff;
        font-size:14px;
        font-weight:800;
        cursor:pointer;
        transition:.2s ease;
        box-shadow:0 10px 24px rgba(255,77,109,.30);
    }

    .btn-submit:hover{
        transform:translateY(-2px);
        box-shadow:0 14px 30px rgba(255,77,109,.38);
    }

    .btn-submit svg{
        width:16px;
        height:16px;
        stroke:#fff;
        stroke-width:2.5;
    }

    /* ===== SIDEBAR ===== */
    .sidebar-card{
        position:sticky;
        top:24px;
    }

    .sidebar-avatar{
        width:96px;
        height:96px;
        margin:0 auto 18px;
        border-radius:50%;
        overflow:hidden;
        border:3px solid rgba(255,77,109,.25);
        background:rgba(255,255,255,.05);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:34px;
        font-weight:800;
        color:var(--primary);
        text-transform:uppercase;
    }

    .sidebar-avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .sidebar-name{
        text-align:center;
        font-size:20px;
        font-weight:800;
        color:#fff;
        margin-bottom:5px;
        word-break:break-word;
    }

    .sidebar-spec{
        text-align:center;
        color:#cbd5e1;
        font-size:13px;
        margin-bottom:24px;
        word-break:break-word;
    }

    .sidebar-meta{
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .meta-item{
        background:rgba(255,255,255,.04);
        border:1px solid rgba(255,255,255,.06);
        border-radius:16px;
        padding:14px;
    }

    .meta-label{
        font-size:11px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.06em;
        color:#94a3b8;
        margin-bottom:6px;
    }

    .meta-value{
        font-size:14px;
        font-weight:600;
        color:#fff;
        line-height:1.5;
        word-break:break-word;
    }

    /* ===== CHECKBOXES ===== */
    input[type="checkbox"] {
        accent-color: #ff4d6d;
    }

    /* ===== FILE UPLOAD ===== */
    .file-upload-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .file-input {
        display: none;
    }

    .file-upload-btn {
        padding: 14px 16px;
        border-radius: 14px;
        border: 2px dashed rgba(255,77,109,.3);
        background: rgba(255,77,109,.05);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        min-height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .file-upload-btn:hover {
        background: rgba(255,77,109,.1);
        border-color: rgba(255,77,109,.5);
    }

    /* ===== CURRENT PHOTO ===== */
    .current-photo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: rgba(255,255,255,.03);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 12px;
        font-size: 13px;
        color: #9ca3af;
    }

    .current-photo img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,77,109,.25);
    }

    /* ===== MOBILE ===== */
    @media(max-width:960px){
        .form-layout{
            grid-template-columns:1fr;
        }
        .sidebar-card{
            position:relative;
            top:0;
        }
    }

    @media(max-width:640px){
        .page-header{
            flex-direction:column;
            align-items:flex-start;
        }
        .form-grid-2{
            grid-template-columns:1fr;
        }
        .form-section,
        .sidebar-card{
            padding:22px;
        }
        .form-footer{
            flex-direction:column;
        }
        .btn-submit,
        .btn-cancel{
            width:100%;
        }
    }
</style>

<div class="employee-page">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <div class="page-eyebrow">{{ __('messages.adm_team') }}</div>
            <h1>{{ __('messages.adm_modify') }}</h1>
            <p>{{ __('messages.adm_employee_management') }}</p>
        </div>

        <a href="{{ route('admin.employees.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ __('messages.btn_back') }}
        </a>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="alert-err">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v4M12 16h.01" stroke-linecap="round"/>
            </svg>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-layout">

        {{-- FORM --}}
        <div>

            <form method="POST" action="{{ route('admin.employees.update', $employee->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- INFOS --}}
                <div class="form-section">

                    <div class="section-title">
                        <div class="section-icon si-pink">👤</div>
                        {{ __('messages.adm_personal_info') }}
                    </div>

                    <div class="form-grid-2">

                        <div class="form-group full">
                            <label class="form-label">
                                {{ __('messages.adm_full_name') }} <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="nameInput"
                                name="name"
                                value="{{ old('name', $employee->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex : Sarah Dupont"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                {{ __('messages.adm_email_address') }} <span class="required">*</span>
                            </label>
                            <input
                                type="email"
                                id="emailInput"
                                name="email"
                                value="{{ old('email', $employee->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="sarah@example.com"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('messages.phone') }}</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $employee->employee?->phone) }}"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="+225 07 00 00 00 00"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- PROFIL --}}
                <div class="form-section">

                    <div class="section-title">
                        <div class="section-icon si-green">
                            <i class="fa-solid fa-image"></i>
                        </div>
                        {{ __('messages.adm_profile_photo') }}
                    </div>

                    <div class="form-grid-2">

                        <div class="form-group">
                            <label class="form-label">{{ __('messages.adm_image') }}</label>

                            {{-- ✅ Aperçu de la photo actuelle --}}
                            @if($employee->employee?->image)
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . $employee->employee->image) }}"
                                         alt="{{ $employee->name }}">
                                    <span>Photo actuelle</span>
                                </div>
                            @endif

                            <div class="file-upload-wrapper">
                                <input
                                    type="file"
                                    id="imageInput"
                                    name="photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="file-input @error('photo') is-invalid @enderror"
                                >
                                <label for="imageInput" class="file-upload-btn">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    {{ $employee->employee?->image ? 'Changer la photo' : 'Choisir une image' }}
                                </label>
                            </div>

                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('messages.salons') }}</label>
                            <select
                                name="salon_id"
                                class="form-select @error('salon_id') is-invalid @enderror"
                            >
                                <option value="">— Sélectionnez un salon —</option>
                                @foreach($salons as $salon)
                                    <option
                                        value="{{ $salon->id }}"
                                        {{ old('salon_id', $employee->employee?->salon_id) == $salon->id ? 'selected' : '' }}
                                    >
                                        {{ $salon->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('salon_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label">
                                {{ __('messages.adm_specialty') }} <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="specInput"
                                name="specialty"
                                value="{{ old('specialty', $employee->employee?->specialty) }}"
                                class="form-control @error('specialty') is-invalid @enderror"
                                placeholder="Ex : Coupe, Coloration, Tresses"
                                required
                            >
                            @error('specialty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label">{{ __('messages.adm_bio') }}</label>
                            <textarea
                                name="bio"
                                class="form-control @error('bio') is-invalid @enderror"
                                placeholder="Quelques mots sur l'expérience et les services proposés"
                            >{{ old('bio', $employee->employee?->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- SERVICES --}}
                <div class="form-section">

                    <div class="section-title">
                        <div class="section-icon si-blue">✂️</div>
                        {{ __('messages.adm_services_spec') }}
                    </div>

                    <div class="form-group full">
                        <label class="form-label">
                            {{ __('messages.adm_select_services') }}
                        </label>

                        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:12px;">
                            @foreach($services as $service)
                                <label style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.08); border-radius:10px; cursor:pointer; transition:all 0.2s;">
                                    <input type="checkbox"
                                           name="services[]"
                                           value="{{ $service->id }}"
                                           {{ $employee->employee?->services?->contains($service->id) ? 'checked' : '' }}
                                           style="width:18px; height:18px; cursor:pointer;">
                                    <div>
                                        <div style="font-weight:600; color:var(--text, #f9fafb); font-size:14px;">
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
                        <div class="section-icon si-purple">🔒</div>
                        {{ __('messages.adm_security') }}
                    </div>

                    <div class="form-grid-2">

                        <div class="form-group">
                            <label class="form-label">{{ __('messages.adm_new_password') }}</label>
                            <div class="password-wrap">
                                <input
                                    type="password"
                                    id="passwordField"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Laisser vide pour conserver le mot de passe"
                                >
                                <button type="button" class="toggle-pw" onclick="togglePassword()">
                                    👁️
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('messages.adm_confirm_password') }}</label>
                            <div class="password-wrap">
                                <input
                                    type="password"
                                    id="confirmPasswordField"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirmez le mot de passe"
                                >
                                <button type="button" class="toggle-pw" onclick="toggleConfirmPassword()">
                                    👁️
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="form-footer">
                    <a href="{{ route('admin.employees.index') }}" class="btn-cancel">
                        {{ __('messages.btn_cancel') }}
                    </a>
                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ __('messages.save_changes') }}
                    </button>
                </div>

            </form>
        </div>

        {{-- SIDEBAR --}}
        <div>
            <div class="sidebar-card">

                <div class="sidebar-avatar" id="previewAvatar">
                    {{-- ✅ Colonne corrigée : image au lieu de photo --}}
                    @if($employee->employee?->image)
                        <img
                            src="{{ asset('storage/' . $employee->employee->image) }}"
                            id="avatarImg"
                            alt="{{ $employee->name }}"
                        >
                    @else
                        <span id="avatarInitials">
                            {{ strtoupper(substr($employee->name, 0, 2)) }}
                        </span>
                    @endif
                </div>

                <div class="sidebar-name" id="previewName">
                    {{ $employee->name }}
                </div>

                <div class="sidebar-spec" id="previewSpec">
                    {{ $employee->employee?->specialty ?: 'Aucune spécialité' }}
                </div>

                <div class="sidebar-meta">

                    <div class="meta-item">
                        <div class="meta-label">{{ __('messages.email') }}</div>
                        <div class="meta-value" id="previewEmail">
                            {{ $employee->email }}
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-label">{{ __('messages.salons') }}</div>
                        <div class="meta-value">
                            {{ $employee->employee?->salon?->name ?? 'Non attribué' }}
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-label">{{ __('messages.adm_registered_on') }}</div>
                        <div class="meta-value">
                            {{ optional($employee->created_at)->format('d/m/Y') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>

    const nameInput  = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const specInput  = document.getElementById('specInput');
    const imageInput = document.getElementById('imageInput');

    const previewName   = document.getElementById('previewName');
    const previewEmail  = document.getElementById('previewEmail');
    const previewSpec   = document.getElementById('previewSpec');
    const previewAvatar = document.getElementById('previewAvatar');

    nameInput?.addEventListener('input', function () {
        const val = this.value.trim();

        if (previewName) {
            previewName.textContent = val || 'Nom employé';
        }

        // Ne remplacer les initiales que si pas d'image affichée
        if (!previewAvatar.querySelector('img')) {
            if (val) {
                const initials = val.split(' ').map(w => w[0]).slice(0, 2).join('');
                previewAvatar.innerHTML = `<span>${initials.toUpperCase()}</span>`;
            } else {
                previewAvatar.innerHTML = '<span>👤</span>';
            }
        }
    });

    emailInput?.addEventListener('input', function () {
        if (previewEmail) {
            previewEmail.textContent = this.value || 'Adresse email';
        }
    });

    specInput?.addEventListener('input', function () {
        if (previewSpec) {
            previewSpec.textContent = this.value || 'Aucune spécialité';
        }
    });

    // ✅ Prévisualisation image dans la sidebar
    imageInput?.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner un fichier image');
                this.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('La taille du fichier ne doit pas dépasser 5MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewAvatar.innerHTML = `
                    <img src="${e.target.result}" id="avatarImg"
                         style="width:100%; height:100%; object-fit:cover;">
                `;
            };
            reader.readAsDataURL(file);

        } else {
            // Restaurer les initiales si on annule la sélection
            const name = nameInput?.value.trim() || '{{ $employee->name }}';
            const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
            previewAvatar.innerHTML = `<span>${initials}</span>`;
        }
    });

    function togglePassword() {
        const field = document.getElementById('passwordField');
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    function toggleConfirmPassword() {
        const field = document.getElementById('confirmPasswordField');
        field.type = field.type === 'password' ? 'text' : 'password';
    }

</script>

@endsection
@extends('layouts.admin')

@section('title', __('messages.adm_add_user'))
@section('page-title', __('messages.adm_add_user'))

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
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #374151);
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.11);
        color: var(--text, #374151);
        text-decoration: none;
    }

    .btn-back svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.5;
    }

    /* ===== LAYOUT ===== */
    .form-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }

    /* ===== SECTIONS ===== */
    .form-section {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 18px;
        padding: 24px 28px;
        margin-bottom: 20px;
    }

    .form-section:last-child { margin-bottom: 0; }

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

    .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .si-pink   { background: rgba(255,77,109,0.12); }
    .si-purple { background: rgba(139,92,246,0.12); }
    .si-blue   { background: rgba(59,130,246,0.12); }

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

    .form-group.full { grid-column: 1 / -1; }

    /* ===== LABEL ===== */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #374151);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .required { color: #ff4d6d; font-size: 14px; line-height: 1; }

    /* ===== INPUTS ===== */
    .form-control,
    .form-select {
        width: 100%;
        padding: 11px 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 10px;
        color: var(--text, #111827);
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

    .invalid-feedback {
        font-size: 12px;
        color: #ef4444;
        margin-top: 2px;
    }

    /* ===== PASSWORD ===== */
    .pw-wrap { position: relative; }

    .pw-wrap .form-control { padding-right: 44px; }

    .pw-toggle {
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
        transition: color 0.15s;
    }

    .pw-toggle:hover { color: #ff4d6d; }

    .pw-toggle svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2;
    }

    /* ===== ROLE SELECTOR ===== */
    .role-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .role-option { display: none; }

    .role-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 10px;
        background: rgba(255,255,255,0.04);
        border: 1.5px solid rgba(255,255,255,0.10);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.18s;
        text-align: center;
    }

    .role-label:hover {
        background: rgba(255,255,255,0.07);
        border-color: rgba(255,255,255,0.18);
    }

    .role-option:checked + .role-label {
        border-color: #ff4d6d;
        background: rgba(255,77,109,0.07);
        box-shadow: 0 0 0 3px rgba(255,77,109,0.10);
    }

    .role-emoji { font-size: 22px; }

    .role-name {
        font-size: 12px;
        font-weight: 700;
        color: var(--text, #111827);
    }

    .role-desc {
        font-size: 11px;
        color: #9ca3af;
        line-height: 1.4;
    }

    /* ===== ERRORS ===== */
    .alert-err {
        display: flex;
        gap: 10px;
        background: rgba(239,68,68,0.07);
        border: 1px solid rgba(239,68,68,0.18);
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 22px;
    }

    .alert-err svg {
        width: 16px;
        height: 16px;
        stroke: #ef4444;
        stroke-width: 2;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .alert-err ul {
        margin: 0;
        padding: 0 0 0 16px;
        font-size: 13px;
        color: #ef4444;
    }

    /* ===== FOOTER ===== */
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
        padding: 11px 26px;
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

    .btn-submit svg {
        width: 15px;
        height: 15px;
        stroke: #fff;
        stroke-width: 2.5;
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

    .preview-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,77,109,0.18), rgba(255,117,143,0.10));
        border: 2px solid rgba(255,77,109,0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 700;
        color: #ff4d6d;
        margin: 0 auto 14px;
        text-transform: uppercase;
        transition: all 0.2s;
    }

    .preview-name {
        text-align: center;
        font-size: 15px;
        font-weight: 700;
        color: var(--text, #111827);
        margin-bottom: 4px;
        min-height: 20px;
    }

    .preview-email {
        text-align: center;
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 16px;
        min-height: 16px;
        word-break: break-all;
    }

    .preview-role-badge {
        display: block;
        text-align: center;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin: 0 auto 20px;
        width: fit-content;
        transition: all 0.2s;
    }

    .role-client   { background: rgba(59,130,246,0.10);  color: #3b82f6; }
    .role-employee { background: rgba(245,158,11,0.10);  color: #f59e0b; }
    .role-admin    { background: rgba(239,68,68,0.10);   color: #ef4444; }

    .sidebar-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.08);
        margin: 0 0 16px;
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
        .role-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">{{ __('messages.adm_platform') }}</div>
        <h1>{{ __('messages.adm_add_user') }}</h1>
        <p>{{ __('messages.adm_create_account') }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-back">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('messages.adm_back_to_list') }}
    </a>
</div>

{{-- ERRORS --}}
@if($errors->any())
    <div class="alert-err">
        <svg viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9"/>
            <path d="M12 8v4M12 16h.01" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
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
        <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
            @csrf

            {{-- INFORMATIONS PERSONNELLES --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon si-pink">👤</div>
                    {{ __('messages.adm_personal_info') }}
                </div>

                <div class="form-grid-2">
                    <div class="form-group full">
                        <label class="form-label">{{ __('messages.adm_full_name') }} <span class="required">*</span></label>
                        <input id="nameInput" type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Ex : Amina Koné" autocomplete="off" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label">{{ __('messages.adm_email_address') }} <span class="required">*</span></label>
                        <input id="emailInput" type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="amina@example.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- SÉCURITÉ --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon si-purple">🔒</div>
                    {{ __('messages.adm_security') }}
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.adm_password') }} <span class="required">*</span></label>
                        <div class="pw-wrap">
                            <input id="pwField" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 caractères" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('pwField')">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('messages.adm_confirm_password') }} <span class="required">*</span></label>
                        <div class="pw-wrap">
                            <input id="pwConfirm" type="password" name="password_confirmation"
                                   class="form-control" placeholder="Répétez le mot de passe" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('pwConfirm')">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RÔLE --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon si-blue">🛡️</div>
                    {{ __('messages.adm_role_permissions') }}
                </div>

                <div class="role-grid">
                    @foreach([
                        ['value'=>'client',   'emoji'=>'👤', 'name'=>__('messages.clients'),   'desc'=>__('messages.adm_client_desc')],
                        ['value'=>'employee', 'emoji'=>'✂️', 'name'=>__('messages.employees'), 'desc'=>__('messages.adm_employee_desc')],
                        ['value'=>'admin',    'emoji'=>'🛡️', 'name'=>__('messages.admin_title'), 'desc'=>__('messages.adm_admin_desc')],
                    ] as $role)
                        <div>
                            <input type="radio" name="role" id="role_{{ $role['value'] }}"
                                   value="{{ $role['value'] }}" class="role-option"
                                   {{ old('role', 'client') === $role['value'] ? 'checked' : '' }}
                                   onchange="updateRoleBadge('{{ $role['value'] }}', '{{ $role['name'] }}')">
                            <label for="role_{{ $role['value'] }}" class="role-label">
                                <span class="role-emoji">{{ $role['emoji'] }}</span>
                                <span class="role-name">{{ $role['name'] }}</span>
                                <span class="role-desc">{{ $role['desc'] }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="form-footer">
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">{{ __('messages.btn_cancel') }}</a>
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ __('messages.btn_save') }}
                </button>
            </div>

        </form>
    </div>

    {{-- SIDEBAR PREVIEW --}}
    <div>
        <div class="sidebar-card">
            <div class="preview-avatar" id="previewAvatar">👤</div>
            <div class="preview-name" id="previewName">{{ __('messages.adm_full_name') }}</div>
            <div class="preview-email" id="previewEmail">email@exemple.com</div>
            <span class="preview-role-badge role-client" id="previewRole">{{ __('messages.clients') }}</span>
            <hr class="sidebar-divider">
            <div class="sidebar-tip">
                <strong>💡</strong>
                {{ __('messages.adm_tip_role') }}
            </div>
        </div>
    </div>

</div>

<script>
    const nameInput  = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const previewAvatar = document.getElementById('previewAvatar');
    const previewName   = document.getElementById('previewName');
    const previewEmail  = document.getElementById('previewEmail');
    const previewRole   = document.getElementById('previewRole');

    nameInput?.addEventListener('input', function () {
        const val = this.value.trim();
        previewName.textContent = val || 'Nom complet';
        if (val) {
            const parts = val.split(' ');
            const initials = parts.map(w => w[0]).slice(0, 2).join('').toUpperCase();
            previewAvatar.textContent = initials;
        } else {
            previewAvatar.textContent = '👤';
        }
    });

    emailInput?.addEventListener('input', function () {
        previewEmail.textContent = this.value.trim() || 'email@exemple.com';
    });

    const roleMap = {
        client:   { label: 'Cliente',  cls: 'role-client' },
        employee: { label: 'Employée', cls: 'role-employee' },
        admin:    { label: 'Admin',    cls: 'role-admin' },
    };

    function updateRoleBadge(val) {
        const r = roleMap[val];
        previewRole.textContent = r.label;
        previewRole.className = 'preview-role-badge ' + r.cls;
    }

    function togglePw(id) {
        const f = document.getElementById(id);
        f.type = f.type === 'password' ? 'text' : 'password';
    }

    // Init badge selon sélection par défaut
    const defaultRole = document.querySelector('input[name="role"]:checked');
    if (defaultRole) updateRoleBadge(defaultRole.value);
</script>

@endsection
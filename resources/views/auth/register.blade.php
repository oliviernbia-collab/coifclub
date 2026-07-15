@extends('layouts.guest')

@section('title', __('messages.auth_register_title'))

@section('content')

<style>
/* ── En-tête de page ──────────────────────────────────────── */
.rg-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 99px;
    border: 1px solid rgba(233,30,140,.3);
    background: rgba(233,30,140,.1);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 14px;
}
.rg-badge i { font-size: 9px; }

.rg-heading {
    margin-bottom: 24px;
    animation: fade-up .6s .05s var(--ease) both;
}
.rg-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 30px;
    font-weight: 300;
    color: var(--text-main);
    line-height: 1.1;
}
.rg-title em { font-style: italic; color: var(--gold-light); }
.rg-sub {
    margin-top: 6px;
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.6;
}
.rg-rule {
    width: 32px; height: 1.5px;
    background: linear-gradient(to right, var(--gold), transparent);
    margin-top: 14px;
}

/* ── Formulaire ───────────────────────────────────────────── */
.auth-form { gap: 15px; }

/* Grille 2 colonnes */
.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
@media (max-width: 480px) { .field-row { grid-template-columns: 1fr; } }

/* Séparateur de section */
.rg-sep {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 2px 0;
    font-size: 9.5px;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--text-muted);
}
.rg-sep::before, .rg-sep::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--border), transparent);
}

/* Select ──────────────────────────────────────────────────── */
.field select {
    width: 100%;
    height: 44px;
    padding: 0 42px 0 42px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--input-bg);
    color: var(--text-main);
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23e91e8c' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    transition: border-color .25s var(--ease), background .25s var(--ease), box-shadow .25s var(--ease);
}
.field select:focus {
    border-color: var(--border-focus);
    background-color: var(--input-focus);
    box-shadow: 0 0 0 3px var(--gold-dim);
}
.field select option { background: #140F12; color: var(--text-main); }

.select-wrap { position: relative; }
.select-wrap .icon-left {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(212,175,55,.35);
    font-size: 13px;
    pointer-events: none;
    transition: color .2s;
}
.select-wrap:focus-within .icon-left { color: var(--gold); }

/* Bloc salon masqué par défaut ───────────────────────────── */
.salon-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    transition: max-height .45s var(--ease), opacity .35s var(--ease);
}
.salon-section.open { max-height: 200px; opacity: 1; }

/* Alerte erreur globale ──────────────────────────────────── */
.rg-alert {
    background: rgba(220,80,80,.08);
    border: 1px solid rgba(220,80,80,.25);
    border-radius: var(--radius);
    padding: 12px 16px;
    font-size: 12.5px;
    color: #E08080;
    margin-bottom: 4px;
    animation: fade-up .4s var(--ease) both;
}
.rg-alert li { list-style: none; display: flex; align-items: center; gap: 7px; }
.rg-alert li + li { margin-top: 5px; }

/* Indicateur force mot de passe ──────────────────────────── */
.pw-strength { display: flex; gap: 4px; margin-top: 6px; }
.pw-bar {
    flex: 1; height: 3px;
    border-radius: 2px;
    background: rgba(255,255,255,.08);
    transition: background .3s;
}
.pw-bar.weak   { background: #E07070; }
.pw-bar.fair   { background: var(--gold); }
.pw-bar.strong { background: #70C090; }
.pw-label {
    font-size: 10px;
    letter-spacing: 1px;
    color: var(--text-muted);
    margin-top: 4px;
    text-transform: uppercase;
    transition: color .3s;
}

/* Scroll accommodation for long register form */
@media (max-height: 700px) {
    .brand { margin-bottom: 16px; }
    .rg-heading { margin-bottom: 16px; }
}
</style>

{{-- ── En-tête ──────────────────────────────────────────────── --}}
<div class="rg-heading">
    <div class="rg-badge">
        <i class="fa-solid fa-sparkles"></i>
        {{ __('messages.auth_register_header') }}
    </div>
    <h1 class="rg-title">{{ __('messages.auth_register_welcome') }}<br><em>{{ __('messages.auth_register_emphasis') }}</em></h1>
    <p class="rg-sub">{{ __('messages.auth_register_subtitle') }}</p>
    <div class="rg-rule"></div>
</div>

{{-- Erreurs globales Laravel --}}
@if ($errors->any())
    <div class="rg-alert">
        @foreach ($errors->all() as $error)
            <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('register.post') }}" class="auth-form" style="display:flex;flex-direction:column;gap:15px;" id="rg-form">
    @csrf

    {{-- ── Identité ─────────────────────────────────────── --}}
    <div class="field-row">
        <div class="field">
            <label for="name">{{ __('messages.full_name') }}</label>
            <div class="input-wrap">
                <i class="fa-regular fa-user icon-left"></i>
                <input class="form-control" type="text" id="name" name="name"
                       placeholder="{{ __('messages.full_name_placeholder') }}" value="{{ old('name') }}" required>
            </div>
            @error('name')
                <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>
        <div class="field">
            <label for="telephone">{{ __('messages.phone') }}</label>
            <div class="input-wrap">
                <i class="fa-solid fa-phone icon-left"></i>
                <input class="form-control" type="tel" id="telephone" name="telephone"
                       placeholder="{{ __('messages.phone_placeholder') }}" value="{{ old('telephone') }}">
            </div>
            @error('telephone')
                <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- ── Email ────────────────────────────────────────── --}}
    <div class="field">
        <label for="email">{{ __('messages.email_address') }}</label>
        <div class="input-wrap">
            <i class="fa-regular fa-envelope icon-left"></i>
            <input class="form-control" type="email" id="email" name="email"
                   placeholder="{{ __('messages.email_placeholder') }}" value="{{ old('email') }}" required autocomplete="email">
        </div>
        @error('email')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- ── Rôle ─────────────────────────────────────────── --}}
    <div class="field">
        <label for="role-select">{{ __('messages.registration_role_label') }}</label>
        <div class="input-wrap select-wrap">
            <i class="fa-solid fa-id-badge icon-left"></i>
            <select class="form-control" id="role-select" name="role" required style="padding-left:42px;">
                <option value="">{{ __('messages.registration_role_placeholder') }}</option>
                <option value="client" @selected(old('role') === 'client')>{{ __('messages.client_role') }}</option>
                {{-- <option value="admin" @selected(old('role') === 'admin')>{{ __('messages.admin_role') }}</option> --}}
            </select>
        </div>
        @error('role')
            <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
        @enderror
    </div>

    {{-- ── Infos salon (admin seulement) ───────────────── --}}
    <div class="salon-section @if(old('role') === 'admin') open @endif" id="salon-section">
        <div class="rg-sep"><span><i class="fa-solid fa-store" style="margin-right:5px;"></i>{{ __('messages.salon_information') }}</span></div>
        <div class="field-row">
            <div class="field">
                <label for="salon_name">{{ __('messages.salon_name') }}</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-scissors icon-left"></i>
                    <input class="form-control" type="text" id="salon_name" name="salon_name"
                           placeholder="{{ __('messages.salon_name_placeholder') }}" value="{{ old('salon_name') }}">
                </div>
            </div>
            <div class="field">
                <label for="salon_city">{{ __('messages.city') }}</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-location-dot icon-left"></i>
                    <input class="form-control" type="text" id="salon_city" name="salon_city"
                           placeholder="{{ __('messages.city_placeholder') }}" value="{{ old('salon_city') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ── Sécurité ─────────────────────────────────────── --}}
    <div class="field-row">
        <div class="field">
            <label for="password">{{ __('messages.password') }}</label>
            <div class="input-wrap">
                <i class="fa-solid fa-lock icon-left"></i>
                <input class="form-control" type="password" id="password" name="password"
                       placeholder="••••••••" required autocomplete="new-password">
                <button type="button" class="icon-right" onclick="togglePw('password','pwIcon1')" aria-label="{{ __('messages.toggle_password_visibility') }}">
                    <i class="fa-regular fa-eye" id="pwIcon1"></i>
                </button>
            </div>
            <div class="pw-strength" id="pw-strength">
                <div class="pw-bar" id="bar1"></div>
                <div class="pw-bar" id="bar2"></div>
                <div class="pw-bar" id="bar3"></div>
            </div>
            <div class="pw-label" id="pw-label">{{ __('messages.password_strength') }}</div>
            @error('password')
                <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>
        <div class="field">
            <label for="password_confirmation">{{ __('messages.password_confirmation') }}</label>
            <div class="input-wrap">
                <i class="fa-solid fa-lock icon-left"></i>
                <input class="form-control" type="password" id="password_confirmation"
                       name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                <button type="button" class="icon-right" onclick="togglePw('password_confirmation','pwIcon2')" aria-label="{{ __('messages.toggle_password_visibility') }}">
                    <i class="fa-regular fa-eye" id="pwIcon2"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Submit ────────────────────────────────────────── --}}
    <button type="submit" class="btn-auth" style="margin-top:4px;">
        {{ __('messages.register') }}
    </button>

</form>

{{-- Footer --}}
<p class="auth-footer">
    {{ __('messages.already_have_account') }} <a href="{{ route('login') }}">{{ __('messages.login') }}</a><br>
    {{ __('messages.return_to') }}<a href="{{ route('home') }}">{{ __('messages.home') }}</a>
</p>

<script>
function togglePw(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.className = show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
}

document.getElementById('role-select').addEventListener('change', function () {
    document.getElementById('salon-section').classList.toggle('open', this.value === 'admin');
});

document.getElementById('password').addEventListener('input', function () {
    const val   = this.value;
    const bars  = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const label = document.getElementById('pw-label');

    bars.forEach(b => b.className = 'pw-bar');

    let score = 0;
    if (val.length >= 8)                               score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val))       score++;
    if (/\d/.test(val) && /[^A-Za-z0-9]/.test(val))   score++;

    const states = [
        { cls: 'weak',   text: 'Faible',  active: 1 },
        { cls: 'fair',   text: 'Moyen',   active: 2 },
        { cls: 'strong', text: 'Fort ✓',  active: 3 },
    ];

    if (val.length === 0) {
        label.textContent = '{{ __("messages.password_strength") }}';
        label.style.color = '';
        return;
    }

    const s = score === 0 ? states[0] : states[score - 1];
    bars.slice(0, s.active).forEach(b => b.classList.add(s.cls));
    label.textContent = s.text;
    label.style.color = s.cls === 'weak' ? '#E07070' : s.cls === 'fair' ? 'var(--gold)' : '#70C090';
});
</script>

@endsection

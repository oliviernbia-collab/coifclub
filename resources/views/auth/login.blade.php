@extends('layouts.guest')

@section('title', __('messages.auth_login_title'))

@section('content')

<style>
/* ── En-tête ──────────────────────────────────────────────── */
.lg-badge {
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
.lg-badge i { font-size: 9px; }

.lg-heading {
    margin-bottom: 28px;
    animation: fade-up .6s .05s var(--ease) both;
}
.lg-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px;
    font-weight: 300;
    color: var(--text-main);
    line-height: 1.1;
}
.lg-title em { font-style: italic; color: var(--gold-light); }

.lg-sub {
    margin-top: 8px;
    font-size: 12.5px;
    color: var(--text-muted);
    line-height: 1.65;
}
.lg-rule {
    width: 34px; height: 1.5px;
    background: linear-gradient(to right, #e91e8c, transparent);
    margin-top: 16px;
}

/* ── Remember & Forgot row ────────────────────────────────── */
.lg-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    margin-top: -4px;
}
.lg-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-soft);
    cursor: pointer;
    user-select: none;
}
.lg-remember input[type="checkbox"] { display: none; }
.lg-checkbox {
    width: 16px; height: 16px;
    border: 1px solid var(--border);
    border-radius: 4px;
    display: grid; place-items: center;
    flex-shrink: 0;
    transition: background .2s, border-color .2s;
}
.lg-remember input:checked ~ .lg-checkbox {
    background: var(--gold);
    border-color: var(--gold);
}
.lg-remember input:checked ~ .lg-checkbox::after {
    content: '✓';
    font-size: 10px;
    font-weight: 700;
    color: #111;
}
.lg-forgot {
    color: rgba(233,30,140,.75);
    text-decoration: none;
    font-size: 12px;
    transition: color .2s;
}
.lg-forgot:hover { color: var(--gold); }
</style>

{{-- ── En-tête ─────────────────────────────────────────────── --}}
<div class="lg-heading">
    <div class="lg-badge">
        <i class="fa-solid fa-lock"></i>
        {{ __('messages.auth_login_header') }}
    </div>
    <h1 class="lg-title">{{ __('messages.auth_login_welcome') }}<br><em>{{ __('messages.auth_login_emphasis') }}</em></h1>
    <p class="lg-sub">{{ __('messages.auth_login_subtitle') }}</p>
    <div class="lg-rule"></div>
</div>

{{-- ── Formulaire ──────────────────────────────────────────── --}}
<form method="POST" action="{{ route('login') }}" class="auth-form" style="display:flex;flex-direction:column;gap:20px;">
    @csrf

    {{-- Email --}}
    <div class="field">
        <label for="email">{{ __('messages.email_address') }}</label>
        <div class="input-wrap">
            <i class="fa-regular fa-envelope icon-left"></i>
            <input
                class="form-control"
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="{{ __('messages.email_placeholder') }}"
                required
                autocomplete="email"
            >
        </div>
        @error('email')
            <span class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Mot de passe --}}
    <div class="field">
        <label for="password">{{ __('messages.password') }}</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock icon-left"></i>
            <input
                class="form-control"
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            >
            <button type="button" class="icon-right" onclick="togglePw()" aria-label="{{ __('messages.toggle_password_visibility') }}">
                <i class="fa-regular fa-eye" id="pwIcon"></i>
            </button>
        </div>
        @error('password')
            <span class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Se souvenir / Mot de passe oublié --}}
    <div class="lg-options">
        <label class="lg-remember">
            <input type="checkbox" name="remember">
            <span class="lg-checkbox"></span>
            <span>{{ __('messages.remember_me') }}</span>
        </label>
        <a href="#" class="lg-forgot">{{ __('messages.forgot_password') }}</a>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-auth">
        {{ __('messages.login') }}
    </button>

</form>

{{-- Footer --}}
<p class="auth-footer">
    {{ __('messages.no_account_yet') }}
    <a href="{{ route('register') }}">{{ __('messages.create_account_free') }}</a><br>
    {{ __('messages.return_to') }}<a href="{{ route('home') }}">{{ __('messages.home') }}</a>
</p>

<script>
function togglePw() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('pwIcon');
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.className = show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
}
</script>

@endsection

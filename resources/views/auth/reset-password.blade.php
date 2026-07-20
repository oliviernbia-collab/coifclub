@extends('layouts.guest')

@section('title', __('messages.auth_reset_title'))

@section('content')

<style>
.rp-badge {
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
.rp-badge i { font-size: 9px; }

.rp-heading {
    margin-bottom: 28px;
    animation: fade-up .6s .05s var(--ease) both;
}
.rp-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px;
    font-weight: 300;
    color: var(--text-main);
    line-height: 1.1;
}
.rp-title em { font-style: italic; color: var(--gold-light); }

.rp-sub {
    margin-top: 8px;
    font-size: 12.5px;
    color: var(--text-muted);
    line-height: 1.65;
}
.rp-rule {
    width: 34px; height: 1.5px;
    background: linear-gradient(to right, #e91e8c, transparent);
    margin-top: 16px;
}
</style>

{{-- ── En-tête ─────────────────────────────────────────────── --}}
<div class="rp-heading">
    <div class="rp-badge">
        <i class="fa-solid fa-lock-open"></i>
        {{ __('messages.auth_reset_header') }}
    </div>
    <h1 class="rp-title">{{ __('messages.auth_reset_welcome') }}<br><em>{{ __('messages.auth_reset_emphasis') }}</em></h1>
    <p class="rp-sub">{{ __('messages.auth_reset_subtitle') }}</p>
    <div class="rp-rule"></div>
</div>

{{-- ── Formulaire ──────────────────────────────────────────── --}}
<form method="POST" action="{{ route('password.update') }}" class="auth-form" style="display:flex;flex-direction:column;gap:20px;">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

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
                value="{{ old('email', $email) }}"
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

    {{-- Nouveau mot de passe --}}
    <div class="field">
        <label for="password">{{ __('messages.new_password') }}</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock icon-left"></i>
            <input
                class="form-control"
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            >
            <button type="button" class="icon-right" onclick="togglePw('password','pwIcon1')" aria-label="{{ __('messages.toggle_password_visibility') }}">
                <i class="fa-regular fa-eye" id="pwIcon1"></i>
            </button>
        </div>
        @error('password')
            <span class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Confirmation --}}
    <div class="field">
        <label for="password_confirmation">{{ __('messages.confirm_new_password') }}</label>
        <div class="input-wrap">
            <i class="fa-solid fa-lock icon-left"></i>
            <input
                class="form-control"
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            >
            <button type="button" class="icon-right" onclick="togglePw('password_confirmation','pwIcon2')" aria-label="{{ __('messages.toggle_password_visibility') }}">
                <i class="fa-regular fa-eye" id="pwIcon2"></i>
            </button>
        </div>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-auth">
        {{ __('messages.reset_password_btn') }}
    </button>

</form>

{{-- Footer --}}
<p class="auth-footer">
    <a href="{{ route('login') }}">{{ __('messages.back_to_login') }}</a><br>
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
</script>

@endsection

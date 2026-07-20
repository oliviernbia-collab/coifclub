@extends('layouts.guest')

@section('title', __('messages.auth_forgot_title'))

@section('content')

<style>
.fp-badge {
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
.fp-badge i { font-size: 9px; }

.fp-heading {
    margin-bottom: 28px;
    animation: fade-up .6s .05s var(--ease) both;
}
.fp-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px;
    font-weight: 300;
    color: var(--text-main);
    line-height: 1.1;
}
.fp-title em { font-style: italic; color: var(--gold-light); }

.fp-sub {
    margin-top: 8px;
    font-size: 12.5px;
    color: var(--text-muted);
    line-height: 1.65;
}
.fp-rule {
    width: 34px; height: 1.5px;
    background: linear-gradient(to right, #e91e8c, transparent);
    margin-top: 16px;
}

.fp-alert {
    background: rgba(112,192,144,.08);
    border: 1px solid rgba(112,192,144,.3);
    border-radius: var(--radius);
    padding: 12px 16px;
    font-size: 12.5px;
    color: #70C090;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: fade-up .4s var(--ease) both;
}
</style>

{{-- ── En-tête ─────────────────────────────────────────────── --}}
<div class="fp-heading">
    <div class="fp-badge">
        <i class="fa-solid fa-key"></i>
        {{ __('messages.auth_forgot_header') }}
    </div>
    <h1 class="fp-title">{{ __('messages.auth_forgot_welcome') }}<br><em>{{ __('messages.auth_forgot_emphasis') }}</em></h1>
    <p class="fp-sub">{{ __('messages.auth_forgot_subtitle') }}</p>
    <div class="fp-rule"></div>
</div>

@if (session('success'))
    <div class="fp-alert">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- ── Formulaire ──────────────────────────────────────────── --}}
<form method="POST" action="{{ route('password.email') }}" class="auth-form" style="display:flex;flex-direction:column;gap:20px;">
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
                autofocus
            >
        </div>
        @error('email')
            <span class="field-error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-auth">
        {{ __('messages.send_reset_link') }}
    </button>

</form>

{{-- Footer --}}
<p class="auth-footer">
    <a href="{{ route('login') }}">{{ __('messages.back_to_login') }}</a><br>
    {{ __('messages.return_to') }}<a href="{{ route('home') }}">{{ __('messages.home') }}</a>
</p>

@endsection

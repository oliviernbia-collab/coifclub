@extends('layouts.client')

@section('title', __('messages.prof_title'))
@section('page-title', __('messages.prof_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.prof-wrap{max-width:900px;}

.prof-sub{color:var(--muted);font-size:.92rem;margin-bottom:28px;}

.prof-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
@media(max-width:680px){.prof-grid{grid-template-columns:1fr;}}

.prof-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:28px;transition:.25s;}
.prof-card:hover{border-color:rgba(233,30,140,.2);}
.prof-card-title{font-size:1rem;font-weight:700;color:var(--text);margin-bottom:22px;display:flex;align-items:center;gap:10px;}
.prof-card-title i{color:var(--pink);}

.flash-ok{background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:12px;padding:12px 16px;color:#4ade80;font-size:.88rem;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.flash-err{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:12px;padding:12px 16px;color:#f87171;font-size:.88rem;font-weight:600;margin-bottom:18px;}

.input-wrap{position:relative;margin-bottom:18px;}
.input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.9rem;pointer-events:none;transition:.2s;}
.prof-input{width:100%;padding:12px 14px 12px 42px;background:rgba(255,255,255,.06);border:1px solid rgba(233,30,140,.2);border-radius:12px;color:var(--text);font-size:.95rem;outline:none;transition:.25s;font-family:inherit;}
.prof-input:focus{border-color:rgba(233,30,140,.5);background:rgba(233,30,140,.05);}
.prof-input::placeholder{color:var(--muted);}
.prof-input:focus ~ i{color:var(--pink);}

.btn-save{width:100%;background:var(--gradient);border:none;color:#fff;font-weight:700;padding:13px;border-radius:12px;cursor:pointer;transition:.25s;font-size:.95rem;box-shadow:0 8px 20px rgba(233,30,140,.3);}
.btn-save:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(233,30,140,.4);}

.btn-dark-save{width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:var(--text);font-weight:700;padding:13px;border-radius:12px;cursor:pointer;transition:.25s;font-size:.95rem;}
.btn-dark-save:hover{background:rgba(255,255,255,.1);border-color:rgba(233,30,140,.3);}

/* Avatar section */
.prof-avatar-section{background:rgba(233,30,140,.05);border:1px solid rgba(233,30,140,.12);border-radius:24px;padding:28px;margin-bottom:24px;display:flex;align-items:center;gap:24px;flex-wrap:wrap;}
.prof-avatar-img{width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(233,30,140,.4);box-shadow:0 0 20px rgba(233,30,140,.2);flex-shrink:0;}
.prof-avatar-name{font-size:1.4rem;font-weight:900;color:var(--text);margin-bottom:4px;}
.prof-avatar-role{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:rgba(233,30,140,.12);border:1px solid rgba(233,30,140,.2);border-radius:999px;color:var(--pink-light);font-size:.78rem;font-weight:700;}
</style>

<div class="prof-wrap">

    <p class="prof-sub">{{ __('messages.prof_subtitle') }}</p>

    {{-- Avatar card --}}
    @auth
    <div class="prof-avatar-section">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2d1854&color=e91e8c&bold=true&size=150"
             class="prof-avatar-img" alt="{{ auth()->user()->name }}">
        <div>
            <div class="prof-avatar-name">{{ auth()->user()->name }}</div>
            <div class="prof-avatar-role"><i class="fa-solid fa-crown"></i> {{ __('messages.prof_role_client') }}</div>
        </div>
    </div>
    @endauth

    <div class="prof-grid">

        {{-- Info personnelles --}}
        <div class="prof-card">
            <div class="prof-card-title">
                <i class="fa-solid fa-id-card"></i> {{ __('messages.prof_info_title') }}
            </div>

            @if(session('success'))
            <div class="flash-ok"><i class="fa-solid fa-circle-check"></i>{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PUT')
                <div class="input-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" value="{{ $user->name }}" class="prof-input" placeholder="{{ __('messages.prof_name_ph') }}" required>
                </div>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" value="{{ $user->email }}" class="prof-input" placeholder="{{ __('messages.prof_email_ph') }}" required>
                </div>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> {{ __('messages.prof_update_btn') }}
                </button>
            </form>
        </div>

        {{-- Sécurité --}}
        <div class="prof-card">
            <div class="prof-card-title">
                <i class="fa-solid fa-shield-halved"></i> {{ __('messages.prof_security_title') }}
            </div>

            @error('current_password')
            <div class="flash-err">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf @method('PUT')
                <div class="input-wrap">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="current_password" class="prof-input" placeholder="{{ __('messages.prof_current_pw') }}" required>
                </div>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" class="prof-input" placeholder="{{ __('messages.prof_new_pw') }}" required>
                </div>
                <div class="input-wrap">
                    <i class="fa-solid fa-check"></i>
                    <input type="password" name="password_confirmation" class="prof-input" placeholder="{{ __('messages.prof_confirm_pw') }}" required>
                </div>
                <button type="submit" class="btn-dark-save">
                    <i class="fa-solid fa-shield-halved mr-2"></i> {{ __('messages.prof_change_pw_btn') }}
                </button>
            </form>
        </div>

    </div>

</div>

@endsection

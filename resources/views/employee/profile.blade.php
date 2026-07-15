@extends('layouts.employee')
@section('title', __('messages.my_profile_title'))

@section('content')

<style>
/* ── Profile top ── */
.profile-top { display:flex; align-items:center; gap:20px; margin-bottom:30px; padding-bottom:24px; border-bottom:1px solid rgba(255,255,255,.08); flex-wrap:wrap; }
.profile-avatar { width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid rgba(233,30,140,.4); box-shadow:0 8px 18px rgba(0,0,0,.25); }
.profile-name { font-size:24px; font-weight:800; color:#fff !important; margin-bottom:6px; }
.profile-role-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(233,30,140,.12); color:#ff6ab4; padding:8px 14px; border-radius:999px; font-size:14px; font-weight:700; border:1px solid rgba(233,30,140,.2); }

/* ── Card ── */
.profile-card-dark { background:rgba(255,255,255,.04); border-radius:24px; border:1px solid rgba(255,255,255,.08); box-shadow:0 4px 24px rgba(0,0,0,.25); overflow:hidden; padding:28px; position:relative; }
.profile-card-dark::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#e91e8c,#ff6ab4); }

/* ── Form overrides ── */
.form-label-dark { font-weight:600; color:rgba(255,255,255,.7) !important; margin-bottom:8px; display:block; }
.input-group-text-dark { background:rgba(255,255,255,.04) !important; border:1px solid rgba(255,255,255,.12) !important; color:rgba(255,255,255,.5) !important; border-radius:14px 0 0 14px; padding:0 14px; display:flex; align-items:center; }
.form-control-dark { height:52px; border-radius:0 14px 14px 0; border:1px solid rgba(255,255,255,.12) !important; padding:12px 16px; font-size:15px; background:rgba(255,255,255,.06) !important; color:#fff !important; transition:.25s ease; outline:none; border-left:none !important; }
.form-control-dark:focus { border-color:rgba(233,30,140,.4) !important; box-shadow:0 0 0 3px rgba(233,30,140,.1) !important; }
.form-control-dark::placeholder { color:rgba(255,255,255,.25) !important; }
textarea.form-control-dark { height:auto; border-radius:0 14px 14px 0; resize:none; }

/* ── Salon box ── */
.salon-box-dark { display:flex; align-items:center; gap:14px; background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.2); border-radius:18px; padding:18px; }
.salon-icon { width:50px; height:50px; border-radius:16px; background:linear-gradient(135deg,#2563eb,#60a5fa); color:#fff; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
.salon-title-dark { font-size:13px; color:rgba(255,255,255,.45); margin-bottom:4px; }
.salon-name-dark { font-size:18px; font-weight:800; color:#fff; }

/* ── Button ── */
.btn-save-dark { background:linear-gradient(135deg,#e91e8c,#c0156d); border:none; color:#fff; font-weight:700; padding:14px 28px; border-radius:14px; transition:.3s ease; box-shadow:0 10px 20px rgba(233,30,140,.25); cursor:pointer; }
.btn-save-dark:hover { transform:translateY(-2px); box-shadow:0 14px 30px rgba(233,30,140,.35); }

/* ── Header ── */
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:16px; }

@media(max-width:768px) {
    .profile-top { flex-direction:column; align-items:center; text-align:center; gap:14px; }
    .profile-name { font-size:20px; }
    .btn-save-dark { width:100%; justify-content:center; padding:15px; }
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title" style="-webkit-text-fill-color:#fff!important;">
            <i class="bi bi-person-gear me-2"></i>
            {{ __('messages.my_profile_title') }}
        </h1>
        <p class="page-subtitle mb-0">{{ __('messages.update_personal_info') }}</p>
    </div>
</div>

<div class="profile-card-dark">

    {{-- PROFILE TOP --}}
    <div class="profile-top">
        <img src="{{ auth()->user()->employee && auth()->user()->employee->photo
                ? asset('storage/' . auth()->user()->employee->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2d1854&color=e91e8c&bold=true'
            }}"
            alt="{{ auth()->user()->name }}"
            class="profile-avatar">
        <div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-role-badge">
                <i class="bi bi-scissors"></i>
                {{ __('messages.professional_employee') }}
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('employee.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- PHOTO --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.profile_photo') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-image"></i></span>
                    <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="form-control form-control-dark">
                </div>
                @if(auth()->user()->employee && auth()->user()->employee->photo)
                    <p class="mt-2" style="font-size:.82rem;color:rgba(255,255,255,.4);">{{ __('messages.current_photo_saved') }}</p>
                @endif
            </div>

            {{-- NOM --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.full_name') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control form-control-dark"
                           value="{{ old('name', auth()->user()->name) }}" required>
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.email_address') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control form-control-dark"
                           value="{{ auth()->user()->email }}" readonly style="opacity:.6;">
                </div>
            </div>

            {{-- TELEPHONE --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.phone') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-telephone"></i></span>
                    <input type="text" name="phone" class="form-control form-control-dark"
                           value="{{ old('phone', auth()->user()->phone) }}" required>
                </div>
            </div>

            {{-- MOT DE PASSE --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.new_password') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control form-control-dark"
                           placeholder="{{ __('messages.leave_empty_no_change') }}">
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.confirm_new_password') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" class="form-control form-control-dark"
                           placeholder="{{ __('messages.confirm_new_password') }}">
                </div>
            </div>

            {{-- SPECIALITE --}}
            <div class="col-md-6">
                <label class="form-label-dark">{{ __('messages.specialty') }}</label>
                <div class="input-group" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark"><i class="bi bi-stars"></i></span>
                    <input type="text" name="specialty" class="form-control form-control-dark"
                           value="{{ old('specialty', auth()->user()->employee?->specialty) }}" required>
                </div>
            </div>

            {{-- BIO --}}
            <div class="col-12">
                <label class="form-label-dark">{{ __('messages.about_me') }}</label>
                <div class="input-group align-items-start" style="border-radius:14px;overflow:hidden;">
                    <span class="input-group-text-dark" style="padding-top:14px;align-self:flex-start;"><i class="bi bi-pencil-square"></i></span>
                    <textarea name="bio" class="form-control form-control-dark" rows="5">{{ old('bio', auth()->user()->employee?->bio) }}</textarea>
                </div>
            </div>

            {{-- SALON --}}
            @if(auth()->user()->employee && auth()->user()->employee->salon)
            <div class="col-12">
                <div class="salon-box-dark">
                    <div class="salon-icon"><i class="bi bi-shop"></i></div>
                    <div>
                        <div class="salon-title-dark">{{ __('messages.associated_salon') }}</div>
                        <div class="salon-name-dark">{{ auth()->user()->employee->salon->nom }}</div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn-save-dark">
                <i class="bi bi-floppy me-2"></i>
                {{ __('messages.save_modifications') }}
            </button>
        </div>

    </form>

</div>

@endsection

@extends('layouts.admin')

@section('title', __('messages.customization'))
@section('page-title', __('messages.customization_page_title'))
@section('page-subtitle', __('messages.customization_page_subtitle'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

:root{
    --ps-bg:#0b1120;
    --ps-card:#111827;
    --ps-card-2:#0f172a;
    --ps-border:rgba(255,255,255,.06);
    --ps-text:#f8fafc;
    --ps-muted:#94a3b8;
    --ps-gold:#d4af37;
    --ps-pink:#ff4d6d;
    --ps-orange:#ff7a59;
    --ps-shadow:0 25px 50px rgba(0,0,0,.35);
}

.ps-wrapper{
    font-family:'Inter',sans-serif;
    color:var(--ps-text);
}

/* =========================================================
   HERO
========================================================= */

.ps-hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    padding:42px;
    margin-bottom:32px;
    background:
        radial-gradient(circle at top right, rgba(255,77,109,.18), transparent 35%),
        radial-gradient(circle at bottom left, rgba(212,175,55,.14), transparent 35%),
        linear-gradient(145deg,#0f172a,#020617);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--ps-shadow);
}

.ps-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:40px 40px;
    opacity:.2;
}

.ps-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--ps-gold);
    font-size:11px;
    letter-spacing:.22em;
    text-transform:uppercase;
    font-weight:600;
    margin-bottom:18px;
}

.ps-eyebrow::before{
    content:'';
    width:40px;
    height:1px;
    background:var(--ps-gold);
}

.ps-title{
    font-family:'Playfair Display',serif;
    font-size:52px;
    font-weight:700;
    line-height:1;
    margin:0 0 16px;
    color:white;
}

.ps-subtitle{
    max-width:720px;
    color:rgba(255,255,255,.68);
    line-height:1.9;
    font-size:15px;
    margin:0;
}

/* =========================================================
   ALERT
========================================================= */

.ps-alert{
    display:flex;
    align-items:center;
    gap:14px;
    padding:18px 22px;
    border-radius:20px;
    margin-bottom:28px;
    background:rgba(16,185,129,.12);
    border:1px solid rgba(16,185,129,.18);
    color:#6ee7b7;
    box-shadow:0 10px 25px rgba(16,185,129,.08);
}

.ps-alert i{
    font-size:20px;
}

/* =========================================================
   GRID
========================================================= */

.ps-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:28px;
}

/* =========================================================
   CARD
========================================================= */

.ps-card{
    position:relative;
    overflow:hidden;
    border-radius:30px;
    padding:32px;
    background:linear-gradient(180deg,var(--ps-card),var(--ps-card-2));
    border:1px solid var(--ps-border);
    box-shadow:var(--ps-shadow);
}

.ps-card::after{
    content:'';
    position:absolute;
    top:-100px;
    right:-100px;
    width:220px;
    height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.03);
}

.ps-card-head{
    margin-bottom:28px;
}

.ps-card-title{
    display:flex;
    align-items:center;
    gap:14px;
    font-size:24px;
    font-weight:700;
    color:white;
    margin-bottom:10px;
}

.ps-card-title i{
    width:52px;
    height:52px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,77,109,.12);
    color:var(--ps-pink);
    border:1px solid rgba(255,77,109,.18);
    font-size:20px;
}

.ps-card-subtitle{
    color:var(--ps-muted);
    line-height:1.7;
    font-size:14px;
}

/* =========================================================
   FORM
========================================================= */

.ps-group{
    margin-bottom:24px;
}

.ps-label{
    display:block;
    margin-bottom:10px;
    font-size:13px;
    font-weight:600;
    letter-spacing:.04em;
    color:#e2e8f0;
}

.ps-input,
.ps-textarea{
    width:100%;
    border:none;
    outline:none;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.06);
    border-radius:18px;
    padding:16px 18px;
    color:white;
    font-size:14px;
    transition:.25s ease;
}

.ps-input:focus,
.ps-textarea:focus{
    border-color:rgba(255,77,109,.45);
    box-shadow:0 0 0 4px rgba(255,77,109,.10);
    background:rgba(255,255,255,.06);
}

.ps-textarea{
    resize:none;
    min-height:170px;
    line-height:1.8;
}

/* =========================================================
   LOGO
========================================================= */

.ps-logo-box{
    display:flex;
    align-items:center;
    justify-content:center;
    width:180px;
    height:180px;
    border-radius:28px;
    overflow:hidden;
    margin-bottom:24px;
    background:rgba(255,255,255,.03);
    border:1px dashed rgba(255,255,255,.10);
    position:relative;
}

.ps-logo-box img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.ps-logo-placeholder{
    text-align:center;
    color:var(--ps-muted);
}

.ps-logo-placeholder i{
    font-size:42px;
    margin-bottom:10px;
    color:rgba(255,255,255,.35);
}

.ps-upload{
    position:relative;
}

.ps-upload input{
    display:none;
}

.ps-upload-label{
    display:inline-flex;
    align-items:center;
    gap:12px;
    padding:14px 22px;
    border-radius:16px;
    background:rgba(255,77,109,.12);
    border:1px solid rgba(255,77,109,.18);
    color:#ff8ba0;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:.25s ease;
}

.ps-upload-label:hover{
    transform:translateY(-2px);
    background:rgba(255,77,109,.18);
}

/* =========================================================
   BUTTON
========================================================= */

.ps-btn{
    border:none;
    outline:none;
    display:inline-flex;
    align-items:center;
    gap:12px;
    padding:15px 26px;
    border-radius:18px;
    font-size:14px;
    font-weight:700;
    color:white;
    cursor:pointer;
    transition:.3s ease;
    background:linear-gradient(135deg,var(--ps-pink),var(--ps-orange));
    box-shadow:
        0 14px 30px rgba(255,77,109,.22),
        inset 0 1px 0 rgba(255,255,255,.15);
}

.ps-btn:hover{
    transform:translateY(-3px);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:992px){

    .ps-grid{
        grid-template-columns:1fr;
    }

    .ps-title{
        font-size:40px;
    }
}

@media(max-width:768px){

    .ps-hero{
        padding:30px;
        border-radius:24px;
    }

    .ps-title{
        font-size:34px;
    }

    .ps-card{
        padding:24px;
        border-radius:24px;
    }

    .ps-logo-box{
        width:150px;
        height:150px;
    }
}
</style>
@endpush

@section('content')

<div class="ps-wrapper">

    {{-- HERO --}}
    <div class="ps-hero">

        <div class="ps-eyebrow">
            {{ __('messages.branding_studio') }}
        </div>

        <h1 class="ps-title">
            {{ __('messages.customization_identity') }}
        </h1>

        <p class="ps-subtitle">
            {{ __('messages.customization_page_description') }}
        </p>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="ps-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- GRID --}}
    <div class="ps-grid">

        {{-- LOGO --}}
        <div class="ps-card">

            <div class="ps-card-head">

                <div class="ps-card-title">
                    <i class="fas fa-image"></i>
                    {{ __('messages.salon_logo') }}
                </div>

                <div class="ps-card-subtitle">
                    {{ __('messages.logo_upload_info') }}
                </div>

            </div>

            <form action="{{ route('admin.personnalisation.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="ps-group">

                    <label class="ps-label">
                        {{ __('messages.logo_preview') }}
                    </label>

                    <div class="ps-logo-box logo-preview">

                        @if($salon && $salon->logo)

                            <img src="{{ asset('storage/' . $salon->logo) }}"
                                 alt="Logo">

                        @else

                            <div class="ps-logo-placeholder">
                                <i class="fas fa-camera"></i>
                                <div>{{ __('messages.no_logo') }}</div>
                            </div>

                        @endif

                    </div>

                    <div class="ps-upload">

                        <input type="file"
                               id="logo"
                               name="logo"
                               accept="image/*"
                               onchange="previewLogo(this)">

                        <label for="logo" class="ps-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            {{ __('messages.choose_file') }}
                        </label>

                    </div>

                </div>

                <button type="submit" class="ps-btn">
                    <i class="fas fa-save"></i>
                    {{ __('messages.save_logo') }}
                </button>

            </form>

        </div>

        {{-- BRANDING --}}
        <div class="ps-card">

            <div class="ps-card-head">

                <div class="ps-card-title">
                    <i class="fas fa-palette"></i>
                    {{ __('messages.branding_and_description') }}
                </div>

                <div class="ps-card-subtitle">
                    {{ __('messages.branding_description_info') }}
                </div>

            </div>

            <form action="{{ route('admin.personnalisation.branding') }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="ps-group">

                    <label class="ps-label">
                        {{ __('messages.salon_description') }}
                    </label>

                    <textarea
                        name="description"
                        class="ps-textarea"
                        placeholder="{{ __('messages.description_placeholder') }}"
                    >{{ old('description', $salon?->description ?? '') }}</textarea>

                </div>

                <button type="submit" class="ps-btn">
                    <i class="fas fa-save"></i>
                    {{ __('messages.save_changes') }}
                </button>

            </form>

        </div>

    </div>

</div>

<script>
function previewLogo(input)
{
    if (input.files && input.files[0])
    {
        const reader = new FileReader();

        reader.onload = function(e)
        {
            const preview = document.querySelector('.logo-preview');

            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
            `;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
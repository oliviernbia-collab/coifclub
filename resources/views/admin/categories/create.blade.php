@extends('layouts.admin')

@section('title', __('messages.adm_create_category'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

:root{
    --cc-bg:#0b1120;
    --cc-card:#111827;
    --cc-card-2:#0f172a;
    --cc-border:rgba(255,255,255,.06);
    --cc-text:#f8fafc;
    --cc-muted:#94a3b8;
    --cc-primary:#10b981;
    --cc-primary-dark:#059669;
    --cc-gold:#d4af37;
    --cc-shadow:0 25px 50px rgba(0,0,0,.35);
}

.cc-wrapper{
    font-family:'Inter',sans-serif;
    color:var(--cc-text);
}

/* =========================================================
   HERO
========================================================= */

.cc-hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    padding:42px;
    margin-bottom:32px;
    background:
        radial-gradient(circle at top right, rgba(16,185,129,.18), transparent 35%),
        radial-gradient(circle at bottom left, rgba(212,175,55,.12), transparent 35%),
        linear-gradient(145deg,#0f172a,#020617);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--cc-shadow);
}

.cc-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:40px 40px;
    opacity:.2;
}

.cc-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--cc-gold);
    font-size:11px;
    font-weight:600;
    letter-spacing:.22em;
    text-transform:uppercase;
    margin-bottom:18px;
}

.cc-eyebrow::before{
    content:'';
    width:40px;
    height:1px;
    background:var(--cc-gold);
}

.cc-title{
    font-family:'Playfair Display',serif;
    font-size:54px;
    line-height:1;
    font-weight:700;
    color:white;
    margin:0 0 16px;
}

.cc-subtitle{
    max-width:720px;
    color:rgba(255,255,255,.68);
    line-height:1.9;
    font-size:15px;
    margin:0;
}

.cc-date{
    margin-top:24px;
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:10px 16px;
    border-radius:14px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
    color:#cbd5e1;
    font-size:13px;
}

/* =========================================================
   FORM CARD
========================================================= */

.cc-card{
    background:linear-gradient(180deg,#111827,#0b1120);
    border:1px solid var(--cc-border);
    border-radius:32px;
    overflow:hidden;
    box-shadow:var(--cc-shadow);
}

.cc-card-head{
    padding:32px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.cc-card-title{
    font-size:30px;
    font-weight:700;
    color:white;
    margin-bottom:10px;
}

.cc-card-subtitle{
    color:var(--cc-muted);
    line-height:1.8;
    font-size:14px;
}

/* =========================================================
   FORM
========================================================= */

.cc-form{
    padding:32px;
}

.cc-group{
    margin-bottom:28px;
}

.cc-label{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    font-size:14px;
    font-weight:700;
    color:white;
}

.cc-label i{
    color:var(--cc-primary);
}

.cc-input,
.cc-textarea{
    width:100%;
    border:none;
    outline:none;
    border-radius:20px;
    padding:18px 20px;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.06);
    color:white;
    font-size:15px;
    transition:.25s ease;
}

.cc-input:focus,
.cc-textarea:focus{
    border-color:rgba(16,185,129,.35);
    box-shadow:0 0 0 5px rgba(16,185,129,.10);
    background:rgba(255,255,255,.06);
}

.cc-input::placeholder,
.cc-textarea::placeholder{
    color:#64748b;
}

.cc-textarea{
    resize:none;
    min-height:150px;
    line-height:1.8;
}

.cc-hint{
    display:flex;
    align-items:center;
    gap:8px;
    margin-top:10px;
    color:var(--cc-muted);
    font-size:13px;
}

/* =========================================================
   ACTIONS
========================================================= */

.cc-actions{
    display:flex;
    align-items:center;
    gap:16px;
    margin-top:36px;
}

.cc-btn{
    border:none;
    outline:none;
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:16px 24px;
    border-radius:18px;
    font-size:14px;
    font-weight:700;
    transition:.25s ease;
    text-decoration:none;
    cursor:pointer;
}

.cc-btn-primary{
    color:white;
    background:linear-gradient(135deg,var(--cc-primary),var(--cc-primary-dark));
    box-shadow:0 15px 30px rgba(16,185,129,.25);
}

.cc-btn-primary:hover{
    transform:translateY(-3px);
    color:white;
}

.cc-btn-secondary{
    color:#cbd5e1;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
}

.cc-btn-secondary:hover{
    background:rgba(255,255,255,.08);
    color:white;
}

/* =========================================================
   INFO BOXES
========================================================= */

.cc-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.cc-info{
    border-radius:24px;
    padding:24px;
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.05);
}

.cc-info-icon{
    width:54px;
    height:54px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:18px;
    font-size:22px;
    background:rgba(16,185,129,.12);
    border:1px solid rgba(16,185,129,.18);
    color:#34d399;
}

.cc-info-title{
    font-size:16px;
    font-weight:700;
    color:white;
    margin-bottom:10px;
}

.cc-info-text{
    color:var(--cc-muted);
    line-height:1.8;
    font-size:14px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1100px){

    .cc-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){

    .cc-hero{
        padding:30px;
        border-radius:24px;
    }

    .cc-title{
        font-size:38px;
    }

    .cc-actions{
        flex-direction:column;
        align-items:stretch;
    }

    .cc-btn{
        justify-content:center;
    }
}
</style>
@endpush

@section('content')

<div class="cc-wrapper">

    <div class="cc-card">

        {{-- Header ------------------------------------------------- --}}
        <div class="cc-card-head" style="display:flex;align-items:center;gap:16px;padding:24px 28px;border-bottom:1px solid rgba(255,255,255,.06);background:rgba(16,185,129,.05);">
            <div style="width:48px;height:48px;border-radius:14px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.2);display:flex;align-items:center;justify-content:center;font-size:20px;color:#34d399;flex-shrink:0;">
                <i class="fa-solid fa-folder-plus"></i>
            </div>
            <div>
                <div class="cc-card-title">{{ __('messages.adm_create_category') }}</div>
                <div class="cc-card-subtitle">{{ __('messages.adm_create_cat_subtitle') }}</div>
            </div>
        </div>

        {{-- Validation errors --------------------------------------- --}}
        @if ($errors->any())
        <div class="cc-alert">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> {{ __('messages.validation_error') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form ---------------------------------------------------- --}}
        <form method="POST"
              action="{{ route('admin.categories.store') }}"
              class="cc-form"
              id="cc-create-form">
            @csrf

            {{-- Name --}}
            <div class="cc-group">
                <label for="nom" class="cc-label">
                    <i class="fa-solid fa-tag"></i>
                    {{ __('messages.adm_cat_nom_label') }}<span style="color:#f87171;margin-left:2px;">*</span>
                </label>
                <input type="text" name="nom" id="nom" class="cc-input"
                       value="{{ old('nom') }}"
                       placeholder="{{ __('messages.adm_cat_nom_placeholder') }}"
                       required>
                <div class="cc-hint">
                    <i class="fa-regular fa-lightbulb"></i>
                    {{ __('messages.adm_cat_nom_hint') }}
                </div>
            </div>

            {{-- Description --}}
            <div class="cc-group">
                <label for="description" class="cc-label">
                    <i class="fa-solid fa-align-left"></i>
                    {{ __('messages.adm_description') }}
                </label>
                <textarea name="description" id="description" class="cc-textarea"
                          placeholder="{{ __('messages.adm_cat_desc_placeholder') }}"
                >{{ old('description') }}</textarea>
                <div class="cc-hint">
                    <i class="fa-regular fa-note-sticky"></i>
                    {{ __('messages.adm_cat_desc_hint') }}
                </div>
            </div>

        </form>

        {{-- Footer -------------------------------------------------- --}}
        <div class="cc-actions" style="display:flex;align-items:center;gap:12px;padding:20px 28px;border-top:1px solid rgba(255,255,255,.06);background:rgba(255,255,255,.02);flex-wrap:wrap;">
            <button type="submit" form="cc-create-form" class="cc-btn cc-btn-primary">
                <i class="fa-solid fa-circle-plus"></i>
                {{ __('messages.adm_create_category') }}
            </button>
            <a href="{{ route('admin.categories') }}" class="cc-btn cc-btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                {{ __('messages.btn_back') }}
            </a>
        </div>

    </div>

</div>

@endsection
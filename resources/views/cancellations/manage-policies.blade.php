@extends('layouts.admin')

@section('title', __('messages.pol_title'))
@section('page-title', __('messages.pol_title'))
@section('page-subtitle', __('messages.pol_hero_desc'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<div class="container-fluid py-4">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))

        <div class="success-alert mb-4">

            <div class="success-alert-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h5 style="color:rgba(255,255,255,.9);margin-bottom:.3rem;">Mise à jour effectuée</h5>
                <p class="mb-0" style="color:rgba(255,255,255,.65);">
                    {{ session('success') }}
                </p>
            </div>

            <button type="button"
                    class="btn-close ms-auto"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- ERRORS --}}
    @if($errors->any())

        <div class="error-alert mb-4">

            <div class="d-flex align-items-start gap-3">

                <div class="error-alert-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div>

                    <h5 style="color:rgba(255,255,255,.9);margin-bottom:.3rem;">Des erreurs ont été détectées</h5>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>

    @endif

    {{-- HERO --}}
    <div class="policy-hero mb-4">

        <div class="hero-content">

            <div class="hero-left">

                <div class="hero-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>

                    <span class="hero-badge">
                        {{ __('messages.pol_badge') }}
                    </span>

                    <h1>
                        {{ __('messages.pol_title') }}
                    </h1>

                    <p>
                        {{ __('messages.pol_hero_desc') }}
                    </p>

                </div>

            </div>

            <div class="hero-stats">

                <div class="hero-stat-card">

                    <span>Total politiques</span>

                    <strong>
                        {{ $policies->count() }}
                    </strong>

                </div>

                <div class="hero-stat-card">

                    <span>Gestion</span>

                    <strong>
                        Automatique
                    </strong>

                </div>

            </div>

        </div>

    </div>

    {{-- CREATE POLICY --}}
    <div class="premium-card create-policy-card mb-5">

        <div class="card-header-premium">

            <div>

                <h2>
                    <i class="fa-solid fa-plus"></i>
                    {{ __('messages.pol_form_title') }}
                </h2>

                <p>
                    {{ __('messages.pol_hero_desc') }}
                </p>

            </div>

            <div class="header-chip">
                <i class="fa-solid fa-gear"></i>
                Configuration avancée
            </div>

        </div>

        <form action="{{ route('admin.cancellation-policies.store') }}"
              method="POST">

            @csrf

            <div class="row g-4">

                {{-- NAME --}}
                <div class="col-lg-4">

                    <label class="form-label-custom">
                        {{ __('messages.pol_field_title') }}
                    </label>

                    <div class="input-group-premium">

                        <div class="input-icon">
                            <i class="fa-solid fa-tag"></i>
                        </div>

                        <input
                            type="text"
                            name="name"
                            class="form-control premium-input"
                            value="{{ old('name') }}"
                            placeholder="{{ __('messages.pol_field_title_ph') }}"
                            required
                        >

                    </div>

                </div>

                {{-- HOURS --}}
                <div class="col-lg-4">

                    <label class="form-label-custom">
                        {{ __('messages.pol_field_hours') }}
                    </label>

                    <div class="input-group-premium">

                        <div class="input-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>

                        <input
                            type="number"
                            name="hours_before"
                            min="0"
                            class="form-control premium-input"
                            value="{{ old('hours_before', 0) }}"
                            placeholder="0"
                            required
                        >

                    </div>

                </div>

                {{-- REFUND --}}
                <div class="col-lg-4">

                    <label class="form-label-custom">
                        {{ __('messages.pol_field_refund') }}
                    </label>

                    <div class="input-group-premium">

                        <div class="input-icon success">
                            <i class="fa-solid fa-percent"></i>
                        </div>

                        <input
                            type="number"
                            name="refund_percentage"
                            min="0"
                            max="100"
                            class="form-control premium-input"
                            value="{{ old('refund_percentage', 0) }}"
                            placeholder="100"
                            required
                        >

                    </div>

                </div>

                {{-- DESCRIPTION --}}
                <div class="col-12">

                    <label class="form-label-custom">
                        {{ __('messages.pol_field_desc') }}
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control premium-textarea"
                        placeholder="{{ __('messages.pol_field_desc_ph') }}"
                    >{{ old('description') }}</textarea>

                </div>

                {{-- BUTTON --}}
                <div class="col-12 text-end">

                    <button type="submit" class="btn-create-policy">

                        <i class="fa-solid fa-plus"></i>

                        {{ __('messages.pol_btn_create') }}

                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- POLICIES --}}
    <div class="row g-4">

        @forelse($policies as $policy)

            @php

                $badgeClass = 'primary';

                if($policy->refund_percentage >= 80){
                    $badgeClass = 'success';
                }elseif($policy->refund_percentage <= 30){
                    $badgeClass = 'danger';
                }

            @endphp

            <div class="col-xl-6">

                <div class="premium-card policy-card h-100">

                    {{-- HEADER --}}
                    <div class="policy-card-header">

                        <div class="policy-title-wrapper">

                            <div class="policy-icon">

                                <i class="fa-solid fa-clock-rotate-left"></i>

                            </div>

                            <div>

                                <h3>
                                    {{ ucfirst($policy->name) }}
                                </h3>

                                <p>
                                    {{ __('messages.pol_last_update') }} :
                                    {{ $policy->updated_at?->diffForHumans() ?? '–' }}
                                </p>

                            </div>

                        </div>

                        <div class="refund-badge {{ $badgeClass }}">

                            {{ $policy->refund_percentage }}%

                        </div>

                    </div>

                    {{-- FORM --}}
                    <form action="{{ route('admin.cancellation-policies.update', $policy) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">

                            {{-- TITLE --}}
                            <div class="col-md-6">

                                <label class="form-label-custom">
                                    {{ __('messages.pol_field_title') }}
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control premium-input"
                                    value="{{ old('name', $policy->name) }}"
                                    required
                                >

                            </div>

                            {{-- HOURS --}}
                            <div class="col-md-3">

                                <label class="form-label-custom">
                                    {{ __('messages.pol_hours_suffix') }}
                                </label>

                                <input
                                    type="number"
                                    name="hours_before"
                                    min="0"
                                    class="form-control premium-input"
                                    value="{{ old('hours_before', $policy->hours_before) }}"
                                    required
                                >

                            </div>

                            {{-- REFUND --}}
                            <div class="col-md-3">

                                <label class="form-label-custom">
                                    %
                                </label>

                                <input
                                    type="number"
                                    name="refund_percentage"
                                    min="0"
                                    max="100"
                                    class="form-control premium-input"
                                    value="{{ old('refund_percentage', $policy->refund_percentage) }}"
                                    required
                                >

                            </div>

                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-4">

                            <label class="form-label-custom">
                                {{ __('messages.pol_field_desc') }}
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control premium-textarea"
                            >{{ old('description', $policy->description) }}</textarea>

                        </div>

                        {{-- FOOTER --}}
                        <div class="policy-footer">

                            <div class="policy-status">

                                <span class="status-dot"></span>

                                {{ __('messages.pol_active_badge') }}

                            </div>

                            <button type="submit"
                                    class="btn-update-policy">

                                <i class="fa-solid fa-floppy-disk"></i>

                                {{ __('messages.pol_btn_update') }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>

                    <h3>
                        {{ __('messages.pol_empty_title') }}
                    </h3>

                    <p>
                        {{ __('messages.pol_empty_text') }}
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>

<style>

    body{
        background: #0e0a1c;
    }

    /* HERO */

    .policy-hero{
        background:
            radial-gradient(circle at top right, rgba(99,102,241,.18), transparent 30%),
            linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 32px;
        padding: 2.2rem;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(15,23,42,.18);
    }

    .hero-content{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-left{
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .hero-icon{
        width: 95px;
        height: 95px;
        border-radius: 28px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .hero-badge{
        display: inline-block;
        padding: .45rem .9rem;
        border-radius: 50px;
        background: rgba(255,255,255,.12);
        color: #cbd5e1;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .policy-hero h1{
        color: white;
        font-size: 2.3rem;
        font-weight: 800;
        margin-bottom: .8rem;
    }

    .policy-hero p{
        color: rgba(255,255,255,.72);
        max-width: 700px;
        line-height: 1.8;
        margin: 0;
    }

    .hero-stats{
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-stat-card{
        min-width: 180px;
        padding: 1.2rem 1.4rem;
        border-radius: 22px;
        background: rgba(255,255,255,.08);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,.06);
    }

    .hero-stat-card span{
        display: block;
        color: rgba(255,255,255,.65);
        margin-bottom: .5rem;
    }

    .hero-stat-card strong{
        color: white;
        font-size: 1.5rem;
        font-weight: 800;
    }

    /* ALERTS */

    .success-alert,
    .error-alert{
        border-radius: 22px;
        padding: 1.2rem 1.4rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid;
    }

    .success-alert{
        background: rgba(16,185,129,.1);
        border-color: rgba(74,222,128,.2);
        color: rgba(255,255,255,.85);
    }

    .error-alert{
        background: rgba(239,68,68,.1);
        border-color: rgba(248,113,113,.2);
        color: rgba(255,255,255,.85);
    }

    .success-alert-icon,
    .error-alert-icon{
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .success-alert-icon{
        background: rgba(16,185,129,.15);
        color: #4ade80;
    }

    .error-alert-icon{
        background: rgba(239,68,68,.15);
        color: #f87171;
    }

    /* CARD */

    .premium-card{
        background: rgba(255,255,255,.05);
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 18px 45px rgba(0,0,0,.2);
        padding: 2rem;
    }

    .card-header-premium{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .card-header-premium h2{
        font-size: 1.5rem;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        margin-bottom: .5rem;
    }

    .card-header-premium p{
        color: rgba(255,255,255,.45);
        margin: 0;
    }

    .header-chip{
        padding: .8rem 1rem;
        border-radius: 16px;
        background: rgba(79,70,229,.15);
        color: #a5b4fc;
        border: 1px solid rgba(165,180,252,.2);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    /* FORM */

    .form-label-custom{
        font-weight: 700;
        margin-bottom: .8rem;
        color: rgba(255,255,255,.75);
        display: block;
    }

    .input-group-premium{
        position: relative;
    }

    .input-icon{
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,.4);
        z-index: 5;
    }

    .input-icon.success{
        color: #4ade80;
    }

    .premium-input{
        height: 58px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,.12);
        padding-left: 3.2rem;
        font-weight: 600;
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.9);
        transition: .25s ease;
    }

    .premium-input::placeholder{ color: rgba(255,255,255,.3); }

    .premium-input:focus,
    .premium-textarea:focus{
        border-color: rgba(212,175,55,.5);
        box-shadow: 0 0 0 4px rgba(212,175,55,.08);
        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.9);
        outline: none;
    }

    .premium-textarea{
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,.12);
        padding: 1rem 1.2rem;
        resize: none;
        line-height: 1.8;
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.9);
    }

    .premium-textarea::placeholder{ color: rgba(255,255,255,.3); }

    /* BUTTONS */

    .btn-create-policy,
    .btn-update-policy{
        border: none;
        border-radius: 18px;
        font-weight: 700;
        color: white;
        transition: .3s ease;
        display: inline-flex;
        align-items: center;
        gap: .7rem;
    }

    .btn-create-policy{
        height: 58px;
        padding: 0 1.7rem;
        background: linear-gradient(135deg, #10b981, #059669);
        box-shadow: 0 18px 35px rgba(16,185,129,.22);
    }

    .btn-update-policy{
        height: 52px;
        padding: 0 1.4rem;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        box-shadow: 0 15px 30px rgba(79,70,229,.2);
    }

    .btn-create-policy:hover,
    .btn-update-policy:hover{
        transform: translateY(-2px);
    }

    /* POLICY CARD */

    .policy-card-header{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .policy-title-wrapper{
        display: flex;
        gap: 1rem;
    }

    .policy-icon{
        width: 68px;
        height: 68px;
        border-radius: 22px;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        box-shadow: 0 15px 30px rgba(79,70,229,.2);
    }

    .policy-title-wrapper h3{
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: .5rem;
        color: rgba(255,255,255,.9);
    }

    .policy-title-wrapper p{
        color: rgba(255,255,255,.4);
        margin: 0;
    }

    .refund-badge{
        min-width: 90px;
        height: 44px;
        padding: 0 1rem;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .refund-badge.primary{
        background: rgba(79,70,229,.15);
        color: #a5b4fc;
        border: 1px solid rgba(165,180,252,.2);
    }

    .refund-badge.success{
        background: rgba(16,185,129,.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,.2);
    }

    .refund-badge.danger{
        background: rgba(239,68,68,.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,.2);
    }

    .policy-footer{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .policy-status{
        display: flex;
        align-items: center;
        gap: .6rem;
        color: rgba(255,255,255,.5);
        font-weight: 600;
    }

    .status-dot{
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #10b981;
    }

    /* EMPTY */

    .empty-state{
        background: rgba(255,255,255,.04);
        border-radius: 32px;
        padding: 5rem 2rem;
        text-align: center;
        border: 1px solid rgba(255,255,255,.08);
    }

    .empty-icon{
        width: 110px;
        height: 110px;
        border-radius: 30px;
        background: rgba(79,70,229,.12);
        color: #a5b4fc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 2rem;
    }

    .empty-state h3{
        font-weight: 800;
        margin-bottom: 1rem;
        color: rgba(255,255,255,.9);
    }

    .empty-state p{
        color: rgba(255,255,255,.45);
        max-width: 500px;
        margin: auto;
    }

    /* MOBILE */

    @media(max-width: 992px){

        .policy-hero h1{
            font-size: 1.8rem;
        }

        .premium-card{
            padding: 1.4rem;
        }

        .policy-card-header{
            flex-direction: column;
        }

    }

</style>

@endsection
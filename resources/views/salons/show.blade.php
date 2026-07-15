@extends('layouts.employee')

@section('title', $salon->name)

@section('content')

{{-- GOOGLE FONT --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

{{-- FONT AWESOME --}}
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

:root{
    --primary:#d4af37;
    --primary-dark:#b89022;
    --dark:#0f172a;
    --dark-2:#111827;
    --gray:#64748b;
    --light:#f8fafc;
    --white:#ffffff;
    --border:#e2e8f0;
}

body{
    background:var(--light);
    font-family:'Inter',sans-serif;
}

/* =========================
   BACK LINK
========================= */

.back-link{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--primary);
    font-weight:600;
    font-size:.95rem;
    text-decoration:none;
    margin-bottom:30px;
    transition:.3s ease;
}

.back-link:hover{
    color:var(--primary-dark);
    gap:14px;
}

.back-link i{
    font-size:.85rem;
}

/* =========================
   HERO
========================= */

.salon-hero{
    position:relative;
    overflow:hidden;
    border-radius:35px;
    padding:0;
    margin-bottom:50px;
    min-height:440px;
    display:flex;
    align-items:flex-end;
}

.salon-hero-bg{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
}

.salon-hero-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(
        0deg,
        rgba(15,23,42,.96) 0%,
        rgba(15,23,42,.65) 55%,
        rgba(15,23,42,.25) 100%
    );
}

.salon-hero::before{
    content:'';
    position:absolute;
    width:380px;
    height:380px;
    border-radius:50%;
    background:rgba(212,175,55,.1);
    top:-150px;
    right:-100px;
    z-index:1;
}

.hero-content{
    position:relative;
    z-index:2;
    padding:50px 60px;
    width:100%;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    padding:12px 22px;
    border-radius:999px;
    color:#fff;
    font-weight:600;
    margin-bottom:20px;
    backdrop-filter:blur(10px);
}

.hero-badge i{
    color:var(--primary);
}

.hero-title{
    font-family:'Playfair Display',serif;
    color:#fff;
    font-size:clamp(2.4rem,4.5vw,4.2rem);
    font-weight:700;
    line-height:1.1;
    margin-bottom:18px;
}

.hero-title span{
    color:var(--primary);
}

.hero-meta{
    display:flex;
    flex-wrap:wrap;
    gap:24px;
}

.hero-meta-item{
    display:flex;
    align-items:center;
    gap:9px;
    color:rgba(255,255,255,.75);
    font-size:.95rem;
}

.hero-meta-item i{
    color:var(--primary);
    font-size:.9rem;
}

/* =========================
   SECTION
========================= */

.section-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:35px;
}

.section-label{
    color:var(--primary);
    font-size:.85rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.15em;
    margin-bottom:10px;
}

.section-title{
    font-size:2.2rem;
    font-weight:800;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
}

/* =========================
   INFO CARDS
========================= */

.info-card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:28px;
    padding:30px;
    display:flex;
    align-items:flex-start;
    gap:18px;
    transition:.35s ease;
    height:100%;
}

.info-card:hover{
    border-color:rgba(212,175,55,.3);
    background:rgba(255,255,255,.09);
    transform:translateY(-4px);
    box-shadow:0 20px 40px rgba(0,0,0,.2);
}

.info-icon{
    width:52px;
    height:52px;
    border-radius:18px;
    background:rgba(212,175,55,.12);
    display:grid;
    place-items:center;
    color:var(--primary);
    font-size:1.15rem;
    flex-shrink:0;
}

.info-label{
    font-size:.8rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.1em;
    color:rgba(255,255,255,.4);
    margin-bottom:6px;
}

.info-value{
    font-size:1rem;
    font-weight:600;
    color:#fff;
}

/* =========================
   SERVICE CARD
========================= */

.service-card{
    position:relative;
    overflow:hidden;
    border-radius:28px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    box-shadow:0 10px 30px rgba(0,0,0,.18);
    transition:.4s ease;
    height:100%;
    display:flex;
    flex-direction:column;
}

.service-card:hover{
    transform:translateY(-8px);
    box-shadow:0 28px 55px rgba(0,0,0,.32);
    border-color:rgba(212,175,55,.28);
}

.service-emoji{
    font-size:2.6rem;
    line-height:1;
    margin-bottom:18px;
}

.service-body{
    padding:28px;
    flex:1;
    display:flex;
    flex-direction:column;
}

.service-name{
    font-size:1.2rem;
    font-weight:800;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
    margin-bottom:10px;
}

.service-desc{
    color:rgba(255,255,255,.55) !important;
    line-height:1.8;
    font-size:.92rem;
    flex:1;
    margin-bottom:22px;
}

.service-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.service-price{
    font-size:1.35rem;
    font-weight:800;
    color:var(--primary);
}

.service-duration{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:rgba(255,255,255,.5);
    font-size:.85rem;
    font-weight:600;
}

.service-duration i{
    color:var(--primary);
}

.service-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    padding:11px 20px;
    border-radius:999px;
    background:linear-gradient(135deg, var(--primary), #f5d06f);
    color:#111827;
    font-weight:700;
    font-size:.88rem;
    transition:.35s ease;
    box-shadow:0 10px 25px rgba(212,175,55,.2);
    margin-top:14px;
}

.service-btn:hover{
    transform:translateX(4px);
    color:#111827;
    box-shadow:0 18px 35px rgba(212,175,55,.3);
}

/* =========================
   EMPTY STATE
========================= */

.empty-state{
    background:rgba(255,255,255,.04);
    border-radius:35px;
    padding:70px 30px;
    text-align:center;
    border:1px solid rgba(255,255,255,.09);
}

.empty-icon{
    width:80px;
    height:80px;
    margin:0 auto 22px;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:rgba(212,175,55,.12);
    color:var(--primary);
    font-size:1.8rem;
}

.empty-state h3{
    font-size:1.7rem;
    font-weight:800;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
    margin-bottom:10px;
}

.empty-state p{
    color:rgba(255,255,255,.5) !important;
    max-width:480px;
    margin:auto;
    line-height:1.8;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:992px){
    .hero-content{ padding:40px 35px; }
    .section-title{ font-size:1.9rem; }
}

@media(max-width:768px){
    .salon-hero{ min-height:360px; border-radius:28px; }
    .hero-content{ padding:32px 24px; }
    .hero-title{ font-size:2.2rem; }
    .info-card{ padding:22px; }
    .service-body{ padding:22px; }
}

</style>

{{-- BACK --}}
<a href="{{ route('salons.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i>
    {{ __('messages.salons_back') }}
</a>

{{-- HERO --}}
<section class="salon-hero">

    <img
        src="{{ $salon->logo_url }}"
        alt="{{ $salon->name }}"
        class="salon-hero-bg"
    >

    <div class="salon-hero-overlay"></div>

    <div class="hero-content">

        <div class="hero-badge">
            <i class="fa-solid fa-crown"></i>
            {{ __('messages.salons_premium_badge') }}
        </div>

        <h1 class="hero-title">
            {{ $salon->name }}
        </h1>

        <div class="hero-meta">

            @if($salon->city)
                <div class="hero-meta-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ $salon->city }}</span>
                </div>
            @endif

            @if($salon->phone)
                <div class="hero-meta-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>{{ $salon->phone }}</span>
                </div>
            @endif

            <div class="hero-meta-item">
                <i class="fa-solid fa-scissors"></i>
                <span>{{ $salon->services->count() }} service{{ $salon->services->count() > 1 ? 's' : '' }}</span>
            </div>

        </div>

    </div>

</section>

{{-- INFO CARDS --}}
@if($salon->description || $salon->address || $salon->phone || $salon->email)

    <div class="section-header">
        <div>
            <div class="section-label">{{ __('messages.salons_about_label') }}</div>
            <h2 class="section-title">{{ __('messages.salons_info_title') }}</h2>
        </div>
    </div>

    <div class="row g-4 mb-5">

        @if($salon->description)
            <div class="col-12">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <div class="info-label">{{ __('messages.salons_info_description') }}</div>
                        <div class="info-value" style="font-weight:400;line-height:1.8;color:rgba(255,255,255,.75)">
                            {{ $salon->description }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($salon->address)
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div class="info-label">{{ __('messages.salons_info_address') }}</div>
                        <div class="info-value">{{ $salon->address }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if($salon->city)
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa-solid fa-city"></i>
                    </div>
                    <div>
                        <div class="info-label">{{ __('messages.salons_info_city') }}</div>
                        <div class="info-value">{{ $salon->city }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if($salon->phone)
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div class="info-label">{{ __('messages.salons_info_phone') }}</div>
                        <div class="info-value">{{ $salon->phone }}</div>
                    </div>
                </div>
            </div>
        @endif

        @if($salon->email)
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div class="info-label">{{ __('messages.salons_info_email') }}</div>
                        <div class="info-value">{{ $salon->email }}</div>
                    </div>
                </div>
            </div>
        @endif

    </div>

@endif

{{-- SERVICES --}}
<div class="section-header">
    <div>
        <div class="section-label">{{ __('messages.salons_services_label') }}</div>
        <h2 class="section-title">{{ __('messages.salons_services_title') }}</h2>
    </div>
</div>

<div class="row g-4">

    @forelse($salon->services as $service)

        <div class="col-xl-4 col-md-6">

            <div class="service-card">

                <div class="service-body">

                    @if($service->emoji)
                        <div class="service-emoji">{{ $service->emoji }}</div>
                    @endif

                    <h3 class="service-name">{{ $service->name }}</h3>

                    @if($service->description)
                        <p class="service-desc">
                            {{ Str::limit($service->description, 100) }}
                        </p>
                    @endif

                    <div class="service-footer">

                        <div>
                            <div class="service-price">
                                {{ number_format($service->price, 2) }}
                            </div>
                            <div class="service-duration">
                                <i class="fa-regular fa-clock"></i>
                                {{ $service->duration }} min
                            </div>
                        </div>

                    </div>

                    <a
                        href="{{ route('services.show', $service) }}"
                        class="service-btn"
                    >
                        {{ __('messages.salons_book_btn') }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-scissors"></i>
                </div>

                <h3>{{ __('messages.salons_no_services') }}</h3>

                <p>
                    {{ __('messages.salons_no_services_text') }}
                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection

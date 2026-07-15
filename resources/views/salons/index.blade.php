@extends('layouts.employee')

@section('title', 'Salons')

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

/* =========================
   PAGE
========================= */

body{
    background:var(--light);
    font-family:'Inter',sans-serif;
}

/* =========================
   HERO
========================= */

.salon-hero{
    position:relative;
    overflow:hidden;
    border-radius:35px;
    padding:80px 60px;
    background:
        linear-gradient(
            135deg,
            rgba(15,23,42,.94),
            rgba(17,24,39,.92)
        ),
        url('/images/gallery-hero.jpg') center/cover no-repeat;
    margin-bottom:50px;
}

.salon-hero::before{
    content:'';
    position:absolute;
    width:420px;
    height:420px;
    border-radius:50%;
    background:rgba(212,175,55,.12);
    top:-180px;
    right:-120px;
}

.salon-hero::after{
    content:'';
    position:absolute;
    width:280px;
    height:280px;
    border-radius:50%;
    background:rgba(255,255,255,.04);
    bottom:-100px;
    left:-80px;
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:760px;
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
    margin-bottom:28px;
    backdrop-filter:blur(10px);
}

.hero-title{
    font-family:'Playfair Display',serif;
    color:#fff;
    font-size:clamp(2.7rem,5vw,5rem);
    font-weight:700;
    line-height:1.1;
    margin-bottom:24px;
}

.hero-title span{
    color:var(--primary);
}

.hero-text{
    color:rgba(255,255,255,.74);
    font-size:1.05rem;
    line-height:1.9;
    max-width:650px;
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
   CARD
========================= */

.salon-card{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    box-shadow:
        0 10px 30px rgba(0,0,0,.2);
    transition:.4s ease;
    height:100%;
}

.salon-card:hover{
    transform:translateY(-10px);
    box-shadow:
        0 30px 60px rgba(0,0,0,.35);
    border-color:rgba(212,175,55,.3);
}

.salon-image-wrap{
    position:relative;
    overflow:hidden;
}

.salon-image{
    width:100%;
    height:320px;
    object-fit:cover;
    transition:transform .7s ease;
}

.salon-card:hover .salon-image{
    transform:scale(1.08);
}

.salon-badge{
    position:absolute;
    top:20px;
    left:20px;
    z-index:5;
    background:rgba(15,23,42,.8);
    color:#fff;
    padding:10px 18px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:700;
    backdrop-filter:blur(10px);
}

.salon-body{
    padding:30px;
}

.salon-name{
    font-size:1.45rem;
    font-weight:800;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
    margin-bottom:14px;
}

.salon-desc{
    color:rgba(255,255,255,.6) !important;
    line-height:1.9;
    margin-bottom:24px;
    min-height:72px;
}

.salon-info{
    display:flex;
    flex-direction:column;
    gap:14px;
    margin-bottom:28px;
}

.info-item{
    display:flex;
    align-items:flex-start;
    gap:12px;
    color:rgba(255,255,255,.55) !important;
    font-size:.95rem;
}

.info-item i{
    width:18px;
    color:var(--primary);
    margin-top:3px;
}

/* =========================
   BUTTON
========================= */

.salon-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
    padding:15px 26px;
    border-radius:999px;
    background:linear-gradient(
        135deg,
        var(--primary),
        #f5d06f
    );
    color:#111827;
    font-weight:700;
    transition:.35s ease;
    box-shadow:
        0 14px 30px rgba(212,175,55,.2);
}

.salon-btn:hover{
    transform:translateX(5px);
    color:#111827;
    box-shadow:
        0 20px 40px rgba(212,175,55,.3);
}

/* =========================
   EMPTY STATE
========================= */

.empty-state{
    background:rgba(255,255,255,.04);
    border-radius:35px;
    padding:80px 30px;
    text-align:center;
    border:1px solid rgba(255,255,255,.09);
    box-shadow:0 15px 40px rgba(0,0,0,.2);
}

.empty-icon{
    width:90px;
    height:90px;
    margin:auto;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:rgba(212,175,55,.12);
    color:var(--primary);
    font-size:2rem;
    margin-bottom:24px;
}

.empty-state h3{
    font-size:2rem;
    font-weight:800;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
    margin-bottom:12px;
}

.empty-state p{
    color:rgba(255,255,255,.55) !important;
    max-width:520px;
    margin:auto;
    line-height:1.8;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:992px){

    .salon-hero{
        padding:60px 35px;
    }

    .section-title{
        font-size:1.9rem;
    }

}

@media(max-width:768px){

    .salon-hero{
        padding:50px 25px;
        border-radius:28px;
    }

    .hero-title{
        font-size:2.5rem;
    }

    .salon-image{
        height:280px;
    }

    .salon-body{
        padding:24px;
    }

}

</style>

{{-- HERO --}}
<section class="salon-hero">

    <div class="hero-content">

        <div class="hero-badge">
            <i class="fa-solid fa-crown"></i>
            {{ __('messages.salons_hero_badge') }}
        </div>

        <h1 class="hero-title">
            {!! __('messages.salons_hero_title') !!}
        </h1>

        <p class="hero-text">
            {{ __('messages.salons_hero_text') }}
        </p>

    </div>

</section>

{{-- SECTION HEADER --}}
<div class="section-header">

    <div>

        <div class="section-label">
            {{ __('messages.salons_section_label') }}
        </div>

        <h2 class="section-title">
            {{ __('messages.salons_section_title') }}
        </h2>

    </div>

</div>

{{-- SALONS --}}
<div class="row g-4">

    @forelse($salons as $salon)

        <div class="col-xl-4 col-md-6">

            <div class="salon-card">

                <div class="salon-image-wrap">

                    <div class="salon-badge">
                        {{ __('messages.salons_card_badge') }}
                    </div>

                    <img
                        src="{{ $salon->logo_url }}"
                        alt="{{ $salon->name }}"
                        class="salon-image"
                    >

                </div>

                <div class="salon-body">

                    <h3 class="salon-name">
                        {{ $salon->name }}
                    </h3>

                    <p class="salon-desc">
                        {{ Str::limit($salon->description, 110) }}
                    </p>

                    <div class="salon-info">

                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $salon->address ?? '—' }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fa-solid fa-phone"></i>
                            <span>{{ $salon->phone ?? '—' }}</span>
                        </div>

                    </div>

                    <a
                        href="{{ route('salons.show', $salon) }}"
                        class="salon-btn"
                    >
                        {{ __('messages.salons_card_btn') }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-shop"></i>
                </div>

                <h3>
                    {{ __('messages.salons_empty_title') }}
                </h3>

                <p>
                    {{ __('messages.salons_empty_text') }}
                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection
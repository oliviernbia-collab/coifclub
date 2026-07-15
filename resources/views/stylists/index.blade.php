@extends('layouts.app')

@section('title', 'Notre Équipe')

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-lt:#ff6ab4;
    --dark:rgba(255,255,255,.9);
    --gray:rgba(255,255,255,.5);
    --border:rgba(255,255,255,.09);
}

body { background: #0e0a1c; color: rgba(255,255,255,.85); }

/* HERO */
.team-hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    padding:6rem 3.5rem;
    margin-bottom:5rem;
    background: linear-gradient(135deg, #1a1230 0%, #2d1060 45%, #3b0f6a 70%, #4a1080 100%);
    box-shadow:0 24px 60px rgba(26,18,48,.3);
}

.team-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        radial-gradient(ellipse 60% 50% at 30% 0%, rgba(233,30,140,.18), transparent),
        radial-gradient(ellipse 40% 40% at 80% 90%, rgba(233,30,140,.1), transparent);
    pointer-events:none;
}

.team-hero::after{
    content:'';
    position:absolute;
    bottom:0; left:0; right:0;
    height:3px;
    background:linear-gradient(90deg, transparent, #e91e8c, transparent);
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:680px;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:.6rem;
    padding:.65rem 1.25rem;
    border-radius:999px;
    background:rgba(233,30,140,.12);
    border:1px solid rgba(233,30,140,.28);
    color:#ff6ab4;
    backdrop-filter:blur(10px);
    font-size:.85rem;
    font-weight:700;
    letter-spacing:.04em;
    text-transform:uppercase;
    margin-bottom:1.6rem;
}

.hero-title{
    font-size:3.4rem;
    font-weight:900;
    color:white;
    line-height:1.1;
    margin-bottom:1.1rem;
    letter-spacing:-.01em;
}

.hero-title span{
    background:linear-gradient(135deg, #e91e8c, #ff6ab4);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

.hero-text{
    color:rgba(255,255,255,.72);
    font-size:1.05rem;
    line-height:1.85;
    max-width:560px;
}

.hero-stats{
    display:flex;
    gap:2.5rem;
    margin-top:2.4rem;
}

.hero-stat-val{
    font-size:2rem;
    font-weight:900;
    color:#ff6ab4;
    line-height:1;
}

.hero-stat-lbl{
    font-size:.78rem;
    color:rgba(255,255,255,.45);
    margin-top:.25rem;
    letter-spacing:.06em;
    text-transform:uppercase;
}

/* SECTION HEADER */
.section-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:1rem;
    margin-bottom:3rem;
    flex-wrap:wrap;
}

.section-label{
    display:inline-flex;
    align-items:center;
    gap:.5rem;
    font-size:.75rem;
    font-weight:800;
    letter-spacing:.12em;
    text-transform:uppercase;
    color:#e91e8c;
    margin-bottom:.6rem;
}

.section-title{
    font-size:2.1rem;
    font-weight:900;
    color:var(--dark);
    margin-bottom:.35rem;
    letter-spacing:-.01em;
}

.section-subtitle{
    color:var(--gray);
    font-size:.95rem;
    margin:0;
}

/* TEAM GRID */
.team-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(290px,1fr));
    gap:28px;
}

/* TEAM CARD */
.team-card{
    position:relative;
    border-radius:28px;
    overflow:hidden;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.09);
    box-shadow:0 4px 6px rgba(0,0,0,.15), 0 12px 32px rgba(0,0,0,.2);
    transition:transform .4s cubic-bezier(.2,0,.2,1), box-shadow .4s ease, border-color .4s ease;
    display:flex;
    flex-direction:column;
}

.team-card:hover{
    transform:translateY(-12px);
    border-color:rgba(233,30,140,.3);
    box-shadow:0 20px 50px rgba(233,30,140,.1), 0 0 0 1px rgba(233,30,140,.08);
}

.team-image-wrapper{
    position:relative;
    height:300px;
    overflow:hidden;
    flex-shrink:0;
}

.team-image{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:top;
    transition:transform .7s cubic-bezier(.2,0,.2,1);
    display:block;
}

.team-card:hover .team-image{ transform:scale(1.07); }

.team-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top, rgba(26,18,48,.75) 0%, rgba(26,18,48,.2) 45%, transparent 100%);
}

.team-badge{
    position:absolute;
    top:16px;
    right:16px;
    background:linear-gradient(135deg, #e91e8c, #c0156d);
    color:#fff;
    padding:.45rem .95rem;
    border-radius:999px;
    font-size:.72rem;
    font-weight:800;
    letter-spacing:.04em;
    text-transform:uppercase;
    box-shadow:0 6px 20px rgba(233,30,140,.35);
}

.team-image-footer{
    position:absolute;
    bottom:0; left:0; right:0;
    padding:1.4rem 1.5rem 1.2rem;
}

.team-name-overlay{
    font-size:1.3rem;
    font-weight:900;
    color:white;
    letter-spacing:-.01em;
    line-height:1.15;
    margin-bottom:.25rem;
    text-shadow:0 2px 8px rgba(0,0,0,.4);
}

.team-role-overlay{
    font-size:.8rem;
    color:#ff6ab4;
    font-weight:600;
    letter-spacing:.04em;
}

/* Content */
.team-content{
    padding:1.5rem 1.6rem 1.6rem;
    display:flex;
    flex-direction:column;
    flex:1;
}

/* Stats row */
.team-stats-row{
    display:flex;
    gap:0;
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.09);
    margin-bottom:1.3rem;
    background:rgba(255,255,255,.05);
}

.team-stat{
    flex:1;
    padding:.75rem .5rem;
    text-align:center;
    border-right:1px solid var(--border);
}

.team-stat:last-child{ border-right:none; }

.team-stat-val{
    font-size:1.1rem;
    font-weight:900;
    color:var(--dark);
    line-height:1;
}

.team-stat-lbl{
    font-size:.65rem;
    color:var(--gray);
    font-weight:600;
    letter-spacing:.05em;
    text-transform:uppercase;
    margin-top:.2rem;
}

/* Tags */
.team-tags{
    display:flex;
    flex-wrap:wrap;
    gap:.4rem;
    margin-bottom:1.3rem;
}

.team-tag{
    font-size:.72rem;
    font-weight:700;
    padding:.3rem .75rem;
    border-radius:999px;
    background:rgba(233,30,140,.08);
    color:#c0156d;
    border:1px solid rgba(233,30,140,.2);
    letter-spacing:.02em;
}

/* Button */
.team-btn{
    margin-top:auto;
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:.55rem;
    text-decoration:none;
    border:none;
    border-radius:16px;
    padding:.9rem 1rem;
    font-size:.9rem;
    font-weight:800;
    background:linear-gradient(135deg, #e91e8c 0%, #c0156d 100%);
    color:#fff;
    transition:.3s ease;
    box-shadow:0 8px 22px rgba(233,30,140,.22);
    letter-spacing:.02em;
}

.team-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 30px rgba(233,30,140,.38);
    color:#fff;
}

/* EMPTY STATE */
.empty-box{
    background:rgba(255,255,255,.05);
    border-radius:30px;
    padding:5rem 2rem;
    text-align:center;
    box-shadow:0 8px 32px rgba(0,0,0,.2);
    border:1px solid rgba(255,255,255,.09);
    grid-column:1/-1;
}

.empty-icon{
    font-size:5rem;
    color:#e91e8c;
    margin-bottom:1.5rem;
}

.empty-title{
    font-size:1.7rem;
    font-weight:900;
    color:var(--dark);
    margin-bottom:.7rem;
}

.empty-text{ color:var(--gray); }


/* ===============================
   HERO IMAGE RIGHT - PREMIUM UI
================================== */

.team-hero{
    position: relative;
    display: grid;
    grid-template-columns: 1fr 520px;
    align-items: center;
    gap: 60px;
    padding: 70px 6%;
    overflow: hidden;
}

/* ===== IMAGE SIDE ===== */
.cp-hero-right{
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Cadre premium */
.cp-hero-right::before{
    content: "";
    position: absolute;
    inset: -18px;
    border-radius: 38px;
    background:
        linear-gradient(135deg,
            rgba(212,175,55,0.25),
            rgba(255,255,255,0.08),
            rgba(212,175,55,0.18));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(212,175,55,0.35);
    box-shadow:
        0 20px 60px rgba(0,0,0,0.12),
        0 0 35px rgba(212,175,55,0.15);
    z-index: 0;
}

/* Effet lumineux */
.cp-hero-right::after{
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    top: -50px;
    right: -40px;
    background: radial-gradient(circle,
        rgba(212,175,55,0.35),
        transparent 70%);
    z-index: 0;
    filter: blur(10px);
}

/* Image */
.cp-hero-right img{
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 500px;
    height: 620px;
    object-fit: cover;

    border-radius: 32px;

    border: 4px solid rgba(255,255,255,0.85);

    box-shadow:
        0 25px 70px rgba(0,0,0,0.18),
        0 10px 30px rgba(212,175,55,0.18);

    transition:
        transform .6s ease,
        box-shadow .6s ease,
        filter .6s ease;

    background: #fff;
}

/* Hover premium */
.cp-hero-right:hover img{
    transform: translateY(-10px) scale(1.02);
    filter: brightness(1.04);
    box-shadow:
        0 35px 90px rgba(0,0,0,0.22),
        0 15px 40px rgba(212,175,55,0.28);
}

/* Overlay dégradé */
.cp-hero-right .image-overlay{
    position: absolute;
    inset: 0;
    border-radius: 32px;
    background: linear-gradient(
        to top,
        rgba(0,0,0,0.35),
        transparent 45%
    );
    z-index: 1;
}

/* Responsive */
@media (max-width: 992px){

    .team-hero{
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }

    .cp-hero-right{
        order: -1;
    }

    .cp-hero-right img{
        max-width: 100%;
        height: 500px;
    }
}

@media (max-width: 576px){

    .team-hero{
        padding: 50px 20px;
    }

    .cp-hero-right::before{
        inset: -10px;
        border-radius: 24px;
    }

    .cp-hero-right img{
        height: 380px;
        border-radius: 22px;
    }
}

/* RESPONSIVE */
@media(max-width:768px){
    .team-hero{ padding:3.5rem 1.75rem; border-radius:24px; }
    .hero-title{ font-size:2.4rem; }
    .hero-stats{ gap:1.6rem; }
    .section-header{ flex-direction:column; align-items:flex-start; }
    .team-grid{ grid-template-columns:1fr; max-width:400px; margin:0 auto; }
}

@media(max-width:480px){
    .hero-title{ font-size:2rem; }
    .team-grid{ max-width:100%; }
}
</style>

<div class="container py-5">
    

    <!-- HERO -->
    <div class="team-hero">

        {{-- Texte gauche --}}
        <div class="hero-content">

            <div class="hero-badge">
                <i class="ti ti-crown"></i>
                {{ __('messages.team_hero_badge') }}
            </div>

            <h1 class="hero-title">
                {{ __('messages.team_hero_title_part1') }} <span>{{ __('messages.team_hero_title_highlight') }}</span>
            </h1>

            <p class="hero-text">
                {{ __('messages.team_hero_text') }}
            </p>

            <div class="hero-stats">
                <div>
                    <div class="hero-stat-val">{{ $team->count() }}+</div>
                    <div class="hero-stat-lbl">{{ __('messages.team_section_title') }}</div>
                </div>
                <div>
                    <div class="hero-stat-val">5★</div>
                    <div class="hero-stat-lbl">{{ __('messages.team_certified_professional') }}</div>
                </div>
            </div>

        </div>

        {{-- Image droite --}}
        <div class="cp-hero-right">
            <div class="image-overlay"></div>
            <img src="{{ asset('images/C34.jpg') }}" alt="{{ __('messages.team_hero_badge') }}">
        </div>

    </div>

    <!-- HEADER -->
    <div class="section-header">

        <div>
            <div class="section-label">
                <i class="ti ti-users"></i>
                {{ __('messages.team_hero_badge') }}
            </div>
            <h2 class="section-title">
                {{ __('messages.team_section_title') }}
            </h2>
            <p class="section-subtitle">
                {{ __('messages.team_section_subtitle') }}
            </p>
        </div>

    </div>

    <!-- TEAM -->
    <div class="team-grid">

        @forelse($team as $member)

            <div class="team-card">

                <!-- IMAGE -->
                <div class="team-image-wrapper">

                    <img src="{{ $member->image_url }}"
                         alt="{{ $member->name }}"
                         class="team-image">

                    <div class="team-overlay"></div>

                    <div class="team-badge">
                        {{ __('messages.team_badge_expert') }}
                    </div>

                    <div class="team-image-footer">
                        <div class="team-name-overlay">
                            {{ $member->name ?? __('messages.team_default_employee') }}
                        </div>
                        <div class="team-role-overlay">
                            {{ $member->specialty ?? $member->role ?? __('messages.team_role_unknown') }}
                        </div>
                    </div>

                </div>

                <!-- CONTENT -->
                <div class="team-content">

                    <!-- STATS -->
                    <div class="team-stats-row">
                        <div class="team-stat">
                            <div class="team-stat-val">★ 5.0</div>
                            <div class="team-stat-lbl">Note</div>
                        </div>
                        <div class="team-stat">
                            <div class="team-stat-val">Pro</div>
                            <div class="team-stat-lbl">Statut</div>
                        </div>
                        <div class="team-stat">
                            <div class="team-stat-val">✓</div>
                            <div class="team-stat-lbl">Certifiée</div>
                        </div>
                    </div>

                    <!-- TAGS -->
                    <div class="team-tags">
                        <span class="team-tag"><i class="ti ti-scissors" style="font-size:.7rem;"></i> Expert</span>
                        <span class="team-tag">Premium</span>
                        <span class="team-tag">{{ __('messages.team_certified_professional') }}</span>
                    </div>

                    <!-- BUTTON -->
                    @php
                        $buttonRoute = auth()->check() && auth()->user()->role === 'admin' && optional($member->user)->id
                            ? route('admin.employees.edit', optional($member->user)->id)
                            : route('stylists.show', $member->id);
                    @endphp

                    <a href="{{ $buttonRoute }}" class="team-btn">
                        <i class="ti ti-user"></i>
                        {{ __('messages.team_view_profile') }}
                    </a>

                </div>

            </div>

        @empty

            <div class="empty-box">

                <div class="empty-icon">
                    <i class="ti ti-users"></i>
                </div>

                <h3 class="empty-title">
                    {{ __('messages.team_empty_title') }}
                </h3>

                <p class="empty-text">
                    {{ __('messages.team_empty_text') }}
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection

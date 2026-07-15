@extends('layouts.home')

@section('title', 'Marol Hair Braiding - Beautiful Braids. Made For You.')

@push('styles')
<style>
/* ══════════════════════════════════════════
   VARIABLES & RESET
══════════════════════════════════════════ */
:root {
    --hp-pink:       #e83e8c;
    --hp-pink-dark:  #c91a78;
    --hp-dark:       #1a1a2e;
    --hp-dark2:      #16213e;
}

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hp-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: #1a1a2e;
    overflow: hidden;
}
.hp-hero-bg {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: center top;
    opacity: .9;
}
.hp-hero-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to right,
        rgba(26,26,46,1)   0%,
        rgba(26,26,46,.95) 30%,
        rgba(26,26,46,.55) 55%,
        rgba(26,26,46,.05) 100%
    );
    z-index: 1;
}
.hp-hero-body {
    position: relative;
    z-index: 2;
    width: 100%;
    padding: 110px 0 80px;
}
.hp-tag {
    display: inline-block;
    color: var(--hp-pink);
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 18px;
    font-family: 'Inter', sans-serif;
}
.hp-hero-h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.6rem, 5vw, 4.5rem);
    font-weight: 900;
    color: #ffffff;
    line-height: 1.05;
    margin-bottom: 20px;
}
.hp-hero-h1 .hp-pink { color: var(--hp-pink); }
.hp-hero-p {
    color: rgba(255,255,255,.65);
    font-size: .98rem;
    max-width: 420px;
    margin-bottom: 36px;
    line-height: 1.8;
    font-family: 'Inter', sans-serif;
}
.hp-cta-row {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 52px;
}
.hp-btn-pink {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: var(--hp-pink);
    color: #fff;
    padding: 13px 26px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: .28s;
    box-shadow: 0 6px 22px rgba(232,62,140,.38);
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}
.hp-btn-pink:hover { background: var(--hp-pink-dark); transform: translateY(-2px); color: #fff; }
.hp-btn-dark {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: rgba(0,0,0,.55);
    color: #fff;
    padding: 13px 26px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: .28s;
    border: 2px solid rgba(255,255,255,.35);
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
    backdrop-filter: blur(4px);
}
.hp-btn-dark:hover { border-color: #fff; background: rgba(0,0,0,.7); color: #fff; }

.hp-badges {
    display: flex;
    gap: 28px;
    flex-wrap: wrap;
}
.hp-badge {
    display: flex;
    align-items: center;
    gap: 10px;
}
.hp-badge-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: rgba(232,62,140,.15);
    border: 1.5px solid rgba(232,62,140,.4);
    display: flex; align-items: center; justify-content: center;
    color: var(--hp-pink);
    font-size: 15px;
    flex-shrink: 0;
}
.hp-badge-text strong {
    display: block;
    color: #fff;
    font-size: 12.5px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    line-height: 1.2;
}
.hp-badge-text small {
    color: rgba(255,255,255,.42);
    font-size: 11px;
    font-family: 'Inter', sans-serif;
}

/* ══════════════════════════════════════════
   POPULAR BRAIDING STYLES  — redesign
══════════════════════════════════════════ */
.hp-styles {
    background: #0a0714;
    padding: 80px 0 60px;
}
.hp-styles-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 8px;
    gap: 12px;
}
.hp-styles-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--hp-pink);
    margin-bottom: 8px;
    font-family: 'Inter', sans-serif;
}
.hp-styles-head h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    line-height: 1.2;
}
.hp-styles-head h2 span { color: var(--hp-pink); font-style: italic; }
.hp-view-all {
    color: rgba(255,255,255,.7);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    font-family: 'Inter', sans-serif;
    border: 1.5px solid rgba(232,62,140,.35);
    background: rgba(255,255,255,.03);
    padding: 8px 16px;
    border-radius: 30px;
    transition: .22s;
    white-space: nowrap;
}
.hp-view-all:hover { color: var(--hp-pink); border-color: rgba(232,62,140,.7); background: rgba(232,62,140,.07); box-shadow: 0 0 14px rgba(232,62,140,.12); }
.hp-title-line {
    width: 44px; height: 3px;
    background: var(--hp-pink);
    border-radius: 2px;
    margin-bottom: 36px;
}

/* — Slider shell — */
.hp-slider-wrap {
    position: relative;
    padding: 0 2px;
}
.hp-slider {
    display: flex;
    gap: 18px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    padding: 10px 4px 28px;
    -webkit-overflow-scrolling: touch;
}
.hp-slider::-webkit-scrollbar { display: none; }

/* — Card — */
.hp-card {
    flex: 0 0 230px;
    border-radius: 18px;
    overflow: hidden;
    background: rgba(255,255,255,.03);
    scroll-snap-align: start;
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,.35);
    border: 2px solid rgba(232,62,140,.3);
    position: relative;
}
.hp-card:hover {
    transform: translateY(-8px);
    border-color: rgba(232,62,140,.65);
    box-shadow: 0 16px 44px rgba(0,0,0,.45), 0 0 28px rgba(232,62,140,.15);
}

/* image area */
.hp-card-img {
    position: relative;
    height: 270px;
    overflow: hidden;
    cursor: pointer;
}
.hp-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
    display: block;
    pointer-events: none;
}
.hp-card:hover .hp-card-img img { transform: scale(1.08); }

/* category badge */
.hp-card-cat {
    position: absolute;
    top: 10px; left: 10px;
    background: rgba(26,26,46,.75);
    backdrop-filter: blur(6px);
    color: rgba(255,255,255,.9);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 30px;
    font-family: 'Inter', sans-serif;
    border: 1px solid rgba(255,255,255,.15);
}

/* like button (top-right) */
.hp-heart {
    position: absolute;
    top: 10px; right: 10px;
    width: 34px; height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(4px);
    border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #ccc;
    font-size: 14px;
    transition: .22s;
    box-shadow: 0 2px 10px rgba(0,0,0,.12);
    flex-shrink: 0;
}
.hp-heart:hover { color: var(--hp-pink); transform: scale(1.15); }
.hp-heart.liked { color: var(--hp-pink); }
.hp-heart.liked i { font-weight: 900; }

/* gradient overlay on image */
.hp-card-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,26,46,.65) 0%, transparent 55%);
    pointer-events: none;
}

/* price tag bottom-left of image */
.hp-card-price-tag {
    position: absolute;
    bottom: 10px; left: 10px;
    background: var(--hp-pink);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 30px;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 3px 12px rgba(232,62,140,.4);
}

/* card body */
.hp-card-body { padding: 14px 16px 16px; }
.hp-card-body h4 {
    font-size: 14.5px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 5px;
    font-family: 'Inter', sans-serif;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hp-card-dur {
    font-size: 11.5px;
    color: rgba(255,255,255,.4);
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 12px;
}
.hp-card-dur i { color: var(--hp-pink); font-size: 11px; }

/* action row */
.hp-card-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}
.hp-card-book {
    flex: 1;
    background: var(--hp-pink);
    color: #fff;
    border: none;
    padding: 9px 0;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: .2s;
    display: block;
}
.hp-card-book:hover { background: var(--hp-pink-dark); color: #fff; }
.hp-card-share {
    width: 34px; height: 34px;
    border-radius: 10px;
    border: 1.5px solid rgba(232,62,140,.3);
    background: rgba(255,255,255,.04);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: rgba(255,255,255,.45);
    font-size: 13px;
    transition: .2s;
    flex-shrink: 0;
}
.hp-card-share:hover { border-color: rgba(232,62,140,.7); color: var(--hp-pink); background: rgba(232,62,140,.08); }

/* — Nav arrows — */
.hp-slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-70%);
    width: 42px; height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    border: 1.5px solid rgba(232,62,140,.35);
    box-shadow: 0 4px 16px rgba(0,0,0,.3);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 14px;
    color: rgba(255,255,255,.6);
    transition: .22s;
    z-index: 5;
}
.hp-slider-btn:hover { background: var(--hp-pink); color: #fff; border-color: var(--hp-pink); box-shadow: 0 8px 24px rgba(232,62,140,.4); }
.hp-slider-prev { left: -21px; }
.hp-slider-next { right: -21px; }

/* — Dots indicator — */
.hp-slider-dots {
    display: flex;
    justify-content: center;
    gap: 7px;
    margin-top: 20px;
}
.hp-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    border: none;
    cursor: pointer;
    padding: 0;
    transition: .25s;
}
.hp-dot.active {
    background: var(--hp-pink);
    width: 22px;
    border-radius: 4px;
}

/* — Toast notification — */
.hp-toast {
    position: fixed;
    bottom: 28px; left: 50%;
    transform: translateX(-50%) translateY(80px);
    background: #1a1a2e;
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    z-index: 9999;
    opacity: 0;
    transition: transform .35s ease, opacity .35s ease;
    white-space: nowrap;
    box-shadow: 0 8px 30px rgba(0,0,0,.3);
    pointer-events: none;
    display: flex;
    align-items: center;
    gap: 9px;
    border-left: 4px solid var(--hp-pink);
}
.hp-toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
.hp-toast.success { border-left-color: #22c55e; }
.hp-toast.error { border-left-color: #ef4444; }
.hp-toast.info { border-left-color: var(--hp-pink); }

/* ══════════════════════════════════════════
   ABOUT
══════════════════════════════════════════ */
.hp-about {
    background: #0c0918;
    padding: 64px 0;
}
.hp-about-inner {
    max-width: 1200px; margin: 0 auto;
    padding: 0 32px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 24px;
    align-items: start;
}

/* Cadres des colonnes texte */
.hp-about-col {
    background: rgba(255,255,255,.04);
    border: 2px solid rgba(232,62,140,.45);
    border-radius: 20px;
    padding: 30px 28px;
    box-shadow: 0 6px 32px rgba(0,0,0,.4), 0 0 0 1px rgba(232,62,140,.1), inset 0 1px 0 rgba(255,255,255,.04);
}
.hp-about-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 18px;
    line-height: 1.2;
}
.hp-about-title span { color: var(--hp-pink); }
.hp-about-desc {
    color: rgba(255,255,255,.6);
    font-size: 13.5px;
    line-height: 1.85;
    margin-bottom: 22px;
    font-family: 'Inter', sans-serif;
}
.hp-checklist {
    list-style: none;
    padding: 0;
    margin: 0 0 30px;
}
.hp-checklist li {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,.75);
    font-size: 13.5px;
    margin-bottom: 11px;
    font-family: 'Inter', sans-serif;
}
.hp-checklist li .hp-check-icon {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--hp-pink);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 11px;
    flex-shrink: 0;
}
.hp-btn-outline-pink {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 2px solid var(--hp-pink);
    color: var(--hp-pink);
    background: transparent;
    padding: 11px 22px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: .25s;
    font-family: 'Inter', sans-serif;
}
.hp-btn-outline-pink:hover { background: var(--hp-pink); color: #fff; }

/* Owner center */
.hp-owner-col { text-align: center; }
.hp-owner-col img {
    width: 220px;
    height: 260px;
    object-fit: cover;
    border-radius: 14px;
    box-shadow: 0 16px 50px rgba(0,0,0,.55);
    border: 2px solid rgba(232,62,140,.2);
}
.hp-owner-name {
    margin-top: 14px;
    color: var(--hp-pink);
    font-size: 14px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
}
.hp-owner-sub {
    color: rgba(255,255,255,.38);
    font-size: 12px;
    font-style: italic;
    font-family: 'Playfair Display', serif;
    margin-top: 3px;
}

/* Mission col */
.hp-mission-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--hp-pink);
    margin-bottom: 20px;
    line-height: 1.25;
}
.hp-mission-p {
    color: rgba(255,255,255,.6);
    font-size: 13.5px;
    line-height: 1.85;
    margin-bottom: 14px;
    font-family: 'Inter', sans-serif;
}
.hp-btn-pink-filled {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--hp-pink);
    color: #fff;
    padding: 12px 22px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: .25s;
    font-family: 'Inter', sans-serif;
    margin-top: 10px;
}
.hp-btn-pink-filled:hover { background: var(--hp-pink-dark); color: #fff; transform: translateY(-2px); }

/* ══════════════════════════════════════════
   FEATURES BAR
══════════════════════════════════════════ */
.hp-features {
    background: #0a0714;
    padding: 32px 0 40px;
    border-top: 1px solid rgba(232,62,140,.12);
}
.hp-features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    padding: 0 32px;
    max-width: 1200px; margin: 0 auto;
}
.hp-feature {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 16px;
    background: rgba(255,255,255,.03);
    border: 2px solid rgba(232,62,140,.3);
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,.3);
    transition: border-color .22s, box-shadow .22s;
}
.hp-feature:hover {
    border-color: rgba(232,62,140,.6);
    box-shadow: 0 6px 24px rgba(0,0,0,.4), 0 0 18px rgba(232,62,140,.12);
}
.hp-feature-icon {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1.5px solid rgba(232,62,140,.45);
    background: rgba(232,62,140,.08);
    display: flex; align-items: center; justify-content: center;
    color: var(--hp-pink);
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 0 14px rgba(232,62,140,.15);
}
.hp-feature-text strong {
    display: block;
    color: #fff;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    line-height: 1.2;
}
.hp-feature-text small {
    color: rgba(255,255,255,.36);
    font-size: 11.5px;
    font-family: 'Inter', sans-serif;
}

/* ══════════════════════════════════════════
   CONTACT INFO
══════════════════════════════════════════ */
.hp-contact {
    background: #0a0714;
    padding: 70px 0;
}
.hp-contact-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.hp-contact-box {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 24px 20px;
    background: rgba(255,255,255,.03);
    border-radius: 14px;
    border: 2px solid rgba(232,62,140,.32);
    box-shadow: 0 4px 20px rgba(0,0,0,.35);
    transition: .3s;
}
.hp-contact-box:hover { transform: translateY(-4px); border-color: rgba(232,62,140,.65); box-shadow: 0 10px 32px rgba(0,0,0,.45), 0 0 20px rgba(232,62,140,.12); }
.hp-contact-ico {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: rgba(232,62,140,.1);
    border: 1.5px solid rgba(232,62,140,.35);
    display: flex; align-items: center; justify-content: center;
    color: var(--hp-pink);
    font-size: 19px;
    flex-shrink: 0;
}
.hp-contact-box h5 {
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 7px;
    font-family: 'Inter', sans-serif;
}
.hp-contact-box p {
    font-size: 13px;
    color: rgba(255,255,255,.5);
    margin: 0 0 5px;
    line-height: 1.6;
    font-family: 'Inter', sans-serif;
}
.hp-contact-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: var(--hp-pink);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
    margin-top: 2px;
}
.hp-contact-link:hover { text-decoration: underline; }

/* ══════════════════════════════════════════
   SPACING BETWEEN SECTIONS
══════════════════════════════════════════ */
.hp-section-gap { height: 32px; background: #0a0714; }

/* ══════════════════════════════════════════
   RESPONSIVE  — tous breakpoints
══════════════════════════════════════════ */

/* ── ≤1100px tablet large ── */
@media (max-width: 1100px) {
    .hp-about-inner { padding: 0 28px; gap: 20px; }
    .hp-features-grid { padding: 0 28px; }
}

/* ── ≤991px tablet ── */
@media (max-width: 991px) {
    /* Hero — image stays visible, gradient adapts */
    .hp-hero-bg { opacity: .65; object-position: center center; }
    .hp-hero-gradient {
        background: linear-gradient(
            to bottom,
            rgba(26,26,46,.45) 0%,
            rgba(26,26,46,.7)  50%,
            rgba(26,26,46,.92) 100%
        ) !important;
    }
    .hp-hero-body { padding: 80px 0 56px; }
    .hp-hero-h1 { font-size: clamp(2rem, 5vw, 3rem); }
    .hp-hero-p { max-width: 100%; }
    .hp-badges { gap: 16px; flex-wrap: wrap; }

    /* About */
    .hp-about { padding: 44px 0 36px; }
    .hp-about-inner { grid-template-columns: 1fr; padding: 0 24px; gap: 20px; }
    .hp-about-col { padding: 22px 20px; }
    .hp-owner-col { order: -1; display: flex; align-items: center; gap: 22px; text-align: left; }
    .hp-owner-col img { width: 150px; height: 175px; }

    /* Features */
    .hp-features-grid { grid-template-columns: repeat(2, 1fr); padding: 0 24px; gap: 14px; }
    .hp-feature { padding: 14px 14px; }

    /* Contact */
    .hp-contact-grid { grid-template-columns: repeat(2, 1fr); }
}

/* ── ≤767px mobile ── */
@media (max-width: 767px) {
    /* Hero */
    .hp-hero { min-height: 90vh; }
    .hp-hero-bg { opacity: .55; object-position: 70% center; }
    .hp-hero-gradient {
        background: linear-gradient(
            to bottom,
            rgba(26,26,46,.3)  0%,
            rgba(26,26,46,.65) 45%,
            rgba(26,26,46,.95) 100%
        ) !important;
    }
    .hp-hero-body { padding: 80px 0 48px; }
    .hp-hero-h1 { font-size: 2.1rem; line-height: 1.1; }
    .hp-hero-p { font-size: .92rem; margin-bottom: 28px; }
    .hp-cta-row { flex-direction: column; gap: 10px; margin-bottom: 36px; }
    .hp-btn-pink, .hp-btn-dark { justify-content: center; width: 100%; max-width: 320px; padding: 14px 20px; font-size: 14px; }
    .hp-badges { gap: 14px; }
    .hp-badge-icon { width: 36px; height: 36px; font-size: 14px; }
    .hp-badge-text strong { font-size: 12px; }
    .hp-badge-text small { font-size: 10.5px; }

    /* Styles section */
    .hp-styles { padding: 48px 0 36px; }
    .hp-styles-head { flex-direction: column; align-items: flex-start; gap: 14px; }
    .hp-styles-head h2 { font-size: 1.65rem; }
    .hp-slider-btn { display: none; }
    .hp-card { flex: 0 0 180px; }
    .hp-card-img { height: 220px; }
    .hp-card-body { padding: 11px 13px 13px; }
    .hp-card-body h4 { font-size: 13px; }
    .hp-card-dur { font-size: 11px; }
    .hp-card-book { font-size: 11.5px; padding: 8px 0; }
    .hp-card-share { width: 30px; height: 30px; font-size: 12px; }
    .hp-slider-dots { margin-top: 14px; }

    /* About */
    .hp-about { padding: 36px 0; }
    .hp-about-inner { padding: 0 16px; gap: 16px; }
    .hp-about-col { padding: 18px 16px; border-radius: 16px; }
    .hp-about-title { font-size: 1.5rem; }
    .hp-about-desc { font-size: 13px; }
    .hp-checklist li { font-size: 13px; }
    .hp-owner-col { flex-direction: column; text-align: center; }
    .hp-owner-col img { width: 180px; height: 210px; }
    .hp-mission-title { font-size: 1.35rem; }
    .hp-mission-p { font-size: 13px; }

    /* Features */
    .hp-features-grid { grid-template-columns: repeat(2, 1fr); padding: 0 16px; gap: 10px; }
    .hp-feature { padding: 12px 12px; }
    .hp-feature-icon { width: 38px; height: 38px; font-size: 16px; }
    .hp-feature-text strong { font-size: 12.5px; }
    .hp-feature-text small { font-size: 11px; }

    /* Contact */
    .hp-contact { padding: 44px 0; }
    .hp-contact-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
    .hp-contact-box { padding: 18px 14px; gap: 12px; }
    .hp-contact-ico { width: 40px; height: 40px; font-size: 16px; }
    .hp-contact-box h5 { font-size: 13px; }
    .hp-contact-box p { font-size: 12px; }
    .hp-contact-link { font-size: 12px; }

    /* Gap */
    .hp-section-gap { height: 20px; }
}

/* ── ≤480px small mobile ── */
@media (max-width: 480px) {
    .hp-hero { min-height: 85vh; }
    .hp-hero-bg { object-position: center center; opacity: .5; }
    .hp-hero-body { padding: 70px 0 40px; }
    .hp-hero-h1 { font-size: 1.85rem; }
    .hp-tag { font-size: 10px; }
    .hp-btn-pink, .hp-btn-dark { max-width: 100%; }
    .hp-badges { flex-direction: column; gap: 12px; }

    .hp-styles { padding: 40px 0 30px; }
    .hp-card { flex: 0 0 162px; }
    .hp-card-img { height: 200px; }

    .hp-contact-grid { grid-template-columns: 1fr; gap: 10px; }
    .hp-contact-box { padding: 16px 14px; }

    .hp-features-grid { grid-template-columns: 1fr 1fr; padding: 0 12px; gap: 8px; }
    .hp-feature { padding: 10px 10px; }
    .hp-about-inner { padding: 0 12px; gap: 14px; }
}

/* ── ≤360px very small ── */
@media (max-width: 360px) {
    .hp-hero-h1 { font-size: 1.65rem; }
    .hp-card { flex: 0 0 148px; }
    .hp-card-img { height: 185px; }
    .hp-features-grid { grid-template-columns: 1fr; }
    .hp-feature { padding: 14px 14px; }
    .hp-contact-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ --}}
<section class="hp-hero">
    <img
        src="{{ asset('images/C00.jpg') }}"
        class="hp-hero-bg"
        alt=""
        aria-hidden="true"
    >
    <div class="hp-hero-gradient"></div>

    <div class="hp-hero-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">

                    <span class="hp-tag">{{ __('messages.hp_tag') }}</span>

                    <h1 class="hp-hero-h1">
                        {{ __('messages.hp_h1_line1') }}<br>
                        <span class="hp-pink">{{ __('messages.hp_h1_line2') }}</span>
                    </h1>

                    <p class="hp-hero-p">{{ __('messages.hp_hero_desc') }}</p>

                    <div class="hp-cta-row">
                        <a href="{{ route('booking.start') }}" class="hp-btn-pink">
                            <i class="fa-regular fa-calendar-check"></i>
                            {{ __('messages.hp_btn_book') }}
                        </a>
                        <a href="{{ route('services.index') }}" class="hp-btn-dark">
                            <i class="fa-solid fa-table-cells-large"></i>
                            {{ __('messages.hp_btn_styles') }}
                        </a>
                    </div>

                    <div class="hp-badges">
                        <div class="hp-badge">
                            <div class="hp-badge-icon"><i class="fa-solid fa-gem"></i></div>
                            <div class="hp-badge-text">
                                <strong>{{ __('messages.hp_badge_quality') }}</strong>
                                <small>{{ __('messages.hp_badge_quality_sub') }}</small>
                            </div>
                        </div>
                        <div class="hp-badge">
                            <div class="hp-badge-icon"><i class="fa-solid fa-shield-heart"></i></div>
                            <div class="hp-badge-text">
                                <strong>{{ __('messages.hp_badge_clean') }}</strong>
                                <small>{{ __('messages.hp_badge_clean_sub') }}</small>
                            </div>
                        </div>
                        <div class="hp-badge">
                            <div class="hp-badge-icon"><i class="fa-regular fa-clock"></i></div>
                            <div class="hp-badge-text">
                                <strong>{{ __('messages.hp_badge_ontime') }}</strong>
                                <small>{{ __('messages.hp_badge_ontime_sub') }}</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     POPULAR BRAIDING STYLES
════════════════════════════════════════════════ --}}
<section class="hp-styles">
    <div class="container">

        <div class="hp-styles-eyebrow">✦ {{ __('messages.hp_tag') }}</div>
        <div class="hp-styles-head">
            <h2>{{ __('messages.hp_popular_title') }} <span>{{ __('messages.hp_popular_span') }}</span></h2>
            <a href="{{ route('services.index') }}" class="hp-view-all">
                {{ __('messages.hp_view_all') }} &nbsp;<i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="hp-title-line"></div>

        <div class="hp-slider-wrap">
            <button class="hp-slider-btn hp-slider-prev" id="hpPrev" aria-label="Previous">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <div class="hp-slider" id="hpSlider">
                @php
                    $sliderServices = collect($latestServices ?? $services ?? []);
                    // No external images — CSS gradient placeholders with emoji icons
                    $defaults = [
                        ['name'=>'Knotless Braids',  'price'=>'From $180','dur'=>'5-6 h','cat'=>'Braids',   'icon'=>'✂️','grad'=>'135deg,#1a0a2e,#3d0060'],
                        ['name'=>'Box Braids',        'price'=>'From $150','dur'=>'4-6 h','cat'=>'Braids',   'icon'=>'💇','grad'=>'135deg,#0a1a2e,#003d3d'],
                        ['name'=>'Island Twist',      'price'=>'From $140','dur'=>'4-5 h','cat'=>'Twists',   'icon'=>'🌀','grad'=>'135deg,#2e0a1a,#600040'],
                        ['name'=>'Cornrows',          'price'=>'From $120','dur'=>'2-4 h','cat'=>'Cornrows', 'icon'=>'〰️','grad'=>'135deg,#0e0a2e,#1a0060'],
                        ['name'=>'Lemonade Braids',   'price'=>'From $160','dur'=>'4-6 h','cat'=>'Braids',   'icon'=>'🌸','grad'=>'135deg,#2e1a00,#603000'],
                        ['name'=>'Goddess Braids',    'price'=>'From $170','dur'=>'5-7 h','cat'=>'Braids',   'icon'=>'👑','grad'=>'135deg,#1a0a2e,#500060'],
                        ['name'=>'Senegalese Twist',  'price'=>'From $145','dur'=>'4-6 h','cat'=>'Twists',   'icon'=>'🌿','grad'=>'135deg,#0a2e1a,#006030'],
                        ['name'=>'Faux Locs',         'price'=>'From $155','dur'=>'5-8 h','cat'=>'Locs',     'icon'=>'🎀','grad'=>'135deg,#2e0a0a,#600020'],
                    ];
                @endphp

                @if($sliderServices->count() > 0)
                    @foreach($sliderServices->take(12) as $svc)
                    @php $svcIsFav = in_array($svc->id, $favoriteIds ?? []); @endphp
                    <div class="hp-card" data-id="{{ $svc->id }}" data-name="{{ $svc->name }}" data-url="{{ route('services.show', $svc->id) }}">
                        <div class="hp-card-img">
                            <img src="{{ $svc->image_url ?? 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=400' }}"
                                 alt="{{ $svc->name }}" loading="lazy">
                            <div class="hp-card-img-overlay"></div>
                            <button class="hp-heart {{ $svcIsFav ? 'liked' : '' }}" data-id="{{ $svc->id }}" title="{{ __('messages.hp_styles_like') }}">
                                <i class="{{ $svcIsFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                        </div>
                        <div class="hp-card-body">
                            <h4>{{ $svc->name }}</h4>
                            <div class="hp-card-dur">
                                <i class="fa-regular fa-clock"></i>
                                {{ $svc->formatted_duration ?? '3-4 h' }}
                            </div>
                            <div class="hp-card-actions">
                                <a href="{{ route('booking.start') }}?service={{ $svc->id }}" class="hp-card-book">
                                    <i class="fa-regular fa-calendar-check"></i> {{ __('messages.hp_styles_book') }}
                                </a>
                                <button class="hp-card-share"
                                        data-name="{{ $svc->name }}"
                                        data-url="{{ route('services.show', $svc->id) }}"
                                        title="{{ __('messages.hp_styles_share') }}">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach($defaults as $s)
                    <div class="hp-card" data-name="{{ $s['name'] }}" data-url="{{ route('services.index') }}">
                        <div class="hp-card-img" style="background:linear-gradient({{ $s['grad'] }});">
                            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:3rem;opacity:.45;">{{ $s['icon'] }}</div>
                            <div class="hp-card-img-overlay"></div>
                            <button class="hp-heart" data-id="d{{ $loop->index }}" title="{{ __('messages.hp_styles_like') }}">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                        <div class="hp-card-body">
                            <h4>{{ $s['name'] }}</h4>
                            <div class="hp-card-dur">
                                <i class="fa-regular fa-clock"></i>
                                {{ $s['dur'] }}
                            </div>
                            <div class="hp-card-actions">
                                <a href="{{ route('booking.start') }}" class="hp-card-book">
                                    <i class="fa-regular fa-calendar-check"></i> {{ __('messages.hp_styles_book') }}
                                </a>
                                <button class="hp-card-share"
                                        data-name="{{ $s['name'] }}"
                                        data-url="{{ route('services.index') }}"
                                        title="{{ __('messages.hp_styles_share') }}">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <button class="hp-slider-btn hp-slider-next" id="hpNext" aria-label="Next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <div class="hp-slider-dots" id="hpDots"></div>

    </div>
</section>

{{-- Toast global --}}
<div class="hp-toast" id="hpToast" role="status" aria-live="polite"></div>

<div class="hp-section-gap"></div>

{{-- ══════════════════════════════════════════════
     ABOUT  (dark rounded card)
════════════════════════════════════════════════ --}}
<div class="hp-about">
    <div class="hp-about-inner">

        {{-- Left: About text --}}
        <div class="hp-about-col">
            <h2 class="hp-about-title">{{ __('messages.hp_about_title') }} <span>{{ __('messages.hp_about_span') }}</span></h2>
            <p class="hp-about-desc">{{ __('messages.hp_about_desc') }}</p>
            <ul class="hp-checklist">
                <li><div class="hp-check-icon"><i class="fa-solid fa-check"></i></div> {{ __('messages.hp_check1') }}</li>
                <li><div class="hp-check-icon"><i class="fa-solid fa-check"></i></div> {{ __('messages.hp_check2') }}</li>
                <li><div class="hp-check-icon"><i class="fa-solid fa-check"></i></div> {{ __('messages.hp_check3') }}</li>
                <li><div class="hp-check-icon"><i class="fa-solid fa-check"></i></div> {{ __('messages.hp_check4') }}</li>
            </ul>
            <a href="{{ route('about') }}" class="hp-btn-outline-pink">{{ __('messages.hp_learn_more') }}</a>
        </div>

        {{-- Center: Owner photo --}}
        <div class="hp-owner-col">
            <img src="{{ asset('images/MAROL3.jpg') }}" alt="{{ __('messages.hp_owner_name') }}">
            <div class="hp-owner-name">{{ __('messages.hp_owner_name') }}</div>
            <div class="hp-owner-sub">{{ __('messages.hp_owner_sub') }}</div>
        </div>

        {{-- Right: Mission --}}
        <div class="hp-about-col">
            <h3 class="hp-mission-title">{{ __('messages.hp_mission_title') }}</h3>
            <p class="hp-mission-p">{{ __('messages.hp_mission_1') }}</p>
            <p class="hp-mission-p">{{ __('messages.hp_mission_2') }}</p>
            <p class="hp-mission-p">{{ __('messages.hp_mission_3') }}</p>
            <a href="{{ route('about') }}" class="hp-btn-pink-filled">
                {{ __('messages.hp_read_more') }} &nbsp;<i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════
     FEATURES BAR  (bottom of dark card)
════════════════════════════════════════════════ --}}
<div class="hp-features">
    <div class="hp-features-grid">
        <div class="hp-feature">
            <div class="hp-feature-icon"><i class="fa-solid fa-user-check"></i></div>
            <div class="hp-feature-text">
                <strong>{{ __('messages.hp_feat1') }}</strong>
                <small>{{ __('messages.hp_feat1_sub') }}</small>
            </div>
        </div>
        <div class="hp-feature">
            <div class="hp-feature-icon"><i class="fa-regular fa-star"></i></div>
            <div class="hp-feature-text">
                <strong>{{ __('messages.hp_feat2') }}</strong>
                <small>{{ __('messages.hp_feat2_sub') }}</small>
            </div>
        </div>
        <div class="hp-feature">
            <div class="hp-feature-icon"><i class="fa-regular fa-heart"></i></div>
            <div class="hp-feature-text">
                <strong>{{ __('messages.hp_feat3') }}</strong>
                <small>{{ __('messages.hp_feat3_sub') }}</small>
            </div>
        </div>
        <div class="hp-feature">
            <div class="hp-feature-icon"><i class="fa-solid fa-thumbs-up"></i></div>
            <div class="hp-feature-text">
                <strong>{{ __('messages.hp_feat4') }}</strong>
                <small>{{ __('messages.hp_feat4_sub') }}</small>
            </div>
        </div>
    </div>
</div>

<div class="hp-section-gap"></div>

{{-- ══════════════════════════════════════════════
     CONTACT INFO
════════════════════════════════════════════════ --}}
<section class="hp-contact">
    <div class="container">
        <div class="hp-contact-grid">

            <div class="hp-contact-box">
                <div class="hp-contact-ico"><i class="fa-solid fa-phone"></i></div>
                <div>
                    <h5>{{ __('messages.hp_contact_call') }}</h5>
                    <p>+1 (301) 219-4507<br>+1 (240) 729-0623</p>
                    <a href="https://wa.me/13012194507" class="hp-contact-link" target="_blank" rel="noopener">
                        {{ __('messages.hp_contact_chat') }}
                    </a>
                </div>
            </div>

            <div class="hp-contact-box">
                <div class="hp-contact-ico"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <h5>{{ __('messages.hp_contact_email') }}</h5>
                    <p>info@marolhairbraiding.com</p>
                    <p style="color:rgba(255,255,255,.3);font-size:12px;">{{ __('messages.hp_contact_reply') }}</p>
                </div>
            </div>

            <div class="hp-contact-box">
                <div class="hp-contact-ico"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <h5>{{ __('messages.hp_contact_location') }}</h5>
                    <p>1545 W 71st Street,<br>Chicago, IL 60636, USA</p>
                    <a href="https://maps.google.com/?q=1545+W+71st+Street+Chicago+IL+60636" class="hp-contact-link" target="_blank" rel="noopener">
                        {{ __('messages.hp_contact_map') }}
                    </a>
                </div>
            </div>

            <div class="hp-contact-box">
                <div class="hp-contact-ico"><i class="fa-regular fa-clock"></i></div>
                <div>
                    <h5>{{ __('messages.hp_contact_hours') }}</h5>
                    <p>{{ __('messages.hp_contact_schedule') }}</p>
                    <p>Sunday: <strong style="color:#e83e8c;">{{ __('messages.hp_contact_closed') }}</strong></p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    /* ── helpers ── */
    const $ = id => document.getElementById(id);
    function showToast(msg, type = 'info') {
        const t = $('hpToast');
        if (!t) return;
        const icons = { success: '✓', error: '✕', info: '♥' };
        t.innerHTML = `<span>${icons[type] || '•'}</span> ${msg}`;
        t.className = `hp-toast show ${type}`;
        clearTimeout(t._tid);
        t._tid = setTimeout(() => t.classList.remove('show'), 3000);
    }

    /* ── SLIDER ── */
    const slider = $('hpSlider');
    const prev   = $('hpPrev');
    const next   = $('hpNext');
    const dotsWrap = $('hpDots');
    if (!slider) return;

    const CARD_W = 248; // card width + gap
    let autoTimer = null;
    let isDragging = false;
    let startX = 0, scrollStart = 0;

    /* Build dots */
    const cards = slider.querySelectorAll('.hp-card');
    const visible = Math.floor(slider.clientWidth / CARD_W) || 1;
    const totalDots = Math.ceil(cards.length / visible);
    let activeDot = 0;
    if (dotsWrap && cards.length > visible) {
        for (let i = 0; i < totalDots; i++) {
            const d = document.createElement('button');
            d.className = 'hp-dot' + (i === 0 ? ' active' : '');
            d.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(d);
        }
    }

    function goTo(idx) {
        activeDot = Math.max(0, Math.min(idx, totalDots - 1));
        slider.scrollTo({ left: activeDot * visible * CARD_W, behavior: 'smooth' });
        dotsWrap && dotsWrap.querySelectorAll('.hp-dot').forEach((d, i) =>
            d.classList.toggle('active', i === activeDot));
    }

    /* Arrow click */
    if (prev) prev.addEventListener('click', () => goTo(activeDot - 1));
    if (next) next.addEventListener('click', () => goTo(activeDot + 1));

    /* Scroll → update dots */
    slider.addEventListener('scroll', () => {
        const idx = Math.round(slider.scrollLeft / (visible * CARD_W));
        if (idx !== activeDot) {
            activeDot = idx;
            dotsWrap && dotsWrap.querySelectorAll('.hp-dot').forEach((d, i) =>
                d.classList.toggle('active', i === activeDot));
        }
    }, { passive: true });

    /* Auto-play */
    function startAuto() {
        autoTimer = setInterval(() => {
            if (activeDot >= totalDots - 1) goTo(0);
            else goTo(activeDot + 1);
        }, 3800);
    }
    function stopAuto() { clearInterval(autoTimer); }
    startAuto();
    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);
    slider.addEventListener('touchstart', stopAuto, { passive: true });

    /* Touch drag (mobile swipe) */
    slider.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
        scrollStart = slider.scrollLeft;
    }, { passive: true });

    slider.addEventListener('touchmove', e => {
        slider.scrollLeft = scrollStart - (e.touches[0].clientX - startX);
    }, { passive: true });

    /* ── FAVORIS (mêmes règles que la page détail service) ── */
    /* Repli localStorage pour les cartes de démo sans service réel (id "dN") */
    const LIKED_KEY = 'mhb_liked';
    let demoLiked = JSON.parse(localStorage.getItem(LIKED_KEY) || '[]');
    const isDemoId = id => /^d\d+$/.test(id);

    function setHeartState(btn, isLiked) {
        btn.classList.toggle('liked', isLiked);
        btn.querySelector('i').className = isLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
    }

    document.querySelectorAll('.hp-heart').forEach(btn => {
        const id = btn.dataset.id;
        if (isDemoId(id)) setHeartState(btn, demoLiked.includes(id));
    });

    document.querySelectorAll('.hp-heart').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const btnEl = this;

            /* pop animation */
            btnEl.style.transform = 'scale(1.4)';
            setTimeout(() => btnEl.style.transform = '', 250);

            if (isDemoId(id)) {
                const isNowLiked = !demoLiked.includes(id);
                demoLiked = isNowLiked ? [...demoLiked, id] : demoLiked.filter(x => x !== id);
                localStorage.setItem(LIKED_KEY, JSON.stringify(demoLiked));
                setHeartState(btnEl, isNowLiked);
                showToast('{{ __('messages.hp_styles_like') }} ♥', 'info');
                return;
            }

            @auth
            const wasLiked = btnEl.classList.contains('liked');
            setHeartState(btnEl, !wasLiked);

            fetch('/favorites/' + id + '/toggle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                setHeartState(btnEl, data.favorited);
                showToast(data.favorited ? '{{ __("messages.svc_liked") }} ♥' : '{{ __("messages.svc_unliked") }}', 'info');
                syncServiceLike(id, data.favorited);
            })
            .catch(() => setHeartState(btnEl, wasLiked));
            @else
            showToast('{{ __("messages.svc_login_to_like") }}', 'error');
            setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1500);
            @endauth
        });
    });

    /* ── SHARE ── */
    document.querySelectorAll('.hp-card-share').forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            const name = this.dataset.name;
            const url  = this.dataset.url;
            const shareData = {
                title: 'Marol Hair Braiding – ' + name,
                text: 'Découvrez ce style de tressage chez Marol Hair Braiding !',
                url: url,
            };
            if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
                try { await navigator.share(shareData); } catch(_) {}
            } else {
                try {
                    await navigator.clipboard.writeText(url);
                    showToast('{{ __('messages.hp_styles_share') }} — lien copié !', 'success');
                } catch(_) {
                    showToast(url, 'info');
                }
            }
        });
    });

    /* ── NEWSLETTER S'ABONNER ── */
    document.querySelectorAll('.hp-footer-sub-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const input = this.querySelector('input[type=email]');
            const btn   = this.querySelector('.hp-footer-sub-btn');
            const email = input.value.trim();
            if (!email) { showToast('{{ __('messages.footer_sub_invalid') }}', 'error'); return; }

            const origText = btn.textContent;
            btn.disabled = true;
            btn.textContent = '…';

            try {
                const res = await fetch('{{ route('newsletter.subscribe') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email }),
                });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message, 'success');
                    input.value = '';
                    btn.textContent = '✓';
                    setTimeout(() => { btn.textContent = origText; btn.disabled = false; }, 3000);
                } else if (data.already) {
                    showToast(data.message, 'info');
                    btn.textContent = origText; btn.disabled = false;
                } else {
                    showToast(data.message || '{{ __('messages.footer_sub_invalid') }}', 'error');
                    btn.textContent = origText; btn.disabled = false;
                }
            } catch (_) {
                showToast('Erreur réseau, réessayez.', 'error');
                btn.textContent = origText; btn.disabled = false;
            }
        });
    });

    /* ── Image cliquable → détail du service ── */
    document.querySelectorAll('#hpSlider .hp-card-img').forEach(imgArea => {
        imgArea.addEventListener('click', function (e) {
            if (e.target.closest('.hp-heart')) return;
            const url = this.closest('.hp-card')?.dataset.url;
            if (url) window.location.href = url;
        });
    });

})();
</script>
@endpush

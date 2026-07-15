@extends('layouts.app')

@section('title', 'Marol Hair Braiding — Premium Salon Chicago')

@section('content')

<style>
/* ═══════════════════════════════════════
   NEW HOME PAGE — DARK PINK THEME
═══════════════════════════════════════ */
body { background: #0e0a1c !important; color: #fff; }
main.content { padding: 0 !important; }

:root {
    --nh-pink:       #e91e8c;
    --nh-pink-dark:  #c91a78;
    --nh-bg:         #0e0a1c;
    --nh-card:       #1a1130;
    --nh-card2:      #120e22;
    --nh-border:     rgba(255,255,255,.06);
    --nh-border-pk:  rgba(233,30,140,.15);
    --nh-muted:      rgba(255,255,255,.6);
    --nh-star:       #f5c518;
}

/* ── PAGE GRID ── */
.nh-page {
    display: grid;
    grid-template-columns: 1fr 380px;
    min-height: calc(100vh - 78px);
    background: var(--nh-bg);
}

/* ── LEFT MAIN ── */
.nh-main { padding: 24px 24px 40px; overflow-x: hidden; }

/* ── HERO CAROUSEL ── */
.nh-hero {
    position: relative;
    height: 520px;
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 20px;
}

.nh-hero-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity .9s ease;
}
.nh-hero-slide.active { opacity: 1; }
.nh-hero-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
}
.nh-hero-slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(14,10,28,.92) 30%, rgba(14,10,28,.45) 65%, rgba(14,10,28,.1) 100%);
}

.nh-hero-body {
    position: absolute;
    bottom: 56px;
    left: 40px;
    right: 45%;
    z-index: 2;
}
.nh-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--nh-pink);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.nh-eyebrow::before { content: '✦'; font-size: .55rem; }

.nh-hero-title {
    font-size: 3rem;
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 4px;
}
.nh-hero-cursive {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 2.6rem;
    font-weight: 600;
    color: var(--nh-pink);
    margin-bottom: 16px;
}
.nh-hero-sub {
    color: rgba(255,255,255,.78);
    font-size: .92rem;
    line-height: 1.65;
    margin-bottom: 22px;
}
.nh-feats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 26px;
}
.nh-feat {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 2px;
}
.nh-feat i {
    color: var(--nh-pink);
    font-size: .9rem;
    margin-bottom: 2px;
}
.nh-feat strong {
    font-size: .75rem;
    color: #fff;
    font-weight: 600;
    display: block;
}
.nh-feat small {
    font-size: .68rem;
    color: rgba(255,255,255,.55);
}
.nh-hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }

.nh-btn-pk {
    background: var(--nh-pink);
    color: #fff;
    border: none;
    padding: 12px 22px;
    border-radius: 50px;
    font-weight: 700;
    font-size: .88rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .3s;
    box-shadow: 0 6px 20px rgba(233,30,140,.35);
}
.nh-btn-pk:hover { background: var(--nh-pink-dark); color: #fff; transform: translateY(-2px); }

.nh-btn-ol {
    background: transparent;
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.35);
    padding: 12px 22px;
    border-radius: 50px;
    font-weight: 600;
    font-size: .88rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .3s;
}
.nh-btn-ol:hover { border-color: var(--nh-pink); color: var(--nh-pink); }

/* Carousel controls */
.nh-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 3;
    width: 40px; height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: .85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .3s;
}
.nh-arrow:hover { background: var(--nh-pink); border-color: var(--nh-pink); }
.nh-arrow-l { left: 14px; }
.nh-arrow-r { right: 14px; }

.nh-dots {
    position: absolute;
    bottom: 14px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 7px;
    z-index: 3;
}
.nh-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,.35);
    cursor: pointer;
    transition: .3s;
}
.nh-dot.active { width: 22px; border-radius: 4px; background: var(--nh-pink); }

/* ── STATS ── */
.nh-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 28px;
}
.nh-stat {
    background: var(--nh-card);
    border-radius: 16px;
    padding: 16px 12px;
    text-align: center;
    border: 1px solid var(--nh-border-pk);
}
.nh-stat-icon {
    width: 34px; height: 34px;
    background: rgba(233,30,140,.12);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: var(--nh-pink);
    font-size: .85rem;
}
.nh-stat-num {
    font-size: 1.55rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
}
.nh-stat-lbl { font-size: .68rem; color: var(--nh-muted); }

/* ── POPULAR STYLES ── */
.nh-styles-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.nh-styles-ttl {
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
    white-space: nowrap;
}
.nh-styles-em { color: var(--nh-pink); }
.nh-styles-line {
    flex: 1;
    height: 3px;
    background: linear-gradient(90deg, var(--nh-pink), transparent);
    border-radius: 2px;
    margin-left: 4px;
}
.nh-styles-scroll {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    padding-bottom: 6px;
    scrollbar-width: none;
}
.nh-styles-scroll::-webkit-scrollbar { display: none; }

.nh-style-card {
    flex: 0 0 190px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: .3s;
}
.nh-style-card:hover { transform: translateY(-5px); }
.nh-style-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
}
.nh-style-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(14,10,28,.88));
    padding: 30px 12px 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
.nh-style-name {
    color: #fff;
    font-weight: 700;
    font-size: .85rem;
    text-align: center;
}
.nh-style-btn {
    background: var(--nh-pink);
    color: #fff;
    border: none;
    padding: 5px 16px;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 700;
    text-decoration: none;
    transition: .2s;
}
.nh-style-btn:hover { background: var(--nh-pink-dark); color: #fff; }

/* ── RIGHT SIDEBAR ── */
.nh-sidebar {
    background: var(--nh-card2);
    border-left: 1px solid var(--nh-border-pk);
    padding: 20px 18px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    overflow-y: auto;
}

.nh-sb-section {
    background: var(--nh-card);
    border-radius: 18px;
    padding: 16px;
    border: 1px solid var(--nh-border);
}
.nh-sb-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}
.nh-sb-title {
    font-size: .95rem;
    font-weight: 800;
    color: #fff;
}
.nh-sb-link {
    font-size: .75rem;
    font-weight: 600;
    color: var(--nh-pink);
    text-decoration: none;
}
.nh-sb-link:hover { text-decoration: underline; color: var(--nh-pink); }

/* ── STYLISTS ── */
.nh-stylists {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}
.nh-stylist {
    background: var(--nh-card2);
    border-radius: 12px;
    padding: 10px 6px;
    text-align: center;
    border: 1px solid var(--nh-border);
    transition: .2s;
}
.nh-stylist:hover { border-color: var(--nh-border-pk); }
.nh-sty-img {
    width: 50px; height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 6px;
    display: block;
    border: 2px solid rgba(233,30,140,.35);
}
.nh-sty-name {
    font-size: .72rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 2px;
}
.nh-sty-role {
    font-size: .6rem;
    color: var(--nh-muted);
    margin-bottom: 5px;
    line-height: 1.3;
}
.nh-sty-stars {
    color: var(--nh-star);
    font-size: .62rem;
    margin-bottom: 7px;
}
.nh-sty-btn {
    background: var(--nh-pink);
    color: #fff;
    border: none;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: .65rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-block;
    transition: .2s;
}
.nh-sty-btn:hover { background: var(--nh-pink-dark); color: #fff; }

/* ── BOOKING CTA ── */
.nh-booking {
    display: grid;
    grid-template-columns: 52px 1fr;
    gap: 12px;
}
.nh-bk-icon {
    width: 52px; height: 52px;
    background: rgba(233,30,140,.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--nh-pink);
    font-size: 1.35rem;
    flex-shrink: 0;
}
.nh-bk-head-title {
    font-size: .78rem;
    color: var(--nh-muted);
    margin-bottom: 2px;
}
.nh-bk-em {
    font-size: 1rem;
    font-weight: 800;
    color: var(--nh-pink);
    display: block;
}
.nh-bk-sub {
    font-size: .68rem;
    color: rgba(255,255,255,.45);
    margin-top: 2px;
}
.nh-bk-full { grid-column: 1 / -1; }
.nh-bk-steps { display: flex; flex-direction: column; gap: 8px; margin-bottom: 14px; }
.nh-bk-step {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: .76rem;
    color: rgba(255,255,255,.8);
}
.nh-step-num {
    width: 22px; height: 22px;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .68rem;
    font-weight: 700;
    color: var(--nh-pink);
    flex-shrink: 0;
}

/* ── SHOP ── */
.nh-tabs {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}
.nh-tab {
    background: rgba(255,255,255,.06);
    color: var(--nh-muted);
    border: none;
    padding: 4px 11px;
    border-radius: 50px;
    font-size: .7rem;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}
.nh-tab.active, .nh-tab:hover { background: var(--nh-pink); color: #fff; }
.nh-products {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}
.nh-product {
    background: var(--nh-card2);
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--nh-border);
    transition: transform .25s, border-color .25s, box-shadow .25s;
    display: flex;
    flex-direction: column;
}
.nh-product:hover {
    border-color: var(--nh-border-pk);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(233,30,140,.15);
}
.nh-product-img {
    display: block;
    width: 100%;
    overflow: hidden;
    flex-shrink: 0;
}
.nh-product img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
    transition: transform .4s;
}
.nh-product:hover img { transform: scale(1.06); }
.nh-product-body { padding: 10px; flex: 1; display: flex; flex-direction: column; gap: 4px; }
.nh-product-name {
    font-size: .78rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 2px;
    line-height: 1.3;
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.nh-product-name:hover { color: var(--nh-pink); }
.nh-product-price {
    font-size: .78rem;
    color: var(--nh-pink);
    font-weight: 800;
    margin-bottom: 6px;
}
.nh-add-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
    background: rgba(233,30,140,.1);
    border: 1px solid rgba(233,30,140,.2);
    color: var(--nh-pink);
    font-size: .68rem;
    font-weight: 700;
    padding: 8px 6px;
    border-radius: 9px;
    cursor: pointer;
    text-decoration: none;
    transition: .2s;
    margin-top: auto;
}
.nh-add-btn:hover { background: var(--nh-pink); color: #fff; border-color: var(--nh-pink); }

/* ── CONTACT ── */
.nh-contact {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    padding: 4px 0;
}
.nh-contact-item h6 {
    font-size: .65rem;
    font-weight: 700;
    color: rgba(255,255,255,.35);
    text-transform: uppercase;
    letter-spacing: .1em;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.nh-contact-item p {
    font-size: .7rem;
    color: rgba(255,255,255,.65);
    margin: 0;
    line-height: 1.55;
}
.nh-socials {
    grid-column: 1 / -1;
    display: flex;
    gap: 8px;
}
.nh-social {
    width: 28px; height: 28px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,.55);
    font-size: .75rem;
    text-decoration: none;
    transition: .2s;
}
.nh-social:hover { background: var(--nh-pink); color: #fff; }

/* Booking CTA reserve button — full-width in sidebar, auto on mobile */
.nh-bk-reserve-btn { width: 100%; }

/* ── RESPONSIVE ── */
@media (max-width: 1200px) {
    .nh-page { grid-template-columns: 1fr 340px; }
    .nh-stylists { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 1024px) {
    .nh-page { grid-template-columns: 1fr; }
    .nh-sidebar {
        border-left: none;
        border-top: 1px solid var(--nh-border-pk);
        overflow-y: visible;
    }
    .nh-stylists { grid-template-columns: repeat(4, 1fr); }
    .nh-sidebar { padding: 16px 14px; }
}
@media (max-width: 768px) {
    .nh-hero { height: 460px; }
    .nh-hero-title { font-size: 2rem; }
    .nh-hero-cursive { font-size: 1.8rem; }
    .nh-hero-sub { font-size: .85rem; margin-bottom: 16px; }
    /* Gradient vertical sur mobile pour meilleure lisibilité du texte */
    .nh-hero-slide::after {
        background: linear-gradient(to top, rgba(14,10,28,.97) 0%, rgba(14,10,28,.75) 45%, rgba(14,10,28,.15) 100%);
    }
    .nh-hero-body { left: 18px; right: 18px; bottom: 24px; top: auto; }
    .nh-stats { grid-template-columns: repeat(2, 1fr); }
    .nh-stylists { grid-template-columns: repeat(4, 1fr); }
    .nh-products { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .nh-product img { height: 160px; }
    .nh-bk-cta-grid { grid-template-columns: 1fr !important; }
    .nh-bk-cta-img { display: none !important; }
    /* Boutons hero : taille réduite, largeur automatique */
    .nh-hero-btns { gap: 10px; flex-wrap: wrap; }
    .nh-btn-pk, .nh-btn-ol {
        padding: 10px 18px;
        font-size: .82rem;
        flex: 0 0 auto;
        white-space: nowrap;
    }
    /* Bouton "Réserver maintenant" : largeur auto sur mobile */
    .nh-bk-reserve-btn {
        width: auto;
        padding-left: 22px;
        padding-right: 22px;
        display: inline-flex;
    }
}
@media (max-width: 576px) {
    body { padding-bottom: 64px; overflow-x: hidden; }
    .nh-main { padding: 12px 10px 28px; }
    .nh-hero { height: 400px; border-radius: 16px; }
    .nh-hero-title { font-size: 1.7rem; line-height: 1.1; }
    .nh-hero-cursive { font-size: 1.5rem; margin-bottom: 10px; }
    .nh-hero-sub { font-size: .78rem; margin-bottom: 12px; line-height: 1.55; }
    /* Cacher les features pour gagner de la place */
    .nh-feats { display: none; }
    .nh-hero-body { left: 14px; right: 14px; bottom: 20px; }
    /* Boutons : compacts, largeur auto, côte à côte */
    .nh-hero-btns { gap: 8px; flex-wrap: nowrap; }
    .nh-btn-pk, .nh-btn-ol {
        padding: 9px 14px;
        font-size: .76rem;
        flex: 0 0 auto;
        white-space: nowrap;
        border-radius: 40px;
    }
    /* Stats : 4 colonnes compactes sur mobile — tous visibles sans scroll */
    .nh-stats { grid-template-columns: repeat(4, 1fr); gap: 6px; margin-bottom: 14px; }
    .nh-stat { padding: 8px 4px; border-radius: 10px; }
    .nh-stat-icon { width: 26px; height: 26px; font-size: .7rem; margin-bottom: 5px; }
    .nh-stat-num { font-size: 1rem; }
    .nh-stat-lbl { font-size: .54rem; line-height: 1.3; }
    .nh-styles-head { margin-bottom: 10px; }
    .nh-styles-ttl { font-size: 1.1rem; }
    .nh-style-card { flex: 0 0 145px; }
    .nh-style-card img { height: 195px; }
    .nh-stylists { grid-template-columns: repeat(2, 1fr); }
    .nh-products { grid-template-columns: repeat(2, 1fr); gap: 7px; }
    .nh-product img { height: 150px; }
    .nh-product-body { padding: 8px; }
    .nh-product-name { font-size: .72rem; }
    .nh-product-price { font-size: .72rem; margin-bottom: 5px; }
    .nh-add-btn { font-size: .62rem; padding: 7px 4px; border-radius: 7px; }
    .nh-sb-section { padding: 12px; }
    .nh-bk-cta-grid { grid-template-columns: 1fr !important; }
    .nh-bk-cta-img { display: none !important; }
}
@media (max-width: 400px) {
    .nh-hero { height: 360px; }
    .nh-hero-title { font-size: 1.45rem; }
    .nh-hero-cursive { font-size: 1.3rem; }
    /* Sur très petits écrans : empiler les boutons mais pas pleine largeur */
    .nh-hero-btns { flex-wrap: wrap; gap: 8px; }
    .nh-btn-pk, .nh-btn-ol {
        padding: 8px 16px;
        font-size: .74rem;
        flex: 0 0 auto;
    }
    .nh-stats { grid-template-columns: repeat(4, 1fr); gap: 4px; }
    .nh-stat-num { font-size: .88rem; }
    .nh-stat-lbl { font-size: .5rem; }
    .nh-eyebrow { display: none; }
}
@media (max-width: 360px) {
    .nh-stats { grid-template-columns: repeat(2, 1fr); gap: 6px; }
    .nh-stat-num { font-size: .92rem; }
    .nh-stat-lbl { font-size: .6rem; }
    .nh-hero-title { font-size: 1.3rem; }
    .nh-btn-pk, .nh-btn-ol { width: 100%; text-align: center; }
}

/* ── MOBILE SIDEBAR ACCORDION ── */
@media (max-width: 1024px) {
    /* Toggle icon hidden on desktop, shown via JS on mobile */
    .nh-sb-toggle-icon {
        display: none;
        width: 24px;
        height: 24px;
        align-items: center;
        justify-content: center;
        background: rgba(233,30,140,.12);
        border-radius: 50%;
        color: var(--nh-pink);
        font-size: .65rem;
        transition: transform .35s ease;
        flex-shrink: 0;
        margin-left: 6px;
        cursor: pointer;
    }
    .nh-sb-section.sb-open .nh-sb-toggle-icon { transform: rotate(180deg); }

    /* Body: animated collapse */
    .nh-sb-body {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        margin-top: 0;
        transition: max-height .4s cubic-bezier(.4,0,.2,1),
                    opacity .35s ease,
                    margin .35s ease;
        pointer-events: none;
    }
    .nh-sb-section.sb-open .nh-sb-body {
        max-height: 1200px;
        opacity: 1;
        margin-top: 14px;
        pointer-events: auto;
    }

    /* Clickable header on mobile */
    .nh-sb-head { cursor: pointer; user-select: none; }

    /* Horizontal scroll for stylists */
    .nh-stylists {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto;
        gap: 10px !important;
        padding-bottom: 6px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .nh-stylists::-webkit-scrollbar { display: none; }
    .nh-stylist { flex: 0 0 110px !important; }

    /* Produits : colonne unique verticale sur mobile */
    .nh-products {
        display: grid !important;
        grid-template-columns: 1fr !important;
        overflow-x: visible !important;
        flex-wrap: unset !important;
        gap: 10px !important;
    }
    .nh-product { flex: unset !important; }
}
</style>

<div class="nh-page">

    {{-- ═══════════ LEFT MAIN ═══════════ --}}
    <div class="nh-main">

        {{-- HERO CAROUSEL --}}
        <div class="nh-hero" id="nhHero">
            @php
                $heroSlides = [
                    asset('images/C00.jpg'),
                    asset('images/C44.jpg'),
                    asset('images/C45.jpg'),
                    asset('images/C46.jpg'),
                    asset('images/C47.jpg'),
                ];
            @endphp
            @foreach($heroSlides as $i => $src)
            <div class="nh-hero-slide {{ $i===0?'active':'' }}">
                <img src="{{ $src }}" alt="Slide {{ $i+1 }}">
            </div>
            @endforeach


<div class="nh-hero-body">
                <p class="nh-eyebrow">{{ __('messages.nh_welcome') }}</p>
                <h1 class="nh-hero-title">{{ __('messages.nh_hero_title') }}</h1>
                <span class="nh-hero-cursive">{{ __('messages.nh_hero_city') }}</span>
                <p class="nh-hero-sub">{{ __('messages.nh_hero_sub') }}</p>
                <div class="nh-feats">
                    <div class="nh-feat">
                        <i class="fa-solid fa-gem"></i>
                        <strong>{{ __('messages.nh_feat1') }}</strong>
                        <small>{{ __('messages.nh_feat1_sub') }}</small>
                    </div>
                    <div class="nh-feat">
                        <i class="fa-solid fa-shield-halved"></i>
                        <strong>{{ __('messages.nh_feat2') }}</strong>
                        <small>{{ __('messages.nh_feat2_sub') }}</small>
                    </div>
                    <div class="nh-feat">
                        <i class="fa-regular fa-clock"></i>
                        <strong>{{ __('messages.nh_feat3') }}</strong>
                        <small>{{ __('messages.nh_feat3_sub') }}</small>
                    </div>
                </div>
                <div class="nh-hero-btns">
                    <a href="{{ route('booking.start') }}" class="nh-btn-pk">
                        <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nh_btn_rdv') }}
                    </a>
                </div>
            </div>

            <button class="nh-arrow nh-arrow-l" onclick="nhSlide(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="nh-arrow nh-arrow-r" onclick="nhSlide(1)"><i class="fa-solid fa-chevron-right"></i></button>
            <div class="nh-dots">
                @foreach($heroSlides as $i => $src)
                <div class="nh-dot {{ $i===0?'active':'' }}" onclick="nhGoTo({{ $i }})"></div>
                @endforeach
            </div>
        </div>

        {{-- STATS --}}
        <div class="nh-stats">
            @php $nhStats = [
                ['icon'=>'fa-users',  'num'=>'1000+', 'lbl'=>__('messages.nh_stat1')],
                ['icon'=>'fa-star',   'num'=>'50+',   'lbl'=>__('messages.nh_stat2')],
                ['icon'=>'fa-trophy', 'num'=>'10+',   'lbl'=>__('messages.nh_stat3')],
                ['icon'=>'fa-heart',  'num'=>'5★',    'lbl'=>__('messages.nh_stat4')],
            ]; @endphp
            @foreach($nhStats as $s)
            <div class="nh-stat">
                <div class="nh-stat-icon"><i class="fa-solid {{ $s['icon'] }}"></i></div>
                <div class="nh-stat-num">{{ $s['num'] }}</div>
                <div class="nh-stat-lbl">{{ $s['lbl'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- POPULAR STYLES --}}
        <div class="nh-styles-head">
            <span class="nh-styles-ttl">{{ __('messages.nh_styles_title') }} <span class="nh-styles-em">{{ __('messages.nh_styles_em') }}</span></span>
            <span class="nh-styles-line"></span>
        </div>
        <div class="nh-styles-scroll">
            @php $stylesFb = [
                ['name'=>'Knotless Braids', 'img'=> asset('images/C5.jpg')],
                ['name'=>'Cornrows',        'img'=> asset('images/C6.jpg')],
                ['name'=>'Boho Braids',     'img'=> asset('images/C7.jpg')],
                ['name'=>'Twist',           'img'=> asset('images/C8.jpg')],
                ['name'=>'Kids Braids',     'img'=> asset('images/C9.jpg')],
            ]; @endphp
            @forelse($services->take(5) as $svc)
            <a href="{{ route('services.show', $svc) }}" class="nh-style-card" style="text-decoration:none;">
                <img src="{{ $svc->image ? asset('storage/'.$svc->image) : 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400&q=80' }}"
                     alt="{{ $svc->nom }}"
                     onerror="this.src='https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400&q=80'">
                <div class="nh-style-overlay">
                    <span class="nh-style-name">{{ $svc->nom }}</span>
                    <span class="nh-style-btn">{{ __('messages.nh_view_more') }}</span>
                </div>
            </a>
            @empty
            @foreach($stylesFb as $style)
            <a href="{{ route('services.index') }}" class="nh-style-card" style="text-decoration:none;">
                <img src="{{ $style['img'] }}" alt="{{ $style['name'] }}">
                <div class="nh-style-overlay">
                    <span class="nh-style-name">{{ $style['name'] }}</span>
                    <span class="nh-style-btn">{{ __('messages.nh_view_more') }}</span>
                </div>
            </a>
            @endforeach
            @endforelse
        </div>

    </div>{{-- /nh-main --}}

    {{-- ═══════════ RIGHT SIDEBAR ═══════════ --}}
    <div class="nh-sidebar">

        {{-- STYLISTS --}}
        <div class="nh-sb-section">
            <div class="nh-sb-head">
                <span class="nh-sb-title">{{ __('messages.nh_stylists_title') }}</span>
                <a href="{{ route('stylists.index') }}" class="nh-sb-link">{{ __('messages.nh_stylists_all') }}</a>
                <span class="nh-sb-toggle-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
            <div class="nh-sb-body">
            <div class="nh-stylists">
                @php $stylistsFb = [
                    ['name'=>'Jessica', 'role'=>'Knotless & Boho Expert', 'stars'=>5,
                     'img'=> asset('images/C10.jpg')],
                    ['name'=>'Sophie',  'role'=>'Cornrows Expert',        'stars'=>5,
                     'img'=> asset('images/C11.jpg')],
                    ['name'=>'Amelia',  'role'=>'Twist & Locs Expert',    'stars'=>5,
                     'img'=> asset('images/C12.jpg')],
                    ['name'=>'Nina',    'role'=>'Kids Braids Specialist', 'stars'=>5,
                     'img'=> asset('images/C13.jpg')],
                ]; @endphp
                @forelse($stylists->take(4) as $stylist)
                <div class="nh-stylist">
                    <img class="nh-sty-img"
                         src="{{ $stylist->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($stylist->user->name??'S').'&background=e91e8c&color=fff&size=200' }}"
                         alt="{{ $stylist->user->name ?? 'Stylist' }}"
                         onerror="this.src='https://ui-avatars.com/api/?name=S&background=e91e8c&color=fff&size=200'">
                    <div class="nh-sty-name">{{ Str::limit($stylist->user->name ?? 'Stylist', 8) }}</div>
                    <div class="nh-sty-role">{{ Str::limit($stylist->specialty ?? 'Expert', 18) }}</div>
                    <div class="nh-sty-stars">★★★★★</div>
                    <a href="{{ route('stylists.show', $stylist->id) }}" class="nh-sty-btn">{{ __('messages.team_view_profile') }}</a>
                </div>
                @empty
                @foreach($stylistsFb as $s)
                <div class="nh-stylist">
                    <img class="nh-sty-img" src="{{ $s['img'] }}" alt="{{ $s['name'] }}">
                    <div class="nh-sty-name">{{ $s['name'] }}</div>
                    <div class="nh-sty-role">{{ $s['role'] }}</div>
                    <div class="nh-sty-stars">{{ str_repeat('★',$s['stars']) }}{{ $s['stars']<5 ? str_repeat('☆',5-$s['stars']) : '' }}</div>
                    <a href="{{ route('stylists.index') }}" class="nh-sty-btn">{{ __('messages.team_view_profile') }}</a>
                </div>
                @endforeach
                @endforelse
            </div>
            </div>{{-- /nh-sb-body --}}
        </div>

    </div>{{-- /nh-sidebar --}}

</div>{{-- /nh-page --}}

@endsection

@push('scripts')
<script>
(function () {
    let nhCur = 0;
    const slides = document.querySelectorAll('.nh-hero-slide');
    const dots   = document.querySelectorAll('.nh-dot');

    function nhGoTo(n) {
        slides[nhCur].classList.remove('active');
        dots[nhCur].classList.remove('active');
        nhCur = (n + slides.length) % slides.length;
        slides[nhCur].classList.add('active');
        dots[nhCur].classList.add('active');
    }

    window.nhSlide = d => nhGoTo(nhCur + d);
    window.nhGoTo  = nhGoTo;

    const timer = setInterval(() => nhSlide(1), 5200);
    document.getElementById('nhHero').addEventListener('mouseenter', () => clearInterval(timer));

    window.nhTab = function(el) {
        document.querySelectorAll('.nh-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        const cat = el.dataset.cat;
        document.querySelectorAll('.nh-product').forEach(p => {
            p.style.display = (cat === 'all' || p.dataset.cat === cat) ? '' : 'none';
        });
    };

    /* ── Auto-scroll infini : Nos styles populaires ── */
    const stylesEl = document.querySelector('.nh-styles-scroll');
    if (stylesEl) {
        /* Duplicate cards for seamless infinite loop */
        Array.from(stylesEl.children).forEach(c => stylesEl.appendChild(c.cloneNode(true)));
        const half = () => stylesEl.scrollWidth / 2;
        setInterval(() => {
            stylesEl.scrollLeft += 1;
            if (stylesEl.scrollLeft >= half()) {
                stylesEl.scrollLeft -= half();
            }
        }, 20);
    }

    /* ── Sidebar accordion mobile ── */
    if (window.innerWidth <= 1024) {
        document.querySelectorAll('.nh-sb-section').forEach(function (section) {
            const head = section.querySelector('.nh-sb-head');
            if (!head) return;
            const icon = head.querySelector('.nh-sb-toggle-icon');
            if (icon) icon.style.display = 'inline-flex';
            /* Toutes les sections ouvertes par défaut */
            section.classList.add('sb-open');
            head.addEventListener('click', function () {
                section.classList.toggle('sb-open');
            });
        });
    }
})();
</script>
@endpush

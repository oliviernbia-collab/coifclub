@extends('layouts.app')

@section('title', 'Blog Beauté — Marol Hair Braiding')
@section('meta_description', __('messages.lp_blog_desc'))

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
:root{
    --rose:       #e91e8c;
    --rose-dark:  #c91a78;
    --rose-glow:  rgba(233,30,140,.18);
    --bg:         #0e0a1c;
    --card:       #1a1130;
    --card2:      #120e22;
    --text:       #fff;
    --muted:      rgba(255,255,255,.6);
    --border:     rgba(255,255,255,.07);
    --border-pk:  rgba(233,30,140,.18);
    --star:       #f5c518;
}

.blog-page {
    font-family:'DM Sans',sans-serif;
    color:var(--text);
    background:var(--bg);
}

/* ── HERO ── */
.blog-hero {
    background:linear-gradient(135deg,#0e0a1c 0%,#1a1130 55%,#120e22 100%);
    padding:90px 5% 80px;
    position:relative;
    overflow:hidden;
}
.blog-hero::before {
    content:'';
    position:absolute;
    top:-80px;
    right:-120px;
    width:500px;
    height:500px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.12),transparent 70%);
    pointer-events:none;
}
.blog-hero::after {
    content:'';
    position:absolute;
    bottom:-80px;
    left:-80px;
    width:300px;
    height:300px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.06),transparent 70%);
    pointer-events:none;
}
.blog-hero-inner {
    max-width:1200px;
    margin:auto;
    position:relative;
    z-index:2;
    display:grid;
    grid-template-columns:1fr 380px;
    gap:50px;
    align-items:center;
    text-align:left;
}
.blog-hero-text { display:flex; flex-direction:column; align-items:flex-start; }
.blog-hero-img-wrap {
    position:relative;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 24px 60px rgba(0,0,0,.35), 0 0 0 1px rgba(233,30,140,.2);
    flex-shrink:0;
}
.blog-hero-img-wrap img {
    width:100%;
    height:480px;
    object-fit:cover;
    object-position:top;
    display:block;
}
.blog-hero-img-wrap::after {
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(to top, rgba(14,10,28,.5), transparent 50%);
    pointer-events:none;
}
.blog-hero-stats { justify-content:flex-start; }
@media(max-width:900px){
    .blog-hero-inner { grid-template-columns:1fr; gap:28px; text-align:center; }
    .blog-hero-text { align-items:center; }
    .blog-hero-stats { justify-content:center; }
    .blog-hero-img-wrap img { height:280px; }
    .blog-hero-img-wrap { order:-1; }
}
.blog-hero-tag {
    font-size:.72rem;
    letter-spacing:3px;
    text-transform:uppercase;
    color:var(--rose);
    font-weight:700;
    margin-bottom:1rem;
    display:inline-flex;
    align-items:center;
    gap:8px;
}
.blog-hero-title {
    font-family:'Playfair Display',serif;
    font-size:clamp(2.2rem,5vw,3.8rem);
    font-weight:700;
    line-height:1.15;
    color:#fff;
    margin-bottom:1.2rem;
}
.blog-hero-title span { color:var(--rose); }
.blog-hero-desc {
    font-size:1rem;
    color:rgba(255,255,255,.7);
    line-height:1.8;
    max-width:600px;
    margin:0 auto 2.5rem;
}
.blog-hero-stats {
    display:flex;
    justify-content:center;
    gap:2.5rem;
    flex-wrap:wrap;
}
.hero-stat { text-align:center; }
.hero-stat-value {
    font-family:'Playfair Display',serif;
    font-size:1.8rem;
    font-weight:700;
    color:var(--rose);
    display:block;
}
.hero-stat-label {
    font-size:.78rem;
    color:rgba(255,255,255,.5);
    margin-top:2px;
}

/* ── SECTION HEADER ── */
.section-wrap {
    padding:5rem 5%;
    background:var(--bg);
}
.section-wrap.alt-bg { background:var(--card2); }
.section-inner { max-width:1200px; margin:auto; }
.section-tag {
    font-size:.72rem;
    letter-spacing:3px;
    text-transform:uppercase;
    color:var(--rose);
    font-weight:700;
    text-align:center;
    margin-bottom:.7rem;
}
.section-title {
    font-family:'Playfair Display',serif;
    font-size:2.2rem;
    font-weight:700;
    text-align:center;
    margin-bottom:.6rem;
    line-height:1.25;
    color:#fff;
}
.section-title span { color:var(--rose); }
.section-sub {
    font-size:.92rem;
    color:var(--muted);
    text-align:center;
    max-width:540px;
    margin:0 auto 3rem;
    line-height:1.7;
}

/* ── PRODUCT GRID ── */
.products-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(290px,1fr));
    gap:1.5rem;
}
.product-card {
    background:var(--card);
    border-radius:24px;
    border:1px solid var(--border-pk);
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,.25);
    transition:all .35s cubic-bezier(.4,0,.2,1);
    display:flex;
    flex-direction:column;
}
.product-card:hover {
    transform:translateY(-8px);
    box-shadow:0 18px 42px rgba(233,30,140,.2);
    border-color:var(--rose);
}
.product-img-wrap {
    position:relative;
    overflow:hidden;
    height:220px;
}
.product-img-wrap img {
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.5s ease;
}
.product-card:hover .product-img-wrap img { transform:scale(1.06); }
.product-badge {
    position:absolute;
    top:14px;
    left:14px;
    background:linear-gradient(135deg,var(--rose),var(--rose-dark));
    color:#fff;
    padding:5px 14px;
    border-radius:999px;
    font-size:.75rem;
    font-weight:700;
    letter-spacing:.03em;
    box-shadow:0 6px 16px rgba(233,30,140,.4);
}
.product-body {
    padding:1.5rem;
    flex:1;
    display:flex;
    flex-direction:column;
    gap:.5rem;
}
.product-name {
    font-family:'Playfair Display',serif;
    font-size:1.15rem;
    font-weight:700;
    color:#fff;
    line-height:1.3;
}
.product-desc { font-size:.83rem; color:var(--muted); line-height:1.7; flex:1; }
.product-footer {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:.8rem;
    padding-top:1rem;
    border-top:1px solid var(--border);
    margin-top:.5rem;
}
.product-price {
    font-family:'Playfair Display',serif;
    font-size:1.1rem;
    font-weight:700;
    color:var(--rose);
}
.product-stock { font-size:.75rem; font-weight:600; padding:4px 12px; border-radius:999px; }
.stock-in  { background:rgba(16,185,129,.15); color:#34d399; }
.stock-out { background:rgba(239,68,68,.12);  color:#f87171; }
.btn-product {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    border-radius:12px;
    background:var(--rose);
    color:#fff;
    font-size:.82rem;
    font-weight:700;
    text-decoration:none;
    transition:.25s ease;
    white-space:nowrap;
    box-shadow:0 6px 18px rgba(233,30,140,.3);
}
.btn-product:hover {
    background:var(--rose-dark);
    transform:translateY(-2px);
    color:#fff;
    text-decoration:none;
}

/* ── PROMO BANNER ── */
.promo-banner {
    background:linear-gradient(135deg,var(--rose),var(--rose-dark));
    border-radius:28px;
    padding:60px 40px;
    text-align:center;
    color:#fff;
    position:relative;
    overflow:hidden;
    margin-top:4rem;
}
.promo-banner::before {
    content:'';
    position:absolute;
    top:-60px;right:-80px;
    width:280px;height:280px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    pointer-events:none;
}
.promo-banner::after {
    content:'';
    position:absolute;
    bottom:-50px;left:-50px;
    width:200px;height:200px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    pointer-events:none;
}
.promo-inner { position:relative; z-index:2; max-width:680px; margin:auto; }
.promo-label {
    font-size:.72rem;
    letter-spacing:3px;
    text-transform:uppercase;
    opacity:.85;
    margin-bottom:.8rem;
    font-weight:700;
}
.promo-title {
    font-family:'Playfair Display',serif;
    font-size:clamp(1.8rem,3.5vw,2.8rem);
    font-weight:700;
    margin-bottom:1rem;
    line-height:1.2;
}
.promo-desc { font-size:.95rem; opacity:.9; line-height:1.8; margin-bottom:2rem; }
.btn-promo {
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:14px 32px;
    border-radius:12px;
    background:#fff;
    color:var(--rose);
    font-weight:700;
    font-size:.92rem;
    text-decoration:none;
    transition:.25s ease;
}
.btn-promo:hover {
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(0,0,0,.3);
    color:var(--rose);
    text-decoration:none;
}

/* ── TIPS ── */
.tips-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
    gap:1.3rem;
}
.tip-card {
    background:var(--card);
    border-radius:20px;
    padding:1.8rem;
    border:1px solid var(--border);
    box-shadow:0 4px 18px rgba(0,0,0,.2);
    transition:.3s ease;
}
.tip-card:hover {
    transform:translateY(-5px);
    box-shadow:0 14px 32px rgba(233,30,140,.15);
    border-color:var(--border-pk);
}
.tip-icon {
    width:52px;height:52px;
    border-radius:14px;
    background:var(--rose-glow);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.3rem;
    color:var(--rose);
    margin-bottom:1.2rem;
}
.tip-title {
    font-family:'Playfair Display',serif;
    font-size:1.05rem;
    font-weight:700;
    color:#fff;
    margin-bottom:.5rem;
}
.tip-text { font-size:.83rem; color:var(--muted); line-height:1.75; }

/* ── EMPTY STATE ── */
.empty-state {
    background:var(--card);
    border-radius:28px;
    padding:80px 30px;
    text-align:center;
    border:1px solid var(--border-pk);
    box-shadow:0 4px 20px rgba(0,0,0,.2);
}
.empty-icon { font-size:3.5rem; color:var(--rose); margin-bottom:1.2rem; opacity:.6; }
.empty-title {
    font-family:'Playfair Display',serif;
    font-size:1.6rem;
    font-weight:700;
    color:#fff;
    margin-bottom:.5rem;
}
.empty-text { color:var(--muted); font-size:.9rem; }

/* ── NEWSLETTER ── */
.newsletter-section { background:var(--card2); padding:5rem 5%; }
.newsletter-card {
    max-width:700px;
    margin:auto;
    background:var(--card);
    border-radius:28px;
    padding:52px 40px;
    text-align:center;
    border:1px solid var(--border-pk);
    box-shadow:0 8px 32px rgba(0,0,0,.25);
    position:relative;
    overflow:hidden;
}
.newsletter-card::before {
    content:'';
    position:absolute;
    top:-60px;right:-60px;
    width:200px;height:200px;
    border-radius:50%;
    background:var(--rose-glow);
    pointer-events:none;
}
.newsletter-inner { position:relative; z-index:2; }
.newsletter-icon {
    width:60px;height:60px;
    background:var(--rose-glow);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.4rem;
    color:var(--rose);
    margin:0 auto 1.5rem;
}
.newsletter-title {
    font-family:'Playfair Display',serif;
    font-size:1.9rem;
    font-weight:700;
    color:#fff;
    margin-bottom:.8rem;
}
.newsletter-title span { color:var(--rose); }
.newsletter-desc { color:var(--muted); line-height:1.8; margin-bottom:2rem; font-size:.93rem; }
.btn-newsletter {
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:14px 30px;
    border-radius:12px;
    background:var(--rose);
    color:#fff;
    font-weight:700;
    text-decoration:none;
    box-shadow:0 8px 22px rgba(233,30,140,.35);
    transition:.25s ease;
}
.btn-newsletter:hover {
    background:var(--rose-dark);
    transform:translateY(-3px);
    box-shadow:0 12px 28px rgba(233,30,140,.5);
    color:#fff;
    text-decoration:none;
}

/* ── RESPONSIVE ── */
@media (max-width:768px) {
    .blog-hero { padding:70px 5% 60px; }
    .blog-hero-stats { gap:1.5rem; }
    .products-grid { grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); }
    .promo-banner { padding:40px 24px; }
    .newsletter-card { padding:36px 24px; }
}
@media (max-width:480px) {
    .products-grid { grid-template-columns:1fr; }
    .tips-grid { grid-template-columns:1fr; }
}
</style>

<div class="blog-page">

    {{-- HERO --}}
    <div class="blog-hero">
        <div class="blog-hero-inner">
            <div class="blog-hero-text">
                <div class="blog-hero-tag">
                    <i class="fa-solid fa-scissors"></i>
                    {{ $salon->name ?? 'Marol Hair Braiding' }}
                </div>
                <h1 class="blog-hero-title">
                    Conseils <span>beauté</span><br>& astuces capillaires
                </h1>
                <p class="blog-hero-desc">
                    Découvrez les meilleures astuces de nos expertes pour sublimer
                    vos cheveux et prendre soin de votre beauté au quotidien.
                </p>
                <div class="blog-hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-value">Pro</span>
                        <span class="hero-stat-label">Qualité professionnelle</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-value">100%</span>
                        <span class="hero-stat-label">Conseils d'expertes</span>
                    </div>
                </div>
            </div>
            <div class="blog-hero-img-wrap">
                <img src="{{ asset('images/C00.jpg') }}" alt="Marol Hair Braiding">
            </div>
        </div>
    </div>

    {{-- BEAUTY TIPS --}}
    <div class="section-wrap alt-bg">
        <div class="section-inner">
            <div class="section-tag">Conseils beauté</div>
            <h2 class="section-title">Prenez soin de vos <span>cheveux</span></h2>
            <p class="section-sub">Nos expertes partagent leurs meilleures astuces pour des cheveux sublimes.</p>

            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon"><i class="fa-solid fa-droplet"></i></div>
                    <div class="tip-title">Hydratation quotidienne</div>
                    <div class="tip-text">Hydratez vos cheveux chaque jour avec des produits naturels adaptés à votre type capillaire pour un éclat permanent.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon"><i class="fa-solid fa-sun"></i></div>
                    <div class="tip-title">Protection solaire</div>
                    <div class="tip-text">Protégez vos cheveux des rayons UV avec des soins spéciaux. La chaleur et le soleil fragilisent la fibre capillaire.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon"><i class="fa-solid fa-scissors"></i></div>
                    <div class="tip-title">Coupe régulière</div>
                    <div class="tip-text">Une coupe tous les 6 à 8 semaines élimine les pointes abîmées et favorise une croissance saine et régulière.</div>
                </div>
                <div class="tip-card">
                    <div class="tip-icon"><i class="fa-solid fa-leaf"></i></div>
                    <div class="tip-title">Masques nourrissants</div>
                    <div class="tip-text">Appliquez un masque capillaire une fois par semaine pour nourrir en profondeur et restaurer la brillance naturelle.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- NEWSLETTER --}}
    <div class="newsletter-section">
        <div class="newsletter-card">
            <div class="newsletter-inner">
                <div class="newsletter-icon"><i class="fa-solid fa-paper-plane"></i></div>
                <h2 class="newsletter-title">Nos <span>astuces beauté</span></h2>
                <p class="newsletter-desc">
                    Rejoignez notre communauté et recevez les dernières tendances coiffure,
                    nos offres exclusives et conseils capillaires directement dans votre espace.
                </p>
                <a href="{{ route('login') }}" class="btn-newsletter">
                    <i class="fa-solid fa-star"></i>
                    Rejoindre la communauté
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamSalon — Salon de coiffure premium Abidjan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{--rose:#c87e5a;--rose-light:#fdf0e8;--text:#1c1210;--muted:#6b4c38;}
        body{font-family:'DM Sans',sans-serif;color:var(--text);}
        .serif{font-family:'Playfair Display',serif}

        /* Nav */
        nav{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-bottom:1px solid #f0e6da;padding:0 5%;height:66px;display:flex;align-items:center;justify-content:space-between;}
        .nav-logo{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--rose);text-decoration:none;}
        .nav-links{display:flex;align-items:center;gap:2rem;}
        .nav-links a{font-size:.85rem;font-weight:500;color:var(--muted);text-decoration:none;transition:.2s;}
        .nav-links a:hover{color:var(--rose);}
        .btn-nav{background:var(--rose);color:#fff;padding:9px 22px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:500;text-decoration:none;transition:.2s;}
        .btn-nav:hover{background:#b36d49;transform:translateY(-1px);}

        /* Hero */
        .hero{min-height:100vh;display:flex;align-items:center;padding:66px 5% 4rem;background:linear-gradient(135deg,#fff 0%,#fdf6f0 50%,#fdf0e8 100%);position:relative;overflow:hidden;}
        .hero::before{content:'';position:absolute;top:-50px;right:-100px;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(200,126,90,.12),transparent);pointer-events:none;}
        .hero-content{max-width:560px;}
        .hero-tag{font-size:.75rem;letter-spacing:3px;text-transform:uppercase;color:var(--rose);font-weight:600;margin-bottom:1rem;}
        .hero-title{font-family:'Playfair Display',serif;font-size:3.2rem;font-weight:700;line-height:1.15;margin-bottom:1.2rem;}
        .hero-title span{color:var(--rose);}
        .hero-desc{font-size:1rem;color:var(--muted);line-height:1.7;margin-bottom:2rem;max-width:440px;}
        .hero-btns{display:flex;gap:1rem;flex-wrap:wrap;}
        .btn-hero{padding:13px 30px;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:500;text-decoration:none;transition:.2s;display:inline-flex;align-items:center;gap:8px;}
        .btn-hero-primary{background:var(--rose);color:#fff;box-shadow:0 6px 20px rgba(200,126,90,.35);}
        .btn-hero-primary:hover{background:#b36d49;transform:translateY(-2px);}
        .btn-hero-outline{background:transparent;color:var(--rose);border:2px solid var(--rose);}
        .btn-hero-outline:hover{background:var(--rose-light);}
        .hero-badges{display:flex;gap:1.5rem;margin-top:2.5rem;flex-wrap:wrap;}
        .hero-badge{display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:var(--muted);}
        .hero-badge i{color:var(--rose);}

        /* Sections */
        section{padding:5rem 5%;}
        .section-tag{font-size:.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--rose);font-weight:600;text-align:center;margin-bottom:.7rem;}
        .section-title{font-family:'Playfair Display',serif;font-size:2.2rem;text-align:center;margin-bottom:3rem;line-height:1.25;}
        .section-title span{color:var(--rose);}

        /* Services */
        .services-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
            gap:1.3rem;
            max-width:1100px;
            margin:0 auto;
        }
        .service-card{
            background:#fff;
            border-radius:24px;
            padding:1.8rem;
            border:1px solid rgba(240,230,218,.85);
            text-align:center;
            transition:all .35s cubic-bezier(.4,0,.2,1);
            cursor:pointer;
            position:relative;
            overflow:hidden;
            box-shadow:0 4px 18px rgba(200,126,90,.08),0 2px 8px rgba(0,0,0,.05);
        }
        .service-card::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:linear-gradient(135deg,rgba(248,238,225,.18),rgba(255,255,255,0));
            opacity:0;
            transition:opacity .35s ease;
            pointer-events:none;
        }
        .service-card:hover{
            transform:translateY(-8px) scale(1.02);
            box-shadow:0 18px 40px rgba(200,126,90,.16),0 8px 22px rgba(0,0,0,.08);
            border-color:var(--rose);
        }
        .service-card:hover::before{
            opacity:1;
        }
        .service-emoji{
            font-size:2.5rem;
            margin-bottom:1rem;
            text-shadow:0 4px 16px rgba(200,126,90,.1);
        }
        .service-cat{
            font-size:.72rem;
            background:rgba(200,126,90,.12);
            color:var(--rose);
            padding:4px 12px;
            border-radius:999px;
            font-weight:700;
            letter-spacing:.06em;
            display:inline-block;
            margin-bottom:.9rem;
        }
        .service-name{
            font-size:1.05rem;
            font-weight:700;
            color:#432a24;
            margin:.8rem 0 .4rem;
            transition:color .35s ease;
        }
        .service-card:hover .service-name{
            color:var(--rose);
        }
        .service-desc{
            font-size:.83rem;
            color:var(--muted);
            line-height:1.75;
            min-height:3.3em;
            margin-bottom:1.2rem;
        }
        .service-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:.8rem;
            margin-top:1.2rem;
            padding-top:1rem;
            border-top:1px solid rgba(240,230,218,.8);
        }
        .service-price{
            font-weight:800;
            color:var(--rose);
            font-size:1rem;
        }
        .service-dur{
            font-size:.78rem;
            color:var(--muted);
            display:inline-flex;
            align-items:center;
            gap:.4rem;
        }
        .btn-reserve{
            background:var(--rose);
            color:#fff;
            border:none;
            padding:11px 18px;
            border-radius:14px;
            font-family:'DM Sans',sans-serif;
            font-size:.85rem;
            cursor:pointer;
            width:100%;
            margin-top:1rem;
            transition:transform .25s ease,box-shadow .25s ease,background .25s ease;
            font-weight:600;
            box-shadow:0 12px 24px rgba(200,126,90,.18);
        }
        .btn-reserve:hover{
            background:#b36d49;
            transform:translateY(-2px);
            box-shadow:0 14px 26px rgba(200,126,90,.22);
        }

        /* Team */
        .team-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:900px;margin:0 auto;}
        .team-card{background:#fff;border-radius:16px;padding:2rem;border:1px solid #f0e6da;text-align:center;}
        .team-avatar{width:80px;height:80px;border-radius:50%;background:var(--rose-light);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--rose);margin:0 auto 1rem;}
        .team-name{font-weight:600;font-size:1rem;margin-bottom:.3rem;}
        .team-spec{font-size:.8rem;color:var(--rose);margin-bottom:.5rem;}
        .team-rating{font-size:.8rem;color:var(--muted);}

        /* Témoignages */
        .reviews-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;max-width:1000px;margin:0 auto;}
        .review-card{background:#fff;border-radius:14px;padding:1.5rem;border:1px solid #f0e6da;}
        .review-stars{font-size:1rem;margin-bottom:.8rem;}
        .review-text{font-size:.85rem;color:var(--muted);line-height:1.6;margin-bottom:1rem;font-style:italic;}
        .review-author{font-weight:600;font-size:.82rem;}

        /* CTA -->
        .cta-section{background:linear-gradient(135deg,#c87e5a,#b36d49);padding:5rem;text-align:center;color:#fff;}
        .cta-title{font-family:'Playfair Display',serif;font-size:2.5rem;margin-bottom:1rem;}
        .cta-desc{font-size:1rem;opacity:.9;margin-bottom:2rem;}
        .btn-cta{background:#fff;color:var(--rose);padding:14px 36px;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:600;text-decoration:none;transition:.2s;display:inline-block;}
        .btn-cta:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.2);}

        /* Footer */
        footer{background:#1c1210;color:#e0c9bc;padding:3rem 5%;display:grid;grid-template-columns:2fr 1fr 1fr;gap:3rem;}
        .footer-logo{font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--rose);margin-bottom:.8rem;}
        .footer-desc{font-size:.8rem;line-height:1.7;opacity:.7;}
        .footer-title{font-size:.8rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--rose);margin-bottom:1rem;}
        .footer-link{display:block;font-size:.8rem;color:#c0a090;text-decoration:none;margin-bottom:.4rem;transition:.2s;}
        .footer-link:hover{color:var(--rose);}
        .footer-bottom{background:#150e0c;padding:1rem 5%;text-align:center;font-size:.75rem;color:#7a5a4a;}


        .topbar-logo img{
            width:20%;
            height:20%;
            object-fit:cover;
            border-radius:10%;
        }
    </style>
</head>
<body>

<!-- Nav -->
<nav>
    <a href="{{ route('home') }}" class="topbar-logo">
        <img src="{{ asset('images/C4.jpg') }}" ">
    </a>
    <div class="nav-links">
        <a href="{{ route('services.index') }}">Prestations</a>
        <a href="{{ route('gallery') }}">Galerie</a>
        <a href="{{ route('contact') }}">Contact</a>
        @auth
        <a href="{{ route('redirect') }}" class="btn-nav">Mon espace</a>
        @else
        <a href="{{ route('login') }}" style="color:var(--muted);">Connexion</a>
        <a href="{{ route('booking.quick') }}" class="btn-nav"><i class="ti ti-calendar-plus"></i> Réserver</a>
        @endauth
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-tag">✦ Salon premium · Abidjan, Côte d'Ivoire</div>
        <h1 class="hero-title">Votre beauté,<br>notre <span>passion</span></h1>
        <p class="hero-desc">Réservez vos soins capillaires en ligne, choisissez votre coiffeuse et payez simplement. Disponible 24h/24.</p>
        <div class="hero-btns">
            <a href="{{ route('booking.quick') }}" class="btn-hero btn-hero-primary">
                <i class="ti ti-calendar-plus"></i> Réserver maintenant
            </a>
            <a href="{{ route('services.index') }}" class="btn-hero btn-hero-outline">
                Voir les prestations
            </a>
        </div>
        <div class="hero-badges">
            <div class="hero-badge"><i class="ti ti-star-filled"></i> 4.9/5 · 200+ avis</div>
            <div class="hero-badge"><i class="ti ti-shield-check"></i> Paiement sécurisé</div>
            <div class="hero-badge"><i class="ti ti-clock"></i> Réponse en 30min</div>
        </div>
    </div>
</section>

<!-- Prestations -->
<section style="background:#f9f4ef;">
    <div class="section-tag">Nos services</div>
    <h2 class="section-title">Nos <span>prestations</span></h2>
    <div class="services-grid">
        @foreach($services as $s)
        <div class="service-card">
            <div class="service-emoji">{{ $s->emoji }}</div>
            <div class="service-cat">{{ $s->category }}</div>
            <div class="service-name">{{ $s->name }}</div>
            <div class="service-desc">{{ Str::limit($s->description, 60) }}</div>
            <div class="service-footer">
                <span class="service-price">{{ $s->formatted_price }}</span>
                <span class="service-dur"><i class="ti ti-clock" style="font-size:.8rem;"></i> {{ $s->formatted_duration }}</span>
            </div>
            <a href="{{ route('booking.quick') }}" style="text-decoration:none;"><button class="btn-reserve">Réserver</button></a>
        </div>
        @endforeach
    </div>
</section>

<!-- Notre équipe -->
<section style="background:#fff;">
    <div class="section-tag">L'équipe</div>
    <h2 class="section-title">Nos <span>coiffeuses</span></h2>
    <div class="team-grid">
        @foreach($employees ?? collect() as $e)
        <div class="team-card">
            <div class="team-avatar">{{ strtoupper(substr($e->user->name,0,1)) }}{{ strtoupper(substr(explode(' ',$e->user->name)[1]??'',0,1)) }}</div>
            <div class="team-name">{{ $e->user->name }}</div>
            <div class="team-spec">{{ $e->specialty }}</div>
            <div class="team-rating">⭐ {{ number_format($e->average_rating,1) }} · Experte confirmée</div>
        </div>
        @endforeach
    </div>
</section>

<!-- Témoignages -->
@if($reviews->count() > 0)
<section style="background:#f9f4ef;">
    <div class="section-tag">Témoignages</div>
    <h2 class="section-title">Ce que disent <span>nos clientes</span></h2>
    <div class="reviews-grid">
        @foreach($reviews as $r)
        <div class="review-card">
            <div class="review-stars">{{ $r->stars }}</div>
            <div class="review-text">"{{ $r->comment }}"</div>
            <div class="review-author">{{ $r->client->name }}</div>
            <div style="font-size:.72rem;color:var(--muted);">{{ $r->service->name }}</div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- CTA -->
<div class="cta-section">
    <h2 class="cta-title">Prête à vous faire chouchouter ?</h2>
    <p class="cta-desc">Réservez en ligne en 2 minutes, payez avec Orange Money, MTN ou Wave.</p>
    <a href="{{ route('booking.quick') }}" class="btn-cta">
        <i class="ti ti-calendar-plus" style="margin-right:6px;"></i>Réserver mon rendez-vous
    </a>
</div>

<!-- Footer -->
<footer>
    <div>
        <div class="footer-logo">✦ GlamSalon</div>
        <p class="footer-desc">Votre salon de coiffure premium à Abidjan. Réservation en ligne, paiement mobile, expertise garantie.</p>
    </div>
    <div>
        <div class="footer-title">Navigation</div>
        <a href="{{ route('home') }}" class="footer-link">{{ __('messages.home') }}</a>
        <a href="{{ route('services.index') }}" class="footer-link">{{ __('messages.services') }}</a>
        <a href="{{ route('gallery') }}" class="footer-link">{{ __('messages.gallery') }}</a>
        <a href="{{ route('contact') }}" class="footer-link">{{ __('messages.contact') }}</a>
    </div>
    <div>
        <div class="footer-title">Contact</div>
        <div class="footer-link">📍 Cocody Angré, Abidjan</div>
        <div class="footer-link">📞 +225 07 00 00 00</div>
        <div class="footer-link">✉️ contact@glamsalon.ci</div>
        <div class="footer-link">🕐 Lun–Sam : 08h–18h</div>
    </div>
</footer>
<div class="footer-bottom">© {{ date('Y') }} GlamSalon · Tous droits réservés · Made with ❤️ in Abidjan</div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.auth_default_title')) — {{ __('messages.brand_name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Outfit:wght@300;400;500;600&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
    /* ══════════════════════════════════════════════════════════════
       RESET & TOKENS
    ══════════════════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --gold:         #e91e8c;
        --gold-light:   #ff6ab4;
        --gold-dim:     rgba(233,30,140,.13);
        --gold-border:  rgba(233,30,140,.25);

        --bg:           #0e0a1c;
        --surface-card: rgba(18,14,34,.97);
        --input-bg:     rgba(255,255,255,.04);
        --input-focus:  rgba(233,30,140,.06);

        --text-main:    #ffffff;
        --text-soft:    rgba(255,255,255,.6);
        --text-muted:   rgba(255,255,255,.35);

        --border:       rgba(233,30,140,.2);
        --border-focus: rgba(233,30,140,.65);
        --radius:       12px;
        --radius-lg:    20px;
        --ease:         cubic-bezier(.4,0,.2,1);
        --ease-spring:  cubic-bezier(.34,1.56,.64,1);
    }

    html, body { height: 100%; }

    body {
        font-family: 'Outfit', sans-serif;
        background: var(--bg);
        overflow-x: hidden;
        color: var(--text-main);
    }

    /* ══════════════════════════════════════════════════════════════
       SPLIT LAYOUT
    ══════════════════════════════════════════════════════════════ */
    .auth-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
    }

    /* ── LEFT PANEL ─────────────────────────────────────────────── */
    .auth-panel {
        position: sticky;
        top: 0;
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 48px 52px;
    }

    /* Slideshow inside left panel */
    .bg-stage {
        position: absolute;
        inset: 0;
        z-index: 0;
    }
    .bg-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.05);
        transition: opacity 1.4s var(--ease), transform 8s linear;
    }
    .bg-slide.active { opacity: 1; transform: scale(1); }
    .bg-slide:nth-child(1) { background-image: url('/images/C34.jpg'); }
    .bg-slide:nth-child(2) { background-image: url('/images/C44.jpg'); }
    .bg-slide:nth-child(3) { background-image: url('/images/C45.jpg'); }

    .panel-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        background:
            linear-gradient(to top, rgba(14,10,28,.97) 0%, rgba(14,10,28,.6) 45%, rgba(14,10,28,.2) 100%),
            linear-gradient(to right, rgba(14,10,28,.4), transparent 60%);
    }

    .bg-grain {
        position: absolute;
        inset: 0;
        z-index: 2;
        opacity: .03;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)'/%3E%3C/svg%3E");
        pointer-events: none;
    }

    .panel-content {
        position: relative;
        z-index: 5;
        color: var(--text-main);
    }

    .panel-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 36px;
    }
    .panel-brand-icon {
        width: 58px; height: 58px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        border: 2.5px solid rgba(233,30,140,.55);
        box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 20px rgba(0,0,0,.5);
    }
    .panel-brand-icon img {
        width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .panel-brand-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 21px;
        font-weight: 400;
        color: var(--text-main);
        letter-spacing: .04em;
        line-height: 1.2;
    }
    .panel-brand-name em { font-style: italic; color: var(--gold-light); }
    .panel-brand-tag {
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(245,234,216,.38);
        margin-top: 2px;
    }

    .panel-headline {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        font-weight: 300;
        line-height: 1.12;
        color: var(--text-main);
        margin-bottom: 14px;
    }
    .panel-headline strong {
        font-weight: 600;
        background: linear-gradient(135deg, #e91e8c, #ff6ab4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .panel-sub {
        font-size: 13px;
        color: rgba(245,234,216,.45);
        line-height: 1.75;
        margin-bottom: 28px;
        max-width: 340px;
    }

    .panel-features {
        display: flex;
        flex-direction: column;
        gap: 11px;
        margin-bottom: 32px;
    }
    .pf-item {
        display: flex;
        align-items: center;
        gap: 13px;
        font-size: 13px;
        color: rgba(245,234,216,.65);
    }
    .pf-check {
        width: 22px; height: 22px;
        border-radius: 50%;
        background: rgba(233,30,140,.1);
        border: 1px solid rgba(233,30,140,.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e91e8c;
        font-size: 9px;
        flex-shrink: 0;
    }

    .panel-rating {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 24px;
        border-top: 1px solid rgba(233,30,140,.15);
    }
    .panel-stars {
        color: #e91e8c;
        font-size: 13px;
        letter-spacing: 2px;
    }
    .panel-rating-text {
        font-size: 12px;
        color: rgba(245,234,216,.4);
    }

    /* ── RIGHT PANEL ─────────────────────────────────────────────── */
    .auth-right {
        background: #120e22;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 56px 40px;
        min-height: 100vh;
    }

    /* ── AUTH CARD ─────────────────────────────────────────────── */
    .auth-card {
        position: relative;
        width: 100%;
        max-width: 440px;
        background: rgba(233,30,140,.04);
        border: 1px solid rgba(233,30,140,.15);
        border-radius: var(--radius-lg);
        padding: 40px 36px 32px;
        box-shadow:
            0 0 0 1px rgba(233,30,140,.06),
            0 32px 64px rgba(0,0,0,.5),
            inset 0 1px 0 rgba(255,255,255,.03);
        animation: card-in .7s var(--ease) both;
    }

    /* Pink top line */
    .auth-card::before {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 1.5px;
        border-radius: 0 0 4px 4px;
        background: linear-gradient(to right, transparent, #e91e8c 40%, #ff6ab4 60%, transparent);
        opacity: .8;
    }

    @keyframes card-in {
        from { opacity: 0; transform: translateY(24px) scale(.99); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── BRAND ─────────────────────────────────────────── */
    .brand {
        text-align: center;
        margin-bottom: 26px;
        animation: fade-up .6s .1s var(--ease) both;
    }

    .brand-icon {
        display: inline-block;
        width: 62px; height: 62px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 14px;
        border: 2.5px solid rgba(233,30,140,.55);
        box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 20px rgba(0,0,0,.4);
    }
    .brand-icon img {
        width: 100%; height: 100%; object-fit: cover; display: block;
    }

    .brand-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 26px;
        font-weight: 400;
        color: var(--text-main);
        letter-spacing: .04em;
        line-height: 1.1;
    }
    .brand-name em { font-style: italic; color: var(--gold-light); }

    .brand-tagline {
        margin-top: 6px;
        font-size: 10.5px;
        font-weight: 400;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .brand-rule {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 16px auto 0;
        max-width: 180px;
        color: var(--gold);
        font-size: 9px;
        letter-spacing: 2px;
    }
    .brand-rule::before, .brand-rule::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── FORM ELEMENTS ─────────────────────────────────── */
    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
        animation: fade-up .65s .2s var(--ease) both;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .field label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold);
        transition: color .2s;
    }
    .field:focus-within label { color: var(--gold-light); }

    .input-wrap { position: relative; }

    .input-wrap .icon-left {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(233,30,140,.35);
        font-size: 13px;
        pointer-events: none;
        transition: color .2s;
    }
    .input-wrap:focus-within .icon-left { color: var(--gold); }

    .input-wrap .icon-right {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 13px;
        padding: 0;
        transition: color .2s;
        line-height: 1;
    }
    .input-wrap .icon-right:hover { color: var(--gold-light); }

    .form-control {
        width: 100%;
        height: 44px;
        padding: 0 42px;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        background: var(--input-bg);
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        outline: none;
        transition:
            border-color .25s var(--ease),
            background .25s var(--ease),
            box-shadow .25s var(--ease);
    }
    .form-control::placeholder { color: var(--text-muted); font-size: 13px; }
    .form-control:focus {
        border-color: var(--border-focus);
        background: var(--input-focus);
        box-shadow: 0 0 0 3px var(--gold-dim), 0 4px 18px rgba(233,30,140,.05);
    }

    .field-error {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: #E87070;
        margin-top: 2px;
    }

    /* ── AUTH OPTIONS (remember / forgot) ─────────────── */
    .auth-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        margin-top: -4px;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-soft);
        user-select: none;
    }
    .remember input { display: none; }
    .remember-box {
        width: 16px; height: 16px;
        border: 1px solid var(--border);
        border-radius: 4px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        transition: background .2s, border-color .2s;
    }
    .remember input:checked ~ .remember-box {
        background: var(--gold);
        border-color: var(--gold);
    }
    .remember input:checked ~ .remember-box::after {
        content: '✓';
        font-size: 10px;
        font-weight: 700;
        color: #111;
    }

    .link-forgot {
        color: rgba(212,175,55,.65);
        text-decoration: none;
        font-size: 12px;
        transition: color .2s;
    }
    .link-forgot:hover { color: var(--gold); }

    /* ── SUBMIT BUTTON ─────────────────────────────────── */
    .btn-auth {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 50px;
        border: none;
        border-radius: var(--radius);
        background: linear-gradient(135deg, #e91e8c 0%, #ff6ab4 50%, #e91e8c 100%);
        background-size: 200% auto;
        color: #ffffff;
        font-family: 'DM Sans', 'Outfit', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        cursor: pointer;
        transition:
            background-position .55s var(--ease),
            box-shadow .3s var(--ease),
            transform .2s var(--ease-spring);
        box-shadow:
            0 4px 24px rgba(233,30,140,.35),
            inset 0 1px 0 rgba(255,255,255,.2);
    }
    .btn-auth:hover {
        background-position: right center;
        box-shadow: 0 8px 36px rgba(233,30,140,.5);
        transform: translateY(-1px);
    }
    .btn-auth:active { transform: translateY(0); }

    /* Shimmer sweep */
    .btn-auth::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,.22) 50%, transparent 70%);
        transform: translateX(-120%);
        transition: transform .6s var(--ease);
    }
    .btn-auth:hover::after { transform: translateX(120%); }

    /* ── SECURITY BADGE ────────────────────────────────── */
    .auth-secure {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin-top: 18px;
        font-size: 10.5px;
        color: var(--text-muted);
        letter-spacing: .3px;
    }
    .auth-secure i { color: rgba(233,30,140,.6); font-size: 10px; }

    /* ── FOOTER ────────────────────────────────────────── */
    .auth-footer {
        margin-top: 22px;
        text-align: center;
        font-size: 12.5px;
        color: var(--text-muted);
        animation: fade-up .65s .3s var(--ease) both;
        line-height: 1.9;
    }
    .auth-footer a {
        color: var(--gold-light);
        text-decoration: none;
        font-weight: 500;
        transition: color .2s;
    }
    .auth-footer a:hover { color: var(--gold); }

    /* ── DIVIDER ───────────────────────────────────────── */
    .auth-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .auth-divider::before, .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--border), transparent);
    }

    /* ── MOBILE ────────────────────────────────────────── */
    @media (max-width: 920px) {
        .auth-split { grid-template-columns: 1fr; }
        .auth-panel { display: none; }
        .auth-right {
            background: linear-gradient(160deg, #0e0a1c 0%, #120e22 100%);
            padding: 36px 20px;
        }
        .auth-card { padding: 36px 24px 28px; }
    }

    /* ── ANIMATIONS ────────────────────────────────────── */
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── SCROLLBAR ─────────────────────────────────────── */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    </style>

    @stack('styles')
</head>
<body>

    <div class="auth-split">

        {{-- ── LEFT PANEL (brand + slideshow) ──────────────────── --}}
        <div class="auth-panel" aria-hidden="true">

            <div class="bg-stage">
                <div class="bg-slide active"></div>
                <div class="bg-slide"></div>
                <div class="bg-slide"></div>
                {{-- <div class="bg-slide"></div> --}}
            </div>
            <div class="panel-overlay"></div>
            <div class="bg-grain"></div>

            <div class="panel-content">

                <div class="panel-brand">
                    <div class="panel-brand-icon">
                        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
                    </div>
                    <div>
                        <div class="panel-brand-name">{{ __('messages.auth_brand_first') }} <em>{{ __('messages.auth_brand_em') }}</em></div>
                        <div class="panel-brand-tag">{{ __('messages.auth_panel_tag') }}</div>
                    </div>
                </div>

                <h2 class="panel-headline">
                    {{ __('messages.auth_panel_headline_1') }}<br>
                    <strong>{{ __('messages.auth_panel_headline_2') }}</strong>
                </h2>

                <p class="panel-sub">
                    {{ __('messages.auth_panel_sub') }}
                </p>

                <div class="panel-features">
                    <div class="pf-item">
                        <div class="pf-check"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.auth_feature_1') }}
                    </div>
                    <div class="pf-item">
                        <div class="pf-check"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.auth_feature_2') }}
                    </div>
                    <div class="pf-item">
                        <div class="pf-check"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.auth_feature_3') }}
                    </div>
                    <div class="pf-item">
                        <div class="pf-check"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.auth_feature_4') }}
                    </div>
                </div>

                <div class="panel-rating">
                    <span class="panel-stars">★★★★★</span>
                    <span class="panel-rating-text">{{ __('messages.auth_rating_text') }}</span>
                </div>

            </div>
        </div>

        {{-- ── RIGHT PANEL (auth card) ────────────────────────── --}}
        <div class="auth-right">
            <div class="auth-card">

                {{-- Brand --}}
                <div class="brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
                    </div>
                    <h1 class="brand-name">{{ __('messages.auth_brand_first') }} <em>{{ __('messages.auth_brand_em') }}</em></h1>
                    <p class="brand-tagline">{{ __('messages.auth_card_tagline') }}</p>
                    <div class="brand-rule">✦</div>
                </div>

                {{-- Page content --}}
                @yield('content')

                {{-- Security badge --}}
                <div class="auth-secure">
                    <i class="fa-solid fa-shield-halved"></i>
                    {{ __('messages.auth_secure_text') }}
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    (function () {
        const slides = document.querySelectorAll('.bg-slide');
        let idx = 0;
        function next() {
            slides[idx].classList.remove('active');
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('active');
        }
        setInterval(next, 4000);
    })();
    </script>

    @stack('scripts')
    @include('partials.toast')
</body>
</html>

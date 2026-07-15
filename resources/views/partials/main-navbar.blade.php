{{--
    partials/main-navbar.blade.php
    Self-contained dark-pink top navbar for all layouts.
    Uses .mnav-* prefix to avoid CSS conflicts with sidebar layouts.
--}}
<style>
/* ── GOOGLE FONTS (if not already loaded) ── */
/* Loaded here for layouts that don't have Cormorant Garamond */

/* ── RESET for navbar zone ── */
.mnav-bar *, .mnav-drawer * { box-sizing: border-box; }

/* ── OVERLAY ── */
.mnav-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(14,10,28,.6);
    z-index: 9800;
    backdrop-filter: blur(2px);
}
.mnav-overlay.open { display: block; }

/* ── DRAWER ── */
.mnav-drawer {
    position: fixed;
    top: 0; right: -360px;
    width: 340px;
    height: 100dvh;
    background: #120e22;
    z-index: 9900;
    transition: right .38s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-left: 1px solid rgba(233,30,140,.15);
}
.mnav-drawer.open { right: 0; }

.mnav-dhdr {
    background: linear-gradient(145deg, #1a1030, #120e22);
    padding: 28px 24px 24px;
    flex-shrink: 0;
    border-bottom: 1px solid rgba(233,30,140,.12);
}
.mnav-dhdr-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.mnav-dbrand {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}
.mnav-dbrand i { color: #e91e8c; }
.mnav-dclose {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,.08);
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: .2s;
}
.mnav-dclose:hover { background: rgba(233,30,140,.2); }

.mnav-dprofile { display: flex; align-items: center; gap: 14px; }
.mnav-davatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    border: 2.5px solid rgba(233,30,140,.5);
    background: linear-gradient(135deg, #e91e8c, #c91a78);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 17px; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}
.mnav-davatar img { width: 100%; height: 100%; object-fit: cover; }
.mnav-dname { font-size: 15px; font-weight: 600; color: white; }
.mnav-drole { font-size: 11px; color: rgba(255,255,255,.5); margin-top: 3px; }

.mnav-dbody {
    flex: 1; overflow-y: auto; padding: 20px 16px;
    scrollbar-width: thin; scrollbar-color: rgba(233,30,140,.3) transparent;
}
.mnav-dbody::-webkit-scrollbar { width: 6px; }
.mnav-dbody::-webkit-scrollbar-thumb { background: rgba(233,30,140,.3); border-radius: 99px; }

.mnav-dsect {
    font-size: 10px; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: rgba(255,255,255,.3);
    padding: 0 8px; margin: 16px 0 8px;
}
.mnav-dsect:first-child { margin-top: 0; }

.mnav-dlink {
    display: flex; align-items: center; gap: 12px;
    text-decoration: none; color: rgba(255,255,255,.8);
    padding: 12px 14px; border-radius: 14px;
    font-size: 14px; font-weight: 500;
    transition: .22s; margin-bottom: 2px;
}
.mnav-dlink-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(255,255,255,.07);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.45); font-size: 15px;
    flex-shrink: 0; transition: .22s;
}
.mnav-dlink:hover { background: rgba(233,30,140,.1); color: #e91e8c; }
.mnav-dlink:hover .mnav-dlink-icon { background: rgba(233,30,140,.2); color: #e91e8c; }
.mnav-dlink.active { background: #e91e8c; color: white; }
.mnav-dlink.active .mnav-dlink-icon { background: rgba(255,255,255,.2); color: white; }

.mnav-dlang {
    display: flex; gap: 6px; margin-top: 8px; padding: 0 8px;
}
.mnav-dlang a {
    flex: 1; text-align: center; padding: 9px 4px;
    border-radius: 10px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: .2s;
}

.mnav-dftr {
    padding: 16px 20px 24px;
    border-top: 1px solid rgba(255,255,255,.08);
    flex-shrink: 0;
}
.mnav-dlogout {
    width: 100%; border: none;
    background: rgba(233,30,140,.1); color: #e91e8c;
    padding: 13px 18px; border-radius: 14px;
    font-size: 14px; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: .25s;
}
.mnav-dlogout:hover { background: #e91e8c; color: white; }

/* ── TOP NAVBAR ── */
.mnav-bar {
    background: #100c20;
    padding: 0 44px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9700;
    height: 78px;
    border-bottom: 1px solid rgba(233,30,140,.15);
    box-shadow: 0 2px 28px rgba(0,0,0,.4), 0 1px 0 rgba(233,30,140,.08);
    gap: 16px;
    font-family: 'DM Sans', 'Inter', sans-serif;
}

/* Logo */
.mnav-logo {
    text-decoration: none;
    display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
}
.mnav-logo-badge {
    width: 58px; height: 58px;
    border-radius: 50%; overflow: hidden; flex-shrink: 0;
    border: 2.5px solid rgba(233,30,140,.55);
    box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 16px rgba(0,0,0,.4);
    transition: transform .3s, box-shadow .3s;
}
.mnav-logo-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 0 0 4px rgba(233,30,140,.28), 0 6px 20px rgba(0,0,0,.5);
}
.mnav-logo-badge img { width: 100%; height: 100%; object-fit: cover; display: block; }
.mnav-brand-text { line-height: 1.1; }
.mnav-brand-name {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: 20px; font-weight: 800; color: #ffffff;
    letter-spacing: .04em; text-transform: uppercase; display: block;
}
.mnav-brand-sub {
    font-size: 10px; font-weight: 700; color: rgba(255,255,255,.75);
    letter-spacing: .18em; text-transform: uppercase; display: block; margin-top: 1px;
}
.mnav-brand-tag {
    font-size: 9px; color: rgba(255,255,255,.35);
    letter-spacing: .22em; text-transform: uppercase;
    font-weight: 500; display: block; margin-top: 1px;
}

/* Links */
.mnav-links {
    display: flex; align-items: center; gap: 2px;
    flex: 1; justify-content: center;
}
.mnav-link {
    text-decoration: none; color: rgba(255,255,255,.8);
    font-size: 13px; font-weight: 500;
    padding: 8px 14px; border-radius: 10px;
    transition: background .2s, color .2s;
    display: flex; align-items: center; gap: 6px;
    letter-spacing: .015em; white-space: nowrap;
}
.mnav-link i { font-size: 11px; color: rgba(255,255,255,.35); transition: color .2s; }
.mnav-link:hover { background: rgba(233,30,140,.1); color: #e91e8c; }
.mnav-link:hover i { color: #e91e8c; }
.mnav-link.active {
    background: rgba(233,30,140,.15); color: #e91e8c;
    font-weight: 600; box-shadow: 0 2px 10px rgba(233,30,140,.15);
}
.mnav-link.active i { color: #e91e8c; }

/* Cart */
.mnav-cart {
    position: relative; width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.65);
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; transition: .2s; flex-shrink: 0;
}
.mnav-cart:hover { border-color: #e83e8c; color: #e83e8c; background: rgba(232,62,140,.1); }
.mnav-cart-badge {
    position: absolute; top: -5px; right: -5px;
    min-width: 17px; height: 17px; border-radius: 999px;
    background: #e83e8c; color: #fff;
    font-size: 9px; font-weight: 700; line-height: 17px; text-align: center;
    padding: 0 3px; border: 2px solid #1a1a2e;
}

/* Likes pill (next to language selector) */
.mnav-likes-pill {
    display: flex; align-items: center; gap: 6px;
    border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
    padding: 6px 12px; font-size: 13px; font-weight: 700;
    color: rgba(255,255,255,.75); background: rgba(255,255,255,.06);
    transition: .2s; flex-shrink: 0; margin-left: 2px;
}
.mnav-likes-pill:hover { border-color: #e83e8c; color: #e83e8c; background: rgba(232,62,140,.1); }
.mnav-likes-pill i { color: #e83e8c; font-size: 13px; }

/* Lang pill (home-style dropdown) */
.mnav-lang-wrap { position: relative; margin-left: 2px; }
.mnav-lang-pill {
    display: flex; align-items: center; gap: 5px;
    border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
    padding: 5px 11px 5px 8px; font-size: 13px; font-weight: 600;
    color: rgba(255,255,255,.75); cursor: pointer; background: rgba(255,255,255,.06);
    transition: border-color .2s; user-select: none; white-space: nowrap;
}
.mnav-lang-pill:hover { border-color: rgba(255,255,255,.4); }
.mnav-lang-flag  { font-size: 16px; line-height: 1; }
.mnav-lang-code  { font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.75); }
.mnav-lang-chevron { font-size: 9px; color: rgba(255,255,255,.4); margin-left: 1px; transition: transform .2s; }
.mnav-lang-wrap.open .mnav-lang-chevron { transform: rotate(180deg); }
.mnav-lang-drop {
    display: none; position: absolute; top: calc(100% + 6px); right: 0;
    background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
    min-width: 140px; box-shadow: 0 8px 28px rgba(0,0,0,.11);
    z-index: 9999; overflow: hidden; padding: 4px 0;
}
.mnav-lang-wrap.open .mnav-lang-drop { display: block; }
.mnav-lang-opt {
    display: flex; align-items: center; gap: 9px; padding: 10px 16px;
    font-size: 13.5px; font-weight: 500; color: #444;
    text-decoration: none; transition: background .15s;
}
.mnav-lang-opt:hover { background: rgba(232,62,140,.07); color: #e83e8c; }
.mnav-lang-opt.active { color: #e83e8c; font-weight: 700; }
.mnav-lang-opt-flag { font-size: 18px; }

/* User area */
.mnav-user-area {
    display: flex; align-items: center; gap: 12px; flex-shrink: 0;
}
.mnav-user-chip {
    display: flex; align-items: center; gap: 9px;
    background: rgba(233,30,140,.12); border-radius: 40px;
    padding: 4px 14px 4px 4px; border: 1px solid rgba(233,30,140,.2);
}
.mnav-user-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #e91e8c, #c91a78);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 12px; font-weight: 600;
    flex-shrink: 0; overflow: hidden;
}
.mnav-user-avatar img { width: 100%; height: 100%; object-fit: cover; }
.mnav-user-name { font-size: 12.5px; font-weight: 600; color: #fff; }
.mnav-user-role { font-size: 10px; color: rgba(255,255,255,.5); }
.mnav-role-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; padding: 2px 7px; border-radius: 20px; font-weight: 600;
}
.mnav-role-admin { background: rgba(233,30,140,.2); color: #e91e8c; }
.mnav-role-emp { background: rgba(233,30,140,.15); color: #e91e8c; }
.mnav-role-client { background: rgba(233,30,140,.2); color: #e91e8c; }

.mnav-btn-login {
    background: #e91e8c; color: #fff; border: none;
    padding: 9px 18px; border-radius: 22px;
    font-size: 12.5px; font-weight: 700; cursor: pointer;
    transition: transform .2s, box-shadow .2s, background .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 3px 12px rgba(233,30,140,.35); white-space: nowrap;
}
.mnav-btn-login:hover {
    transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,140,.5);
    background: #c91a78; color: #fff;
}

.mnav-btn-logout {
    width: 36px; height: 36px; border-radius: 9px;
    border: 1px solid rgba(233,30,140,.2);
    background: rgba(233,30,140,.08); color: #e91e8c;
    font-size: 14px; cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
    display: flex; align-items: center; justify-content: center;
}
.mnav-btn-logout:hover { background: #e91e8c; color: white; }

/* Mobile toggle */
.mnav-toggle {
    display: none; width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(233,30,140,.2);
    color: rgba(255,255,255,.85); font-size: 17px;
    cursor: pointer; align-items: center; justify-content: center;
    transition: background .2s, color .2s;
}
.mnav-toggle:hover { background: rgba(233,30,140,.18); color: #e91e8c; }

/* Mobile lang pills — hidden on desktop, shown on mobile */
.mnav-lang-mobile {
    display: none;
    align-items: center;
    gap: 3px;
    flex-shrink: 0;
}
.mnav-lang-mob-btn {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 5px 9px; border-radius: 8px;
    font-size: 11.5px; font-weight: 600;
    text-decoration: none; transition: .2s;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.55);
    border: 1px solid rgba(233,30,140,.18);
}
.mnav-lang-mob-btn.active { background: #e91e8c; color: #fff; border-color: #e91e8c; }
.mnav-lang-mob-btn:hover { background: rgba(233,30,140,.2); color: #fff; }

/* Responsive */
@media(max-width: 900px) {
    .mnav-bar { padding: 0 16px; height: 68px; }
    /* Keep brand text visible on mobile — but compact */
    .mnav-brand-text { display: block; }
    .mnav-brand-name { font-size: 15px; }
    .mnav-brand-sub  { font-size: 8.5px; letter-spacing: .14em; }
    .mnav-brand-tag  { display: none; }
    .mnav-links, .mnav-user-area { display: none; }
    .mnav-cart { margin-left: auto; margin-right: 6px; }
    .mnav-toggle { display: flex; }
    .mnav-lang { display: none; }
    .mnav-likes-pill { padding: 5px 9px; font-size: 12px; }
    /* Show compact lang pills on mobile */
    .mnav-lang-mobile { display: flex; }
}
@media(max-width: 400px) {
    .mnav-logo-badge { width: 44px; height: 44px; }
    .mnav-brand-name { font-size: 13px; }
    .mnav-brand-sub  { font-size: 7.5px; }
}
</style>

{{-- ── MOBILE OVERLAY ── --}}
<div class="mnav-overlay" id="mnavOverlay" onclick="mnavClose()"></div>

{{-- ── MOBILE DRAWER ── --}}
<div class="mnav-drawer" id="mnavDrawer">

    <div class="mnav-dhdr">
        <div class="mnav-dhdr-top">
            <a href="{{ route('home') }}" class="mnav-dbrand">
                <i class="fa-solid fa-scissors"></i>
                Marol Hair Braiding
            </a>
            <button class="mnav-dclose" onclick="mnavClose()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        @auth
        <div class="mnav-dprofile">
            <div class="mnav-davatar">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=e91e8c&color=fff' }}" alt="Avatar">
            </div>
            <div>
                <div class="mnav-dname">{{ auth()->user()->name }}</div>
                <div class="mnav-drole">
                    @if(auth()->user()->role === 'admin') {{ __('messages.role_admin') }}
                    @elseif(auth()->user()->role === 'employee') {{ __('messages.role_employee') }}
                    @else {{ __('messages.role_client') }}
                    @endif
                </div>
            </div>
        </div>
        @endauth
    </div>

    <div class="mnav-dbody">

        <div class="mnav-dsect">{{ __('messages.navigation') }}</div>

        <a href="{{ route('home') }}" class="mnav-dlink {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="mnav-dlink-icon"><i class="fa-solid fa-house"></i></div> {{ __('messages.home') }}
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mnav-dlink {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <div class="mnav-dlink-icon"><i class="fa-solid fa-crown"></i></div> {{ __('messages.dashboard') }}
                </a>
            @elseif(auth()->user()->role === 'employee')
                <a href="{{ route('employee.dashboard') }}" class="mnav-dlink {{ request()->routeIs('employee.*') ? 'active' : '' }}">
                    <div class="mnav-dlink-icon"><i class="fa-solid fa-gauge-high"></i></div> {{ __('messages.dashboard') }}
                </a>
            @else
                <a href="{{ route('client.dashboard') }}" class="mnav-dlink {{ request()->routeIs('client.*') ? 'active' : '' }}">
                    <div class="mnav-dlink-icon"><i class="fa-solid fa-gauge-high"></i></div> {{ __('messages.dashboard') }}
                </a>
            @endif
            {{-- <a href="{{ route('reservations.index') }}" class="mnav-dlink {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                <div class="mnav-dlink-icon"><i class="fa-solid fa-calendar-check"></i></div> {{ __('messages.my_reservations') }}
            </a> --}}
        @else
            <a href="{{ route('booking.start') }}" class="mnav-dlink">
                <div class="mnav-dlink-icon"><i class="fa-solid fa-calendar-check"></i></div> {{ __('messages.appointment') }}
            </a>
        @endauth

        <a href="{{ route('stylists.index') }}" class="mnav-dlink {{ request()->routeIs('stylists.*') ? 'active' : '' }}">
            <div class="mnav-dlink-icon"><i class="fa-solid fa-star"></i></div> {{ __('messages.stylists') }}
        </a>
        <a href="{{ route('gallery') }}" class="mnav-dlink {{ request()->routeIs('gallery') ? 'active' : '' }}">
            <div class="mnav-dlink-icon"><i class="fa-solid fa-images"></i></div> {{ __('messages.gallery') }}
        </a>

        <a href="{{ route('about') }}" class="mnav-dlink {{ request()->routeIs('about') ? 'active' : '' }}">
            <div class="mnav-dlink-icon"><i class="fa-solid fa-circle-info"></i></div> {{ __('messages.about') }}
        </a>

        <a href="{{ route('contact') }}" class="mnav-dlink {{ request()->routeIs('contact') ? 'active' : '' }}">
            <div class="mnav-dlink-icon"><i class="fa-solid fa-envelope"></i></div> {{ __('messages.contact') }}
        </a>

        @if(request()->routeIs('home'))
        <div class="mnav-dlang">
            <a href="{{ route('locale.switch', 'fr') }}"
               style="{{ app()->getLocale()==='fr' ? 'background:#e91e8c;color:#fff;' : 'background:rgba(255,255,255,.06);color:rgba(255,255,255,.6);' }}">
                FR
            </a>
            <a href="{{ route('locale.switch', 'en') }}"
               style="{{ app()->getLocale()==='en' ? 'background:#e91e8c;color:#fff;' : 'background:rgba(255,255,255,.06);color:rgba(255,255,255,.6);' }}">
                EN
            </a>
            <a href="{{ route('locale.switch', 'es') }}"
               style="{{ app()->getLocale()==='es' ? 'background:#e91e8c;color:#fff;' : 'background:rgba(255,255,255,.06);color:rgba(255,255,255,.6);' }}">
                ES
            </a>
        </div>
        @endif

    </div>

    @auth
    <div class="mnav-dftr">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="mnav-dlogout">
                <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
            </button>
        </form>
    </div>
    @endauth

</div>

{{-- ── PROMO BANNER ── --}}
@include('partials.promo-banner')

{{-- ── NAVBAR ── --}}
<nav class="mnav-bar">

    <a href="{{ route('home') }}" class="mnav-logo">
        <div class="mnav-logo-badge">
            <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
        </div>
        <div class="mnav-brand-text">
            <span class="mnav-brand-name">Marol</span>
            <span class="mnav-brand-sub">Hair Braiding</span>
            <span class="mnav-brand-tag">Salon</span>
        </div>
    </a>

    <div class="mnav-links">
        <a href="{{ route('home') }}" class="mnav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            {{ __('messages.home') }}
        </a>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mnav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-crown"></i> {{ __('messages.role_admin') }}
                </a>
            @elseif(auth()->user()->role === 'employee')
                <a href="{{ route('employee.dashboard') }}" class="mnav-link {{ request()->routeIs('employee.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> {{ __('messages.employee_space') }}
                </a>
            @else
                <a href="{{ route('client.dashboard') }}" class="mnav-link {{ request()->routeIs('client.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> {{ __('messages.my_space') }}
                </a>
            @endif
            {{-- <a href="{{ route('reservations.index') }}" class="mnav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                {{ __('messages.my_reservations') }}
            </a> --}}
        @else
            <a href="{{ route('booking.start') }}" class="mnav-link {{ request()->routeIs('booking.*') ? 'active' : '' }}">
                {{ __('messages.appointment') }}
            </a>
        @endauth
        <a href="{{ route('stylists.index') }}" class="mnav-link {{ request()->routeIs('stylists.*') ? 'active' : '' }}">
            {{ __('messages.stylists') }}
        </a>
        <a href="{{ route('gallery') }}" class="mnav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">
            {{ __('messages.gallery') }}
        </a>

        <a href="{{ route('about') }}" class="mnav-link {{ request()->routeIs('about') ? 'active' : '' }}">
            {{ __('messages.about') }}
        </a>

        <a href="{{ route('contact') }}" class="mnav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
            {{ __('messages.contact') }}
        </a>
    </div>

    <div class="mnav-likes-pill" title="Likes">
        <i class="fa-solid fa-heart"></i>
        <span>{{ $totalLikes ?? 0 }}</span>
    </div>

    @php $mnav_loc = app()->getLocale(); @endphp
    <div class="mnav-lang-wrap" id="mnavLangWrap">
        <div class="mnav-lang-pill" onclick="mnavLangToggle()">
            <span class="mnav-lang-flag">
                @if($mnav_loc==='fr') 🇫🇷
                @elseif($mnav_loc==='en') 🇺🇸
                @else 🇪🇸
                @endif
            </span>
            <span class="mnav-lang-code">{{ strtoupper($mnav_loc) }}</span>
            <i class="fa-solid fa-chevron-down mnav-lang-chevron"></i>
        </div>
        <div class="mnav-lang-drop">
            <a href="{{ route('locale.switch','en') }}" class="mnav-lang-opt {{ $mnav_loc==='en'?'active':'' }}">
                <span class="mnav-lang-opt-flag">🇺🇸</span> {{ __('messages.nav_lang_en') }}
            </a>
            <a href="{{ route('locale.switch','fr') }}" class="mnav-lang-opt {{ $mnav_loc==='fr'?'active':'' }}">
                <span class="mnav-lang-opt-flag">🇫🇷</span> {{ __('messages.nav_lang_fr') }}
            </a>
            <a href="{{ route('locale.switch','es') }}" class="mnav-lang-opt {{ $mnav_loc==='es'?'active':'' }}">
                <span class="mnav-lang-opt-flag">🇪🇸</span> {{ __('messages.nav_lang_es') }}
            </a>
        </div>
    </div>

    <div class="mnav-user-area">
        @auth
            <div class="mnav-user-chip">
                <div class="mnav-user-avatar">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=e91e8c&color=fff' }}" alt="Avatar">
                </div>
                <div>
                    <div class="mnav-user-name">{{ auth()->user()->name }}</div>
                    <div class="mnav-user-role">
                        @if(auth()->user()->role === 'admin')
                            <span class="mnav-role-badge mnav-role-admin"><i class="fa-solid fa-crown" style="font-size:9px;"></i> {{ __('messages.role_admin') }}</span>
                        @elseif(auth()->user()->role === 'employee')
                            <span class="mnav-role-badge mnav-role-emp"><i class="fa-solid fa-user-tie" style="font-size:9px;"></i> {{ __('messages.role_employee') }}</span>
                        @else
                            <span class="mnav-role-badge mnav-role-client"><i class="fa-solid fa-star" style="font-size:9px;"></i> {{ __('messages.role_client') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mnav-btn-logout" title="{{ __('messages.logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mnav-btn-login">
                <i class="fa-solid fa-user"></i> {{ __('messages.my_account') }}
            </a>
        @endauth
    </div>

    <button class="mnav-toggle" onclick="mnavSmartOpen()">
        <i class="fa-solid fa-bars"></i>
    </button>

</nav>

<script>
/* ── Compteur de likes (navbar) — appelé depuis toute page où un cœur like/favorite un service ── */
function updateLikesBadge(delta) {
    const el = document.querySelector('.mnav-likes-pill span');
    if (!el) return;
    const current = parseInt(el.textContent, 10) || 0;
    el.textContent = Math.max(0, current + delta);
}

/* ── Toggle "like" (table likes) en parallèle du favori — synchronise le compteur global ── */
function syncServiceLike(serviceId, liked) {
    fetch('/likes/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ type: 'service', id: serviceId })
    }).catch(() => {});
    updateLikesBadge(liked ? 1 : -1);
}

function mnavOpen() {
    document.getElementById('mnavDrawer').classList.add('open');
    document.getElementById('mnavOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function mnavClose() {
    document.getElementById('mnavDrawer').classList.remove('open');
    document.getElementById('mnavOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
function mnavLangToggle() {
    document.getElementById('mnavLangWrap').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    var w = document.getElementById('mnavLangWrap');
    if (w && !w.contains(e.target)) w.classList.remove('open');
});
function mnavSmartOpen() {
    if (document.getElementById('sidebar') && typeof toggleSidebar === 'function') {
        toggleSidebar();
    } else if (document.getElementById('mobile-drawer') && typeof toggleDrawer === 'function') {
        toggleDrawer();
    } else {
        mnavOpen();
    }
}
</script>

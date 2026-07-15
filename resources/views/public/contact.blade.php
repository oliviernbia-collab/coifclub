@extends('layouts.app')

@section('title', __('messages.contact'))

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,400;1,600;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

/* ═══════════════════════════════════════
   CONTACT PAGE — dark premium theme
════════════════════════════════════════ */

* { box-sizing: border-box; }
.cp-page { background: #0e0a1c; min-height: 100vh; }

/* ── HERO ─────────────────────────────── */
.cp-hero {
    position: relative;
    overflow: hidden;
    background: #160d2a;
    min-height: 320px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: stretch;
}

.cp-hero-left {
    padding: 72px clamp(24px, 6vw, 80px) 72px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.cp-hero-left::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 0% 50%, rgba(233,30,140,.18), transparent),
        radial-gradient(ellipse 40% 50% at 100% 0%, rgba(76,29,149,.22), transparent);
    pointer-events: none;
}

.cp-hero-right {
    position: relative;
    overflow: hidden;
    min-height: 320px;
}

.cp-hero-right img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

.cp-hero-right::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, #160d2a 0%, transparent 30%);
    pointer-events: none;
}

.cp-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 999px;
    background: rgba(233,30,140,.15);
    border: 1px solid rgba(233,30,140,.3);
    color: #e91e8c;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 24px;
    width: fit-content;
    position: relative;
    z-index: 1;
}

.cp-hero-title {
    font-family: 'Inter', sans-serif;
    font-size: clamp(2rem, 4.5vw, 3.2rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.cp-hero-cursive {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 600;
    color: #e91e8c;
    margin-bottom: 18px;
    display: block;
    line-height: 1.3;
    position: relative;
    z-index: 1;
}

.cp-hero-desc {
    color: rgba(255,255,255,.65);
    font-size: .95rem;
    line-height: 1.8;
    max-width: 480px;
    position: relative;
    z-index: 1;
}

/* ── MAIN SECTION ─────────────────────── */
.cp-main {
    padding: 0 clamp(16px, 5vw, 60px) 60px;
    max-width: 1320px;
    margin: 0 auto;
    margin-top: -1px;
    background: #0e0a1c;
}

.cp-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1.2fr;
    gap: 20px;
    padding-top: 40px;
}

/* ── CARD ─────────────────────────────── */
.cp-card {
    background: #160d2a;
    border: 1px solid rgba(233,30,140,.15);
    border-radius: 24px;
    padding: 32px 28px;
}

.cp-card-title {
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.cp-card-title i {
    color: #e91e8c;
    font-size: 1rem;
}

/* ── CONTACT INFO ─────────────────────── */
.cp-info-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 24px;
}

.cp-info-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 12px 14px;
    border-radius: 14px;
    transition: background .2s;
}

.cp-info-item:hover { background: rgba(233,30,140,.06); }

.cp-info-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.2);
    display: flex; align-items: center; justify-content: center;
    color: #e91e8c;
    font-size: .9rem;
    flex-shrink: 0;
}

.cp-info-label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.4);
    margin-bottom: 3px;
}

.cp-info-value {
    font-size: .9rem;
    color: rgba(255,255,255,.85);
    line-height: 1.6;
    font-weight: 500;
}

.cp-whatsapp-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 12px 22px;
    border-radius: 12px;
    background: #25d366;
    color: #fff;
    font-weight: 700;
    font-size: .88rem;
    text-decoration: none;
    transition: .25s;
    margin-top: 4px;
}

.cp-whatsapp-btn:hover {
    background: #1da851;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(37,211,102,.3);
}

/* ── OPENING HOURS ────────────────────── */
.cp-hours-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.cp-hours-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    border-radius: 10px;
    transition: background .2s;
}

.cp-hours-row:hover { background: rgba(255,255,255,.04); }

.cp-hours-day {
    font-size: .88rem;
    color: rgba(255,255,255,.7);
    font-weight: 500;
}

.cp-hours-time {
    font-size: .85rem;
    font-weight: 700;
    color: rgba(255,255,255,.9);
}

.cp-hours-closed {
    font-size: .85rem;
    font-weight: 600;
    color: rgba(255,255,255,.35);
    font-style: italic;
}

.cp-hours-divider {
    height: 1px;
    background: rgba(255,255,255,.06);
    margin: 4px 0;
}

/* ── FORM ─────────────────────────────── */
.cp-form-group {
    margin-bottom: 16px;
}

.cp-label {
    display: block;
    margin-bottom: 7px;
    font-size: .82rem;
    font-weight: 600;
    color: rgba(255,255,255,.6);
    letter-spacing: .01em;
}

.cp-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 12px;
    background: rgba(255,255,255,.06);
    color: #fff;
    font-size: .9rem;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: .25s;
    appearance: none;
    -webkit-appearance: none;
}

.cp-input:focus {
    border-color: #e91e8c;
    background: rgba(233,30,140,.06);
    box-shadow: 0 0 0 3px rgba(233,30,140,.12);
}

.cp-input::placeholder { color: rgba(255,255,255,.3); }

textarea.cp-input {
    resize: vertical;
    min-height: 130px;
    line-height: 1.7;
}

.cp-btn-send {
    width: 100%;
    border: none;
    background: linear-gradient(135deg, #e91e8c, #c0156d);
    color: #fff;
    padding: 14px 24px;
    border-radius: 14px;
    font-size: .95rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    transition: .3s;
    box-shadow: 0 6px 24px rgba(233,30,140,.35);
    letter-spacing: .02em;
    margin-top: 6px;
}

.cp-btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(233,30,140,.45);
}

.cp-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-top: 16px;
    padding: 14px 18px;
    border-radius: 14px;
    font-size: .87rem;
    font-weight: 600;
    line-height: 1.6;
}

.cp-alert.success {
    background: rgba(22,163,74,.1);
    border: 1.5px solid rgba(22,163,74,.25);
    color: #4ade80;
}

.cp-alert.error {
    background: rgba(220,38,38,.08);
    border: 1.5px solid rgba(220,38,38,.22);
    color: #f87171;
}

/* ── MAP SECTION ──────────────────────── */
.cp-map-section {
    padding: 0 clamp(16px, 5vw, 60px) 80px;
    max-width: 1320px;
    margin: 0 auto;
    background: #0e0a1c;
}

.cp-map-card {
    background: #160d2a;
    border: 1px solid rgba(233,30,140,.15);
    border-radius: 24px;
    overflow: hidden;
}

.cp-map-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 32px 36px;
    gap: 20px;
    flex-wrap: wrap;
}

.cp-map-info-left { display: flex; align-items: flex-start; gap: 16px; }

.cp-map-pin-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: rgba(233,30,140,.15);
    border: 1px solid rgba(233,30,140,.25);
    display: flex; align-items: center; justify-content: center;
    color: #e91e8c;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.cp-map-title {
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 5px;
}

.cp-map-sub {
    font-size: .87rem;
    color: rgba(255,255,255,.5);
    line-height: 1.6;
}

.cp-map-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 12px 24px;
    border-radius: 14px;
    background: linear-gradient(135deg, #e91e8c, #c0156d);
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: .88rem;
    transition: .25s;
    white-space: nowrap;
    box-shadow: 0 6px 20px rgba(233,30,140,.3);
    flex-shrink: 0;
}

.cp-map-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(233,30,140,.42);
    color: #fff;
}

.cp-map-frame {
    width: 100%;
    height: 400px;
    border: none;
    display: block;
    filter: grayscale(20%) contrast(1.05);
}

/* ── RESPONSIVE ───────────────────────── */
@media (max-width: 1100px) {
    .cp-grid { grid-template-columns: 1fr 1fr; }
    .cp-grid > *:last-child { grid-column: 1 / -1; }
}

@media (max-width: 900px) {
    .cp-hero { grid-template-columns: 1fr; }
    .cp-hero-right { display: none; }
    .cp-hero-left { padding: 60px 24px; }
}

@media (max-width: 700px) {
    .cp-grid { grid-template-columns: 1fr; }
    .cp-grid > *:last-child { grid-column: auto; }
    .cp-map-info { flex-direction: column; align-items: flex-start; }
    .cp-map-frame { height: 280px; }
}

@media (max-width: 480px) {
    .cp-card { padding: 24px 18px; }
    .cp-map-info { padding: 24px 20px; }
}

</style>
@endpush

@section('content')
<div class="cp-page">

{{-- ── HERO ──────────────────────────────── --}}
<section class="cp-hero">
    <div class="cp-hero-left">

        <span class="cp-hero-badge">
            <i class="fa-solid fa-headset"></i>
            {{ __('messages.contact') }}
        </span>

        <h1 class="cp-hero-title">{{ __('messages.contact_us') }}</h1>

        <span class="cp-hero-cursive">{{ __('messages.contact_subtitle') }}</span>

        <p class="cp-hero-desc">{{ __('messages.contact_description') }}</p>

    </div>

    <div class="cp-hero-right">
        <img src="{{ asset('images/C34.jpg') }}" alt="{{ __('messages.contact_us') }}">
    </div>
</section>

{{-- ── MAIN CONTENT ─────────────────────── --}}
<div class="cp-main">
    <div class="cp-grid">

        {{-- ─ Contact Information ─ --}}
        <div class="cp-card">
            <div class="cp-card-title">
                <i class="fa-solid fa-circle-info"></i>
                {{ __('messages.contact_information') }}
            </div>

            <div class="cp-info-list">
                <div class="cp-info-item">
                    <div class="cp-info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <div class="cp-info-label">{{ __('messages.phone') }}</div>
                        <div class="cp-info-value">301-219-4507 / 240-729-0623</div>
                    </div>
                </div>

                <div class="cp-info-item">
                    <div class="cp-info-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <div class="cp-info-label">{{ __('messages.email') }}</div>
                        <div class="cp-info-value">info@marolhairbraiding.com</div>
                    </div>
                </div>

                <div class="cp-info-item">
                    <div class="cp-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <div class="cp-info-label">{{ __('messages.address') }}</div>
                        <div class="cp-info-value">1545 W 71st Street,<br>Chicago, IL 60636</div>
                    </div>
                </div>

                <div class="cp-info-item">
                    <div class="cp-info-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div>
                        <div class="cp-info-label">{{ __('messages.whatsapp') }}</div>
                        <div class="cp-info-value">{{ __('messages.chat_on_whatsapp') }}</div>
                    </div>
                </div>
            </div>

            <a href="https://wa.me/301-219-4507" target="_blank" rel="noopener" class="cp-whatsapp-btn">
                <i class="fa-brands fa-whatsapp" style="font-size:1.15rem;"></i>
                {{ __('messages.chat_on_whatsapp') }}
            </a>
        </div>

        {{-- ─ Opening Hours ─ --}}
        <div class="cp-card">
            <div class="cp-card-title">
                <i class="fa-solid fa-clock"></i>
                {{ __('messages.opening_hours') }}
            </div>

            <div class="cp-hours-list">
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.monday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.tuesday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.wednesday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.thursday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.friday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.saturday') }}</span>
                    <span class="cp-hours-time">9:00 AM – 8:00 PM</span>
                </div>
                <div class="cp-hours-divider"></div>
                <div class="cp-hours-row">
                    <span class="cp-hours-day">{{ __('messages.sunday') }}</span>
                    <span class="cp-hours-closed">{{ __('messages.closed') }}</span>
                </div>
            </div>
        </div>

        {{-- ─ Send Message Form ─ --}}
        <div class="cp-card">
            <div class="cp-card-title">
                <i class="fa-solid fa-paper-plane"></i>
                {{ __('messages.send_us_message') }}
            </div>

            <form method="POST" action="{{ route('contact.send') }}">
                @csrf

                <div class="cp-form-group">
                    <label class="cp-label">{{ __('messages.your_name') }}</label>
                    <input type="text" name="name" class="cp-input"
                           value="{{ old('name') }}"
                           placeholder="{{ __('messages.your_name') }}" required>
                </div>

                <div class="cp-form-group">
                    <label class="cp-label">{{ __('messages.phone_number') }}</label>
                    <input type="tel" name="phone" class="cp-input"
                           value="{{ old('phone') }}"
                           placeholder="+1 (000) 000-0000">
                </div>

                <div class="cp-form-group">
                    <label class="cp-label">{{ __('messages.email_address') }}</label>
                    <input type="email" name="email" class="cp-input"
                           value="{{ old('email') }}"
                           placeholder="{{ __('messages.email_placeholder') }}" required>
                </div>

                <div class="cp-form-group">
                    <label class="cp-label">{{ __('messages.message') }}</label>
                    <textarea name="message" class="cp-input"
                              placeholder="{{ __('messages.message') }}…"
                              required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="cp-btn-send">
                    <i class="fa-solid fa-paper-plane"></i>
                    {{ __('messages.send_message') }}
                </button>

                @if(session('success'))
                <div class="cp-alert success">
                    <i class="fa-solid fa-circle-check" style="font-size:16px;flex-shrink:0;margin-top:2px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="cp-alert error">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size:16px;flex-shrink:0;margin-top:2px;"></i>
                    <ul style="margin:0;padding-left:2px;list-style:none;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </form>
        </div>

    </div>
</div>

{{-- ── MAP ───────────────────────────────── --}}
<div class="cp-map-section">
    <div class="cp-map-card">

        <div class="cp-map-info">
            <div class="cp-map-info-left">
                <div class="cp-map-pin-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <div class="cp-map-title">{{ __('messages.easy_to_find') }}</div>
                    <div class="cp-map-sub">{{ __('messages.free_parking') }}</div>
                </div>
            </div>
            <a href="https://maps.google.com/?q=1545+W+71st+Street+Chicago+IL+60636"
               target="_blank"
               rel="noopener"
               class="cp-map-btn">
                <i class="fa-solid fa-diamond-turn-right"></i>
                {{ __('messages.get_directions') }}
            </a>
        </div>

        <iframe
            class="cp-map-frame"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=1545+W+71st+Street+Chicago+IL+60636&output=embed"
            title="{{ __('messages.find_us') }}">
        </iframe>

    </div>
</div>

</div>
@endsection

@once
<style>
/* ═══════════════════════════════════════════
   SHARED FOOTER — partials/footer.blade.php
═══════════════════════════════════════════ */
.hp-footer {
    background: #1a1a2e;
    color: rgba(255,255,255,.45);
    margin-top: auto;
    font-family: 'Inter', sans-serif;
}
.hp-footer-main {
    display: grid;
    grid-template-columns: 1.8fr 1fr 1fr 1.6fr;
    gap: 48px;
    padding: 64px 52px 52px;
}
.hp-footer-logo-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.hp-footer-flame {
    width: 42px; height: 42px; flex-shrink: 0;
    border-radius: 50%; overflow: hidden;
    border: 2px solid rgba(233,30,140,.4);
    box-shadow: 0 0 0 3px rgba(233,30,140,.1);
}
.hp-footer-flame img { width: 100%; height: 100%; object-fit: cover; display: block; }
.hp-footer-brand { line-height: 1.1; }
.hp-footer-brand-name {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.hp-footer-tagline {
    font-size: 12.5px;
    color: rgba(255,255,255,.3);
    line-height: 1.7;
    max-width: 210px;
}
.hp-footer-col-title {
    font-size: 13.5px;
    font-weight: 700;
    color: rgba(255,255,255,.82);
    margin-bottom: 18px;
    letter-spacing: .01em;
}
.hp-footer-links {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 10px;
}
.hp-footer-links a {
    color: rgba(255,255,255,.38);
    font-size: 13px;
    text-decoration: none;
    transition: color .18s;
}
.hp-footer-links a:hover { color: #e83e8c; }
.hp-footer-socials {
    display: flex; gap: 9px; margin-bottom: 24px;
}
.hp-footer-soc {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.11);
    background: rgba(255,255,255,.04);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.38);
    font-size: 14px;
    text-decoration: none;
    transition: .2s;
}
.hp-footer-soc:hover {
    background: #e83e8c; border-color: #e83e8c;
    color: #fff; transform: translateY(-2px);
}
.hp-footer-sub-label {
    font-size: 12px;
    color: rgba(255,255,255,.32);
    margin-bottom: 10px;
}
.hp-footer-sub-form {
    display: flex;
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 8px;
    overflow: hidden;
    background: rgba(255,255,255,.04);
}
.hp-footer-sub-form input {
    flex: 1; background: transparent; border: none; outline: none;
    padding: 10px 13px; color: #fff; font-size: 12.5px; font-family: 'Inter', sans-serif;
}
.hp-footer-sub-form input::placeholder { color: rgba(255,255,255,.2); }
.hp-footer-sub-btn {
    background: #e83e8c; color: #fff; border: none;
    padding: 10px 16px; font-size: 13px; font-weight: 700; cursor: pointer;
    transition: background .2s; font-family: 'Inter', sans-serif; white-space: nowrap;
}
.hp-footer-sub-btn:hover { background: #c91a78; }
.hp-footer-bottom {
    border-top: 1px solid rgba(255,255,255,.06);
    padding: 16px 52px;
    text-align: center;
    font-size: 12px;
    color: rgba(255,255,255,.2);
}
@media (max-width: 991px) {
    .hp-footer-main { grid-template-columns: 1fr 1fr; gap: 36px; padding: 44px 28px 36px; }
}
@media (max-width: 767px) {
    .hp-footer-main { grid-template-columns: 1fr; gap: 28px; padding: 36px 20px 28px; }
    .hp-footer-bottom { padding: 16px 20px; }
}
</style>
@endonce

<footer class="hp-footer">
    <div class="hp-footer-main">

        {{-- Col 1 — Brand --}}
        <div>
            <div class="hp-footer-logo-row">
                <div class="hp-footer-flame">
                    <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
                </div>
                <div class="hp-footer-brand">
                    <span class="hp-footer-brand-name">Marol<br>Hair Braiding</span>
                </div>
            </div>
            <p class="hp-footer-tagline">{{ __('messages.footer_tagline') }}</p>
        </div>

        {{-- Col 2 — Quick Links --}}
        <div>
            <div class="hp-footer-col-title">{{ __('messages.footer_quick_links') }}</div>
            <ul class="hp-footer-links">
                <li><a href="{{ route('home') }}">{{ __('messages.nav_link_home') }}</a></li>
                <li><a href="{{ route('services.index') }}">{{ __('messages.footer_link_styles') }}</a></li>
                <li><a href="{{ route('about') }}">{{ __('messages.nav_link_about') }}</a></li>
                <li><a href="{{ route('booking.start') }}">{{ __('messages.footer_link_booking') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ __('messages.nav_link_contact') }}</a></li>
            </ul>
        </div>

        {{-- Col 3 — More --}}
        <div>
            <div class="hp-footer-col-title">{{ __('messages.footer_more') }}</div>
            <ul class="hp-footer-links">
                <li><a href="{{ route('faq') }}">{{ __('messages.footer_link_faq') }}</a></li>
                <li><a href="{{ route('legal.policies') }}">{{ __('messages.footer_link_policies') }}</a></li>
                <li><a href="{{ route('legal.privacy') }}">{{ __('messages.footer_link_privacy') }}</a></li>
                <li><a href="{{ route('legal.cgu') }}">{{ __('messages.footer_link_terms') }}</a></li>
            </ul>
        </div>

        {{-- Col 4 — Follow Us + Subscribe --}}
        <div>
            <div class="hp-footer-col-title">{{ __('messages.footer_follow_us') }}</div>
            <div class="hp-footer-socials">
                <a href="#" class="hp-footer-soc" title="Instagram" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hp-footer-soc" title="Facebook" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="hp-footer-soc" title="TikTok" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://wa.me/13121234567" class="hp-footer-soc" title="WhatsApp" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
            <div class="hp-footer-col-title" style="margin-top:6px;">{{ __('messages.footer_subscribe') }}</div>
            <p class="hp-footer-sub-label">{{ __('messages.footer_sub_label') }}</p>
            <form class="hp-footer-sub-form">
                <input type="email" placeholder="{{ __('messages.footer_email_ph') }}" required>
                <button class="hp-footer-sub-btn" type="submit">{{ __('messages.footer_sub_btn') }}</button>
            </form>
        </div>

    </div>

    <div class="hp-footer-bottom">
        {{ str_replace(':year', date('Y'), __('messages.footer_copyright')) }}
    </div>
</footer>

@if(!empty($activePromotion))
    <div class="promo-banner" data-promo-id="{{ $activePromotion->id }}" style="background:#ef4444;color:#fff;padding:8px 12px;text-align:center;position:relative;z-index:9999;overflow:hidden;">
        <button type="button" class="promo-close-btn" aria-label="{{ __('messages.promo_close') }}" style="position:absolute;right:10px;top:8px;background:transparent;border:none;color:rgba(255,255,255,.95);font-size:18px;cursor:pointer;">&times;</button>
        <div class="promo-viewport" style="overflow:hidden;white-space:nowrap;">
            <div class="promo-track" style="display:inline-block;padding-left:100%;animation:promo-scroll 14s linear infinite;">
                <strong style="margin-right:12px;">{{ $activePromotion->code ?? ($activePromotion->description ?? __('messages.promo_default_label')) }}</strong>
                @if($activePromotion->description)
                    {{ $activePromotion->description }} —
                @endif
                <span>
                    {{ optional($activePromotion->valid_from)->format('d/m/Y') }} {{ __('messages.promo_date_to') }} {{ optional($activePromotion->valid_until)->format('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    <style>
        @keyframes promo-scroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }
        .promo-banner { font-weight:700; font-size:14px; }
        .promo-banner .promo-track { will-change: transform; }
        .promo-banner:hover .promo-track { animation-play-state: paused; }
        .promo-close-btn { opacity: .95; transition: opacity .15s; }
        .promo-close-btn:hover { opacity: 1; transform: scale(1.05); }
        @media (max-width:640px) { .promo-banner { font-size:13px; } }
    </style>

    <script>
        (function(){
            try {
                var banner = document.querySelector('.promo-banner[data-promo-id="' + @json($activePromotion->id) + '"]');
                if (!banner) return;
                var promoKey = 'promo_hidden_' + banner.dataset.promoId;
                if (localStorage.getItem(promoKey) === '1') { banner.remove(); return; }

                var btn = banner.querySelector('.promo-close-btn');
                btn.addEventListener('click', function(){
                    banner.style.transition = 'opacity .3s, max-height .4s, transform .3s';
                    banner.style.opacity = '0';
                    banner.style.maxHeight = '0';
                    banner.style.transform = 'translateY(-6px)';
                    setTimeout(function(){ banner.remove(); }, 400);
                    try { localStorage.setItem(promoKey, '1'); } catch(e) { /* ignore */ }
                });
            } catch(e) { console && console.error && console.error(e); }
        })();
    </script>
@endif

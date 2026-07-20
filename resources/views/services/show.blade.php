@extends('layouts.home')

@section('title', ($service->name ?? $service->nom ?? 'Service') . ' — Marol Hair Braiding')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($service->description ?? __('messages.seo_default_description')), 160))
@if($service->image)
@section('og_image', asset('storage/' . $service->image))
@endif

@push('styles')
<style>
/* ══════════════════════════════════════════
   SERVICE SHOW — Dark Theme + Pink Frames
══════════════════════════════════════════ */
.sv-wrap { background: #0a0714; min-height: 80vh; padding: 36px 0 80px; }

/* Breadcrumb */
.sv-crumb { font-size: 12.5px; color: rgba(255,255,255,.35); margin-bottom: 32px; font-family: 'Inter', sans-serif; }
.sv-crumb a { color: rgba(255,255,255,.35); text-decoration: none; transition: color .2s; }
.sv-crumb a:hover { color: #e83e8c; }
.sv-crumb span { color: #e83e8c; margin: 0 6px; }

/* Main layout */
.sv-layout { display: grid; grid-template-columns: 1fr 360px; gap: 28px; align-items: start; }
.sv-layout.has-gallery { grid-template-columns: 80px 1fr 360px; }

/* Left thumbnails */
.sv-thumbs { display: flex; flex-direction: column; gap: 10px; }
.sv-thumb {
    width: 80px; height: 80px; border-radius: 12px; overflow: hidden;
    cursor: pointer; border: 2px solid rgba(232,62,140,.25); transition: .22s;
    box-shadow: 0 2px 12px rgba(0,0,0,.35);
}
.sv-thumb.active {
    border-color: #e83e8c;
    box-shadow: 0 0 18px rgba(232,62,140,.35);
}
.sv-thumb:hover { border-color: rgba(232,62,140,.6); }
.sv-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: .3s; }
.sv-thumb:hover img { transform: scale(1.08); }

/* Main image */
.sv-main-img {
    border-radius: 20px; overflow: hidden; aspect-ratio: 4/3;
    border: 2px solid rgba(232,62,140,.4);
    box-shadow: 0 8px 40px rgba(0,0,0,.5), 0 0 0 1px rgba(232,62,140,.08);
}
.sv-main-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: .5s; }

/* Right panel */
.sv-panel { padding-left: 4px; }
.sv-panel-name {
    font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700;
    color: #fff; margin: 0 0 8px; line-height: 1.15;
}
.sv-panel-price {
    font-size: 1.25rem; font-weight: 800; color: #e83e8c;
    margin: 0 0 18px; font-family: 'Inter', sans-serif;
}
.sv-panel-desc {
    font-size: 13.5px; color: rgba(255,255,255,.48); line-height: 1.75;
    margin: 0 0 22px; font-family: 'Inter', sans-serif;
}

/* Features */
.sv-features {
    background: rgba(255,255,255,.025);
    border: 2px solid rgba(232,62,140,.3);
    border-radius: 16px; padding: 16px 18px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.3);
}
.sv-feature {
    display: flex; align-items: center; gap: 12px;
    padding: 9px 0; font-size: 13.5px; color: rgba(255,255,255,.7);
    font-family: 'Inter', sans-serif;
    border-bottom: 1px solid rgba(255,255,255,.05);
}
.sv-feature:last-child { border: none; padding-bottom: 0; }
.sv-feature:first-child { padding-top: 0; }
.sv-feature-icon {
    width: 22px; height: 22px; border-radius: 50%; background: #e83e8c;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 11px; flex-shrink: 0;
    box-shadow: 0 0 10px rgba(232,62,140,.35);
}

/* Book box */
.sv-book-box {
    background: rgba(255,255,255,.025);
    border: 2px solid rgba(232,62,140,.38);
    border-radius: 18px; padding: 24px; margin-bottom: 16px;
    box-shadow: 0 4px 28px rgba(0,0,0,.35), 0 0 0 1px rgba(232,62,140,.06);
}
.sv-book-title {
    font-size: 14.5px; font-weight: 700; color: #fff;
    margin: 0 0 18px; font-family: 'Inter', sans-serif;
}
.sv-steps { display: flex; flex-direction: column; gap: 10px; margin-bottom: 22px; }
.sv-step {
    display: flex; align-items: center; gap: 12px;
    font-size: 13px; color: rgba(255,255,255,.55); font-family: 'Inter', sans-serif;
}
.sv-step-num {
    width: 26px; height: 26px; border-radius: 50%;
    background: linear-gradient(135deg, #e83e8c, #c0156d);
    color: #fff; font-size: 12px; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(232,62,140,.4);
}
.sv-btn-book {
    display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;
    background: linear-gradient(135deg, #e83e8c, #c0156d);
    color: #fff; padding: 14px; border-radius: 12px;
    font-size: 15px; font-weight: 700; text-decoration: none; border: none; cursor: pointer;
    transition: .22s; box-shadow: 0 6px 22px rgba(232,62,140,.45); font-family: 'Inter', sans-serif;
}
.sv-btn-book:hover { box-shadow: 0 8px 30px rgba(232,62,140,.6); transform: translateY(-2px); color: #fff; }

/* Secondary actions */
.sv-actions {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px;
    background: rgba(255,255,255,.025);
    border: 1.5px solid rgba(232,62,140,.25);
    border-radius: 14px;
    box-shadow: 0 2px 14px rgba(0,0,0,.25);
}
.sv-fav-btn {
    display: inline-flex; align-items: center; gap: 8px; font-size: 13px;
    color: rgba(255,255,255,.5); cursor: pointer;
    background: none; border: none; font-family: 'Inter', sans-serif; transition: color .2s;
    font-weight: 600;
}
.sv-fav-btn:hover { color: #e83e8c; }
.sv-fav-btn.active { color: #e83e8c; }
.sv-share { display: flex; align-items: center; gap: 8px; }
.sv-share-label { font-size: 12px; color: rgba(255,255,255,.3); font-family: 'Inter', sans-serif; }
.sv-share-btn {
    width: 34px; height: 34px; border-radius: 50%;
    border: 1.5px solid rgba(232,62,140,.3);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.5); font-size: 13px;
    text-decoration: none; cursor: pointer;
    background: rgba(255,255,255,.04); transition: .22s;
}
.sv-share-btn:hover { border-color: rgba(232,62,140,.7); color: #e83e8c; background: rgba(232,62,140,.08); }

/* Toast */
.sv-toast {
    position: fixed; bottom: 28px; left: 50%;
    transform: translateX(-50%) translateY(80px);
    background: #1a0d2e; color: #fff;
    padding: 13px 22px; border-radius: 14px;
    font-size: 13.5px; font-weight: 600;
    font-family: 'Inter', sans-serif;
    z-index: 9999; opacity: 0;
    transition: transform .3s ease, opacity .3s ease;
    white-space: nowrap; pointer-events: none;
    display: flex; align-items: center; gap: 10px;
    border-left: 4px solid #e83e8c;
    box-shadow: 0 8px 32px rgba(0,0,0,.5);
}
.sv-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.sv-toast.success { border-left-color: #22c55e; }
.sv-toast.error   { border-left-color: #ef4444; }
.sv-toast.share   { border-left-color: #60a5fa; }

@media (max-width: 1024px) {
    .sv-layout.has-gallery { grid-template-columns: 70px 1fr 300px; gap: 18px; }
    .sv-layout:not(.has-gallery) { grid-template-columns: 1fr 300px; gap: 18px; }
}
@media (max-width: 767px) {
    .sv-layout, .sv-layout.has-gallery { grid-template-columns: 1fr; }
    .sv-thumbs { flex-direction: row; }
    .sv-thumb { width: 64px; height: 64px; }
    .sv-panel { padding-left: 0; }
    .sv-actions { flex-direction: column; align-items: flex-start; gap: 14px; }
}
</style>
@endpush

@section('content')
<div class="sv-wrap">
<div class="container">

    {{-- Breadcrumb --}}
    <div class="sv-crumb">
        <a href="{{ route('home') }}">{{ __('messages.nav_link_home') }}</a>
        <span>›</span>
        <a href="{{ route('services.index') }}">{{ __('messages.svc_show_breadcrumb') }}</a>
        <span>›</span>
        {{ $service->name ?? $service->nom }}
    </div>

    @php
        $serviceName = $service->name ?? $service->nom ?? 'Service';
        $serviceDesc = $service->description ?? 'A protective style that is gentle on your hair and scalp. Lightweight, natural-looking, and long-lasting with proper care.';
        $mainImg = $service->image_url ?? asset('images/C34.jpg');
        // Only include real additional images if the service has a gallery relationship
        $extraImgs = collect($service->images ?? [])
            ->pluck('url')
            ->filter()
            ->values()
            ->toArray();
        $thumbImgs = array_unique(array_merge([$mainImg], $extraImgs));
        $hasGallery = count($thumbImgs) > 1;
        $features = [
            __('messages.svc_show_feature1'),
            __('messages.svc_show_feature2'),
            __('messages.svc_show_feature3'),
            __('messages.svc_show_feature4'),
        ];
    @endphp

    <div class="sv-layout {{ $hasGallery ? 'has-gallery' : '' }}">

        {{-- LEFT: Thumbnails (only if multiple images) --}}
        @if($hasGallery)
        <div class="sv-thumbs">
            @foreach($thumbImgs as $i => $img)
            <div class="sv-thumb {{ $i===0?'active':'' }}" onclick="switchImg('{{ $img }}', this)">
                <img src="{{ $img }}" alt="vue {{ $i+1 }}" loading="lazy">
            </div>
            @endforeach
        </div>
        @endif

        {{-- CENTER: Main Image --}}
        <div class="sv-main-img">
            <img id="mainImg" src="{{ $mainImg }}" alt="{{ $serviceName }}">
        </div>

        {{-- RIGHT: Details --}}
        <div class="sv-panel">
            <h1 class="sv-panel-name">{{ $serviceName }}</h1>

            <p class="sv-panel-desc">{{ $serviceDesc }}</p>

            <div class="sv-features">
                @foreach($features as $feat)
                <div class="sv-feature">
                    <div class="sv-feature-icon"><i class="fa-solid fa-check"></i></div>
                    {{ $feat }}
                </div>
                @endforeach
            </div>

            <div class="sv-book-box">
                <div class="sv-book-title">{{ __('messages.svc_show_book_title') }}</div>
                <div class="sv-steps">
                    <div class="sv-step"><div class="sv-step-num">1</div> {{ __('messages.svc_show_step1') }}</div>
                    <div class="sv-step"><div class="sv-step-num">2</div> {{ __('messages.svc_show_step2') }}</div>
                    <div class="sv-step"><div class="sv-step-num">3</div> {{ __('messages.svc_show_step3') }}</div>
                </div>
                <a href="{{ route('booking.start', ['service' => $service->id]) }}" class="sv-btn-book">
                    {{ __('messages.svc_show_book_btn') }}
                </a>
            </div>

            <div class="sv-actions">
                <button class="sv-fav-btn" id="favBtn" onclick="toggleFav()">
                    <i class="{{ isset($isFavorite) && $isFavorite ? 'fa-solid' : 'fa-regular' }} fa-heart" id="favIcon"></i>
                    <span id="favLabel">{{ isset($isFavorite) && $isFavorite ? __('messages.svc_show_remove_fav') : __('messages.svc_show_add_fav') }}</span>
                </button>
                <div class="sv-share">
                    <span class="sv-share-label">{{ __('messages.svc_show_share') }}</span>
                    <a href="https://wa.me/?text={{ urlencode($serviceName . ' — ' . url()->current()) }}" target="_blank" class="sv-share-btn" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="sv-share-btn" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <button class="sv-share-btn" onclick="navigator.clipboard.writeText(window.location.href)" title="{{ __('messages.svc_show_copy') }}">
                        <i class="fa-solid fa-link"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>{{-- /.sv-layout --}}

</div>
</div>

{{-- Toast --}}
<div class="sv-toast" id="svToast" role="status" aria-live="polite"></div>

@endsection

@push('scripts')
<script>
/* ── Toast ── */
function svToast(msg, type = 'info') {
    const t = document.getElementById('svToast');
    const icons = {
        success: '<i class="fa-solid fa-circle-check"></i>',
        error:   '<i class="fa-solid fa-circle-xmark"></i>',
        info:    '<i class="fa-solid fa-heart"></i>',
        share:   '<i class="fa-solid fa-link"></i>'
    };
    t.innerHTML = (icons[type] || '') + ' ' + msg;
    t.className = 'sv-toast show ' + type;
    clearTimeout(t._tid);
    t._tid = setTimeout(() => t.classList.remove('show'), 3000);
}

/* ── Galerie images ── */
function switchImg(src, el) {
    const main = document.getElementById('mainImg');
    main.style.opacity = '0';
    setTimeout(() => { main.src = src; main.style.opacity = '1'; }, 200);
    document.querySelectorAll('.sv-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
document.getElementById('mainImg').style.transition = 'opacity .2s';

/* ── Favoris ── */
function toggleFav() {
    @if(auth()->check())
    const addFavText    = '{{ __("messages.svc_show_add_fav") }}';
    const removeFavText = '{{ __("messages.svc_show_remove_fav") }}';
    const icon  = document.getElementById('favIcon');
    const label = document.getElementById('favLabel');
    const btn   = document.getElementById('favBtn');
    const isFav = icon.classList.contains('fa-solid');

    icon.className = isFav ? 'fa-regular fa-heart' : 'fa-solid fa-heart';
    label.textContent = isFav ? addFavText : removeFavText;
    btn.classList.toggle('active', !isFav);

    /* pop animation */
    icon.style.transform = 'scale(1.4)';
    setTimeout(() => icon.style.transform = '', 220);

    fetch('/favorites/{{ $service->id }}/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(() => {
        svToast(!isFav ? '{{ __("messages.svc_liked") }}' : '{{ __("messages.svc_unliked") }}', 'info');
        syncServiceLike({{ $service->id }}, !isFav);
    })
    .catch(() => svToast(!isFav ? '{{ __("messages.svc_liked") }}' : '{{ __("messages.svc_unliked") }}', 'info'));
    @else
    svToast('{{ __("messages.svc_login_to_like") }}', 'error');
    setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1500);
    @endif
}

/* ── Partager — copie lien ── */
document.querySelector('.sv-share-btn[title="{{ __("messages.svc_show_copy") }}"]')
    ?.addEventListener('click', async function () {
        try {
            await navigator.clipboard.writeText(window.location.href);
            svToast('Lien copié dans le presse-papier !', 'share');
        } catch (_) {
            svToast(window.location.href, 'share');
        }
    });
</script>
@endpush

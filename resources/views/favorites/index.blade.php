@extends('layouts.client')

@section('title', __('messages.fav_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.fav-wrap{max-width:1200px;}

.fav-header{margin-bottom:40px;}
.fav-title{font-size:2.4rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin:0 0 10px;letter-spacing:-.5px;}
.fav-subtitle{font-size:.95rem;color:var(--muted);margin-bottom:14px;}
.fav-count-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(233,30,140,.1);border:1px solid rgba(233,30,140,.25);color:var(--pink-light);font-size:.85rem;font-weight:600;padding:8px 18px;border-radius:999px;}

.fav-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:26px;}

.fav-card{background:var(--card);border:1px solid var(--card-border);border-radius:22px;overflow:hidden;transition:.35s;display:flex;flex-direction:column;}
.fav-card:hover{transform:translateY(-8px);border-color:rgba(233,30,140,.3);box-shadow:0 20px 50px rgba(0,0,0,.35);}

.fav-img-wrap{position:relative;height:210px;overflow:hidden;background:rgba(233,30,140,.06);}
.fav-img-wrap img{width:100%;height:100%;object-fit:cover;transition:.4s;}
.fav-card:hover .fav-img-wrap img{transform:scale(1.08);}
.fav-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,transparent 30%,rgba(10,5,25,.9) 100%);}
.fav-placeholder{display:flex;align-items:center;justify-content:center;font-size:3.5rem;width:100%;height:100%;color:rgba(233,30,140,.3);}

.fav-badge-cat{position:absolute;top:14px;left:14px;background:rgba(15,8,30,.8);border:1px solid rgba(233,30,140,.3);color:var(--pink-light);font-size:.72rem;font-weight:700;padding:5px 13px;border-radius:999px;text-transform:uppercase;letter-spacing:.07em;backdrop-filter:blur(8px);}

.fav-remove-btn{position:absolute;top:12px;right:12px;width:38px;height:38px;border-radius:50%;background:rgba(15,8,30,.8);border:1px solid rgba(233,30,140,.25);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--pink-light);font-size:15px;transition:.2s;backdrop-filter:blur(8px);}
.fav-remove-btn:hover{background:rgba(233,30,140,.2);border-color:rgba(233,30,140,.5);transform:scale(1.1);}

.fav-body{padding:22px;flex-grow:1;display:flex;flex-direction:column;}
.fav-cat{font-size:.72rem;color:var(--pink);font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;}
.fav-name{font-size:1rem;font-weight:800;color:var(--text);margin:0 0 8px;line-height:1.3;}
.fav-desc{font-size:.84rem;color:var(--muted);margin:0 0 14px;line-height:1.6;flex-grow:1;}

.fav-rating{display:flex;align-items:center;gap:8px;margin-bottom:14px;}
.fav-stars{display:flex;gap:2px;}
.fav-stars i{font-size:11px;color:var(--pink);}
.fav-rating-txt{font-size:.78rem;color:var(--muted);}

.fav-footer{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-top:14px;border-top:1px solid rgba(255,255,255,.06);}
.fav-price{font-size:1.15rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.fav-duration{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:5px;margin-top:3px;}

.btn-reserve{background:var(--gradient);color:#fff;font-size:.82rem;font-weight:700;padding:10px 16px;border-radius:12px;border:none;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:7px;white-space:nowrap;text-decoration:none;box-shadow:0 6px 16px rgba(233,30,140,.3);}
.btn-reserve:hover{transform:translateY(-2px);color:#fff;}

.empty-state{text-align:center;padding:80px 24px;display:grid;place-items:center;min-height:400px;}
.empty-icon{font-size:4.5rem;color:rgba(233,30,140,.2);margin-bottom:22px;}
.empty-state h3{font-size:1.7rem;font-weight:800;color:var(--text);margin-bottom:10px;}
.empty-state p{font-size:.95rem;color:var(--muted);margin-bottom:28px;}
.btn-explore{background:var(--gradient);color:#fff;padding:13px 28px;border-radius:14px;border:none;font-weight:700;font-size:.92rem;cursor:pointer;transition:.25s;display:inline-flex;align-items:center;gap:8px;text-decoration:none;box-shadow:0 8px 20px rgba(233,30,140,.3);}
.btn-explore:hover{transform:translateY(-2px);color:#fff;}

/* ── SECTION DÉCOUVRIR ─────── */
.discover-section{margin-top:64px;}
.discover-header{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:28px;}
.discover-title{font-size:1.45rem;font-weight:900;color:var(--text);letter-spacing:-.02em;}
.discover-title span{background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.discover-divider{height:1px;background:linear-gradient(to right,rgba(233,30,140,.25),transparent);margin-bottom:32px;}

.svc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;}

.svc-item{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:20px;overflow:hidden;display:flex;flex-direction:column;transition:.3s;}
.svc-item:hover{transform:translateY(-6px);border-color:rgba(233,30,140,.25);box-shadow:0 16px 40px rgba(0,0,0,.3);}

.svc-img-wrap{position:relative;height:180px;overflow:hidden;background:rgba(233,30,140,.05);}
.svc-img-wrap img{width:100%;height:100%;object-fit:cover;transition:.4s;}
.svc-item:hover .svc-img-wrap img{transform:scale(1.06);}
.svc-img-placeholder{display:flex;align-items:center;justify-content:center;height:100%;font-size:2.8rem;color:rgba(233,30,140,.25);}

.svc-fav-btn{position:absolute;top:10px;right:10px;width:36px;height:36px;border-radius:50%;background:rgba(15,8,30,.78);border:1px solid rgba(233,30,140,.22);color:rgba(255,255,255,.55);display:flex;align-items:center;justify-content:center;font-size:14px;cursor:pointer;backdrop-filter:blur(8px);transition:.2s;z-index:2;}
.svc-fav-btn:hover{background:rgba(233,30,140,.15);border-color:rgba(233,30,140,.5);color:#ec4899;transform:scale(1.1);}
.svc-fav-btn.favorited{background:rgba(233,30,140,.2);border-color:rgba(233,30,140,.55);color:#ec4899;}
.svc-fav-btn.loading{opacity:.5;pointer-events:none;}

.svc-cat-badge{position:absolute;top:10px;left:10px;background:rgba(15,8,30,.8);border:1px solid rgba(233,30,140,.28);color:var(--pink-light);font-size:.68rem;font-weight:700;padding:4px 11px;border-radius:999px;text-transform:uppercase;letter-spacing:.06em;backdrop-filter:blur(8px);}

.svc-body{padding:18px;flex:1;display:flex;flex-direction:column;}
.svc-name{font-size:.95rem;font-weight:800;color:var(--text);margin:0 0 6px;line-height:1.3;}
.svc-desc{font-size:.82rem;color:var(--muted);line-height:1.6;flex:1;margin-bottom:14px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.svc-meta{display:flex;align-items:center;justify-content:space-between;gap:10px;padding-top:12px;border-top:1px solid rgba(255,255,255,.05);}
.svc-price{font-size:1.05rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.svc-dur{font-size:.75rem;color:var(--muted);display:flex;align-items:center;gap:4px;}
.btn-add-fav{display:inline-flex;align-items:center;gap:6px;background:rgba(233,30,140,.1);border:1px solid rgba(233,30,140,.28);color:var(--pink-light);font-size:.78rem;font-weight:700;padding:8px 14px;border-radius:10px;cursor:pointer;transition:.2s;white-space:nowrap;}
.btn-add-fav:hover{background:rgba(233,30,140,.2);border-color:rgba(233,30,140,.5);}
.btn-add-fav.favorited{background:rgba(233,30,140,.18);border-color:#ec4899;color:#ec4899;}

@media(max-width:640px){
    .fav-grid{grid-template-columns:1fr;gap:18px;}
    .svc-grid{grid-template-columns:1fr;}
    .fav-title{font-size:1.8rem;}
}
</style>

<div class="fav-wrap">

    <div class="fav-header">
        <h1 class="fav-title"><i class="fa-solid fa-heart"></i> {{ __('messages.fav_title') }}</h1>
        <p class="fav-subtitle">{{ __('messages.fav_subtitle') }}</p>
        @if($favorites->count() > 0)
        <span class="fav-count-badge">
            <i class="fa-solid fa-star"></i>
            {{ $favorites->count() }} service{{ $favorites->count() > 1 ? 's' : '' }}
        </span>
        @endif
    </div>

    @if($favorites->count() > 0)
    <div class="fav-grid" id="fav-grid">
        @foreach($favorites as $favorite)
        @php $svc = $favorite->service; @endphp
        <div class="fav-card" id="fav-card-{{ $svc->id }}" data-service-id="{{ $svc->id }}">
            <div class="fav-img-wrap">
                @if($svc->image)
                    <img src="{{ asset('storage/'.$svc->image) }}" alt="{{ $svc->name }}">
                @else
                    <div class="fav-placeholder"><i class="fa-solid fa-scissors"></i></div>
                @endif
                <div class="fav-img-overlay"></div>
                <span class="fav-badge-cat">
                    <i class="fa-solid fa-tag" style="margin-right:4px;"></i>
                    {{ $svc->categorie->nom ?? $svc->category ?? 'Service' }}
                </span>
                <button type="button"
                        class="fav-remove-btn"
                        title="{{ __('messages.fav_remove_title') }}"
                        onclick="removeFavorite({{ $svc->id }}, this)"
                        data-url="{{ route('favorites.toggle', $svc) }}">
                    <i class="fa-solid fa-heart-crack"></i>
                </button>
            </div>
            <div class="fav-body">
                <div class="fav-cat">{{ $svc->categorie->nom ?? $svc->category ?? 'Service' }}</div>
                <h3 class="fav-name">{{ $svc->name }}</h3>
                <p class="fav-desc">{{ Str::limit($svc->description, 100) }}</p>
                <div class="fav-rating">
                    <div class="fav-stars">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>
                    <span class="fav-rating-txt">{{ $svc->reviews_count ?? 0 }} avis</span>
                </div>
                <div class="fav-footer">
                    <div>
                        <div class="fav-price">{{ number_format($svc->price, 0, ',', ' ') }}</div>
                        @if($svc->duration)
                        <div class="fav-duration">
                            <i class="fa-regular fa-clock"></i>
                            {{ $svc->duration >= 60 ? intdiv($svc->duration, 60).'h'.($svc->duration % 60 ? ($svc->duration % 60).'min' : '') : $svc->duration.'min' }}
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('services.show', $svc) }}" class="btn-reserve">
                        <i class="fa-solid fa-calendar-check"></i> {{ __('messages.fav_book') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div>
            <div class="empty-icon"><i class="fa-regular fa-heart"></i></div>
            <h3>{{ __('messages.fav_empty_title') }}</h3>
            <p>{{ __('messages.fav_empty_text') }}</p>
            <a href="{{ route('services.index') }}" class="btn-explore">
                <i class="fa-solid fa-sparkles"></i> {{ __('messages.fav_discover') }}
            </a>
        </div>
    </div>
    @endif

    {{-- ── SECTION DÉCOUVRIR D'AUTRES SERVICES ────────────────────── --}}
    @php $otherServices = $allServices->whereNotIn('id', $favoriteIds); @endphp
    @if($otherServices->count() > 0)
    <div class="discover-section">
        <div class="discover-divider"></div>
        <div class="discover-header">
            <h2 class="discover-title">
                {{ __('messages.fav_discover_more') }} <span>services</span>
            </h2>
            <span class="fav-count-badge" style="font-size:.78rem;">
                <i class="fa-solid fa-scissors"></i>
                {{ $otherServices->count() }} service{{ $otherServices->count() > 1 ? 's' : '' }} disponible{{ $otherServices->count() > 1 ? 's' : '' }}
            </span>
        </div>

        <div class="svc-grid">
            @foreach($otherServices as $svc)
            <div class="svc-item" id="svc-item-{{ $svc->id }}">
                <div class="svc-img-wrap">
                    @if($svc->image)
                        <img src="{{ asset('storage/'.$svc->image) }}" alt="{{ $svc->name }}" loading="lazy">
                    @else
                        <div class="svc-img-placeholder"><i class="fa-solid fa-scissors"></i></div>
                    @endif

                    @if($svc->category)
                        <span class="svc-cat-badge">{{ $svc->category }}</span>
                    @endif

                    <button type="button"
                            class="svc-fav-btn"
                            title="{{ __('messages.fav_add_title') }}"
                            data-service-id="{{ $svc->id }}"
                            data-url="{{ route('favorites.toggle', $svc) }}"
                            onclick="toggleFromDiscover(this)">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </div>

                <div class="svc-body">
                    <h3 class="svc-name">{{ $svc->name }}</h3>
                    <p class="svc-desc">
                        {{ $svc->description ?: __('messages.fav_default_desc') }}
                    </p>
                    <div class="svc-meta">
                        <div>
                            <div class="svc-price">{{ number_format($svc->price, 0, ',', ' ') }}</div>
                            @if($svc->duration)
                            <div class="svc-dur">
                                <i class="fa-regular fa-clock"></i>
                                {{ $svc->duration >= 60 ? intdiv($svc->duration, 60).'h'.($svc->duration % 60 ? ($svc->duration % 60).'min' : '') : $svc->duration.'min' }}
                            </div>
                            @endif
                        </div>
                        <button type="button"
                                class="btn-add-fav"
                                data-service-id="{{ $svc->id }}"
                                data-url="{{ route('favorites.toggle', $svc) }}"
                                onclick="toggleFromDiscover(this)">
                            <i class="fa-regular fa-heart"></i>
                            {{ __('messages.fav_add_short') }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;

function removeFavorite(serviceId, btn) {
    btn.disabled = true;
    const card = document.getElementById('fav-card-' + serviceId);
    const grid = document.getElementById('fav-grid');

    fetch(btn.dataset.url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
    })
    .then(r => r.json())
    .then(() => {
        syncServiceLike(serviceId, false);
        // Animate out the favorites card
        card.style.transition = 'opacity .3s, transform .3s';
        card.style.opacity    = '0';
        card.style.transform  = 'scale(.95)';
        setTimeout(() => {
            card.remove();
            const remaining = grid ? grid.querySelectorAll('.fav-card').length : 0;
            updateFavBadge(remaining);
            if (remaining === 0) {
                grid && grid.closest('.fav-grid-wrap') && grid.closest('.fav-grid-wrap').remove();
                showEmptyFav();
            }
            // Move the service card back to the discover section
            restoreToDiscover(serviceId);
        }, 300);
    })
    .catch(() => { btn.disabled = false; });
}

function toggleFromDiscover(btn) {
    const serviceId = btn.dataset.serviceId;
    btn.classList.add('loading');

    // Sync both buttons in the same card (icon + text button)
    const card = document.getElementById('svc-item-' + serviceId);
    const allBtns = card ? card.querySelectorAll('[data-service-id="' + serviceId + '"]') : [btn];

    fetch(btn.dataset.url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
    })
    .then(r => r.json())
    .then(data => {
        allBtns.forEach(b => b.classList.remove('loading'));
        syncServiceLike(serviceId, data.favorited);

        if (data.favorited) {
            // Animate card into favorites grid
            if (card) {
                card.style.transition = 'opacity .3s, transform .3s';
                card.style.opacity    = '0';
                card.style.transform  = 'scale(.95)';
                setTimeout(() => { card.remove(); }, 300);
            }
            // Update favorites badge count (reload to show new card properly)
            const favGrid = document.getElementById('fav-grid');
            const currentCount = favGrid ? favGrid.querySelectorAll('.fav-card').length : 0;
            updateFavBadge(currentCount + 1);

            // Reload page to show new favorite card properly
            setTimeout(() => location.reload(), 350);
        } else {
            // Removed from favorites — update UI
            allBtns.forEach(b => {
                b.classList.remove('favorited');
                const icon = b.querySelector('i');
                if (icon) { icon.classList.replace('fa-solid', 'fa-regular'); }
                if (b.classList.contains('btn-add-fav')) b.innerHTML = '<i class="fa-regular fa-heart"></i> Ajouter';
            });
        }
    })
    .catch(() => allBtns.forEach(b => b.classList.remove('loading')));
}

function updateFavBadge(count) {
    const badge = document.querySelector('.fav-count-badge');
    if (badge) badge.textContent = count + ' service' + (count > 1 ? 's' : '');
}

function showEmptyFav() {
    // Show empty state if no favorites remain
    const wrap = document.querySelector('.fav-wrap');
    const section = document.createElement('div');
    section.className = 'empty-state';
    section.innerHTML = `
        <div>
            <div class="empty-icon"><i class="fa-regular fa-heart"></i></div>
            <h3>Aucun favori pour le moment</h3>
            <p>Ajoutez des services ci-dessous</p>
        </div>`;
    wrap.insertBefore(section, document.querySelector('.discover-section'));
}

function restoreToDiscover(serviceId) {
    // If the card exists in discover section, show it again (already removed = not needed)
    const card = document.getElementById('svc-item-' + serviceId);
    if (card) {
        card.style.opacity   = '0';
        card.style.transform = 'scale(.95)';
        setTimeout(() => {
            card.style.transition = 'opacity .3s, transform .3s';
            card.style.opacity    = '1';
            card.style.transform  = '';
        }, 50);
        // Reset buttons
        card.querySelectorAll('.svc-fav-btn, .btn-add-fav').forEach(b => {
            b.classList.remove('favorited');
            const icon = b.querySelector('i');
            if (icon) { icon.classList.replace('fa-solid', 'fa-regular'); }
            if (b.classList.contains('btn-add-fav')) b.innerHTML = '<i class="fa-regular fa-heart"></i> Ajouter';
        });
    }
}
</script>
@endpush

@endsection

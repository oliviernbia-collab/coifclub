@extends('layouts.app')

@section('title', ($stylist->user->name ?? 'Coiffeuse') . ' — Services')

@section('content')

<style>
:root{
    --pink:#e91e8c; --pink-lt:#ff6ab4; --pink-dark:#c91a78;
    --bg:#0e0a1c; --card:#1a1130; --card2:#120e22;
    --border:rgba(255,255,255,.07); --border-pk:rgba(233,30,140,.15);
    --text:#fff; --muted:rgba(255,255,255,.55);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

body { background:var(--bg); color:var(--text); }

.sp-wrap { max-width:1100px; margin:0 auto; padding:48px 20px 80px; }

/* ── PROFILE HERO ── */
.sp-hero {
    display:grid;
    grid-template-columns:200px 1fr;
    gap:28px;
    align-items:center;
    background:linear-gradient(135deg,#120e22 0%,#1a1130 100%);
    border:1px solid var(--border-pk);
    border-radius:22px;
    padding:24px 28px;
    margin:0 auto 30px;
    max-width:680px;
    position:relative;
    overflow:hidden;
}
.sp-hero::before {
    content:''; position:absolute; top:-60px; right:-80px;
    width:280px; height:280px; border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.1),transparent 70%);
    pointer-events:none;
}

.sp-photo-wrap {
    position:relative;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 16px 48px rgba(0,0,0,.35), 0 0 0 3px rgba(233,30,140,.25);
}
.sp-photo-wrap img {
    width:100%;
    height:230px;
    object-fit:cover;
    object-position:top;
    display:block;
}

.sp-info { position:relative; z-index:1; padding-left:8px; }
.sp-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(233,30,140,.12); border:1px solid var(--border-pk);
    color:var(--pink-lt); padding:6px 14px; border-radius:99px;
    font-size:.75rem; font-weight:700; letter-spacing:.08em;
    text-transform:uppercase; margin-bottom:14px;
}
.sp-name { font-size:1.55rem; font-weight:900; color:var(--text); margin-bottom:4px; line-height:1.1; }
.sp-specialty { color:var(--pink-lt); font-size:.88rem; font-weight:600; margin-bottom:12px; }
.sp-bio { color:var(--muted); font-size:.84rem; line-height:1.65; max-width:400px; margin-bottom:14px; }

.sp-stats {
    display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px;
}
.sp-stat {
    background:rgba(255,255,255,.05); border:1px solid var(--border-pk);
    border-radius:12px; padding:8px 14px; text-align:center;
}
.sp-stat-val { font-size:1rem; font-weight:900; color:var(--pink-lt); line-height:1; }
.sp-stat-lbl { font-size:.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-top:3px; }

.sp-btn {
    display:inline-flex; align-items:center; gap:8px;
    background:var(--gradient); color:#fff; text-decoration:none;
    padding:10px 20px; border-radius:12px; font-weight:700; font-size:.84rem;
    box-shadow:0 6px 18px rgba(233,30,140,.3); transition:.25s;
}
.sp-btn:hover { transform:translateY(-2px); box-shadow:0 10px 26px rgba(233,30,140,.45); color:#fff; }

/* ── SERVICES HEADER ── */
.sp-section-head {
    display:flex; align-items:center; gap:10px;
    font-size:.68rem; font-weight:700; letter-spacing:.14em;
    text-transform:uppercase; color:var(--pink);
    margin-bottom:24px;
}
.sp-section-head::after { content:''; flex:1; height:1px; background:var(--border-pk); }

/* ── SERVICES GRID ── */
.sp-services { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; }

.sp-svc-card {
    background:var(--card); border:1px solid var(--border-pk);
    border-radius:20px; overflow:hidden;
    transition:.3s; box-shadow:0 4px 16px rgba(0,0,0,.2);
}
.sp-svc-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(233,30,140,.15); border-color:rgba(233,30,140,.35); }

.sp-svc-img { height:180px; overflow:hidden; position:relative; }
.sp-svc-img img { width:100%; height:100%; object-fit:cover; transition:.6s; }
.sp-svc-card:hover .sp-svc-img img { transform:scale(1.07); }
.sp-svc-img::after { content:''; position:absolute; inset:0; background:linear-gradient(to top,rgba(14,10,28,.5),transparent); }

.sp-svc-body { padding:20px; }
.sp-svc-name { font-size:1rem; font-weight:800; color:var(--text); margin-bottom:8px; }
.sp-svc-desc { font-size:.84rem; color:var(--muted); line-height:1.65; margin-bottom:14px; min-height:42px; }
.sp-svc-meta { display:flex; align-items:center; justify-content:space-between; }
.sp-svc-price { font-size:1.2rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
.sp-svc-dur { font-size:.8rem; color:var(--muted); display:flex; align-items:center; gap:5px; }
.sp-svc-btn {
    display:block; width:100%; margin-top:14px;
    background:var(--gradient); color:#fff; text-align:center; text-decoration:none;
    border:none; border-radius:12px; padding:11px;
    font-weight:700; font-size:.88rem; cursor:pointer; transition:.25s;
}
.sp-svc-btn:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(233,30,140,.35); color:#fff; }

/* ── EMPTY ── */
.sp-empty { text-align:center; padding:60px 20px; color:var(--muted); }
.sp-empty i { font-size:3rem; color:var(--pink); margin-bottom:16px; display:block; }

/* ── BACK ── */
.sp-back {
    display:inline-flex; align-items:center; gap:8px;
    color:var(--muted); text-decoration:none; font-size:.88rem; font-weight:600;
    margin-bottom:24px; transition:.2s;
}
.sp-back:hover { color:var(--pink-lt); }

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .sp-hero { grid-template-columns:1fr; gap:16px; padding:18px; }
    .sp-photo-wrap img { height:180px; }
    .sp-name { font-size:1.35rem; }
    .sp-services { grid-template-columns:1fr; }
}
</style>

<div class="sp-wrap">

    <a href="{{ route('stylists.index') }}" class="sp-back">
        <i class="fa-solid fa-arrow-left"></i> Retour à l'équipe
    </a>

    {{-- PROFILE HERO --}}
    <div class="sp-hero">
        <div class="sp-photo-wrap">
            <img src="{{ $stylist->photo_url }}" alt="{{ $stylist->user->name ?? 'Coiffeuse' }}">
        </div>
        <div class="sp-info">
            <div class="sp-badge"><i class="fa-solid fa-star"></i> Experte certifiée</div>
            <h1 class="sp-name">{{ $stylist->user->name ?? 'Coiffeuse' }}</h1>
            <div class="sp-specialty">{{ $stylist->specialty ?? 'Coiffeuse professionnelle' }}</div>
            @if($stylist->bio)
            <p class="sp-bio">{{ $stylist->bio }}</p>
            @endif
            <div class="sp-stats">
                <div class="sp-stat">
                    <div class="sp-stat-val">{{ $stylist->services->count() }}</div>
                    <div class="sp-stat-lbl">Services</div>
                </div>
                <div class="sp-stat">
                    <div class="sp-stat-val">★ 5.0</div>
                    <div class="sp-stat-lbl">Note</div>
                </div>
                <div class="sp-stat">
                    <div class="sp-stat-val">Pro</div>
                    <div class="sp-stat-lbl">Statut</div>
                </div>
            </div>
            <a href="{{ route('booking.appointment', ['employee_id' => $stylist->id]) }}" class="sp-btn">
                <i class="fa-solid fa-calendar-check"></i>
                Prendre rendez-vous
            </a>
        </div>
    </div>

    {{-- SERVICES --}}
    <div class="sp-section-head">
        <i class="fa-solid fa-scissors"></i> Ses services
    </div>

    @if($stylist->services->isEmpty())
    <div class="sp-empty">
        <i class="fa-solid fa-scissors"></i>
        <p>Aucun service assigné pour le moment.</p>
    </div>
    @else
    <div class="sp-services">
        @foreach($stylist->services as $service)
        <div class="sp-svc-card">
            <div class="sp-svc-img" style="cursor:default;">
                <img src="{{ $service->image ? asset('storage/'.$service->image) : 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&q=80' }}"
                     alt="{{ $service->name ?? $service->nom }}"
                     onerror="this.src='https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&q=80'">
            </div>
            <div class="sp-svc-body">
                <div class="sp-svc-name">{{ $service->name ?? $service->nom }}</div>
                <div class="sp-svc-desc">{{ \Illuminate\Support\Str::limit($service->description ?? '', 90) }}</div>
                <div class="sp-svc-meta">
                    <span class="sp-svc-price">
                        {{ number_format($service->price ?? $service->prix ?? 0, 0, ',', ' ') }}
                    </span>
                    @if($service->duration ?? $service->duree)
                    <span class="sp-svc-dur">
                        <i class="fa-regular fa-clock"></i>
                        {{ $service->formatted_duration ?? ($service->duration ?? $service->duree) . ' min' }}
                    </span>
                    @endif
                </div>
                <a href="{{ route('booking.appointment', ['employee_id' => $stylist->id, 'service_id' => $service->id]) }}" class="sp-svc-btn">
                    <i class="fa-solid fa-calendar-check"></i> Prendre rendez-vous
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection

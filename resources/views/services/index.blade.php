@extends('layouts.home')

@section('title', 'Our Braiding Styles — Marol Hair Braiding')
@section('meta_description', __('messages.svc_hero_text'))

@push('styles')
<style>
.bs-wrap { background: #fff; min-height: 80vh; padding: 40px 0 80px; }

/* Breadcrumb */
.bs-crumb {
    font-size: 12.5px;
    color: #999;
    margin-bottom: 28px;
    font-family: 'Inter', sans-serif;
}
.bs-crumb a { color: #999; text-decoration: none; }
.bs-crumb a:hover { color: #e83e8c; }
.bs-crumb span { color: #e83e8c; margin: 0 6px; }

/* Header */
.bs-header { margin-bottom: 32px; }
.bs-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 6px;
}
.bs-header p { font-size: 14px; color: #777; margin: 0; font-family: 'Inter', sans-serif; }

/* Filter tabs */
.bs-filters {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 36px;
}
.bs-filter-btn {
    padding: 8px 18px;
    border-radius: 25px;
    border: 1.5px solid #e8e8e8;
    background: #fff;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    cursor: pointer;
    transition: .2s;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}
.bs-filter-btn:hover { border-color: #e83e8c; color: #e83e8c; }
.bs-filter-btn.active {
    background: #e83e8c;
    border-color: #e83e8c;
    color: #fff;
    font-weight: 600;
}

/* Cards grid */
.bs-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
}
.bs-card {
    border-radius: 14px;
    border: 1px solid #ebebeb;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    transition: .28s;
}
.bs-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,.11); }
.bs-card-img {
    position: relative;
    height: 200px;
    overflow: hidden;
}
.bs-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: .45s;
    display: block;
}
.bs-card:hover .bs-card-img img { transform: scale(1.06); }
.bs-card-heart {
    position: absolute;
    top: 10px; right: 10px;
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,.95);
    border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #bbb;
    font-size: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
    transition: .2s;
}
.bs-card-heart:hover, .bs-card-heart.liked { color: #e83e8c; }
.bs-card-body { padding: 14px 16px 18px; }
.bs-card-name {
    font-size: 14.5px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 5px;
    font-family: 'Inter', sans-serif;
}
.bs-card-price {
    font-size: 12.5px;
    color: #888;
    margin: 0 0 10px;
    font-family: 'Inter', sans-serif;
}
.bs-card-link {
    font-size: 13px;
    font-weight: 600;
    color: #e83e8c;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
}
.bs-card-link:hover { text-decoration: underline; }

/* Pagination */
.bs-pagination { margin-top: 48px; display: flex; justify-content: center; gap: 8px; }
.bs-pagination .page-link {
    border-radius: 8px !important;
    border: 1.5px solid #e8e8e8;
    color: #444;
    font-size: 13px;
    font-weight: 500;
}
.bs-pagination .page-item.active .page-link {
    background: #e83e8c;
    border-color: #e83e8c;
    color: #fff;
}

/* Empty state */
.bs-empty {
    grid-column: 1/-1;
    text-align: center;
    padding: 80px 20px;
    color: #aaa;
    font-family: 'Inter', sans-serif;
}
.bs-empty i { font-size: 3rem; margin-bottom: 16px; display: block; color: #ddd; }

@media (max-width: 991px) { .bs-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 767px) { .bs-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 479px) { .bs-grid { grid-template-columns: 1fr; } .bs-filter-btn { font-size: 12px; padding: 7px 13px; } }
</style>
@endpush

@section('content')
<div class="bs-wrap">
<div class="container">

    {{-- Breadcrumb --}}
    <div class="bs-crumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        Braiding Styles
    </div>

    {{-- Header --}}
    <div class="bs-header">
        <h1>Our Braiding Styles</h1>
        <p>Choose your favorite style and book easily.</p>
    </div>

    {{-- Filter tabs --}}
    @php
        $categories = $services->pluck('categorie.name')->filter()->unique()->values();
        $defaultFilters = ['Knotless', 'Box Braids', 'Twist', 'Cornrows', 'Special'];
    @endphp
    <div class="bs-filters">
        <button class="bs-filter-btn active" data-filter="all">All Styles</button>
        @foreach($categories->take(5) as $cat)
            <button class="bs-filter-btn" data-filter="{{ Str::slug($cat) }}">{{ $cat }}</button>
        @endforeach
        @foreach($defaultFilters as $df)
            @if(!$categories->contains($df))
                <button class="bs-filter-btn" data-filter="{{ Str::slug($df) }}">{{ $df }}</button>
            @endif
        @endforeach
    </div>

    {{-- Grid --}}
    <div class="bs-grid" id="bsGrid">
        @forelse($services as $svc)
        @php
            $imgs = [
                'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?q=80&w=400',
                'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=400',
                'https://images.unsplash.com/photo-1559599101-f09722fb4948?q=80&w=400',
                'https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=400',
                'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?q=80&w=400',
                'https://images.unsplash.com/photo-1503104834685-7205e8607eb9?q=80&w=400',
                'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?q=80&w=400',
            ];
            $imgFallback = $imgs[$loop->index % count($imgs)];
            $isLiked = in_array($svc->id, $likedIds ?? []);
            $isFav   = in_array($svc->id, $favoriteIds ?? []);
        @endphp
        <div class="bs-card" data-cat="{{ Str::slug($svc->categorie->name ?? '') }}">
            <div class="bs-card-img">
                <img src="{{ $svc->image_url ?? $imgFallback }}" alt="{{ $svc->name }}" loading="lazy">
                <button class="bs-card-heart {{ $isFav ? 'liked' : '' }}"
                        data-id="{{ $svc->id }}"
                        title="Add to favorites">
                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                </button>
            </div>
            <div class="bs-card-body">
                <div class="bs-card-name">{{ $svc->name }}</div>
                <div class="bs-card-price">{{ $svc->formatted_price ?? 'From ' . number_format($svc->price ?? 0) }}</div>
                <a href="{{ route('services.show', $svc->id) }}" class="bs-card-link">View Details</a>
            </div>
        </div>
        @empty
        {{-- Default cards if no services in DB --}}
        @php
            $defaults = [
                ['Knotless', 'From $180', 'knotless', $imgs[0]],
                ['Box Braids', 'From $150', 'box-braids', $imgs[1]],
                ['Island Twist', 'From $140', 'twist', $imgs[2]],
                ['Natural Twist', 'From $120', 'twist', $imgs[3]],
                ['Spring Twist', 'From $130', 'twist', $imgs[4]],
                ['Marley Twist', 'From $130', 'twist', $imgs[5]],
                ['French Curls', 'From $120', 'special', $imgs[6]],
                ['Cornrows', 'From $110', 'cornrows', $imgs[0]],
                ['Tribal Braids', 'From $180', 'knotless', $imgs[1]],
                ['Lemonade Braids', 'From $150', 'knotless', $imgs[2]],
                ['Miracle Knots', 'From $100', 'knotless', $imgs[3]],
            ];
        @endphp
        @foreach($defaults as $d)
        <div class="bs-card" data-cat="{{ $d[2] }}">
            <div class="bs-card-img">
                <img src="{{ $d[3] }}" alt="{{ $d[0] }}" loading="lazy">
                <button class="bs-card-heart"><i class="fa-regular fa-heart"></i></button>
            </div>
            <div class="bs-card-body">
                <div class="bs-card-name">{{ $d[0] }}</div>
                <div class="bs-card-price">{{ $d[1] }}</div>
                <a href="{{ route('booking.start') }}" class="bs-card-link">View Details</a>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($services, 'links'))
    <div class="bs-pagination">
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>
</div>
@endsection

@push('scripts')
<script>
// Category filter
document.querySelectorAll('.bs-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.bs-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const f = this.dataset.filter;
        document.querySelectorAll('.bs-card').forEach(card => {
            card.style.display = (f === 'all' || card.dataset.cat === f) ? '' : 'none';
        });
    });
});
// Heart toggle
document.querySelectorAll('.bs-card-heart').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const liked = this.classList.toggle('liked');
        this.querySelector('i').className = liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
    });
});
</script>
@endpush

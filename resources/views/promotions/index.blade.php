@extends('layouts.admin')

@section('title', 'Promotions')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
body{
    background:#f4f7fb;
}

/* =========================
   PAGE HEADER CARD
========================= */
.page-header{
    background:#fff;
    border-radius:28px;
    padding:28px;
    box-shadow:0 10px 35px rgba(15,23,42,.05);
    border:1px solid #e2e8f0;
    margin-bottom:28px;
}

.page-title{
    font-size:30px;
    font-weight:900;
    color:#D4AF37;
}

.page-subtitle{
    color:#64748b;
    margin-top:6px;
    font-size:14px;
}

/* =========================
   PROMO FORM
========================= */
.promo-form{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-top:18px;
}

.promo-input{
    flex:1;
    min-width:220px;
    padding:14px 16px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    background:#f8fafc;
    outline:none;
    font-weight:600;
}
.promo-filter-bar{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:10px;
    margin-top:20px;
}

.filter-chip{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:10px 16px;
    border-radius:999px;
    background:#f8fafc;
    color:#0f172a;
    font-weight:700;
    text-decoration:none;
    border:1px solid transparent;
    transition:.2s ease;
}

.filter-chip:hover,
.filter-chip.active{
    background:linear-gradient(135deg,#D4AF37,#f6e27a);
    color:#111827;
    border-color:transparent;
    box-shadow:0 4px 14px rgba(212,175,55,.25);
}

.badge-category{
    display:inline-flex;
    align-items:center;
    padding:7px 12px;
    border-radius:999px;
    background:#fef3c7;
    color:#b45309;
    margin-top:12px;
    font-size:13px;
    font-weight:700;
}
.promo-input:focus{
    border-color:#D4AF37;
    background:#fff;
    box-shadow:0 0 0 3px rgba(212,175,55,.1);
}

.promo-btn{
    padding:14px 22px;
    border:none;
    border-radius:18px;
    font-weight:800;
    color:#111827;
    background:linear-gradient(135deg,#D4AF37,#f6e27a);
    cursor:pointer;
    transition:.25s ease;
    white-space:nowrap;
    box-shadow:0 4px 16px rgba(212,175,55,.28);
}

.promo-btn:hover{
    transform:translateY(-2px);
}

/* =========================
   GRID PROMOS
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:20px;
}

/* CARD PROMO */
.promo-card{
    background:#fff;
    border-radius:26px;
    padding:24px;
    box-shadow:0 10px 35px rgba(15,23,42,.05);
    border:1px solid #e2e8f0;
    transition:.25s ease;
    position:relative;
    overflow:hidden;
}

.promo-card:hover{
    transform:translateY(-4px);
    box-shadow:0 18px 50px rgba(15,23,42,.08);
}

.promo-card::before{
    content:"";
    position:absolute;
    width:140px;
    height:140px;
    background:rgba(212,175,55,.06);
    border-radius:50%;
    right:-50px;
    top:-50px;
}

/* BADGE */
.badge{
    display:inline-flex;
    align-items:center;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.badge-type{
    background:#ecfdf5;
    color:#10b981;
}

/* CODE */
.promo-code{
    font-size:24px;
    font-weight:900;
    color:#0f172a;
    margin-top:14px;
}

/* DESC */
.promo-desc{
    color:#64748b;
    margin-top:10px;
    font-size:14px;
}

/* VALUE */
.promo-value{
    font-size:28px;
    font-weight:900;
    color:#0f172a;
}

.promo-date{
    font-size:13px;
    color:#64748b;
    margin-top:6px;
}

.promo-actions{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin-top:18px;
}

.promo-action-btn{
    padding:10px 14px;
    border-radius:16px;
    font-weight:700;
    font-size:13px;
    border:none;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.promo-action-edit{
    background:linear-gradient(135deg,#D4AF37,#f6e27a);
    color:#111827;
}

.promo-action-delete{
    background:#ef4444;
    color:#fff;
}

/* EMPTY */
.empty{
    background:#fff;
    border-radius:26px;
    padding:50px 20px;
    text-align:center;
    color:#64748b;
    border:1px solid #e2e8f0;
    box-shadow:0 10px 35px rgba(15,23,42,.05);
}
</style>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <div class="page-title">
                <i class="fa-solid fa-tags text-primary me-2"></i>
                Promotions en cours
            </div>
            <p class="page-subtitle">
                Appliquez un code promo et profitez de nos offres exclusives.
            </p>

            <form action="{{ route('promotions.validate') }}" method="POST" class="promo-form">
                @csrf

                <input type="text"
                       name="code"
                       class="promo-input"
                       placeholder="Entrez votre code promo">

                <button type="submit" class="promo-btn">
                    <i class="fa-solid fa-check me-2"></i>
                    Valider
                </button>
            </form>
        </div>

        <div class="promo-filter-bar">
            <a href="{{ route('promotions.index') }}" class="filter-chip {{ $selectedCategory === 'all' ? 'active' : '' }}">
                {{ __('messages.promotion_filter_all') }}
            </a>
            @foreach($categories as $categoryKey => $categoryLabel)
                <a href="{{ route('promotions.index', ['category' => $categoryKey]) }}"
                   class="filter-chip {{ $selectedCategory === $categoryKey ? 'active' : '' }}">
                    {{ $categoryLabel }}
                </a>
            @endforeach
        </div>

    </div>

    {{-- PROMOTIONS GRID --}}
    <div class="grid">

        @forelse($promotions as $promotion)
 
        <div class="promo-card">

            <div class="promo-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                <span class="badge badge-type">
                    {{ $promotion->type_label }}
                </span>

                <span class="badge badge-category">
                    {{ __("messages.promo_category_{$promotion->category}") }}
                </span>
            </div>

            <div style="margin-top:18px;">
                <div class="promo-value">
                    @if($promotion->type === 'percentage')
                        {{ $promotion->value }}%
                    @elseif($promotion->type === 'fixed_amount')
                        {{ number_format($promotion->value,0,',',' ') }}
                    @else
                        Gratuit
                    @endif
                </div>

                <div class="promo-date">
                    Valable jusqu'au {{ optional($promotion->valid_until)->format('d/m/Y') ?? __('messages.promotion_valid_until') }}
                </div>
            </div>

            <div class="promo-actions">
                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="promo-action-btn promo-action-edit">
                    <i class="fa-solid fa-pen"></i>
                    Modifier
                </a>

                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="promo-action-btn promo-action-delete">
                        <i class="fa-solid fa-trash"></i>
                        Supprimer
                    </button>
                </form>
            </div>

        </div>

        @empty

        <div class="empty">
            <i class="fa-solid fa-ticket fa-2x mb-3"></i>
            <h3>Aucune promotion active</h3>
            <p>Revenez bientôt pour découvrir nos nouvelles offres</p>
        </div>

        @endforelse

    </div>

</div>

@endsection
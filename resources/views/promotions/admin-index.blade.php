@extends('layouts.admin')

@section('title', __('messages.promo_title') . ' - Administration')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

@php
    use App\Models\Promotion;
    $totalPromo   = Promotion::count();
    $activePromo  = Promotion::where('status','active')->where('is_active',true)->count();
    $expiredPromo = Promotion::where('valid_until','<', now())->count();
    $draftPromo   = Promotion::where('status','draft')->count();
@endphp

<style>

    body{ background:#0e0a1c; }

    /* ── HERO ── */
    .promo-hero{
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
        border-radius:30px;
        padding:2rem;
        overflow:hidden;
        position:relative;
        box-shadow:0 25px 60px rgba(15,23,42,.18);
        margin-bottom:1.5rem;
    }

    .hero-content{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:2rem;
        flex-wrap:wrap;
    }

    .hero-left{
        display:flex;
        align-items:center;
        gap:1.5rem;
    }

    .hero-icon{
        width:90px;
        height:90px;
        border-radius:28px;
        background:rgba(255,255,255,.12);
        backdrop-filter:blur(10px);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:2rem;
        color:white;
        border:1px solid rgba(255,255,255,.15);
        flex-shrink:0;
    }

    .hero-badge{
        background:rgba(255,255,255,.12);
        color:#cbd5e1;
        padding:.45rem .85rem;
        border-radius:50px;
        font-size:.75rem;
        font-weight:700;
        letter-spacing:.5px;
        text-transform:uppercase;
        display:inline-block;
        margin-bottom:1rem;
    }

    .promo-hero h1{
        color:white;
        font-size:2.2rem;
        font-weight:800;
        margin-bottom:.6rem;
    }

    .promo-hero .hero-desc{
        color:rgba(255,255,255,.75);
        max-width:600px;
        margin:0;
        line-height:1.7;
    }

    .hero-right{
        display:flex;
        gap:1rem;
        flex-wrap:wrap;
        align-items:center;
    }

    .hero-mini-card{
        min-width:130px;
        background:rgba(255,255,255,.08);
        border:1px solid rgba(255,255,255,.1);
        border-radius:22px;
        padding:1rem 1.2rem;
        backdrop-filter:blur(14px);
    }

    .hero-mini-card span{
        color:rgba(255,255,255,.65);
        display:block;
        margin-bottom:.5rem;
        font-size:.85rem;
    }

    .hero-mini-card strong{
        color:white;
        font-size:1.6rem;
        font-weight:800;
    }

    .btn-new-promo{
        display:inline-flex;
        align-items:center;
        gap:.6rem;
        padding:.9rem 1.4rem;
        border-radius:18px;
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        color:white;
        font-weight:700;
        font-size:.95rem;
        text-decoration:none;
        box-shadow:0 15px 30px rgba(212,175,55,.28);
        transition:.25s ease;
        white-space:nowrap;
    }

    .btn-new-promo:hover{
        transform:translateY(-2px);
        color:white;
        text-decoration:none;
    }

    /* ── STAT CARDS ── */
    .premium-stat-card{
        position:relative;
        background:rgba(255,255,255,.06);
        border-radius:26px;
        padding:1.8rem;
        overflow:hidden;
        border:1px solid rgba(255,255,255,.09);
        box-shadow:0 15px 40px rgba(0,0,0,.2);
        transition:.35s ease;
        height:100%;
    }

    .premium-stat-card:hover{
        transform:translateY(-6px);
        box-shadow:0 22px 60px rgba(0,0,0,.3);
        border-color:rgba(212,175,55,.25);
    }

    .stat-glow{
        position:absolute;
        top:-40px;
        right:-40px;
        width:120px;
        height:120px;
        border-radius:50%;
        opacity:.12;
    }

    .stat-glow.primary  { background:#D4AF37; }
    .stat-glow.success  { background:#10b981; }
    .stat-glow.warning  { background:#f59e0b; }
    .stat-glow.secondary{ background:#6b7280; }

    .stat-label{
        color:rgba(255,255,255,.45);
        text-transform:uppercase;
        letter-spacing:.8px;
        font-size:.75rem;
        font-weight:700;
    }

    .premium-stat-card h2{
        font-size:2.2rem;
        font-weight:800;
        margin:.8rem 0 .4rem;
        color:rgba(255,255,255,.9);
    }

    .premium-stat-card p{
        color:rgba(255,255,255,.35);
        margin:0;
    }

    .premium-icon{
        width:68px;
        height:68px;
        border-radius:22px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.4rem;
    }

    .premium-icon.primary  { background:rgba(212,175,55,.15);  color:#D4AF37; }
    .premium-icon.success  { background:rgba(16,185,129,.15);  color:#10b981; }
    .premium-icon.warning  { background:rgba(245,158,11,.15);  color:#f59e0b; }
    .premium-icon.secondary{ background:rgba(107,114,128,.15); color:#9ca3af; }

    /* ── TABLE CARD ── */
    .premium-table-card{
        background:rgba(255,255,255,.05);
        border-radius:30px;
        overflow:hidden;
        border:1px solid rgba(255,255,255,.09);
        box-shadow:0 20px 50px rgba(0,0,0,.25);
    }

    .premium-table-header{
        padding:1.8rem 2rem;
        border-bottom:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
    }

    .premium-table-header h3{
        font-size:1.35rem;
        font-weight:800;
        color:rgba(255,255,255,.9);
        margin-bottom:.45rem;
    }

    .premium-table-header p{
        margin:0;
        color:rgba(255,255,255,.45);
    }

    .count-chip{
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        color:white;
        padding:.9rem 1.2rem;
        border-radius:16px;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:.6rem;
        box-shadow:0 15px 30px rgba(212,175,55,.25);
        white-space:nowrap;
    }

    .premium-table{ --bs-table-color:rgba(255,255,255,.8); --bs-table-bg:transparent; }

    .premium-table thead th{
        background:rgba(255,255,255,.04);
        color:rgba(255,255,255,.45);
        text-transform:uppercase;
        letter-spacing:.7px;
        font-size:.75rem;
        font-weight:800;
        border:none;
        padding:1.2rem 1.4rem;
    }

    .premium-table tbody tr{
        border-bottom:1px solid rgba(255,255,255,.06);
        transition:.25s ease;
    }

    .premium-table tbody tr:hover{
        background:rgba(255,255,255,.04);
    }

    .premium-table td{
        border:none;
        padding:1.4rem;
        vertical-align:middle;
        color:rgba(255,255,255,.8);
    }

    /* ── CODE BADGE ── */
    .code-badge{
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        padding:.5rem 1rem;
        border-radius:12px;
        background:rgba(212,175,55,.12);
        border:1px solid rgba(212,175,55,.25);
        font-weight:900;
        color:#D4AF37;
        font-size:.9rem;
        letter-spacing:.05em;
    }

    /* ── STATUS BADGES ── */
    .promo-badge{
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        padding:.5rem .9rem;
        border-radius:999px;
        font-size:.78rem;
        font-weight:800;
    }

    .promo-badge.active   { background:rgba(16,185,129,.15);  color:#4ade80; border:1px solid rgba(74,222,128,.2); }
    .promo-badge.inactive { background:rgba(239,68,68,.15);   color:#f87171; border:1px solid rgba(248,113,113,.2); }
    .promo-badge.draft    { background:rgba(245,158,11,.15);  color:#fbbf24; border:1px solid rgba(251,191,36,.2); }

    /* ── ACTION BUTTONS ── */
    .btn-act{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        padding:.55rem 1rem;
        border-radius:14px;
        font-weight:700;
        font-size:.82rem;
        text-decoration:none;
        border:none;
        color:#fff;
        cursor:pointer;
        transition:.2s ease;
    }

    .btn-act:hover{ transform:translateY(-1px); color:#fff; text-decoration:none; }
    .btn-edit   { background:linear-gradient(135deg,#D4AF37,#B8860B); box-shadow:0 8px 20px rgba(212,175,55,.2); }
    .btn-delete { background:linear-gradient(135deg,#ef4444,#dc2626); box-shadow:0 8px 20px rgba(239,68,68,.2); }

    /* ── VALIDITY ── */
    .validity-cell{
        font-size:.88rem;
        color:rgba(255,255,255,.75);
        font-weight:600;
    }

    .validity-cell span{
        color:rgba(255,255,255,.4);
        font-size:.78rem;
        display:block;
    }

    /* ── EMPTY ── */
    .empty-box{
        text-align:center;
        padding:5rem 2rem;
    }

    .empty-icon-wrap{
        width:100px;
        height:100px;
        border-radius:30px;
        background:rgba(212,175,55,.1);
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 1.5rem;
        font-size:2.5rem;
        color:#D4AF37;
    }

    .empty-box h3{ font-weight:800; color:rgba(255,255,255,.9); margin-bottom:.5rem; }
    .empty-box p { color:rgba(255,255,255,.4); }

    /* ── PAGINATION ── */
    .pg-footer{
        padding:1.2rem 2rem;
        border-top:1px solid rgba(255,255,255,.07);
        display:flex;
        justify-content:center;
    }

    /* ── RESPONSIVE ── */
    @media(max-width:768px){
        .promo-hero h1{ font-size:1.6rem; }
        .hero-left{ gap:1rem; }
        .hero-icon{ width:70px; height:70px; font-size:1.5rem; }
        .premium-table-header{ flex-direction:column; align-items:flex-start; }
        .premium-stat-card h2{ font-size:1.6rem; }
    }

</style>

<div class="container-fluid px-4">

    {{-- HERO --}}
    <div class="promo-hero">
        <div class="hero-content">

            <div class="hero-left">
                <div class="hero-icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div>
                    <span class="hero-badge">{{ __('messages.promo_badge') }}</span>
                    <h1>{{ __('messages.promo_title') }}</h1>
                    <p class="hero-desc">{{ __('messages.promo_hero_desc') }}</p>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-mini-card">
                    <span>{{ __('messages.promo_hero_total') }}</span>
                    <strong>{{ $totalPromo }}</strong>
                </div>
                <div class="hero-mini-card">
                    <span>{{ __('messages.promo_hero_active') }}</span>
                    <strong>{{ $activePromo }}</strong>
                </div>
                <a href="{{ route('admin.promotions.create') }}" class="btn-new-promo">
                    <i class="fa-solid fa-plus"></i>
                    {{ __('messages.promo_new_btn') }}
                </a>
            </div>

        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow primary"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.promo_stat_total_label') }}</span>
                        <h2>{{ $totalPromo }}</h2>
                        <p>{{ __('messages.promo_stat_total_sub') }}</p>
                    </div>
                    <div class="premium-icon primary">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow success"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.promo_stat_active_label') }}</span>
                        <h2>{{ $activePromo }}</h2>
                        <p>{{ __('messages.promo_stat_active_sub') }}</p>
                    </div>
                    <div class="premium-icon success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow warning"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.promo_stat_expired_label') }}</span>
                        <h2>{{ $expiredPromo }}</h2>
                        <p>{{ __('messages.promo_stat_expired_sub') }}</p>
                    </div>
                    <div class="premium-icon warning">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow secondary"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.promo_stat_draft_label') }}</span>
                        <h2>{{ $draftPromo }}</h2>
                        <p>{{ __('messages.promo_stat_draft_sub') }}</p>
                    </div>
                    <div class="premium-icon secondary">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="premium-table-card">

        <div class="premium-table-header">
            <div>
                <h3><i class="fa-solid fa-gift me-2" style="color:#D4AF37;"></i>{{ __('messages.promo_table_title') }}</h3>
                <p>{{ __('messages.promo_table_sub') }}</p>
            </div>
            <div class="count-chip">
                <i class="fa-solid fa-ticket"></i>
                {{ $promotions->total() }} {{ __('messages.promo_count') }}
            </div>
        </div>

        @if($promotions->isEmpty())

            <div class="empty-box">
                <div class="empty-icon-wrap">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h3>{{ __('messages.promo_empty_title') }}</h3>
                <p>{{ __('messages.promo_empty_text') }}</p>
                <a href="{{ route('admin.promotions.create') }}" class="btn-new-promo mt-3" style="width:fit-content;margin:1rem auto 0;">
                    <i class="fa-solid fa-plus"></i> {{ __('messages.promo_create_btn') }}
                </a>
            </div>

        @else

            <div class="table-responsive">
                <table class="table premium-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>{{ __('messages.promo_col_code') }}</th>
                            <th>{{ __('messages.promo_col_category') }}</th>
                            <th>{{ __('messages.promo_col_type') }}</th>
                            <th>{{ __('messages.promo_col_value') }}</th>
                            <th>{{ __('messages.promo_col_validity') }}</th>
                            <th>{{ __('messages.promo_col_status') }}</th>
                            <th class="text-end">{{ __('messages.promo_col_actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($promotions as $promotion)
                        <tr>

                            {{-- CODE --}}
                            <td>
                                <span class="code-badge">
                                    <i class="fa-solid fa-tag"></i>
                                    {{ $promotion->code }}
                                </span>
                            </td>

                            {{-- CATÉGORIE --}}
                            <td style="font-weight:600;color:rgba(255,255,255,.8);">
                                {{ $promotion->category_label }}
                            </td>

                            {{-- TYPE --}}
                            <td style="color:rgba(255,255,255,.5);">
                                {{ $promotion->type_label }}
                            </td>

                            {{-- VALEUR --}}
                            <td style="font-weight:800;color:rgba(255,255,255,.9);">
                                @if($promotion->type === 'percentage')
                                    {{ $promotion->value }}%
                                @elseif($promotion->type === 'fixed_amount')
                                    {{ number_format($promotion->value, 0, ',', ' ') }}
                                @else
                                    {{ __('messages.promotion_type_free_service') }}
                                @endif
                            </td>

                            {{-- VALIDITÉ --}}
                            <td>
                                <div class="validity-cell">
                                    {{ $promotion->valid_from->format('d/m/Y') }}
                                    <span>→ {{ $promotion->valid_until->format('d/m/Y') }}</span>
                                </div>
                            </td>

                            {{-- STATUT --}}
                            <td>
                                <span class="promo-badge {{ $promotion->status }}">
                                    @if($promotion->status === 'active')
                                        <i class="fa-solid fa-circle-check"></i>
                                    @elseif($promotion->status === 'draft')
                                        <i class="fa-solid fa-file-pen"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    @endif
                                    {{ $promotion->status_label }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2 flex-wrap">

                                    <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                       class="btn-act btn-edit"
                                       data-edit-url="{{ route('admin.promotions.edit', $promotion) }}"
                                       data-edit-title="{{ __('messages.promo_btn_edit') }}">
                                        <i class="fa-solid fa-pen"></i> {{ __('messages.promo_btn_edit') }}
                                    </a>

                                    <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-delete"
                                                onclick="return confirm('{{ __('messages.promo_delete_confirm') }}')">
                                            <i class="fa-solid fa-trash"></i> {{ __('messages.promo_btn_delete') }}
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="pg-footer">
                {{ $promotions->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

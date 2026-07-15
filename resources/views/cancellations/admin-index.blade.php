@extends('layouts.admin')

@section('title', __('messages.canc_title'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

@php
    use App\Models\Cancellation;
    $totalCancellations = Cancellation::count();
    $pendingCount       = Cancellation::where('status','pending')->count();
    $approvedCount      = Cancellation::where('status','approved')->count();
    $rejectedCount      = Cancellation::where('status','rejected')->count();
@endphp

<style>

    body{ background:#0e0a1c; }

    /* ── HERO ── */
    .canc-hero{
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

    .canc-hero h1{
        color:white;
        font-size:2.2rem;
        font-weight:800;
        margin-bottom:.6rem;
    }

    .canc-hero > .hero-content p{
        color:rgba(255,255,255,.75);
        max-width:600px;
        margin:0;
        line-height:1.7;
    }

    .hero-right{
        display:flex;
        gap:1rem;
        flex-wrap:wrap;
    }

    .hero-mini-card{
        min-width:140px;
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

    .stat-glow.primary{ background:#D4AF37; }
    .stat-glow.warning{ background:#f59e0b; }
    .stat-glow.success{ background:#10b981; }
    .stat-glow.danger { background:#ef4444; }

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

    .premium-icon.primary{ background:rgba(212,175,55,.15);  color:#D4AF37; }
    .premium-icon.warning{ background:rgba(245,158,11,.15);  color:#f59e0b; }
    .premium-icon.success{ background:rgba(16,185,129,.15);  color:#10b981; }
    .premium-icon.danger { background:rgba(239,68,68,.15);   color:#ef4444; }

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

    .premium-table tbody tr:hover{ background:rgba(255,255,255,.04); }

    .premium-table td{
        border:none;
        padding:1.4rem;
        vertical-align:middle;
        color:rgba(255,255,255,.8);
    }

    .premium-table{ --bs-table-color:rgba(255,255,255,.8); --bs-table-bg:transparent; }

    /* ── USER CELL ── */
    .user-cell{
        display:flex;
        align-items:center;
        gap:1rem;
    }

    .user-avatar{
        width:52px;
        height:52px;
        border-radius:18px;
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        color:white;
        font-weight:800;
        font-size:1rem;
        display:flex;
        align-items:center;
        justify-content:center;
        box-shadow:0 10px 25px rgba(212,175,55,.25);
        overflow:hidden;
        flex-shrink:0;
    }

    .user-avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .user-cell h6{
        margin:0 0 .3rem;
        font-weight:800;
        color:rgba(255,255,255,.9);
    }

    .user-cell span{
        color:rgba(255,255,255,.4);
        font-size:.85rem;
    }

    /* ── SERVICE CELL ── */
    .service-cell{
        display:flex;
        align-items:center;
        gap:.6rem;
        font-weight:700;
        color:rgba(255,255,255,.85);
    }

    .service-cell i{ color:#D4AF37; }

    /* ── DATE CELL ── */
    .date-cell{
        display:flex;
        align-items:center;
        gap:.5rem;
        color:rgba(255,255,255,.5);
        font-weight:600;
    }

    .date-cell i{ color:#D4AF37; }

    /* ── REFUND CELL ── */
    .refund-amount{
        font-size:1rem;
        font-weight:900;
        color:#D4AF37;
    }

    .refund-percent{
        font-size:.82rem;
        color:rgba(255,255,255,.4);
        margin-top:.2rem;
    }

    /* ── STATUS ── */
    .status-badge{
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        padding:.55rem 1rem;
        border-radius:999px;
        font-size:.8rem;
        font-weight:800;
        background:rgba(245,158,11,.15);
        color:#fbbf24;
        border:1px solid rgba(251,191,36,.2);
    }

    /* ── ACTION BUTTONS ── */
    .btn-act{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        padding:.6rem 1rem;
        border-radius:14px;
        font-weight:700;
        font-size:.82rem;
        border:none;
        color:#fff;
        cursor:pointer;
        transition:.2s ease;
    }

    .btn-act:hover{ transform:translateY(-1px); }
    .btn-approve{ background:linear-gradient(135deg,#10b981,#059669); box-shadow:0 8px 20px rgba(16,185,129,.2); }
    .btn-reject { background:linear-gradient(135deg,#ef4444,#dc2626); box-shadow:0 8px 20px rgba(239,68,68,.2); }

    /* ── ALERT ── */
    .success-alert{
        background:rgba(16,185,129,.1);
        border:1px solid rgba(74,222,128,.2);
        border-radius:22px;
        padding:1.2rem 1.4rem;
        display:flex;
        align-items:center;
        gap:1rem;
        margin-bottom:1.5rem;
    }

    .success-alert-icon{
        width:50px;
        height:50px;
        border-radius:15px;
        background:rgba(16,185,129,.15);
        color:#4ade80;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.2rem;
        flex-shrink:0;
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
        background:rgba(16,185,129,.1);
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 1.5rem;
        font-size:2.5rem;
        color:#4ade80;
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
        .canc-hero h1{ font-size:1.6rem; }
        .hero-left{ gap:1rem; }
        .hero-icon{ width:70px; height:70px; font-size:1.5rem; }
        .premium-table-header{ flex-direction:column; align-items:flex-start; }
        .d-flex.gap-2{ flex-wrap:wrap; }
    }

</style>

<div class="container-fluid px-4">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="success-alert">
            <div class="success-alert-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <strong style="color:#4ade80;">{{ __('messages.canc_success') }}</strong>
                <p style="margin:0;color:rgba(255,255,255,.7);">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- HERO --}}
    <div class="canc-hero">
        <div class="hero-content">

            <div class="hero-left">
                <div class="hero-icon">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div>
                    <span class="hero-badge">{{ __('messages.canc_badge') }}</span>
                    <h1>{{ __('messages.canc_title') }}</h1>
                    <p>{{ __('messages.canc_hero_desc') }}</p>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-mini-card">
                    <span>{{ __('messages.promo_hero_total') }}</span>
                    <strong>{{ $totalCancellations }}</strong>
                </div>
                <div class="hero-mini-card">
                    <span>{{ __('messages.canc_stat_pending_label') }}</span>
                    <strong>{{ $pendingCount }}</strong>
                </div>
                <div class="hero-mini-card">
                    <span>{{ __('messages.canc_stat_approved_label') }}</span>
                    <strong>{{ $approvedCount }}</strong>
                </div>
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
                        <span class="stat-label">{{ __('messages.canc_stat_total_label') }}</span>
                        <h2>{{ $totalCancellations }}</h2>
                        <p>{{ __('messages.canc_stat_total_sub') }}</p>
                    </div>
                    <div class="premium-icon primary">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow warning"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.canc_stat_pending_label') }}</span>
                        <h2>{{ $pendingCount }}</h2>
                        <p>{{ __('messages.canc_stat_pending_sub') }}</p>
                    </div>
                    <div class="premium-icon warning">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow success"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.canc_stat_approved_label') }}</span>
                        <h2>{{ $approvedCount }}</h2>
                        <p>{{ __('messages.canc_stat_approved_sub') }}</p>
                    </div>
                    <div class="premium-icon success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow danger"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.canc_stat_rejected_label') }}</span>
                        <h2>{{ $rejectedCount }}</h2>
                        <p>{{ __('messages.canc_stat_rejected_sub') }}</p>
                    </div>
                    <div class="premium-icon danger">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="premium-table-card">

        <div class="premium-table-header">
            <div>
                <h3><i class="fa-solid fa-clock-rotate-left me-2" style="color:#D4AF37;"></i>{{ __('messages.canc_table_title') }}</h3>
                <p>{{ __('messages.canc_table_sub') }}</p>
            </div>
            <div class="count-chip">
                <i class="fa-solid fa-ban"></i>
                {{ $cancellations->total() }} {{ __('messages.canc_count') }}
            </div>
        </div>

        @if($cancellations->isEmpty())

            <div class="empty-box">
                <div class="empty-icon-wrap">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <h3>{{ __('messages.canc_empty_title') }}</h3>
                <p>{{ __('messages.canc_empty_text') }}</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="table premium-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-user me-1"></i> {{ __('messages.canc_col_client') }}</th>
                            <th><i class="fa-solid fa-scissors me-1"></i> {{ __('messages.canc_col_service') }}</th>
                            <th><i class="fa-regular fa-calendar me-1"></i> {{ __('messages.canc_col_date') }}</th>
                            <th><i class="fa-solid fa-wallet me-1"></i> {{ __('messages.canc_col_refund') }}</th>
                            <th><i class="fa-solid fa-circle-info me-1"></i> {{ __('messages.canc_col_status') }}</th>
                            <th class="text-end"><i class="fa-solid fa-gear me-1"></i> {{ __('messages.canc_col_actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cancellations as $cancellation)
                        <tr>

                            {{-- CLIENT --}}
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        @if(!empty($cancellation->reservation->client->photo))
                                            <img src="{{ asset('storage/'.$cancellation->reservation->client->photo) }}"
                                                 alt="{{ $cancellation->reservation->client->name }}">
                                        @else
                                            {{ strtoupper(substr($cancellation->reservation->client->name ?? 'C', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h6>{{ $cancellation->reservation->client->name ?? 'Cliente inconnue' }}</h6>
                                        <span>Demande d'annulation</span>
                                    </div>
                                </div>
                            </td>

                            {{-- SERVICE --}}
                            <td>
                                <div class="service-cell">
                                    <i class="fa-solid fa-scissors"></i>
                                    {{ $cancellation->reservation->service->name ?? '–' }}
                                </div>
                            </td>

                            {{-- DATE --}}
                            <td>
                                <div class="date-cell">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($cancellation->reservation->date)->format('d/m/Y') }}
                                </div>
                            </td>

                            {{-- REFUND --}}
                            <td>
                                <div class="refund-amount">
                                    {{ number_format($cancellation->refund_amount, 0, ',', ' ') }}
                                </div>
                                <div class="refund-percent">
                                    {{ $cancellation->refund_percentage }}% remboursé
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="status-badge">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                    {{ ucfirst($cancellation->status) }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">

                                    <form action="{{ route('admin.cancellations.approve', $cancellation) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-act btn-approve">
                                            <i class="fa-solid fa-circle-check"></i> {{ __('messages.canc_btn_approve') }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.cancellations.reject', $cancellation) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-act btn-reject">
                                            <i class="fa-solid fa-circle-xmark"></i> {{ __('messages.canc_btn_reject') }}
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
                {{ $cancellations->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

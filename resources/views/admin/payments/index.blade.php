@extends('layouts.admin')

@section('title', __('messages.adm_payments_title'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

@php
    use App\Models\Payment;
    $total       = Payment::count();
    $completedCt = Payment::whereIn('status',['completed','paid','success'])->count();
    $pending     = Payment::where('status','pending')->count();
    $failed      = Payment::whereNotIn('status',['completed','paid','success','pending'])->count();
    $totalAmount = Payment::whereIn('status',['completed','paid','success'])->sum('amount');
@endphp

<style>

    body{ background:#0e0a1c; }

    /* ── HERO ── */
    .pay-hero{
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

    .pay-hero h1{
        color:white;
        font-size:2.2rem;
        font-weight:800;
        margin-bottom:.6rem;
    }

    .pay-hero p{
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
    .stat-glow.success{ background:#10b981; }
    .stat-glow.warning{ background:#f59e0b; }
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
    .premium-icon.success{ background:rgba(16,185,129,.15);  color:#10b981; }
    .premium-icon.warning{ background:rgba(245,158,11,.15);  color:#f59e0b; }
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

    /* ── AMOUNT ── */
    .amount-cell{
        font-size:1rem;
        font-weight:900;
        color:#D4AF37;
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
    }

    .status-success { background:rgba(16,185,129,.15); color:#4ade80; border:1px solid rgba(74,222,128,.2); }
    .status-pending { background:rgba(245,158,11,.15);  color:#fbbf24; border:1px solid rgba(251,191,36,.2); }
    .status-failed  { background:rgba(239,68,68,.15);   color:#f87171; border:1px solid rgba(248,113,113,.2); }

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
    .btn-validate { background:linear-gradient(135deg,#10b981,#059669); }
    .btn-proof    { background:linear-gradient(135deg,#64748b,#475569); }
    .btn-proof-dl { background:linear-gradient(135deg,#0ea5e9,#0284c7); }

    /* ── DATE ── */
    .date-cell{
        display:flex;
        align-items:center;
        gap:.5rem;
        color:rgba(255,255,255,.5);
        font-weight:600;
    }

    .date-cell i{ color:#D4AF37; }

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

    /* ── FILTER BUTTONS ── */
    .filter-group{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .filter-btn{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:10px 18px;
        border-radius:14px;
        font-size:.82rem;
        font-weight:700;
        text-decoration:none;
        border:1px solid rgba(255,255,255,.12);
        background:rgba(255,255,255,.06);
        color:rgba(255,255,255,.7);
        transition:.2s ease;
    }
    .filter-btn:hover{
        background:rgba(255,255,255,.12);
        color:#fff;
        transform:translateY(-1px);
        text-decoration:none;
    }
    .filter-btn.active-all{
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        border-color:transparent;
        color:#fff;
        box-shadow:0 6px 18px rgba(212,175,55,.3);
    }
    .filter-btn.active-shop{
        background:linear-gradient(135deg,#7c3aed,#5b21b6);
        border-color:transparent;
        color:#fff;
        box-shadow:0 6px 18px rgba(124,58,237,.3);
    }
    .filter-btn.active-resa{
        background:linear-gradient(135deg,#0ea5e9,#0284c7);
        border-color:transparent;
        color:#fff;
        box-shadow:0 6px 18px rgba(14,165,233,.3);
    }

    /* ── SOURCE BADGE in table ── */
    .source-badge{
        display:inline-flex;
        align-items:center;
        gap:5px;
        padding:4px 10px;
        border-radius:50px;
        font-size:.72rem;
        font-weight:700;
    }
    .src-shop{ background:rgba(124,58,237,.15);color:#a78bfa;border:1px solid rgba(124,58,237,.25); }
    .src-resa{ background:rgba(14,165,233,.15);color:#38bdf8;border:1px solid rgba(14,165,233,.25); }

    /* ── RESPONSIVE ── */
    @media(max-width:768px){
        .pay-hero h1{ font-size:1.6rem; }
        .hero-left{ gap:1rem; }
        .hero-icon{ width:70px; height:70px; font-size:1.5rem; }
        .premium-table-header{ flex-direction:column; align-items:flex-start; }
        .premium-stat-card h2{ font-size:1.6rem; }
        .filter-group{ width:100%; }
    }

</style>

<div class="container-fluid px-4">

    {{-- HERO --}}
    <div class="pay-hero">
        <div class="hero-content">

            <div class="hero-left">
                <div class="hero-icon">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <span class="hero-badge">{{ __('messages.adm_finance_badge') }}</span>
                    <h1>{{ __('messages.adm_payments_title') }}</h1>
                    <p>{{ __('messages.adm_payments_hero_subtitle') }}</p>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-mini-card">
                    <span>{{ __('messages.adm_hero_total') }}</span>
                    <strong>{{ $total }}</strong>
                </div>
                <div class="hero-mini-card">
                    <span>{{ __('messages.adm_hero_completed') }}</span>
                    <strong>{{ $completedCt }}</strong>
                </div>
                <div class="hero-mini-card">
                    <span>{{ __('messages.adm_payment_pending') }}</span>
                    <strong>{{ $pending }}</strong>
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
                        <span class="stat-label">{{ __('messages.adm_successful_payments') }}</span>
                        <h2>{{ $total }}</h2>
                        <p>{{ __('messages.adm_all_txn') }}</p>
                    </div>
                    <div class="premium-icon primary">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow success"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.adm_collected_amount') }}</span>
                        <h2 style="font-size:1.5rem;">{{ number_format($reservationAmount, 0, ',', ' ') }}</h2>
                        <p>{{ __('messages.adm_completed_payments') }}</p>
                    </div>
                    <div class="premium-icon success">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow warning"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.adm_payment_pending') }}</span>
                        <h2>{{ $pending }}</h2>
                        <p>{{ __('messages.adm_to_validate') }}</p>
                    </div>
                    <div class="premium-icon warning">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-glow danger"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label">{{ __('messages.adm_failed_txn') }}</span>
                        <h2>{{ $failed }}</h2>
                        <p>{{ __('messages.adm_rejected_txn') }}</p>
                    </div>
                    <div class="premium-icon danger">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Montant réservation --}}
        <div class="col-xl-12 col-md-6">
            <div class="premium-stat-card" style="border-color:rgba(14,165,233,.2);">
                <div class="stat-glow" style="background:#0ea5e9;"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="stat-label" style="color:#38bdf8;">Montant réservation</span>
                        <h2 style="font-size:1.5rem;color:#38bdf8;">
                            {{ number_format($reservationAmount, 0, ',', ' ') }}
                        </h2>
                        <p>Revenus issus des réservations salon</p>
                    </div>
                    <div class="premium-icon" style="background:rgba(14,165,233,.15);color:#38bdf8;">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="premium-table-card">

        <div class="premium-table-header">
            <div>
                <h3><i class="fa-solid fa-list-ul me-2" style="color:#D4AF37;"></i>{{ __('messages.adm_payment_history') }}</h3>
                <p>{{ __('messages.adm_payment_history_sub') }}</p>
            </div>
            <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                <div class="filter-group">
                    <a
                        href="{{ route('admin.payments') }}"
                        class="filter-btn {{ !$filter ? 'active-all' : '' }}"
                    >
                        <i class="fa-solid fa-list"></i>
                        Toutes
                    </a>
                    <a
                        href="{{ route('admin.payments', ['filter' => 'reservation']) }}"
                        class="filter-btn {{ $filter === 'reservation' ? 'active-resa' : '' }}"
                    >
                        <i class="fa-solid fa-scissors"></i>
                        Réservation
                    </a>
                </div>
                <div class="count-chip">
                    <i class="fa-solid fa-receipt"></i>
                    {{ $payments->total() }} {{ __('messages.adm_payment_count') }}
                </div>
            </div>
        </div>

        @if($payments->isEmpty())

            <div class="empty-box">
                <div class="empty-icon-wrap">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <h3>{{ __('messages.adm_no_payments') }}</h3>
                <p>{{ __('messages.adm_no_payments_platform') }}</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="table premium-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag me-1"></i> ID</th>
                            <th><i class="fa-solid fa-user me-1"></i> {{ __('messages.adm_col_client') }}</th>
                            <th><i class="fa-solid fa-coins me-1"></i> {{ __('messages.adm_col_amount') }}</th>
                            <th><i class="fa-solid fa-credit-card me-1"></i> {{ __('messages.adm_col_method') }}</th>
                            <th><i class="fa-solid fa-circle-info me-1"></i> {{ __('messages.adm_col_status') }}</th>
                            <th><i class="fa-solid fa-list-check me-1"></i> {{ __('messages.adm_col_actions') }}</th>
                            <th><i class="fa-regular fa-calendar me-1"></i> {{ __('messages.adm_col_date') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($payments as $p)
                        @php
                            $st = strtolower($p->status);
                            $badgeClass = in_array($st,['success','paid','completed']) ? 'status-success' : ($st === 'pending' ? 'status-pending' : 'status-failed');
                        @endphp
                        <tr>

                            {{-- ID --}}
                            <td>
                                <span style="font-weight:800;color:rgba(255,255,255,.9);">#{{ $p->id }}</span>
                            </td>

                            {{-- USER --}}
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        @if(!empty($p->user?->photo))
                                            <img src="{{ asset('storage/'.$p->user->photo) }}" alt="{{ $p->user->name }}">
                                        @else
                                            {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h6>{{ $p->user->name ?? __('messages.adm_unknown_user') }}</h6>
                                        @if($p->reservation_id)
                                            <span class="source-badge src-resa"><i class="fa-solid fa-scissors"></i> Réservation</span>
                                        @else
                                            <span>{{ __('messages.adm_client_payment') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- AMOUNT --}}
                            <td>
                                <span class="amount-cell">
                                    <i class="fa-solid fa-wallet me-1" style="color:#D4AF37;"></i>
                                    {{ number_format($p->amount, 0, ',', ' ') }}
                                </span>
                            </td>

                            {{-- METHOD --}}
                            <td style="font-weight:600;color:rgba(255,255,255,.75);">
                                {{ $p->method_label }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="status-badge {{ $badgeClass }}">
                                    @if(in_array($st,['success','paid','completed']))
                                        <i class="fa-solid fa-circle-check"></i> {{ __('messages.adm_payment_completed_label') }}
                                    @elseif($st === 'pending')
                                        <i class="fa-solid fa-hourglass-half"></i> {{ __('messages.adm_payment_pending') }}
                                    @else
                                        <i class="fa-solid fa-circle-xmark"></i> {{ ucfirst($p->status) }}
                                    @endif
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    @if($p->method === 'cash' && $p->status === 'pending')
                                        @if($p->proof_path)
                                            <a href="{{ asset('storage/'.$p->proof_path) }}" class="btn-act btn-proof" target="_blank">
                                                <i class="fa-solid fa-file-invoice"></i> {{ __('messages.adm_payment_proof') }}
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('admin.payments.validate', $p) }}" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-act btn-validate">
                                                <i class="fa-solid fa-check"></i> {{ __('messages.adm_payment_validate') }}
                                            </button>
                                        </form>
                                    @elseif($p->proof_path)
                                        <a href="{{ asset('storage/'.$p->proof_path) }}" class="btn-act btn-proof-dl" target="_blank">
                                            <i class="fa-solid fa-file-invoice"></i> {{ __('messages.adm_payment_proof') }}
                                        </a>
                                    @else
                                        <span style="color:rgba(255,255,255,.3);font-size:.85rem;">—</span>
                                    @endif
                                </div>
                            </td>

                            {{-- DATE --}}
                            <td>
                                <div class="date-cell">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $p->created_at->format('d/m/Y') }}
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="pg-footer">
                {{ $payments->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

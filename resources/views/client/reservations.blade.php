@extends('layouts.client')
@section('title', __('messages.clt_reservations_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.res-wrap{max-width:900px;}

.res-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:32px;}
.res-title{font-size:1.8rem;font-weight:900;color:var(--text);margin-bottom:4px;}
.res-sub{color:var(--muted);font-size:.9rem;}

.btn-new{display:inline-flex;align-items:center;gap:8px;padding:12px 22px;background:var(--gradient);color:#fff;border-radius:14px;text-decoration:none;font-weight:700;font-size:.9rem;transition:.3s;box-shadow:0 8px 20px rgba(233,30,140,.3);}
.btn-new:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(233,30,140,.45);color:#fff;}

.flash-ok{background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:14px;padding:14px 18px;color:#4ade80;font-weight:600;margin-bottom:24px;font-size:.9rem;}

.res-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:24px;margin-bottom:20px;position:relative;overflow:hidden;transition:.3s;}
.res-card::before{content:'';position:absolute;top:0;left:0;width:5px;height:100%;background:var(--gradient);border-radius:5px 0 0 5px;}
.res-card:hover{border-color:rgba(233,30,140,.25);transform:translateY(-3px);box-shadow:0 16px 40px rgba(0,0,0,.25);}

.res-top{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:20px;}

.res-icon{width:66px;height:66px;border-radius:18px;background:rgba(233,30,140,.12);border:1px solid rgba(233,30,140,.2);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0;}
.res-left{display:flex;align-items:flex-start;gap:16px;}

.svc-name{font-size:1.1rem;font-weight:800;color:var(--text);margin-bottom:6px;}
.emp-name{color:var(--pink-light);font-size:.88rem;font-weight:600;margin-bottom:10px;}
.info-line{display:flex;align-items:center;gap:8px;color:var(--muted);font-size:.82rem;margin-bottom:5px;}
.info-line i{color:var(--pink);width:14px;}

.res-right{text-align:right;}
.res-price{font-size:1.5rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:6px;}
.pay-method{color:var(--muted);font-size:.78rem;margin-bottom:10px;}

.status-badge{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:999px;font-size:.78rem;font-weight:700;}
.status-confirmed{background:rgba(74,222,128,.12);color:#4ade80;}
.status-pending{background:rgba(251,191,36,.12);color:#fbbf24;}
.status-done{background:rgba(99,102,241,.12);color:#818cf8;}
.status-cancelled{background:rgba(239,68,68,.12);color:#f87171;}

.res-alert{margin-top:18px;border-radius:14px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;border:1px solid transparent;}
.alert-warning-dk{background:rgba(251,191,36,.08);border-color:rgba(251,191,36,.2);color:#fbbf24;}
.alert-success-dk{background:rgba(74,222,128,.08);border-color:rgba(74,222,128,.2);color:#4ade80;}

.btn-cancel-req{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#f87171;border-radius:12px;font-size:.82rem;font-weight:700;cursor:pointer;transition:.25s;}
.btn-cancel-req:hover{background:rgba(239,68,68,.2);}

.review-box{margin-top:20px;padding-top:18px;border-top:1px solid rgba(255,255,255,.06);}
.review-title{font-weight:700;color:var(--text);margin-bottom:14px;font-size:.95rem;}
.stars-wrap{display:flex;gap:8px;margin-bottom:14px;}
.star{font-size:1.8rem;cursor:pointer;transition:.2s;filter:grayscale(1);opacity:.35;}
.star:hover,.star.active{filter:none;opacity:1;transform:scale(1.12);}
.review-ta{width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(233,30,140,.2);border-radius:14px;padding:14px;color:var(--text);font-family:inherit;font-size:.9rem;resize:none;outline:none;transition:.25s;margin-bottom:14px;}
.review-ta:focus{border-color:rgba(233,30,140,.5);background:rgba(233,30,140,.06);}
.review-ta::placeholder{color:var(--muted);}
.btn-review{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;background:var(--gradient);color:#fff;border:none;border-radius:12px;font-weight:700;font-size:.88rem;cursor:pointer;transition:.3s;box-shadow:0 6px 16px rgba(233,30,140,.3);}
.btn-review:hover{transform:translateY(-2px);}

.review-display{margin-top:14px;padding:16px;background:rgba(233,30,140,.06);border:1px solid rgba(233,30,140,.15);border-radius:14px;}
.review-stars{color:var(--pink-light);margin-bottom:6px;}
.review-comment{color:var(--text);font-size:.9rem;font-style:italic;}

.empty-card{background:var(--card);border:1px dashed rgba(233,30,140,.2);border-radius:28px;padding:60px 24px;text-align:center;}
.empty-icon{font-size:3.5rem;color:rgba(233,30,140,.3);margin-bottom:16px;}
.empty-title{font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:8px;}
.empty-text{color:var(--muted);margin-bottom:24px;font-size:.9rem;}

.pagination-wrap{margin-top:24px;}
.pagination{display:flex;gap:6px;flex-wrap:wrap;}
.pagination .page-link{background:var(--card);border:1px solid var(--card-border);color:var(--text);border-radius:10px;padding:6px 13px;font-size:.85rem;text-decoration:none;transition:.2s;}
.pagination .page-link:hover,.pagination .page-item.active .page-link{background:var(--gradient);border-color:transparent;color:#fff;}
.pagination .page-item.disabled .page-link{opacity:.35;pointer-events:none;}

.cancel-policy-box{margin-top:14px;padding:14px 18px;background:rgba(148,163,184,.07);border:1px solid rgba(148,163,184,.15);border-radius:14px;}
.cancel-policy-head{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.75);font-weight:700;font-size:.88rem;margin-bottom:8px;}
.cancel-policy-head i{color:#94a3b8;font-size:.85rem;}
.cancel-policy-desc{color:rgba(255,255,255,.45);font-size:.82rem;line-height:1.65;margin:0 0 10px;}
.cancel-policy-meta{display:flex;flex-wrap:wrap;gap:14px;}
.cancel-meta-item{display:flex;align-items:center;gap:6px;font-size:.8rem;color:rgba(255,255,255,.5);}
.cancel-meta-item i{color:#94a3b8;width:12px;}
.cancel-meta-item strong{color:rgba(255,255,255,.75);}

@media(max-width:640px){
    .res-top{flex-direction:column;}
    .res-right{text-align:left;}
    .res-header{flex-direction:column;align-items:flex-start;}
}
</style>

<div class="res-wrap">

@if(session('success'))
<div class="flash-ok"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</div>
@endif

<div class="res-header">
    <div>
        <h1 class="res-title">{{ __('messages.clt_reservations_title') }}</h1>
        <p class="res-sub">{{ $reservations->total() }} {{ __('messages.clt_new_reservation') }}</p>
    </div>
    <a href="{{ route('booking.start') }}" class="btn-new">
        <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.clt_new_reservation') }}
    </a>
</div>

@forelse($reservations as $r)
<div class="res-card">
    <div class="res-top">

        <div class="res-left">
            <div class="res-icon">{{ $r->service->emoji }}</div>
            <div>
                <h3 class="svc-name">{{ $r->service->name }}</h3>
                <div class="emp-name">{{ __('messages.clt_res_with') }} <strong>{{ $r->employee->user->name }}</strong></div>
                <div class="info-line"><i class="fa-solid fa-calendar"></i>{{ \Carbon\Carbon::parse($r->date)->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY') }}</div>
                <div class="info-line"><i class="fa-solid fa-clock"></i>{{ \Carbon\Carbon::parse($r->start_time)->format('H:i') }}</div>
                <div class="info-line"><i class="fa-solid fa-hashtag"></i>{{ $r->reference }}</div>
            </div>
        </div>

        <div class="res-right">
            <div class="res-price">{{ $r->formatted_amount }}</div>
            @if($r->payment)<div class="pay-method">{{ $r->payment->method_label }}</div>@endif
            <span class="status-badge {{ $r->status === 'confirmed' ? 'status-confirmed' : ($r->status === 'pending' ? 'status-pending' : ($r->status === 'done' ? 'status-done' : 'status-cancelled')) }}">
                <i class="fa-solid fa-circle-dot"></i> {{ $r->status_label }}
            </span>
        </div>

    </div>

    @if($r->isPending() || $r->isConfirmed())
    @php $cancelPolicy = \App\Models\CancellationPolicy::getPolicyForReservation($r); @endphp
    <div class="res-alert {{ $r->isPending() ? 'alert-warning-dk' : 'alert-success-dk' }}">
        <div>
            @if($r->isPending())
                <i class="fa-solid fa-clock mr-1"></i> {{ __('messages.clt_pending_confirm') }}
            @else
                <i class="fa-solid fa-check mr-1"></i> {{ __('messages.clt_reservation_confirmed') }}
            @endif
        </div>
        <form action="{{ route('client.cancel-request', $r) }}" method="POST" onsubmit="return confirm('{{ __('messages.clt_res_cancel_confirm') }}')">
            @csrf
            <button type="submit" class="btn-cancel-req"><i class="fa-solid fa-xmark"></i> {{ __('messages.clt_request_cancel') }}</button>
        </form>
    </div>

    {{-- Cancellation policy (read-only) --}}
    <div class="cancel-policy-box">
        <div class="cancel-policy-head">
            <i class="fa-solid fa-shield-halved"></i>
            <span>{{ $cancelPolicy->name }}</span>
        </div>
        @if($cancelPolicy->description)
        <p class="cancel-policy-desc">{{ $cancelPolicy->description }}</p>
        @endif
        <div class="cancel-policy-meta">
            <div class="cancel-meta-item">
                <i class="fa-solid fa-clock"></i>
                <span>Délai : {{ $cancelPolicy->hours_before > 0 ? $cancelPolicy->hours_before . 'h avant' : 'Immédiatement' }}</span>
            </div>
            <div class="cancel-meta-item">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Remboursement : <strong>{{ $cancelPolicy->refund_percentage }}%</strong></span>
            </div>
        </div>
    </div>
    @endif

    @if($r->isDone() && !$r->review)
    <div class="review-box" x-data="{ rating: 0 }">
        <div class="review-title">{{ __('messages.clt_experience_title') }}</div>
        <form action="{{ route('client.reservations.review', $r) }}" method="POST">
            @csrf
            <div class="stars-wrap">
                @for($i = 1; $i <= 5; $i++)
                <span class="star" @click="rating={{ $i }}" @mouseover="rating={{ $i }}" @mouseleave="" :class="rating >= {{ $i }} ? 'active' : ''">⭐</span>
                @endfor
                <input type="hidden" name="rating" :value="rating">
            </div>
            <textarea name="comment" rows="3" class="review-ta" placeholder="{{ __('messages.clt_share_experience') }}"></textarea>
            <button type="submit" class="btn-review" :disabled="rating===0" :style="rating===0?'opacity:.45;cursor:not-allowed':''">
                <i class="fa-solid fa-star"></i> {{ __('messages.clt_publish_review') }}
            </button>
        </form>
    </div>
    @endif

    @if($r->isDone() && $r->review)
    <div class="review-display">
        <div class="review-stars">{{ $r->review->stars }}</div>
        <div class="review-comment">"{{ $r->review->comment }}"</div>
    </div>
    @endif

</div>
@empty
<div class="empty-card">
    <div class="empty-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
    <h3 class="empty-title">{{ __('messages.clt_no_reservation') }}</h3>
    <p class="empty-text">{{ __('messages.clt_no_reservation_text') }}</p>
    <a href="{{ route('booking.start') }}" class="btn-new">
        <i class="fa-solid fa-calendar-plus"></i> {{ __('messages.clt_book_appointment') }}
    </a>
</div>
@endforelse

<div class="pagination-wrap">{{ $reservations->links() }}</div>

</div>
@endsection

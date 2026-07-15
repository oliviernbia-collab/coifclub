@extends('layouts.client')

@section('title', __('messages.mybk_title'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.res-wrap{max-width:900px;}

.res-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:32px;}
.res-title{font-size:1.8rem;font-weight:900;color:var(--text);margin-bottom:4px;display:flex;align-items:center;gap:12px;}
.res-sub{color:var(--muted);font-size:.9rem;}

.res-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;overflow:hidden;margin-bottom:20px;transition:.3s;}
.res-card:hover{border-color:rgba(233,30,140,.25);transform:translateY(-3px);box-shadow:0 16px 40px rgba(0,0,0,.25);}
.res-card-stripe{height:4px;background:var(--gradient);}
.res-card-body{padding:26px 28px;}

.res-top{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:20px;margin-bottom:24px;}
.svc-title{font-size:1.15rem;font-weight:800;color:var(--text);margin-bottom:10px;display:flex;align-items:center;gap:10px;}
.svc-title i{color:var(--pink);}
.meta-row{display:flex;flex-wrap:wrap;gap:16px;}
.meta-item{display:flex;align-items:center;gap:7px;font-size:.88rem;color:var(--muted);}
.meta-item i{color:var(--pink);}

.res-right{text-align:right;flex-shrink:0;}
.res-price{font-size:1.5rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:8px;}
.status-badge{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:999px;font-size:.8rem;font-weight:700;margin-top:6px;}
.badge-confirmed{background:rgba(74,222,128,.12);color:#4ade80;}
.badge-pending{background:rgba(251,191,36,.12);color:#fbbf24;}
.badge-cancelled{background:rgba(239,68,68,.12);color:#f87171;}

.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;}
@media(max-width:640px){.info-grid{grid-template-columns:1fr;}}

.info-box{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:18px;padding:18px;}
.info-box-title{font-size:.85rem;font-weight:700;color:var(--text);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
.info-box-title .icon{width:30px;height:30px;border-radius:9px;background:rgba(233,30,140,.12);display:flex;align-items:center;justify-content:center;color:var(--pink);font-size:.8rem;flex-shrink:0;}
.info-line{font-size:.88rem;color:var(--muted);margin-bottom:6px;line-height:1.6;}
.info-line strong{color:var(--text);}

.cancel-box{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);border-radius:20px;padding:22px;}
.cancel-title{font-size:.95rem;font-weight:700;color:#f87171;display:flex;align-items:center;gap:9px;margin-bottom:14px;}
.cancel-ta{width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(239,68,68,.2);border-radius:14px;padding:13px 15px;color:var(--text);font-family:inherit;font-size:.9rem;resize:none;outline:none;transition:.25s;margin-bottom:12px;}
.cancel-ta:focus{border-color:rgba(239,68,68,.4);background:rgba(239,68,68,.05);}
.cancel-ta::placeholder{color:var(--muted);}
.btn-cancel-req{display:inline-flex;align-items:center;gap:8px;padding:11px 20px;background:linear-gradient(135deg,#ef4444,#dc2626);border:none;border-radius:14px;color:#fff;font-weight:700;font-size:.88rem;cursor:pointer;transition:.25s;box-shadow:0 6px 16px rgba(239,68,68,.3);}
.btn-cancel-req:hover{transform:translateY(-2px);}

.alert-cancelled{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:16px;padding:16px 20px;color:#f87171;font-size:.9rem;}

.empty-box{background:var(--card);border:1px dashed rgba(233,30,140,.2);border-radius:24px;padding:60px 24px;text-align:center;}
.empty-box i{font-size:3.5rem;color:rgba(233,30,140,.3);margin-bottom:16px;display:block;}
.empty-box h4{font-size:1.3rem;font-weight:800;color:var(--text);margin-bottom:8px;}
.empty-box p{color:var(--muted);font-size:.9rem;margin:0;}

.pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:24px;}
.pagination .page-link{background:var(--card);border:1px solid var(--card-border);color:var(--text);border-radius:10px;padding:6px 13px;font-size:.85rem;text-decoration:none;transition:.2s;}
.pagination .page-link:hover,.pagination .page-item.active .page-link{background:var(--gradient);border-color:transparent;color:#fff;}
.pagination .page-item.disabled .page-link{opacity:.35;pointer-events:none;}

@media(max-width:640px){
    .res-top{flex-direction:column;}
    .res-right{text-align:left;}
    .res-header{flex-direction:column;align-items:flex-start;}
}
</style>

<div class="res-wrap">

    <div class="res-header">
        <div>
            <h1 class="res-title"><i class="fa-solid fa-calendar-check"></i> {{ __('messages.mybk_title') }}</h1>
            <p class="res-sub">{{ __('messages.mybk_subtitle') }}</p>
        </div>
    </div>

    @if($reservations->isEmpty())
    <div class="empty-box">
        <i class="fa-regular fa-calendar-xmark"></i>
        <h4>{{ __('messages.mybk_empty_title') }}</h4>
        <p>{{ __('messages.mybk_empty_text') }}</p>
    </div>
    @endif

    @foreach($reservations as $reservation)
    @php
        $policy = \App\Models\CancellationPolicy::getPolicyForReservation($reservation);
        $refundAmount = ($reservation->amount * ($policy->refund_percentage ?? 0)) / 100;
    @endphp

    <div class="res-card">
        <div class="res-card-stripe"></div>
        <div class="res-card-body">

            <div class="res-top">
                <div>
                    <div class="svc-title">
                        <i class="fa-solid fa-scissors"></i>
                        {{ optional($reservation->service)->name ?? 'Service' }}
                    </div>
                    <div class="meta-row">
                        <div class="meta-item"><i class="fa-regular fa-calendar"></i>{{ optional($reservation->date)->format('d/m/Y') }}</div>
                        <div class="meta-item"><i class="fa-regular fa-clock"></i>{{ optional($reservation->start_time)->format('H:i') ?: $reservation->start_time ?? '—' }}</div>
                        <div class="meta-item"><i class="fa-solid fa-hashtag"></i>{{ $reservation->reference }}</div>
                    </div>
                </div>
                <div class="res-right">
                    <div class="res-price">{{ $reservation->formatted_amount }}</div>
                    <span class="status-badge badge-{{ $reservation->status_color }}">
                        @if($reservation->status_color === 'confirmed')<i class="fa-solid fa-circle-check"></i>
                        @elseif($reservation->status_color === 'cancelled')<i class="fa-solid fa-circle-xmark"></i>
                        @else<i class="fa-solid fa-hourglass-half"></i>@endif
                        {{ $reservation->status_label }}
                    </span>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-title">
                        <div class="icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                        {{ __('messages.mybk_cancel_policy') }}
                    </div>
                    <div class="info-line"><strong>{{ __('messages.mybk_refund') }} :</strong> {{ $policy->refund_percentage ?? 0 }}%</div>
                    <div class="info-line"><strong>{{ __('messages.mybk_estimated_amount') }} :</strong> {{ number_format($refundAmount, 0, ',', ' ') }}</div>
                    <div class="info-line">{{ $policy->description ?? __('messages.mybk_no_policy') }}</div>
                </div>
                <div class="info-box">
                    <div class="info-box-title">
                        <div class="icon"><i class="fa-solid fa-user-tie"></i></div>
                        {{ __('messages.mybk_appt_info') }}
                    </div>
                    <div class="info-line"><strong>{{ __('messages.mybk_stylist') }} :</strong> {{ $reservation->employee?->user?->name ?? __('messages.mybk_not_defined') }}</div>
                    <div class="info-line"><strong>{{ __('messages.mybk_salon') }} :</strong> {{ $reservation->salon?->name ?? '—' }}</div>
                    <div class="info-line"><strong>{{ __('messages.mybk_payment') }} :</strong> {{ $reservation->payment?->method ?? __('messages.mybk_not_defined') }}</div>
                </div>
            </div>

            @if($reservation->isPending() || $reservation->isConfirmed())
            <div class="cancel-box">
                <div class="cancel-title"><i class="fa-solid fa-ban"></i> {{ __('messages.mybk_cancel_request') }}</div>
                <form action="{{ route('client.cancel-request', $reservation) }}" method="POST">
                    @csrf
                    <textarea name="reason" rows="3" class="cancel-ta" placeholder="{{ __('messages.mybk_cancel_placeholder') }}">{{ old('reason') }}</textarea>
                    @error('reason')<div style="color:#f87171;font-size:.82rem;margin-bottom:10px;">{{ $message }}</div>@enderror
                    <button type="submit" class="btn-cancel-req"><i class="fa-solid fa-paper-plane"></i> {{ __('messages.mybk_send_request') }}</button>
                </form>
            </div>
            @elseif($reservation->isCancelled())
            <div class="alert-cancelled">
                <div style="font-weight:700;margin-bottom:6px;"><i class="fa-solid fa-circle-xmark mr-2"></i> {{ __('messages.mybk_cancelled_title') }}</div>
                {{ $reservation->cancellation_reason ?? __('messages.mybk_no_reason') }}
            </div>
            @endif

        </div>
    </div>
    @endforeach

    @if(method_exists($reservations, 'links'))
    <div>{{ $reservations->links() }}</div>
    @endif

</div>

@endsection

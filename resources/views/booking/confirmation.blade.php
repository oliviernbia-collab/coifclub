@extends('layouts.home')

@section('title', 'Appointment Confirmed — Marol Hair Braiding')

@push('styles')
<style>
.conf-wrap {
    background: #f9f9fb;
    min-height: 80vh;
    padding: 60px 0 80px;
    font-family: 'Inter', sans-serif;
}
.conf-card {
    max-width: 640px;
    margin: 0 auto;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,.08);
    overflow: hidden;
}

/* Header */
.conf-header {
    text-align: center;
    padding: 48px 40px 32px;
    border-bottom: 1px solid #f2f2f2;
}
.conf-check-circle {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(232,62,140,.1);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: #e83e8c;
}
.conf-h1 {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 10px;
}
.conf-subtitle { font-size: 14px; color: #777; margin: 0; line-height: 1.6; }

/* Details table */
.conf-details { padding: 28px 40px; }
.conf-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px 0;
    border-bottom: 1px solid #f5f5f5;
    font-size: 14px;
}
.conf-row:last-child { border: none; }
.conf-row-label { color: #999; font-weight: 500; }
.conf-row-value { color: #1a1a1a; font-weight: 600; text-align: right; }
.conf-row-value.pink { color: #e83e8c; font-size: 1.05rem; }

/* Email note */
.conf-email-note {
    background: rgba(232,62,140,.05);
    border-radius: 10px;
    padding: 14px 18px;
    margin: 0 40px 28px;
    font-size: 13px;
    color: #888;
    text-align: center;
    border: 1px solid rgba(232,62,140,.12);
}
.conf-email-note strong { color: #e83e8c; }

/* Buttons */
.conf-actions {
    display: flex;
    gap: 12px;
    padding: 0 40px 40px;
}
.conf-btn-primary {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
    background: #e83e8c; color: #fff; padding: 13px;
    border-radius: 10px; font-size: 14px; font-weight: 700;
    text-decoration: none; transition: .22s;
    box-shadow: 0 4px 16px rgba(232,62,140,.3);
}
.conf-btn-primary:hover { background: #c91a78; transform: translateY(-2px); color: #fff; }
.conf-btn-outline {
    flex: 1; display: flex; align-items: center; justify-content: center;
    border: 1.5px solid #e0e0e0; color: #555; padding: 13px;
    border-radius: 10px; font-size: 14px; font-weight: 600;
    text-decoration: none; transition: .2s; background: #fff;
}
.conf-btn-outline:hover { border-color: #e83e8c; color: #e83e8c; }

@media (max-width: 640px) {
    .conf-header, .conf-details { padding-left: 22px; padding-right: 22px; }
    .conf-email-note { margin-left: 22px; margin-right: 22px; }
    .conf-actions { flex-direction: column; padding-left: 22px; padding-right: 22px; padding-bottom: 30px; }
    .conf-h1 { font-size: 1.4rem; }
}
</style>
@endpush

@section('content')
<div class="conf-wrap">

    <div class="conf-card">

        {{-- Header --}}
        <div class="conf-header">
            <div class="conf-check-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="conf-h1">{{ __('messages.conf_h1') }}</h1>
            <p class="conf-subtitle">
                {{ __('messages.conf_subtitle') }}
            </p>
        </div>

        {{-- Details --}}
        <div class="conf-details">
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_svc_label') }}</span>
                <span class="conf-row-value">{{ optional($reservation->service)->name ?? optional($reservation->service)->nom ?? '—' }}</span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_date_label') }}</span>
                <span class="conf-row-value">
                    {{ \Carbon\Carbon::parse($reservation->date)->isoFormat('dddd, MMMM D, YYYY') }}
                </span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_time_label') }}</span>
                <span class="conf-row-value">{{ $reservation->start_time ?? __('messages.conf_time_default') }}</span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_dur_label') }}</span>
                <span class="conf-row-value">{{ optional($reservation->service)->formatted_duration ?? '—' }} <span style="color:#aaa;font-weight:400;">{{ __('messages.conf_dur_sfx') }}</span></span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_total_label') }}</span>
                <span class="conf-row-value pink">{{ number_format($payment->amount ?? $reservation->amount ?? 0) }}</span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_pay_label') }}</span>
                <span class="conf-row-value">
                    @switch($payment->method ?? '')
                        @case('stripe') {{ __('messages.conf_pay_card') }} @break
                        @case('paypal') {{ __('messages.conf_pay_paypal') }} @break
                        @case('mobile_money') {{ __('messages.conf_pay_mobile') }} @break
                        @case('cash') {{ __('messages.conf_pay_cash') }} @break
                        @default {{ ucfirst($payment->method ?? 'Online') }}
                    @endswitch
                </span>
            </div>
            <div class="conf-row">
                <span class="conf-row-label">{{ __('messages.conf_stylist_label') }}</span>
                <span class="conf-row-value">{{ optional($reservation->employee)->name ?? __('messages.conf_stylist_default') }}</span>
            </div>
        </div>

        {{-- Email note --}}
        <div class="conf-email-note">
            {{ __('messages.conf_email_note') }}
            <strong>{{ auth()->user()->email ?? 'your email' }}</strong>
        </div>

        {{-- Actions --}}
        <div class="conf-actions">
            <a href="{{ route('client.reservations.show', $reservation->id) }}" class="conf-btn-primary">
                <i class="fa-regular fa-calendar-check"></i>
                {{ __('messages.conf_view_appt') }}
            </a>
            <a href="{{ route('home') }}" class="conf-btn-outline">
                {{ __('messages.conf_back_home') }}
            </a>
        </div>

    </div>

</div>
@endsection

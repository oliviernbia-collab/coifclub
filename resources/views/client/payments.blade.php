@extends('layouts.client')

@section('title', __('messages.clt_pay_title'))
@section('page-title', __('messages.clt_pay_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.pay-wrap{max-width:960px;}

.pay-header{margin-bottom:28px;}
.pay-title{font-size:1.8rem;font-weight:900;color:var(--text);margin-bottom:4px;}
.pay-sub{color:var(--muted);font-size:.9rem;}

.pay-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;}
.stat-card{background:var(--card);border:1px solid var(--card-border);border-radius:20px;padding:20px;display:flex;align-items:center;gap:14px;transition:.25s;}
.stat-card:hover{border-color:rgba(233,30,140,.2);}
.stat-icon{width:44px;height:44px;border-radius:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-val{font-size:1.3rem;font-weight:900;color:var(--text);}
.stat-lbl{font-size:.78rem;color:var(--muted);}

.table-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;overflow:hidden;}
.table-head{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.05);}
.table-head-title{font-size:1rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
.table-head-title i{color:var(--pink);}
.table-head-count{font-size:.8rem;color:var(--muted);}

.pay-table{width:100%;border-collapse:collapse;}
.pay-table thead tr{background:rgba(233,30,140,.06);}
.pay-table th{padding:13px 20px;text-align:left;font-size:.75rem;font-weight:700;color:var(--pink-light);text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid rgba(233,30,140,.12);}
.pay-table th:last-child,.pay-table td:last-child{text-align:center;}
.pay-table th.r,.pay-table td.r{text-align:right;}
.pay-table tbody tr{border-bottom:1px solid rgba(255,255,255,.04);transition:.2s;}
.pay-table tbody tr:last-child{border-bottom:none;}
.pay-table tbody tr:hover{background:rgba(233,30,140,.03);}
.pay-table td{padding:15px 20px;font-size:.88rem;color:var(--text);vertical-align:middle;}
.pay-ref{font-family:monospace;font-size:.8rem;color:var(--muted);}
.pay-amount{font-weight:800;color:var(--text);}
.method-cell{display:inline-flex;align-items:center;gap:7px;font-size:.82rem;color:var(--text);}

.badge-ok{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;background:rgba(74,222,128,.12);color:#4ade80;border-radius:999px;font-size:.75rem;font-weight:700;}
.badge-pending{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;background:rgba(251,191,36,.12);color:#fbbf24;border-radius:999px;font-size:.75rem;font-weight:700;}
.badge-fail{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;background:rgba(239,68,68,.12);color:#f87171;border-radius:999px;font-size:.75rem;font-weight:700;}

.pay-empty{padding:60px 24px;text-align:center;}
.pay-empty i{font-size:3rem;color:var(--muted);margin-bottom:16px;display:block;}
.pay-empty p{color:var(--muted);font-size:.9rem;}

@media(max-width:680px){
    .pay-stats{grid-template-columns:1fr;}
    .pay-table th:nth-child(2),.pay-table td:nth-child(2),
    .pay-table th:nth-child(3),.pay-table td:nth-child(3){display:none;}
}
</style>

<div class="pay-wrap">

    <div class="pay-header">
        <h2 class="pay-title">{{ __('messages.clt_pay_title') }}</h2>
        <p class="pay-sub">{{ __('messages.clt_payment_history') }}</p>
    </div>

    @php
        $total   = $payments->sum('amount');
        $done    = $payments->where('status','completed')->count();
        $pending = $payments->where('status','pending')->count();
    @endphp

    <div class="pay-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(233,30,140,.12);">
                <i class="fa-solid fa-coins" style="color:var(--pink);font-size:18px;"></i>
            </div>
            <div>
                <div class="stat-val">{{ number_format($total, 0) }}</div>
                <div class="stat-lbl">{{ __('messages.clt_total_spent_label') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(74,222,128,.1);">
                <i class="fa-solid fa-circle-check" style="color:#4ade80;font-size:18px;"></i>
            </div>
            <div>
                <div class="stat-val">{{ $done }}</div>
                <div class="stat-lbl">{{ __('messages.clt_successful_payments') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(251,191,36,.1);">
                <i class="fa-regular fa-clock" style="color:#fbbf24;font-size:18px;"></i>
            </div>
            <div>
                <div class="stat-val">{{ $pending }}</div>
                <div class="stat-lbl">{{ __('messages.clt_pending_payments') }}</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-head">
            <div class="table-head-title">
                <i class="fa-regular fa-credit-card"></i> {{ __('messages.clt_txn_history') }}
            </div>
            <span class="table-head-count">{{ $payments->count() }} {{ __('messages.clt_txn_count') }}</span>
        </div>

        @if($payments->isEmpty())
        <div class="pay-empty">
            <i class="fa-regular fa-credit-card"></i>
            <p>{{ __('messages.clt_no_payment_yet') }}</p>
        </div>
        @else
        <div style="overflow-x:auto;">
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.adm_date') }}</th>
                        <th>{{ __('messages.clt_txn_ref') }}</th>
                        <th>{{ __('messages.clt_txn_service') }}</th>
                        <th>{{ __('messages.clt_txn_method') }}</th>
                        <th class="r">{{ __('messages.clt_txn_amount') }}</th>
                        <th>{{ __('messages.clt_txn_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                        <td><span class="pay-ref">#{{ substr($payment->transaction_id ?? $payment->id, 0, 10) }}</span></td>
                        <td>{{ $payment->reservation?->service?->name ?? ($payment->order ? 'Commande #'.$payment->order_id : '—') }}</td>
                        <td>
                            <span class="method-cell">
                                @if($payment->method === 'stripe')
                                    <i class="fa-brands fa-cc-stripe" style="color:#635bff;font-size:16px;"></i>
                                @elseif($payment->method === 'paypal')
                                    <i class="fa-brands fa-paypal" style="color:#009cde;font-size:16px;"></i>
                                @else
                                    <i class="fa-solid fa-mobile-screen-button" style="color:var(--pink);font-size:14px;"></i>
                                @endif
                                {{ $payment->method_label }}
                            </span>
                        </td>
                        <td class="r"><span class="pay-amount">{{ number_format($payment->amount, 2) }}</span></td>
                        <td>
                            @if($payment->status === 'completed')
                                <span class="badge-ok"><i class="fa-solid fa-check" style="font-size:10px;"></i> {{ __('messages.clt_txn_succeeded') }}</span>
                            @elseif($payment->status === 'pending')
                                <span class="badge-pending"><i class="fa-regular fa-clock" style="font-size:10px;"></i> {{ __('messages.pending') }}</span>
                            @else
                                <span class="badge-fail"><i class="fa-solid fa-xmark" style="font-size:10px;"></i> {{ __('messages.clt_txn_failed') }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection

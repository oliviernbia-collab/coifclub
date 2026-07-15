@extends('layouts.app')

@section('title', 'Paiement Mobile Money')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.pay-page{
    min-height:100vh;
    padding:4rem 1.2rem 5rem;
    position:relative;
}
.pay-page::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(circle at top right,rgba(233,30,140,.1),transparent 30%),
               radial-gradient(circle at bottom left,rgba(233,30,140,.06),transparent 25%);
}

.pay-container{max-width:620px;margin:auto;position:relative;z-index:2;}

/* Header */
.pay-header{text-align:center;margin-bottom:36px;}
.pay-icon-box{
    width:72px;height:72px;border-radius:22px;margin:0 auto 20px;
    background:var(--gradient);display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:1.8rem;box-shadow:0 16px 32px rgba(233,30,140,.4);
}
.pay-title{font-size:2rem;font-weight:900;color:var(--text);margin-bottom:8px;}
.pay-subtitle{color:var(--muted);line-height:1.7;max-width:500px;margin:auto;font-size:.95rem;}

/* Card */
.pay-card{
    background:var(--card);backdrop-filter:blur(20px);
    border:1px solid var(--card-border);border-radius:28px;overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.3);
}

/* Summary top */
.pay-top{
    padding:26px 30px;
    background:rgba(233,30,140,.05);
    border-bottom:1px solid rgba(233,30,140,.12);
}
.sum-item{display:flex;align-items:flex-start;gap:14px;margin-bottom:18px;}
.sum-item:last-child{margin-bottom:0;}
.sum-icon{
    width:46px;height:46px;border-radius:14px;flex-shrink:0;
    background:rgba(233,30,140,.12);border:1px solid rgba(233,30,140,.2);
    display:flex;align-items:center;justify-content:center;color:var(--pink);font-size:.95rem;
}
.sum-label{font-size:.78rem;color:var(--muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;}
.sum-value{font-weight:700;color:var(--text);line-height:1.4;font-size:.95rem;}
.sum-value.amount{font-size:1.4rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.sum-sub{color:var(--muted);font-size:.85rem;margin-top:3px;}

/* Body */
.pay-body{padding:28px 30px;}

.alert-err{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:14px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#f87171;font-weight:600;font-size:.9rem;margin-bottom:20px;}

.form-lbl{display:block;margin-bottom:8px;font-weight:700;color:var(--text);font-size:.9rem;}
.input-wrap{position:relative;margin-bottom:22px;}
.input-ico{position:absolute;top:50%;left:16px;transform:translateY(-50%);color:var(--muted);}
.pay-input{
    width:100%;height:56px;
    background:rgba(255,255,255,.06);border:1px solid rgba(233,30,140,.2);
    border-radius:16px;padding:0 16px 0 46px;
    color:var(--text);font-size:1rem;outline:none;transition:.25s;font-family:inherit;
}
.pay-input:focus{border-color:rgba(233,30,140,.5);background:rgba(233,30,140,.06);}
.pay-input::placeholder{color:var(--muted);}
.err-txt{margin-top:6px;color:#f87171;font-size:.85rem;font-weight:600;}

.secure-box{
    margin-bottom:24px;padding:14px 16px;
    border-radius:16px;background:rgba(74,222,128,.07);
    border:1px solid rgba(74,222,128,.15);
    display:flex;align-items:flex-start;gap:12px;color:#4ade80;font-size:.88rem;line-height:1.6;
}
.secure-box i{flex-shrink:0;margin-top:2px;}

.pay-btn{
    width:100%;height:56px;border:none;border-radius:16px;
    background:var(--gradient);color:#fff;font-size:1rem;font-weight:800;
    display:flex;align-items:center;justify-content:center;gap:10px;
    cursor:pointer;transition:.3s;box-shadow:0 14px 28px rgba(233,30,140,.35);
}
.pay-btn:hover{transform:translateY(-2px);box-shadow:0 20px 36px rgba(233,30,140,.45);}

.pay-footer{margin-top:16px;text-align:center;color:var(--muted);font-size:.82rem;}

@media(max-width:580px){
    .pay-title{font-size:1.65rem;}
    .pay-top,.pay-body{padding:20px;}
}
</style>

<div class="pay-page">
<div class="pay-container">

    {{-- Header --}}
    <div class="pay-header">
        <div class="pay-icon-box"><i class="fa-solid fa-wallet"></i></div>
        <h1 class="pay-title">Paiement Mobile Money</h1>
        <p class="pay-subtitle">Finalisez votre acompte de réservation en toute sécurité via votre service Mobile Money.</p>
    </div>

    <div class="pay-card">

        {{-- Summary --}}
        <div class="pay-top">
            <div class="sum-item">
                <div class="sum-icon"><i class="fa-solid fa-scissors"></i></div>
                <div>
                    <div class="sum-label">Réservation</div>
                    <div class="sum-value">{{ $payment->reservation->service->name }}</div>
                    <div class="sum-sub">{{ $payment->reservation->date->format('d/m/Y') }} à {{ $payment->reservation->start_time }}</div>
                </div>
            </div>
            <div class="sum-item">
                <div class="sum-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                <div>
                    <div class="sum-label">Montant à payer</div>
                    <div class="sum-value amount">{{ number_format($payment->amount, 0, ',', ' ') }}</div>
                </div>
            </div>
            <div class="sum-item">
                <div class="sum-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                <div>
                    <div class="sum-label">Méthode</div>
                    <div class="sum-value">{{ $payment->method_label }}</div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="pay-body">
            @if(session('error'))
            <div class="alert-err"><i class="fa-solid fa-circle-exclamation"></i><span>{{ session('error') }}</span></div>
            @endif

            <form action="{{ route('payment.mobile.process', $payment) }}" method="POST">
                @csrf
                <label class="form-lbl" for="phone_number">Numéro Mobile Money</label>
                <div class="input-wrap">
                    <span class="input-ico"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" id="phone_number" name="phone_number" class="pay-input"
                           value="{{ old('phone_number', $payment->phone_number) }}"
                           placeholder="+225 07 00 00 00">
                    @error('phone_number')<div class="err-txt">{{ $message }}</div>@enderror
                </div>

                <div class="secure-box">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div>Votre paiement est sécurisé et crypté. Vous recevrez une confirmation après validation de la transaction.</div>
                </div>

                <button type="submit" class="pay-btn">
                    <i class="fa-solid fa-lock"></i> Payer maintenant
                </button>
            </form>

            <div class="pay-footer">Transaction sécurisée &bull; Mobile Money &bull; Paiement instantané</div>
        </div>

    </div>

</div>
</div>

@endsection

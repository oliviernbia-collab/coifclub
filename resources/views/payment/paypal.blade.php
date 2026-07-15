@extends('layouts.app')

@section('title', 'Paiement PayPal')

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
    min-height:100vh;padding:4rem 1.2rem 5rem;position:relative;
}
.pay-page::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(circle at top right,rgba(233,30,140,.1),transparent 30%),
               radial-gradient(circle at bottom left,rgba(233,30,140,.06),transparent 25%);
}

.pay-container{max-width:580px;margin:auto;position:relative;z-index:2;}

.pay-header{text-align:center;margin-bottom:36px;}
.pay-icon-box{
    width:72px;height:72px;border-radius:22px;margin:0 auto 20px;
    background:linear-gradient(135deg,#009cde,#003087);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:1.8rem;box-shadow:0 16px 32px rgba(0,156,222,.3);
}
.pay-title{font-size:2rem;font-weight:900;color:var(--text);margin-bottom:8px;}
.pay-subtitle{color:var(--muted);line-height:1.7;max-width:480px;margin:auto;font-size:.95rem;}

.pay-card{
    background:var(--card);backdrop-filter:blur(20px);
    border:1px solid var(--card-border);border-radius:28px;overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.3);margin-bottom:16px;
}

.pay-top{
    padding:26px 30px;
    background:rgba(233,30,140,.05);
    border-bottom:1px solid rgba(233,30,140,.12);
}
.sum-item{display:flex;align-items:flex-start;gap:14px;margin-bottom:16px;}
.sum-item:last-child{margin-bottom:0;}
.sum-icon{
    width:44px;height:44px;border-radius:13px;flex-shrink:0;
    background:rgba(233,30,140,.12);border:1px solid rgba(233,30,140,.2);
    display:flex;align-items:center;justify-content:center;color:var(--pink);font-size:.9rem;
}
.sum-label{font-size:.75rem;color:var(--muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;}
.sum-value{font-weight:700;color:var(--text);font-size:.92rem;}
.sum-value.amount{font-size:1.3rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.sum-sub{color:var(--muted);font-size:.83rem;margin-top:2px;}

.pay-body{padding:26px 30px;}

.alert-err{display:flex;align-items:center;gap:10px;padding:13px 16px;border-radius:13px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#f87171;font-weight:600;font-size:.88rem;margin-bottom:18px;}

.pay-info{color:var(--muted);font-size:.9rem;line-height:1.7;margin-bottom:22px;}

.btn-paypal{
    display:flex;align-items:center;justify-content:center;gap:12px;
    width:100%;height:56px;border-radius:16px;
    background:linear-gradient(135deg,#009cde,#003087);
    color:#fff;font-size:1rem;font-weight:800;
    text-decoration:none;border:none;cursor:pointer;
    transition:.3s;box-shadow:0 14px 28px rgba(0,156,222,.3);
}
.btn-paypal:hover{transform:translateY(-2px);box-shadow:0 20px 36px rgba(0,156,222,.4);color:#fff;}

.pay-footer{margin-top:14px;text-align:center;color:var(--muted);font-size:.82rem;}

.secure-note{
    display:flex;align-items:center;gap:10px;
    background:rgba(233,30,140,.06);border:1px solid rgba(233,30,140,.12);
    border-radius:14px;padding:14px 18px;color:var(--muted);font-size:.85rem;line-height:1.6;
    margin-top:14px;
}
.secure-note i{color:var(--pink);flex-shrink:0;}

@media(max-width:540px){.pay-title{font-size:1.65rem;}.pay-top,.pay-body{padding:20px;}}
</style>

<div class="pay-page">
<div class="pay-container">

    <div class="pay-header">
        <div class="pay-icon-box"><i class="fa-brands fa-paypal"></i></div>
        <h1 class="pay-title">Paiement PayPal</h1>
        <p class="pay-subtitle">Confirmez le paiement PayPal pour votre acompte de réservation.</p>
    </div>

    <div class="pay-card">
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
                <div class="sum-icon"><i class="fa-brands fa-paypal"></i></div>
                <div>
                    <div class="sum-label">Méthode</div>
                    <div class="sum-value">PayPal</div>
                </div>
            </div>
        </div>

        <div class="pay-body">
            @if(session('error'))
            <div class="alert-err"><i class="fa-solid fa-circle-exclamation"></i><span>{{ session('error') }}</span></div>
            @endif

            <p class="pay-info">Cliquez sur le bouton ci-dessous pour ouvrir PayPal et finaliser votre paiement sécurisé. Vous serez redirigé vers le site PayPal.</p>

            <a href="{{ $approvalUrl }}" class="btn-paypal">
                <i class="fa-brands fa-paypal" style="font-size:1.3rem;"></i> Payer avec PayPal
            </a>

            <div class="secure-note">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Paiement 100% sécurisé par PayPal. Vos données bancaires ne nous sont jamais transmises.</span>
            </div>
        </div>
    </div>

    <div class="pay-footer">Transaction sécurisée &bull; PayPal &bull; Protection acheteur incluse</div>

</div>
</div>

@endsection

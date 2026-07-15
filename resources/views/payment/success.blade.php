@extends('layouts.app')
@section('title', 'Paiement réussi')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.suc-page{
    min-height:100vh;padding:4rem 1.2rem 5rem;position:relative;
}
.suc-page::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(circle at top right,rgba(233,30,140,.1),transparent 30%),
               radial-gradient(circle at bottom left,rgba(233,30,140,.06),transparent 25%);
}

.suc-container{max-width:560px;margin:auto;position:relative;z-index:2;}

.suc-hero{text-align:center;margin-bottom:32px;}
.suc-check{
    width:88px;height:88px;border-radius:50%;margin:0 auto 24px;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    display:flex;align-items:center;justify-content:center;
    font-size:2.4rem;box-shadow:0 20px 40px rgba(34,197,94,.35);
    animation:popIn .5s cubic-bezier(.175,.885,.32,1.275) both;
}
@keyframes popIn{from{transform:scale(0);opacity:0}to{transform:scale(1);opacity:1}}

.suc-title{font-size:2rem;font-weight:900;color:var(--text);margin-bottom:10px;}
.suc-sub{color:var(--muted);line-height:1.7;font-size:.93rem;max-width:440px;margin:auto;}

.suc-card{
    background:var(--card);backdrop-filter:blur(20px);
    border:1px solid var(--card-border);border-radius:28px;overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.3);margin-bottom:20px;
}

.suc-card-head{
    padding:18px 28px;
    background:rgba(34,197,94,.06);border-bottom:1px solid rgba(34,197,94,.12);
    display:flex;align-items:center;gap:10px;font-weight:800;color:var(--text);font-size:.95rem;
}
.suc-card-head i{color:#4ade80;}

.suc-row{
    display:flex;justify-content:space-between;align-items:flex-start;gap:12px;
    padding:13px 28px;border-bottom:1px solid rgba(255,255,255,.04);font-size:.87rem;
}
.suc-row:last-child{border-bottom:none;}
.suc-key{color:var(--muted);flex-shrink:0;}
.suc-val{font-weight:600;color:var(--text);text-align:right;}
.suc-val.highlight{font-size:1.05rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}

.suc-actions{display:flex;flex-direction:column;gap:12px;}
.btn-primary{
    display:flex;align-items:center;justify-content:center;gap:10px;
    height:54px;border-radius:16px;background:var(--gradient);
    color:#fff;font-weight:800;font-size:.95rem;text-decoration:none;
    box-shadow:0 12px 28px rgba(233,30,140,.35);transition:.3s;
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 18px 36px rgba(233,30,140,.45);color:#fff;}

.btn-outline{
    display:flex;align-items:center;justify-content:center;gap:10px;
    height:54px;border-radius:16px;
    background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);
    color:var(--text);font-weight:700;font-size:.93rem;text-decoration:none;transition:.3s;
}
.btn-outline:hover{border-color:rgba(233,30,140,.3);color:var(--pink-light);}

.whatsapp-note{
    margin-top:20px;display:flex;align-items:flex-start;gap:12px;
    background:rgba(37,211,102,.07);border:1px solid rgba(37,211,102,.15);
    border-radius:16px;padding:14px 18px;color:rgba(255,255,255,.6);font-size:.85rem;line-height:1.6;
}
.whatsapp-note i{color:#25d366;flex-shrink:0;margin-top:2px;}

@media(max-width:540px){
    .suc-title{font-size:1.65rem;}
    .suc-row{flex-direction:column;gap:4px;}
    .suc-val{text-align:left;}
    .suc-card-head,.suc-row{padding-left:20px;padding-right:20px;}
}
</style>

<div class="suc-page">
<div class="suc-container">

    <div class="suc-hero">
        <div class="suc-check">✓</div>
        <h1 class="suc-title">Paiement réussi !</h1>
        <p class="suc-sub">Votre réservation est confirmée. Vous allez recevoir une confirmation par WhatsApp.</p>
    </div>

    <div class="suc-card">
        <div class="suc-card-head"><i class="fa-solid fa-receipt"></i> Récapitulatif de la transaction</div>

        @foreach([
            ['Référence',    $payment->reservation->reference,                                                                    false],
            ['Prestation',   $payment->reservation->service->name,                                                                false],
            ['Coiffeuse',    $payment->reservation->employee->user->name,                                                         false],
            ['Date',         \Carbon\Carbon::parse($payment->reservation->date)->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY'), false],
            ['Heure',        \Carbon\Carbon::parse($payment->reservation->start_time)->format('H:i'),                             false],
            ['Montant payé', $payment->formatted_amount,                                                                          true],
            ['Méthode',      $payment->method_label,                                                                              false],
        ] as [$key, $val, $hl])
        <div class="suc-row">
            <span class="suc-key">{{ $key }}</span>
            <span class="suc-val {{ $hl ? 'highlight' : '' }}">{{ $val }}</span>
        </div>
        @endforeach
    </div>

    <div class="suc-actions">
        <a href="{{ route('client.reservations') }}" class="btn-primary">
            <i class="fa-solid fa-list-check"></i> Voir mes réservations
        </a>
        <a href="{{ route('booking.appointment') }}" class="btn-outline">
            <i class="fa-solid fa-calendar-plus"></i> Prendre un autre rendez-vous
        </a>
    </div>

    <div class="whatsapp-note">
        <i class="fa-brands fa-whatsapp fa-lg"></i>
        <div>Un message de confirmation vous sera envoyé sur WhatsApp avec tous les détails de votre rendez-vous.</div>
    </div>

</div>
</div>

@endsection

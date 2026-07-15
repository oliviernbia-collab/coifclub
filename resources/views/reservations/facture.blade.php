<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture — {{ $reservation->client->name ?? 'Client' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
    *, *::before, *::after{ box-sizing:border-box; margin:0; padding:0; }

    :root{
        --pk:#e91e8c; --pk-dark:#c91a78;
        --bg:#0e0a1c; --card:#1a1130; --card2:#120e22;
        --border:rgba(255,255,255,.07); --border-pk:rgba(233,30,140,.18);
        --text:#fff; --muted:rgba(255,255,255,.55);
        --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
    }

    body{
        font-family:'DM Sans',sans-serif;
        background:var(--bg);
        color:var(--text);
        min-height:100vh;
        padding:40px 20px;
    }

    .invoice-wrap{
        max-width:780px;
        margin:0 auto;
    }

    /* ── PRINT BUTTON ── */
    .print-bar{
        display:flex; justify-content:flex-end; gap:10px;
        margin-bottom:24px;
    }
    .btn-print{
        display:inline-flex; align-items:center; gap:8px;
        padding:11px 22px; border-radius:12px;
        background:var(--gradient); border:none;
        color:#fff; font-weight:700; font-size:.88rem;
        cursor:pointer; transition:.2s;
        box-shadow:0 6px 20px rgba(233,30,140,.3);
    }
    .btn-print:hover{ transform:translateY(-2px); }
    .btn-back{
        display:inline-flex; align-items:center; gap:8px;
        padding:11px 22px; border-radius:12px;
        background:rgba(255,255,255,.06); border:1.5px solid rgba(255,255,255,.1);
        color:rgba(255,255,255,.75); font-weight:600; font-size:.88rem;
        text-decoration:none; transition:.2s;
    }
    .btn-back:hover{ background:rgba(255,255,255,.09); color:#fff; }

    /* ── INVOICE CARD ── */
    .invoice{
        background:var(--card);
        border:1px solid var(--border-pk);
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 16px 48px rgba(0,0,0,.35);
    }

    /* ── HEADER ── */
    .inv-header{
        background:linear-gradient(135deg,#120e22 0%,#1a1130 100%);
        padding:36px 40px;
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:24px;
        border-bottom:1px solid var(--border-pk);
        position:relative; overflow:hidden;
    }
    .inv-header::before{
        content:''; position:absolute; top:-80px; right:-80px;
        width:280px; height:280px; border-radius:50%;
        background:radial-gradient(circle,rgba(233,30,140,.1),transparent 70%);
        pointer-events:none;
    }
    .inv-brand{ position:relative; z-index:1; }
    .inv-logo{
        display:flex; align-items:center; gap:14px; margin-bottom:8px;
    }
    .inv-logo-icon{
        width:50px; height:50px; border-radius:14px;
        background:var(--gradient);
        display:flex; align-items:center; justify-content:center;
        font-size:1.4rem; color:#fff;
    }
    .inv-logo-name{ font-size:1.4rem; font-weight:900; color:#fff; }
    .inv-logo-sub{ font-size:.78rem; color:var(--muted); }
    .inv-brand p{ font-size:.82rem; color:var(--muted); line-height:1.6; }

    .inv-meta{ text-align:right; position:relative; z-index:1; }
    .inv-title{
        font-size:2rem; font-weight:900; letter-spacing:.04em;
        background:var(--gradient); -webkit-background-clip:text;
        -webkit-text-fill-color:transparent; margin-bottom:10px;
    }
    .inv-ref{
        display:inline-flex; align-items:center; gap:6px;
        background:rgba(233,30,140,.1); border:1px solid var(--border-pk);
        border-radius:9px; padding:6px 14px;
        font-size:.82rem; font-weight:700; color:var(--pk);
        margin-bottom:8px;
    }
    .inv-date{ font-size:.82rem; color:var(--muted); }

    /* ── PARTIES ── */
    .inv-parties{
        display:grid; grid-template-columns:1fr 1fr;
        gap:24px; padding:30px 40px;
        border-bottom:1px solid var(--border);
    }
    .inv-party-label{
        font-size:.67rem; font-weight:700; letter-spacing:.12em;
        text-transform:uppercase; color:var(--pk); margin-bottom:10px;
        display:flex; align-items:center; gap:6px;
    }
    .inv-party-name{ font-size:1rem; font-weight:800; color:var(--text); margin-bottom:5px; }
    .inv-party-detail{ font-size:.83rem; color:var(--muted); line-height:1.7; }

    /* ── ITEMS TABLE ── */
    .inv-items{ padding:30px 40px; border-bottom:1px solid var(--border); }
    .inv-table{ width:100%; border-collapse:collapse; }
    .inv-table thead tr{
        background:rgba(233,30,140,.06);
        border-bottom:1px solid var(--border-pk);
    }
    .inv-table thead th{
        padding:12px 16px;
        font-size:10px; font-weight:700; letter-spacing:1.4px;
        text-transform:uppercase; color:rgba(255,255,255,.35);
    }
    .inv-table thead th:last-child{ text-align:right; }
    .inv-table tbody td{
        padding:16px; font-size:.9rem; color:rgba(255,255,255,.85);
        border-bottom:1px solid rgba(255,255,255,.04);
    }
    .inv-table tbody td:last-child{ text-align:right; font-weight:800; color:var(--text); }
    .inv-table tbody tr:last-child td{ border-bottom:none; }
    .inv-item-name{ font-weight:700; color:var(--text); }
    .inv-item-meta{ font-size:.78rem; color:var(--muted); margin-top:3px; }

    /* ── TOTALS ── */
    .inv-totals{ padding:24px 40px 30px; }
    .inv-total-row{
        display:flex; justify-content:space-between; align-items:center;
        padding:10px 0; border-bottom:1px solid rgba(255,255,255,.04);
        font-size:.88rem;
    }
    .inv-total-row:last-child{
        border-bottom:none; border-top:2px solid var(--border-pk);
        margin-top:6px; padding-top:16px;
        font-size:1.15rem; font-weight:900;
    }
    .inv-total-label{ color:var(--muted); }
    .inv-total-row:last-child .inv-total-label{ color:var(--text); }
    .inv-total-val{ font-weight:700; color:var(--text); }
    .inv-total-row:last-child .inv-total-val{
        background:var(--gradient);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        font-size:1.3rem;
    }

    /* ── FOOTER ── */
    .inv-footer{
        background:var(--card2);
        border-top:1px solid var(--border);
        padding:22px 40px;
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:16px;
    }
    .inv-footer p{ font-size:.78rem; color:var(--muted); line-height:1.6; }
    .inv-footer-brand{ font-weight:700; color:var(--pk); font-size:.88rem; }
    .inv-status{
        display:inline-flex; align-items:center; gap:7px;
        padding:8px 18px; border-radius:99px;
        font-size:.82rem; font-weight:700;
        background:rgba(74,222,128,.12); color:#4ade80;
        border:1px solid rgba(74,222,128,.25);
    }

    /* ── RESPONSIVE ── */
    @media(max-width:640px){
        body{ padding:20px 12px; }
        .inv-header{ padding:24px; flex-direction:column; align-items:flex-start; }
        .inv-meta{ text-align:left; }
        .inv-parties{ grid-template-columns:1fr; padding:20px 24px; gap:20px; }
        .inv-items{ padding:20px 24px; }
        .inv-totals{ padding:16px 24px 24px; }
        .inv-footer{ padding:18px 24px; flex-direction:column; align-items:flex-start; }
        .inv-table thead th:nth-child(3){ display:none; }
        .inv-table tbody td:nth-child(3){ display:none; }
    }

    /* ── PRINT ── */
    @media print{
        body{ background:#fff; color:#111; padding:0; }
        :root{
            --bg:#fff; --card:#fff; --card2:#f8f9fa;
            --border:rgba(0,0,0,.08); --border-pk:rgba(233,30,140,.2);
            --text:#111; --muted:#6b7280;
        }
        .print-bar{ display:none !important; }
        .invoice{ box-shadow:none; border:1px solid #e5e7eb; }
        .inv-header{ background:#fff; border-bottom:2px solid #e91e8c; }
        .inv-title{ color:#e91e8c; -webkit-text-fill-color:#e91e8c; background:none; }
        .inv-logo-icon{ background:#e91e8c; }
        .inv-total-row:last-child .inv-total-val{ color:#e91e8c; -webkit-text-fill-color:#e91e8c; }
    }
    </style>
</head>
<body>

<div class="invoice-wrap">

    {{-- Barre d'actions (cachée à l'impression) --}}
    <div class="print-bar">
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
        <button class="btn-print" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Imprimer
        </button>
    </div>

    <div class="invoice">

        {{-- HEADER --}}
        <div class="inv-header">
            <div class="inv-brand">
                <div class="inv-logo">
                    <div class="inv-logo-icon"><i class="fa-solid fa-scissors"></i></div>
                    <div>
                        <div class="inv-logo-name">Marol Hair Braiding</div>
                        <div class="inv-logo-sub">Premium Salon — Chicago, IL</div>
                    </div>
                </div>
                <p>
                    123 S Michigan Ave, Chicago, IL 60603<br>
                    contact@marolhair.com · +1 (312) 555-0100
                </p>
            </div>
            <div class="inv-meta">
                <div class="inv-title">FACTURE</div>
                <div class="inv-ref">
                    <i class="fa-solid fa-hashtag"></i>
                    {{ $reservation->reference ?? ('FAC-' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT)) }}
                </div>
                <div class="inv-date">
                    Émise le {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                </div>
            </div>
        </div>

        {{-- PARTIES --}}
        <div class="inv-parties">
            <div>
                <div class="inv-party-label"><i class="fa-solid fa-scissors"></i> Prestataire</div>
                <div class="inv-party-name">Marol Hair Braiding</div>
                <div class="inv-party-detail">
                    123 S Michigan Ave<br>
                    Chicago, IL 60603<br>
                    contact@marolhair.com
                </div>
            </div>
            <div>
                <div class="inv-party-label"><i class="fa-solid fa-user"></i> Cliente</div>
                <div class="inv-party-name">{{ $reservation->client->name ?? '—' }}</div>
                <div class="inv-party-detail">
                    {{ $reservation->client->email ?? '—' }}<br>
                    {{ $reservation->client->phone ?? '' }}
                </div>
            </div>
        </div>

        {{-- ITEMS --}}
        <div class="inv-items">
            <div style="overflow-x:auto;">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Prestation</th>
                        <th style="text-align:left;">Date & Heure</th>
                        <th style="text-align:left;">Coiffeuse</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="inv-item-name">
                                {{ $reservation->service->nom ?? $reservation->service->name ?? 'Service' }}
                            </div>
                            @if(!empty($reservation->service->duree))
                            <div class="inv-item-meta">
                                <i class="fa-regular fa-clock"></i>
                                Durée : {{ $reservation->service->duree }} min
                            </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;">
                                {{ \Carbon\Carbon::parse($reservation->date_reservation ?? $reservation->date)->format('d/m/Y') }}
                            </div>
                            <div style="font-size:.8rem;color:var(--muted);">
                                {{ $reservation->heure_reservation ?? $reservation->start_time ?? '—' }}
                            </div>
                        </td>
                        <td>
                            {{ $reservation->employee?->user?->name ?? '—' }}
                        </td>
                        <td>
                            {{ number_format($reservation->service->prix ?? $reservation->amount ?? 0, 2, '.', ',') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        {{-- TOTALS --}}
        <div class="inv-totals">
            @php
                $subtotal = $reservation->service->prix ?? $reservation->amount ?? 0;
                $deposit  = $reservation->payment?->amount ?? 0;
                $remaining= $subtotal - $deposit;
            @endphp
            <div class="inv-total-row">
                <span class="inv-total-label">Sous-total</span>
                <span class="inv-total-val">{{ number_format($subtotal, 2, '.', ',') }}</span>
            </div>
            @if($deposit > 0)
            <div class="inv-total-row">
                <span class="inv-total-label">Acompte versé</span>
                <span class="inv-total-val" style="color:#4ade80;">− {{ number_format($deposit, 2, '.', ',') }}</span>
            </div>
            <div class="inv-total-row">
                <span class="inv-total-label">Reste à payer</span>
                <span class="inv-total-val">{{ number_format($remaining, 2, '.', ',') }}</span>
            </div>
            @endif
            <div class="inv-total-row">
                <span class="inv-total-label">Total</span>
                <span class="inv-total-val">{{ number_format($subtotal, 2, '.', ',') }}</span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="inv-footer">
            <div>
                <p>Merci de votre confiance.<br>
                Pour toute question : <strong style="color:var(--pk);">contact@marolhair.com</strong></p>
            </div>
            <div style="text-align:right;">
                <span class="inv-status">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ $reservation->status == 'confirmed' || $reservation->status == 'confirmee' ? 'Confirmée' : ucfirst($reservation->status ?? 'En cours') }}
                </span>
                <div class="inv-footer-brand" style="margin-top:10px;">Marol Hair Braiding ✦</div>
            </div>
        </div>

    </div>{{-- /invoice --}}

</div>{{-- /invoice-wrap --}}

</body>
</html>

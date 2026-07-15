@extends('layouts.employee')
@section('title', 'Mes revenus')

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
    :root{
        --primary:#d4af37;
        --primary-dark:#b89022;
        --dark:#111827;
        --gray:#6b7280;
        --light:#f9fafb;
        --white:#ffffff;
        --success:#16a34a;
        --border:#e5e7eb;
    }

    /* ================= HEADER ================= */
    .page-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:28px;
        flex-wrap:wrap;
        gap:16px;
    }

    .page-title{
        font-size:32px;
        font-weight:800;
        color:var(--primary);
        margin-bottom:6px;
    }

    .page-subtitle{
        color:var(--gray);
        font-size:15px;
        margin:0;
    }

    /* ================= CARDS ================= */
    .card-pro{
        background:var(--white);
        border-radius:24px;
        border:1px solid var(--border);
        box-shadow:
            0 10px 30px rgba(0,0,0,0.05);
        transition:0.3s ease;
        position:relative;
        overflow:hidden;
        height:100%;
    }

    .card-pro:hover{
        transform:translateY(-5px);
        box-shadow:
            0 18px 40px rgba(0,0,0,0.08);
    }

    .card-pro::before{
        content:'';
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:5px;
        background:linear-gradient(
            90deg,
            var(--primary),
            #f4d76e
        );
    }

    .stat-top{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:18px;
    }

    .stat-label{
        font-size:15px;
        font-weight:700;
        color:#374151;
    }

    .stat-icon{
        width:54px;
        height:54px;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
        color:#fff;
    }

    .gold{
        background:linear-gradient(135deg,#d4af37,#f4d76e);
    }

    .blue{
        background:linear-gradient(135deg,#2563eb,#60a5fa);
    }

    .green{
        background:linear-gradient(135deg,#16a34a,#4ade80);
    }

    .stat-value{
        font-size:34px;
        font-weight:800;
        color:var(--dark);
        line-height:1.1;
        margin-bottom:10px;
    }

    .stat-desc{
        color:var(--gray) !important;
        font-size:14px;
        margin:0;
        line-height:1.6;
    }

    /* ================= TABLE ================= */
    .table-card-title{
        display:flex;
        align-items:center;
        gap:10px;
        font-size:20px;
        font-weight:700;
        color:var(--dark);
        margin-bottom:22px;
    }

    .table{
        margin:0;
    }

    .table thead th{
        background:#f3f4f6;
        color:#374151;
        font-size:14px;
        font-weight:700;
        border:none;
        padding:16px;
    }

    .table tbody td{
        padding:18px 16px;
        border-top:1px solid #f1f5f9;
        color:#111827;
        font-weight:500;
        vertical-align:middle;
    }

    .table tbody tr{
        transition:0.2s ease;
    }

    .table tbody tr:hover{
        background:#fafafa;
    }

    .revenue-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:rgba(22,163,74,0.1);
        color:var(--success);
        padding:8px 14px;
        border-radius:999px;
        font-size:14px;
        font-weight:700;
    }

    .empty-state{
        padding:40px 20px;
        text-align:center;
        color:var(--gray);
        font-size:15px;
    }

    .empty-icon{
        font-size:48px;
        margin-bottom:14px;
        color:#cbd5e1;
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:768px){

        .page-title{
            font-size:26px;
        }

        .stat-value{
            font-size:28px;
        }

    }
</style>

<div class="page-header">

    <div>
        <h1 class="page-title">
            <i class="fa-solid fa-wallet me-2"></i>
            Mes revenus
        </h1>

        <p class="page-subtitle">
            Analysez vos gains et suivez vos performances financières
        </p>
    </div>

</div>

<div class="row g-4">

    {{-- REVENU TOTAL --}}
    <div class="col-lg-4 col-md-6">

        <div class="card-pro p-4">

            <div class="stat-top">

                <div class="stat-label">
                    Revenu total
                </div>

                <div class="stat-icon gold">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>

            </div>

            <div class="stat-value">
                {{ number_format($totalRevenus, 0, ',', ' ') }}
            </div>

            <p class="stat-desc">
                Somme totale générée par vos rendez-vous terminés.
            </p>

        </div>

    </div>

    {{-- RDV --}}
    <div class="col-lg-4 col-md-6">

        <div class="card-pro p-4">

            <div class="stat-top">

                <div class="stat-label">
                    Rendez-vous terminés
                </div>

                <div class="stat-icon blue">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

            </div>

            <div class="stat-value">
                {{ $reservations->count() }}
            </div>

            <p class="stat-desc">
                Nombre total de réservations confirmées et payées.
            </p>

        </div>

    </div>

    {{-- DERNIER MOIS --}}
    <div class="col-lg-4 col-md-12">

        <div class="card-pro p-4">

            <div class="stat-top">

                <div class="stat-label">
                    Dernier mois
                </div>

                <div class="stat-icon green">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

            </div>

            <div class="stat-value">
                {{ number_format($revenusParMois->last() ?? 0, 0, ',', ' ') }}
            </div>

            <p class="stat-desc">
                Montant enregistré pour votre dernier mois d'activité.
            </p>

        </div>

    </div>

</div>

{{-- TABLEAU --}}
<div class="card-pro p-4 mt-4">

    <h5 class="table-card-title">
        <i class="fa-solid fa-chart-column"></i>
        Revenus par mois
    </h5>

    @if($revenusParMois->isEmpty())

        <div class="empty-state">

            <div class="empty-icon">
                <i class="fa-regular fa-folder-open"></i>
            </div>

            <div>
                Aucune donnée de revenu disponible pour le moment.
            </div>

        </div>

    @else

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>
                            <i class="fa-regular fa-calendar me-2"></i>
                            Mois
                        </th>

                        <th>
                            <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                            Revenu généré
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($revenusParMois as $mois => $revenu)

                        <tr>

                            <td>
                                <i class="fa-regular fa-calendar-days me-2 text-secondary"></i>

                                {{ \Carbon\Carbon::parse($mois . '-01')->locale(app()->getLocale())->isoFormat('MMMM YYYY') }}
                            </td>

                            <td>

                                <span class="revenue-badge">

                                    <i class="fa-solid fa-coins"></i>

                                    {{ number_format($revenu, 0, ',', ' ') }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>

@endsection

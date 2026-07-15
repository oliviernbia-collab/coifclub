@extends('layouts.client')

@section('title', 'Mes demandes d\'annulation')

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
    --light:#f8fafc;
    --card:#ffffff;
    --success:#10b981;
    --danger:#ef4444;
    --warning:#f59e0b;
    --border:#e5e7eb;
}

body{
    background:linear-gradient(to bottom,#0f172a,#111827);
    min-height:100vh;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:30px;
}

.page-title{
    font-size:2rem;
    font-weight:800;
    color:#fff;
    margin:0;
}

.page-subtitle{
    color:#cbd5e1;
    font-size:.95rem;
    margin-top:6px;
}

/* MAIN CARD */
.main-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    background:rgba(255,255,255,0.97);
    box-shadow:
        0 15px 35px rgba(0,0,0,0.12),
        0 4px 10px rgba(0,0,0,0.04);
}

.card-top{
    height:6px;
    background:linear-gradient(90deg,var(--primary),#f7d774);
}

/* EMPTY */
.empty-box{
    text-align:center;
    padding:70px 20px;
}

.empty-icon{
    width:90px;
    height:90px;
    border-radius:50%;
    background:rgba(212,175,55,0.12);
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    font-size:2rem;
    margin-bottom:20px;
}

.empty-title{
    font-size:1.3rem;
    font-weight:800;
    color:var(--dark);
}

.empty-text{
    color:var(--gray);
    max-width:450px;
    margin:auto;
}

/* TABLE */
.table{
    margin:0;
}

.table thead{
    background:#f8fafc;
}

.table thead th{
    border:none;
    padding:18px 20px;
    font-size:.85rem;
    font-weight:800;
    color:#374151 !important;
    background:#f8fafc !important;
    text-transform:uppercase;
    letter-spacing:.4px;
    white-space:nowrap;
}

.table tbody td{
    border-top:1px solid #f1f5f9;
    padding:22px 20px;
    vertical-align:middle;
}

.table tbody tr{
    transition:.2s ease;
}

.table tbody tr:hover{
    background:#fafafa;
}

/* SERVICE */
.service-box{
    display:flex;
    align-items:center;
    gap:14px;
}

.service-icon{
    width:50px;
    height:50px;
    border-radius:16px;
    background:rgba(212,175,55,0.12);
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.1rem;
}

.service-name{
    font-weight:800;
    color:var(--dark);
    margin-bottom:3px;
}

.service-ref{
    font-size:.82rem;
    color:var(--gray);
}

/* DATE */
.date-box{
    display:flex;
    align-items:center;
    gap:10px;
    color:var(--gray);
    font-weight:600;
}

.date-box i{
    color:var(--primary-dark);
}

/* AMOUNT */
.amount{
    font-size:1rem;
    font-weight:900;
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    gap:8px;
}

/* BADGE */
.badge-status{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:800;
}

.badge-approved{
    background:#ecfdf5;
    color:#047857;
}

.badge-rejected{
    background:#fef2f2;
    color:#b91c1c;
}

.badge-pending{
    background:#fffbeb;
    color:#b45309;
}

/* MOBILE */
@media(max-width:768px){

    .page-title{
        font-size:1.6rem;
    }

    .table thead{
        display:none;
    }

    .table,
    .table tbody,
    .table tr,
    .table td{
        display:block;
        width:100%;
    }

    .table tr{
        border-bottom:1px solid #eef2f7;
        padding:10px 0;
    }

    .table td{
        border:none;
        padding:12px 18px;
    }

}

</style>

<div class="container py-5">

    {{-- HEADER --}}
    <div class="page-header">

        <div>

            <h1 class="page-title">
                <i class="fa-solid fa-ban me-2"></i>
                Mes demandes d'annulation
            </h1>

            <div class="page-subtitle">
                Consultez le statut de vos demandes et vos remboursements.
            </div>

        </div>

    </div>

    {{-- CARD --}}
    <div class="main-card">

        <div class="card-top"></div>

        <div class="card-body p-0">

            {{-- EMPTY --}}
            @if($cancellations->isEmpty())

                <div class="empty-box">

                    <div class="empty-icon">
                        <i class="fa-regular fa-calendar-xmark"></i>
                    </div>

                    <div class="empty-title mb-2">
                        Aucune demande trouvée
                    </div>

                    <div class="empty-text">
                        Vous n'avez encore effectué aucune demande d'annulation.
                    </div>

                </div>

            @else

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>

                                <th>
                                    <i class="fa-solid fa-scissors me-2"></i>
                                    Réservation
                                </th>

                                <th>
                                    <i class="fa-regular fa-calendar me-2"></i>
                                    Date
                                </th>

                                <th>
                                    <i class="fa-solid fa-wallet me-2"></i>
                                    Remboursement
                                </th>

                                <th>
                                    <i class="fa-solid fa-circle-info me-2"></i>
                                    Statut
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach($cancellations as $cancellation)

                                @php
                                    $status = $cancellation->status;
                                @endphp

                                <tr>

                                    {{-- SERVICE --}}
                                    <td>

                                        <div class="service-box">

                                            <div class="service-icon">
                                                <i class="fa-solid fa-scissors"></i>
                                            </div>

                                            <div>

                                                <div class="service-name">
                                                    {{ $cancellation->reservation->service->name ?? 'Service indisponible' }}
                                                </div>

                                                <div class="service-ref">
                                                    Réf :
                                                    {{ $cancellation->reservation->reference ?? '—' }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- DATE --}}
                                    <td>

                                        <div class="date-box">
                                            <i class="fa-regular fa-calendar"></i>

                                            {{ \Carbon\Carbon::parse($cancellation->reservation->date)->format('d/m/Y') }}
                                        </div>

                                    </td>

                                    {{-- AMOUNT --}}
                                    <td>

                                        <div class="amount">
                                            <i class="fa-solid fa-coins"></i>

                                            {{ number_format($cancellation->refund_amount, 0, ',', ' ') }}
                                        </div>

                                    </td>

                                    {{-- STATUS --}}
                                    <td>

                                        <span class="badge-status
                                            @if($status === 'approved') badge-approved
                                            @elseif($status === 'rejected') badge-rejected
                                            @else badge-pending
                                            @endif">

                                            @if($status === 'approved')

                                                <i class="fa-solid fa-circle-check"></i>

                                            @elseif($status === 'rejected')

                                                <i class="fa-solid fa-circle-xmark"></i>

                                            @else

                                                <i class="fa-solid fa-hourglass-half"></i>

                                            @endif

                                            {{ ucfirst($status) }}

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
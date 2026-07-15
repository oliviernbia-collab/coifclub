@extends('layouts.prestataire')

@section('title', 'Dashboard Prestataire')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background: #0b0f19;
    color: #e5e7eb;
}

/* HEADER */
.dashboard-header{
    background: linear-gradient(135deg, #111827, #1f2937);
    border-radius: 24px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.35);
}

/* CARD */
.card-pro{
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 22px;
    backdrop-filter: blur(18px);
    transition: .3s ease;
}

.card-pro:hover{
    transform: translateY(-5px);
}

/* STATS */
.stat-card{
    position: relative;
    padding: 25px;
    border-radius: 22px;
    overflow: hidden;
    color: white;
    transition: .3s;
}

.stat-card:hover{
    transform: translateY(-5px);
}

.stat-card i{
    position: absolute;
    right: 18px;
    bottom: 10px;
    font-size: 55px;
    opacity: 0.15;
}

.bg1{ background: linear-gradient(135deg,#16a34a,#15803d); }
.bg2{ background: linear-gradient(135deg,#2563eb,#1d4ed8); }
.bg3{ background: linear-gradient(135deg,#f59e0b,#d97706); }
.bg4{ background: linear-gradient(135deg,#111827,#374151); }

/* QUICK ACTION */
.quick-action{
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 18px;
    padding: 18px;
    text-align: center;
    transition: .3s;
    cursor: pointer;
}

.quick-action:hover{
    background: #111827;
    transform: translateY(-4px);
}

/* PLANNING */
.plan-item{
    padding: 15px;
    border-radius: 16px;
    background: rgba(255,255,255,0.03);
    margin-bottom: 12px;
    transition: .3s;
}

.plan-item:hover{
    background: rgba(255,255,255,0.06);
    transform: translateX(5px);
}

.icon-box{
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: rgba(37,99,235,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#60a5fa;
}

.badge-ok{ color:#10b981; font-weight:600; }
.badge-wait{ color:#f59e0b; font-weight:600; }

</style>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="dashboard-header">

        <h2 class="fw-bold">
            <i class="fa-solid fa-gauge-high me-2"></i>
            Bonjour,{{ auth()->user()->name }} 
        </h2>

        <p class="opacity-75 mb-0">
            Voici un résumé de votre activité aujourd'hui
        </p>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="stat-card bg1">
                <h6>Aujourd'hui</h6>
                <h2>{{ $stats['today'] ?? 0 }}</h2>
                <small>Réservations</small>
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg2">
                <h6>Semaine</h6>
                <h2>{{ $stats['this_week'] ?? 0 }}</h2>
                <small>Réservations</small>
                <i class="fa-solid fa-calendar-week"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg3">
                <h6>Clients</h6>
                <h2>{{ $stats['clients'] ?? 0 }}</h2>
                <small>Total clients</small>
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg4">
                <h6>Revenus</h6>
                <h2>{{ $stats['revenue'] ?? 0 }}</h2>
                <small>Estimé</small>
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

    </div>

    <div class="row g-4">

        {{-- PLANNING --}}
        <div class="col-lg-8">

            <div class="card-pro p-4">

                <h5 class="mb-3">
                    <i class="fa-solid fa-calendar-days text-primary me-2"></i>
                    Planning
                </h5>

                <div class="plan-item">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <div class="icon-box">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <div>
                                <strong>Coupe homme</strong><br>
                                <small>Lundi 10h</small>
                            </div>
                        </div>
                        <span class="badge-ok">Confirmé</span>
                    </div>
                </div>

                <div class="plan-item">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <div class="icon-box">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <div>
                                <strong>Coloration</strong><br>
                                <small>Mardi 14h</small>
                            </div>
                        </div>
                        <span class="badge-wait">En attente</span>
                    </div>
                </div>

            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="col-lg-4">

            <div class="card-pro p-4">

                <h5 class="mb-3">
                    Actions rapides
                </h5>

                <div class="row g-2">

                    <div class="col-6">
                        <div class="quick-action">
                            <i class="fa-solid fa-plus text-primary"></i>
                            <p class="mb-0">Ajouter</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="quick-action">
                            <i class="fa-solid fa-scissors text-primary"></i>
                            <p class="mb-0">Services</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
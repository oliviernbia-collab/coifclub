@extends('layouts.prestataire')

@section('title', 'Mes Revenus')

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    .dashboard-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        border-radius: 22px;
        padding: 35px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .card-pro {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .stat-card {
        border-radius: 20px;
        padding: 25px;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .stat-card i {
        position: absolute;
        right: 20px;
        bottom: 15px;
        font-size: 45px;
        opacity: 0.15;
    }

    .bg-success-soft {
        background: linear-gradient(135deg, #16a34a, #15803d);
    }

    .bg-primary-soft {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    .bg-warning-soft {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .revenue-box {
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #f1f5f9;
        transition: 0.3s;
    }

    .revenue-box:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .revenue-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        font-size: 22px;
    }

    .chart-container {
        position: relative;
        height: 420px;
    }

    .table-custom th {
        border: none;
        color: #64748b;
        font-weight: 600;
    }

    .table-custom td {
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .badge-success-soft {
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
        padding: 8px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

</style>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="dashboard-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h2 class="fw-bold mb-2">
                    <i class="fa-solid fa-wallet me-2"></i>
                    Tableau des Revenus
                </h2>

                <p class="mb-0 text-light opacity-75">
                    Analyse complète de vos gains et performances
                </p>

            </div>

            <button class="btn btn-light rounded-pill px-4 mt-3 mt-md-0">
                <i class="fa-solid fa-file-export me-2"></i>
                Exporter
            </button>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-4">

        {{-- TOTAL --}}
        <div class="col-lg-4 col-md-6">

            <div class="stat-card bg-success-soft">

                <h6 class="mb-2">Revenu total</h6>

                <h2 class="fw-bold">
                    {{ number_format($totalRevenue, 0, ',', ' ') }}
                </h2>

                <small>
                    Revenus cumulés
                </small>

                <i class="fa-solid fa-sack-dollar"></i>

            </div>

        </div>

        {{-- MOIS --}}
        <div class="col-lg-4 col-md-6">

            <div class="stat-card bg-primary-soft">

                <h6 class="mb-2">Ce mois</h6>

                <h2 class="fw-bold">
                    {{ number_format(collect($data)->last(), 0, ',', ' ') }}
                </h2>

                <small>
                    Revenus mensuels
                </small>

                <i class="fa-solid fa-chart-line"></i>

            </div>

        </div>

        {{-- CROISSANCE --}}
        <div class="col-lg-4 col-md-12">

            <div class="stat-card bg-warning-soft">

                <h6 class="mb-2">Performance</h6>

                <h2 class="fw-bold">
                    +24%
                </h2>

                <small>
                    Croissance estimée
                </small>

                <i class="fa-solid fa-arrow-trend-up"></i>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="row g-4">

        {{-- CHART --}}
        <div class="col-lg-8">

            <div class="card-pro p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">
                            <i class="fa-solid fa-chart-column me-2 text-primary"></i>
                            Revenus mensuels
                        </h5>

                        <small class="text-muted">
                            Évolution de vos revenus
                        </small>

                    </div>

                    <button class="btn btn-dark rounded-pill">
                        <i class="fa-solid fa-filter me-2"></i>
                        Filtrer
                    </button>

                </div>

                <div class="chart-container">
                    <canvas id="revenuChart"></canvas>
                </div>

            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            <div class="card-pro p-4 mb-4">

                <h5 class="fw-bold mb-4">
                    <i class="fa-solid fa-coins me-2 text-warning"></i>
                    Résumé financier
                </h5>

                <div class="revenue-box mb-3">

                    <div class="d-flex align-items-center">

                        <div class="revenue-icon me-3">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Gains aujourd'hui
                            </small>

                            <strong>45 000</strong>
                        </div>

                    </div>

                </div>

                <div class="revenue-box mb-3">

                    <div class="d-flex align-items-center">

                        <div class="revenue-icon me-3">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Paiements reçus
                            </small>

                            <strong>128 transactions</strong>
                        </div>

                    </div>

                </div>

                <div class="revenue-box">

                    <div class="d-flex align-items-center">

                        <div class="revenue-icon me-3">
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Satisfaction client
                            </small>

                            <strong>4.9 / 5</strong>
                        </div>

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="card-pro p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-receipt me-2 text-success"></i>
                        Derniers revenus
                    </h5>

                    <span class="badge-success-soft">
                        Récent
                    </span>

                </div>

                <div class="table-responsive">

                    <table class="table table-custom">

                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Montant</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($labels as $index => $label)

                                <tr>

                                    <td>
                                        {{ $label }}
                                    </td>

                                    <td class="fw-bold text-success">
                                        {{ number_format($data[$index], 0, ',', ' ') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('revenuChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: @json($labels),

        datasets: [{

            label: 'Revenus',

            data: @json($data),

            borderRadius: 10,

            borderSkipped: false,

            backgroundColor: [
                '#2563eb',
                '#16a34a',
                '#f59e0b',
                '#7c3aed',
                '#dc2626',
                '#0891b2'
            ]

        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            }

        },

        scales: {

            y: {

                beginAtZero: true,

                grid: {
                    color: '#f1f5f9'
                }

            },

            x: {

                grid: {
                    display: false
                }

            }

        }

    }

});

</script>

@endsection
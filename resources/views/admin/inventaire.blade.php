@extends('layouts.admin')

@section('title', __('messages.inv_title'))
@section('page-title', __('messages.inv_subtitle'))
@section('page-subtitle', __('messages.inv_hero_desc'))

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    body{
        background: #0e0a1c;
    }

    /* ====================================
        MAIN CARD
    ==================================== */

    .inventory-card{
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 30px;
        overflow: hidden;
        background: rgba(255,255,255,.05);
        box-shadow: 0 14px 40px rgba(0,0,0,.25);
    }

    /* ====================================
        HEADER
    ==================================== */

    .inventory-header{
        padding: 36px;
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .inventory-header::before{
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -120px;
        right: -90px;
    }

    .inventory-header::after{
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        bottom: -90px;
        left: -60px;
    }

    .inventory-title{
        font-size: 30px;
        font-weight: 900;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }

    .inventory-subtitle{
        color: rgba(255,255,255,0.82);
        font-size: 15px;
        line-height: 1.7;
        max-width: 700px;
        position: relative;
        z-index: 2;
    }

    .inventory-badge{
        margin-top: 22px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        font-weight: 700;
        font-size: 14px;
        position: relative;
        z-index: 2;
    }

    /* ====================================
        STATS
    ==================================== */

    .stats-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
        gap: 22px;
        padding: 30px;
        background: rgba(255,255,255,.03);
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .stat-card{
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 22px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,.15);
    }

    .stat-card::before{
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(212,175,55,.06);
        right: -40px;
        top: -40px;
    }

    .stat-top{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .stat-icon{
        width: 62px;
        height: 62px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .icon-blue{
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
    }

    .icon-green{
        background: linear-gradient(135deg,#10b981,#059669);
    }

    .icon-orange{
        background: linear-gradient(135deg,#f59e0b,#ea580c);
    }

    .stat-number{
        font-size: 30px;
        font-weight: 900;
        color: rgba(255,255,255,.9);
        line-height: 1;
    }

    .stat-label{
        color: rgba(255,255,255,.45);
        font-size: 14px;
        font-weight: 600;
    }

    /* ====================================
        TABLE
    ==================================== */

    .table-wrapper{
        padding: 30px;
    }

    .inventory-table{
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 18px;
    }

    .inventory-table{ --bs-table-color:rgba(255,255,255,.8); --bs-table-bg:transparent; }

    .inventory-table thead th{
        border: none;
        background: transparent;
        color: rgba(255,255,255,.45);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        padding: 0 18px 12px;
    }

    .inventory-table tbody tr{
        background: rgba(255,255,255,.04);
        transition: .25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    .inventory-table tbody tr:hover{
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,.2);
        background: rgba(255,255,255,.07);
    }

    .inventory-table tbody td{
        padding: 24px 18px;
        vertical-align: middle;
        border-top: none;
        border-bottom: none;
        color: rgba(255,255,255,.8);
    }

    .inventory-table{ --bs-table-color:rgba(255,255,255,.8); --bs-table-bg:transparent; }

    .inventory-table tbody td:first-child{
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .inventory-table tbody td:last-child{
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    /* ====================================
        SERVICE INFO
    ==================================== */

    .service-info{
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .service-icon{
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow:
            0 10px 20px rgba(37,99,235,0.18);
    }

    .service-name{
        font-size: 17px;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        margin-bottom: 4px;
    }

    .service-desc{
        color: rgba(255,255,255,.4);
        font-size: 13px;
        font-weight: 600;
    }

    /* ====================================
        BADGES
    ==================================== */

    .info-badge{
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
    }

    .badge-category{
        background: rgba(59,130,246,.15);
        color: #93c5fd;
        border: 1px solid rgba(147,197,253,.2);
    }

    .badge-price{
        background: rgba(16,185,129,.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,.2);
    }

    .badge-duration{
        background: rgba(234,88,12,.15);
        color: #fb923c;
        border: 1px solid rgba(251,146,60,.2);
    }

    .badge-active{
        background: rgba(16,185,129,.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,.2);
    }

    .badge-disabled{
        background: rgba(239,68,68,.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,.2);
    }

    /* ====================================
        ACTION BUTTONS
    ==================================== */

    .action-group{
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .action-btn{
        border: none;
        border-radius: 14px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 700;
        transition: .25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-edit{
        background: rgba(212,175,55,.15);
        color: #D4AF37;
        border: 1px solid rgba(212,175,55,.25);
    }

    .btn-edit:hover{
        background: rgba(212,175,55,.25);
        transform: translateY(-2px);
        color: #f4d06f;
    }

    .btn-view{
        background: #111827;
        color: white;
    }

    .btn-view:hover{
        background: #000;
        color: white;
        transform: translateY(-2px);
    }

    /* ====================================
        EMPTY STATE
    ==================================== */

    .empty-state{
        padding: 90px 20px;
        text-align: center;
    }

    .empty-icon{
        width: 120px;
        height: 120px;
        margin: auto;
        border-radius: 30px;
        background: linear-gradient(135deg,#e2e8f0,#cbd5e1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #475569;
        margin-bottom: 28px;
    }

    .empty-title{
        font-size: 28px;
        font-weight: 900;
        color: rgba(255,255,255,.9);
        margin-bottom: 10px;
    }

    .empty-text{
        color: rgba(255,255,255,.4);
        font-size: 15px;
    }

    /* ====================================
        RESPONSIVE
    ==================================== */

    @media(max-width: 768px){

        .inventory-header{
            padding: 26px;
        }

        .table-wrapper{
            padding: 18px;
        }

        .inventory-title{
            font-size: 25px;
        }

        .action-group{
            justify-content: center;
        }

        .action-btn{
            width: 100%;
            justify-content: center;
        }

    }

</style>

<div class="card inventory-card">

    {{-- HEADER --}}
    <div class="inventory-header">

        <div class="inventory-title">
            <i class="fa-solid fa-box-open me-2"></i>
            {{ __('messages.inv_subtitle') }}
        </div>

        <div class="inventory-subtitle">
            {{ __('messages.inv_hero_desc') }}
        </div>

        <div class="inventory-badge">
            <i class="fa-solid fa-chart-line"></i>
            {{ __('messages.inv_badge') }}
        </div>

    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-scissors"></i>
                </div>

                <div class="stat-number">
                    {{ $services->count() }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.inv_stat_total') }}
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="stat-number">
                    {{ $services->where('is_active', true)->count() }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.inv_stat_active') }}
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-orange">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="stat-number">
                    {{ $services->avg('duration') ?? 0 }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.inv_stat_duration') }}
            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">

        @if($services->count())

            <div class="table-responsive">

                <table class="table inventory-table align-middle">

                    <thead>

                        <tr>

                            <th>
                                <i class="fa-solid fa-briefcase me-1"></i>
                                {{ __('messages.inv_col_service') }}
                            </th>

                            <th>
                                <i class="fa-solid fa-layer-group me-1"></i>
                                {{ __('messages.inv_col_category') }}
                            </th>

                            <th>
                                <i class="fa-solid fa-money-bill-wave me-1"></i>
                                {{ __('messages.inv_col_price') }}
                            </th>

                            <th>
                                <i class="fa-solid fa-clock me-1"></i>
                                {{ __('messages.inv_col_duration') }}
                            </th>

                            <th>
                                <i class="fa-solid fa-signal me-1"></i>
                                {{ __('messages.inv_col_status') }}
                            </th>

                            <th class="text-end">
                                <i class="fa-solid fa-gear me-1"></i>
                                {{ __('messages.inv_col_actions') }}
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($services as $service)

                            <tr>

                                {{-- SERVICE --}}
                                <td style="min-width:280px;">

                                    <div class="service-info">

                                        <div class="service-icon">
                                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                                        </div>

                                        <div>

                                            <div class="service-name">
                                                {{ $service->name }}
                                            </div>

                                            <div class="service-desc">
                                                {{ __('messages.inv_premium_badge') }}
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- CATEGORY --}}
                                <td>

                                    <div class="info-badge badge-category">

                                        <i class="fa-solid fa-layer-group"></i>

                                        {{ $service->category }}

                                    </div>

                                </td>

                                {{-- PRICE --}}
                                <td>

                                    <div class="info-badge badge-price">

                                        <i class="fa-solid fa-coins"></i>

                                        {{ number_format($service->price ?? $service->prix ?? 0, 0, ',', ' ') }}

                                    </div>

                                </td>

                                {{-- DURATION --}}
                                <td>

                                    <div class="info-badge badge-duration">

                                        <i class="fa-solid fa-stopwatch"></i>

                                        {{ $service->duration ?? $service->duree }} min

                                    </div>

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if($service->is_active)

                                        <div class="info-badge badge-active">

                                            <i class="fa-solid fa-circle-check"></i>

                                            {{ __('messages.inv_status_active') }}

                                        </div>

                                    @else

                                        <div class="info-badge badge-disabled">

                                            <i class="fa-solid fa-circle-xmark"></i>

                                            {{ __('messages.inv_status_disabled') }}

                                        </div>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-end">

                                    <div class="action-group">

                                        <a href="{{ route('admin.services.show', $service) }}"
                                           class="action-btn btn-view">

                                            <i class="fa-solid fa-eye"></i>
                                            {{ __('messages.inv_btn_view') }}

                                        </a>

                                        <a href="{{ route('admin.services.edit', $service) }}"
                                           class="action-btn btn-edit">

                                            <i class="fa-solid fa-pen-to-square"></i>
                                            {{ __('messages.inv_btn_edit') }}

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>

                                        <div class="empty-title">
                                            {{ __('messages.inv_empty_title') }}
                                        </div>

                                        <div class="empty-text">
                                            {{ __('messages.inv_empty_text') }}
                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <div class="empty-title">
                    Aucun service trouvé
                </div>

                <div class="empty-text">
                    Aucun service n'est actuellement enregistré dans l'inventaire.
                </div>

            </div>

        @endif

    </div>

</div>

@endsection
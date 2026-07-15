@extends('layouts.admin')

@section('title', __('messages.adm_clients_title'))

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    body{ background: #0e0a1c; }

    /* ===================================
        PAGE HEADER
    ==================================== */

    .page-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .page-title{
        font-size: 34px;
        font-weight: 900;
        color: #D4AF37;
        margin-bottom: 8px;
    }

    .page-subtitle{
        color: rgba(255,255,255,.5);
        font-size: 15px;
        margin-bottom: 0;
    }

    .dashboard-btn{
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 14px 22px;
        font-weight: 700;
        background: rgba(255,255,255,.07);
        color: rgba(255,255,255,.85);
        transition: .25s ease;
    }

    .dashboard-btn:hover{
        transform: translateY(-2px);
        color: white;
        background: rgba(255,255,255,.12);
    }

    /* ===================================
        STATS
    ==================================== */

    .stats-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card{
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 24px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0,0,0,.2);
        transition: .3s ease;
    }

    .stat-card:hover{ transform: translateY(-4px); border-color: rgba(212,175,55,.25); }

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
        margin-bottom: 18px;
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

    .icon-blue  { background: linear-gradient(135deg,#2563eb,#1d4ed8); }
    .icon-green { background: linear-gradient(135deg,#10b981,#059669); }
    .icon-orange{ background: linear-gradient(135deg,#f59e0b,#ea580c); }

    .stat-value{
        font-size: 30px;
        font-weight: 900;
        color: rgba(255,255,255,.9);
        line-height: 1;
    }

    .stat-label{
        color: rgba(255,255,255,.45);
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
    }

    /* ===================================
        MAIN CARD
    ==================================== */

    .clients-card{
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 28px;
        overflow: hidden;
        background: rgba(255,255,255,.05);
        box-shadow: 0 14px 40px rgba(0,0,0,.25);
    }

    .clients-header{
        padding: 28px 32px;
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .clients-header::before{
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
        right: -90px;
        top: -90px;
    }

    .clients-header-title{
        font-size: 24px;
        font-weight: 800;
        position: relative;
        z-index: 2;
    }

    .clients-header-subtitle{
        color: rgba(255,255,255,.7);
        margin-top: 8px;
        position: relative;
        z-index: 2;
    }

    /* ===================================
        TABLE
    ==================================== */

    .table-wrapper{ padding: 28px; }

    .clients-table{
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 14px;
        --bs-table-color: rgba(255,255,255,.8);
        --bs-table-bg: transparent;
    }

    .clients-table thead th{
        border: none;
        background: transparent;
        color: rgba(255,255,255,.45);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        padding: 0 16px 12px;
    }

    .clients-table tbody tr{
        background: rgba(255,255,255,.04);
        transition: .25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    .clients-table tbody tr:hover{
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0,0,0,.2);
        background: rgba(255,255,255,.07);
    }

    .clients-table tbody td{
        padding: 22px 16px;
        vertical-align: middle;
        border-top: none;
        border-bottom: none;
        color: rgba(255,255,255,.8);
    }

    .clients-table tbody td:first-child{
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .clients-table tbody td:last-child{
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    /* ===================================
        CLIENT INFO
    ==================================== */

    .client-info{
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .client-avatar{
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(135deg,#D4AF37,#B8860B);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 10px 20px rgba(212,175,55,.2);
    }

    .client-name{
        font-size: 16px;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        margin-bottom: 4px;
    }

    .client-role{
        color: rgba(255,255,255,.4);
        font-size: 13px;
        font-weight: 600;
    }

    /* ===================================
        INFO BADGES
    ==================================== */

    .info-badge{
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
    }

    .badge-email  { background: rgba(59,130,246,.15);  color: #93c5fd; border: 1px solid rgba(147,197,253,.2); }
    .badge-phone  { background: rgba(255,255,255,.06); color: rgba(255,255,255,.7); border: 1px solid rgba(255,255,255,.1); }
    .badge-booking{ background: rgba(16,185,129,.15);  color: #4ade80; border: 1px solid rgba(74,222,128,.2); }
    .badge-date   { background: rgba(234,88,12,.15);   color: #fb923c; border: 1px solid rgba(251,146,60,.2); }

    /* ===================================
        ACTIONS
    ==================================== */

    .action-group{
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .action-btn{
        border: none;
        border-radius: 14px;
        padding: 11px 16px;
        font-size: 13px;
        font-weight: 700;
        transition: .25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit  { background: rgba(212,175,55,.15); color: #D4AF37; border: 1px solid rgba(212,175,55,.25); }
    .btn-edit:hover { background: rgba(212,175,55,.25); color: #f4d06f; transform: translateY(-2px); }
    .btn-delete{ background: rgba(239,68,68,.15);  color: #f87171; border: 1px solid rgba(248,113,113,.2); }
    .btn-delete:hover{ background: rgba(239,68,68,.25); transform: translateY(-2px); }
    .btn-print { background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.12); }
    .btn-print:hover{ background: rgba(255,255,255,.14); color: white; transform: translateY(-2px); }
    .btn-points{ background: rgba(139,92,246,.15); color: #a78bfa; border: 1px solid rgba(167,139,250,.2); }
    .btn-points:hover{ background: rgba(139,92,246,.3); color: #c4b5fd; transform: translateY(-2px); }

    .pts-modal-input{
        width:100%;
        background:rgba(255,255,255,.05);
        border:1px solid rgba(167,139,250,.25);
        border-radius:12px;
        padding:12px 16px;
        color:#fff;
        font-size:14px;
        outline:none;
        transition:.2s;
    }
    .pts-modal-input:focus{ border-color:#a78bfa; box-shadow:0 0 0 3px rgba(167,139,250,.15); }
    .pts-modal-label{ color:#cbd5e1; font-size:13px; font-weight:600; display:block; margin-bottom:8px; }

    /* ===================================
        EMPTY STATE
    ==================================== */

    .empty-state{
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon{
        width: 120px;
        height: 120px;
        margin: 0 auto 26px;
        border-radius: 30px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.09);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: rgba(255,255,255,.3);
    }

    .empty-title{
        font-size: 28px;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        margin-bottom: 10px;
    }

    .empty-text{ color: rgba(255,255,255,.4); font-size: 15px; }

    /* ===================================
        PAGINATION
    ==================================== */

    .pagination-wrapper{
        margin-top: 28px;
        display: flex;
        justify-content: center;
    }

    /* ===================================
        RESPONSIVE
    ==================================== */

    @media(max-width: 768px){

        .table-wrapper{
            padding: 18px;
        }

        .clients-header{
            padding: 24px;
        }

        .page-title{
            font-size: 28px;
        }

        .action-group{
            flex-direction: column;
        }

        .action-btn{
            justify-content: center;
            width: 100%;
        }

    }

</style>

<div class="container-fluid py-4">

    @if(session('success'))
        <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);color:#4ade80;padding:14px 20px;border-radius:14px;margin-bottom:22px;font-weight:600;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#f87171;padding:14px 20px;border-radius:14px;margin-bottom:22px;font-weight:600;">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">

        <div>

            <div class="page-title">
                <i class="fa-solid fa-users-viewfinder me-2 text-primary"></i>
                {{ __('messages.adm_clients_title') }}
            </div>

            <p class="page-subtitle">
                {{ __('messages.adm_clients_page_subtitle') }}
            </p>

        </div>

        <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">
            <i class="fa-solid fa-arrow-left-long me-2"></i>
            {{ __('messages.adm_return_dashboard') }}
        </a>

    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div class="stat-value">
                    {{ $clients->total() }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.adm_total_clients_label') }}
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <div class="stat-value">
                    {{ $clients->sum('reservations_as_client_count') }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.adm_bookings_made') }}
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon icon-orange">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <div class="stat-value">
                    {{ $clients->count() }}
                </div>

            </div>

            <div class="stat-label">
                {{ __('messages.adm_visible_clients') }}
            </div>

        </div>

    </div>

    {{-- MAIN CARD --}}
    <div class="card clients-card">

        {{-- CARD HEADER --}}
        <div class="clients-header">

            <div class="clients-header-title">
                <i class="fa-solid fa-user-group me-2"></i>
                {{ __('messages.adm_registered_clients') }}
            </div>

            <div class="clients-header-subtitle">
                {{ __('messages.adm_registered_clients_sub') }}
            </div>

        </div>

        {{-- CARD BODY --}}
        <div class="table-wrapper">

            @if($clients->count())

                <div class="table-responsive">

                    <table class="table clients-table align-middle">

                        <thead>
                            <tr>

                                <th>
                                    <i class="fa-solid fa-hashtag me-1"></i>
                                    ID
                                </th>

                                <th>
                                    <i class="fa-solid fa-user me-1"></i>
                                    {{ __('messages.adm_col_client') }}
                                </th>

                                <th>
                                    <i class="fa-solid fa-envelope me-1"></i>
                                    {{ __('messages.email') }}
                                </th>

                                <th>
                                    <i class="fa-solid fa-phone me-1"></i>
                                    {{ __('messages.adm_col_phone') }}
                                </th>

                                <th>
                                    <i class="fa-solid fa-calendar-days me-1"></i>
                                    {{ __('messages.adm_col_reservations') }}
                                </th>

                                <th>
                                    <i class="fa-solid fa-clock me-1"></i>
                                    {{ __('messages.adm_col_inscription') }}
                                </th>

                                <th class="text-center">
                                    <i class="fa-solid fa-gear me-1"></i>
                                    {{ __('messages.adm_col_actions') }}
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach($clients as $client)

                                <tr>

                                    {{-- ID --}}
                                    <td class="fw-bold text-muted">
                                        #{{ $client->id }}
                                    </td>

                                    {{-- CLIENT --}}
                                    <td style="min-width:260px;">

                                        <div class="client-info">

                                            <div class="client-avatar">
                                                {{ strtoupper(substr($client->name,0,1)) }}
                                            </div>

                                            <div>

                                                <div class="client-name">
                                                    {{ $client->name }}
                                                </div>

                                                <div class="client-role">
                                                    <i class="fa-solid fa-crown me-1"></i>
                                                    {{ __('messages.adm_premium_client_label') }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- EMAIL --}}
                                    <td>

                                        <div class="info-badge badge-email">

                                            <i class="fa-solid fa-envelope-circle-check"></i>

                                            {{ $client->email ?? __('messages.adm_not_provided') }}

                                        </div>

                                    </td>

                                    {{-- PHONE --}}
                                    <td>

                                        <div class="info-badge badge-phone">

                                            <i class="fa-solid fa-phone-volume"></i>

                                            {{ $client->phone ?? __('messages.adm_not_provided') }}

                                        </div>

                                    </td>

                                    {{-- BOOKINGS --}}
                                    <td>

                                        <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-start;">

                                            <div class="info-badge badge-booking">
                                                <i class="fa-solid fa-calendar-check"></i>
                                                {{ $client->reservations_as_client_count ?? 0 }}
                                            </div>

                                            <button
                                                type="button"
                                                class="action-btn btn-points"
                                                onclick="openPointsModal({{ $client->id }}, '{{ addslashes($client->name) }}')"
                                            >
                                                <i class="fa-solid fa-coins"></i>
                                                Points
                                            </button>

                                        </div>

                                    </td>

                                    {{-- DATE --}}
                                    <td>

                                        <div class="info-badge badge-date">

                                            <i class="fa-solid fa-clock"></i>

                                            {{ $client->created_at->format('d/m/Y') }}

                                        </div>

                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-center">

                                        <div class="action-group">

                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('admin.clients.edit', $client->id) }}"
                                                class="action-btn btn-edit"
                                                data-edit-url="{{ route('admin.clients.edit', $client->id) }}"
                                                data-edit-title="{{ __('messages.adm_edit_client_title') }}"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                {{ __('messages.adm_btn_modify') }}
                                            </a>

                                            {{-- DELETE --}}
                                            <form
                                                action="{{ route('admin.clients.destroy', $client->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('{{ __('messages.adm_delete_client_confirm') }}')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn btn-delete"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                    {{ __('messages.btn_delete') }}
                                                </button>

                                            </form>

                                            {{-- PRINT --}}
                                            <a
                                                href="{{ route('admin.clients.print', $client->id) }}"
                                                target="_blank"
                                                class="action-btn btn-print"
                                            >
                                                <i class="fa-solid fa-print"></i>
                                                {{ __('messages.adm_btn_print') }}
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- EMPTY STATE --}}
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa-solid fa-users-slash"></i>
                    </div>

                    <div class="empty-title">
                        {{ __('messages.adm_no_clients') }}
                    </div>

                    <div class="empty-text">
                        {{ __('messages.adm_no_clients_platform') }}
                    </div>

                </div>

            @endif

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        {{ $clients->links() }}
    </div>

</div>

{{-- MODAL : Attribuer des points --}}
<div class="modal fade" id="pointsModal" tabindex="-1" aria-labelledby="pointsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content" style="background:#150f2a;border:1px solid rgba(167,139,250,.2);border-radius:22px;overflow:hidden;">

            <div class="modal-header" style="background:rgba(139,92,246,.08);border-bottom:1px solid rgba(167,139,250,.15);padding:22px 28px;">
                <h5 class="modal-title" id="pointsModalLabel" style="color:#a78bfa;font-weight:800;font-size:18px;">
                    <i class="fa-solid fa-coins me-2"></i>
                    Attribuer des points
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form id="pointsForm" method="POST" action="">
                @csrf

                <div class="modal-body" style="padding:28px;">

                    <p style="color:rgba(255,255,255,.55);font-size:14px;margin-bottom:22px;">
                        Client : <strong id="pointsClientName" style="color:#a78bfa;"></strong>
                    </p>

                    <div style="margin-bottom:18px;">
                        <label class="pts-modal-label">
                            <i class="fa-solid fa-star me-1"></i>
                            Nombre de points
                        </label>
                        <input
                            type="number"
                            name="points"
                            class="pts-modal-input"
                            min="1"
                            required
                            placeholder="Ex : 50"
                        >
                    </div>

                    <div>
                        <label class="pts-modal-label">
                            <i class="fa-solid fa-tag me-1"></i>
                            Raison
                        </label>
                        <input
                            type="text"
                            name="reason"
                            class="pts-modal-input"
                            required
                            placeholder="Ex : Bonus fidélité, geste commercial…"
                        >
                    </div>

                </div>

                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,.07);padding:18px 28px;gap:12px;">
                    <button type="button" class="action-btn btn-print" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="action-btn btn-points">
                        <i class="fa-solid fa-plus"></i>
                        Attribuer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function openPointsModal(clientId, clientName) {
    var base = "{{ route('admin.loyalty.bonus', '__ID__') }}";
    document.getElementById('pointsForm').action = base.replace('__ID__', clientId);
    document.getElementById('pointsClientName').textContent = clientName;
    var modal = new bootstrap.Modal(document.getElementById('pointsModal'));
    modal.show();
}
</script>

@endsection
@extends('layouts.admin')

@section('title', __('messages.salons'))
@section('page-title', __('messages.adm_salon_management'))
@section('page-subtitle', __('messages.adm_salon_management'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap');

:root{
    --sl-bg:#020617;
    --sl-card:#0f172a;
    --sl-card-2:#111827;
    --sl-border:rgba(255,255,255,.06);
    --sl-text:#f8fafc;
    --sl-muted:#94a3b8;
    --sl-primary:#ff4d6d;
    --sl-primary-2:#ff758f;
    --sl-success:#10b981;
    --sl-danger:#ef4444;
    --sl-blue:#3b82f6;
    --sl-shadow:0 30px 60px rgba(0,0,0,.35);
}

/* =====================================================
   GLOBAL
===================================================== */

.salon-root{
    font-family:'Inter',sans-serif;
    color:var(--sl-text);
}

/* =====================================================
   HERO
===================================================== */

.salon-hero{
    position:relative;
    overflow:hidden;
    border-radius:34px;
    padding:42px;
    margin-bottom:30px;
    background:
        radial-gradient(circle at top right, rgba(255,77,109,.18), transparent 32%),
        radial-gradient(circle at bottom left, rgba(59,130,246,.14), transparent 28%),
        linear-gradient(145deg,#111827,#020617);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--sl-shadow);
}

.salon-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:42px 42px;
    opacity:.18;
}

.salon-hero-top{
    position:relative;
    z-index:2;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
}

.salon-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:10px;
    margin-bottom:18px;
    color:#ff8fa3;
    font-size:11px;
    letter-spacing:.22em;
    text-transform:uppercase;
    font-weight:700;
}

.salon-eyebrow::before{
    content:'';
    width:38px;
    height:1px;
    background:#ff8fa3;
}

.salon-title{
    font-family:'Playfair Display',serif;
    font-size:58px;
    line-height:1;
    margin:0 0 14px;
    color:white;
    font-weight:700;
}

.salon-subtitle{
    max-width:760px;
    font-size:15px;
    line-height:1.9;
    color:rgba(255,255,255,.70);
    margin:0;
}

.salon-date{
    margin-top:24px;
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:12px 18px;
    border-radius:14px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
    color:#cbd5e1;
    font-size:13px;
}

.btn-create{
    border:none;
    outline:none;
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:16px 24px;
    border-radius:18px;
    background:linear-gradient(135deg,var(--sl-primary),var(--sl-primary-2));
    color:white;
    text-decoration:none;
    font-size:14px;
    font-weight:700;
    box-shadow:0 18px 35px rgba(255,77,109,.25);
    transition:.25s ease;
}

.btn-create:hover{
    transform:translateY(-3px);
    color:white;
}

/* =====================================================
   ALERT
===================================================== */

.alert-success-pro{
    margin-bottom:28px;
    border-radius:22px;
    padding:18px 22px;
    background:rgba(16,185,129,.10);
    border:1px solid rgba(16,185,129,.18);
    color:#6ee7b7;
    display:flex;
    align-items:center;
    gap:12px;
    font-weight:600;
}

/* =====================================================
   STATS
===================================================== */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
    margin-bottom:30px;
}

.stat-card{
    position:relative;
    overflow:hidden;
    border-radius:28px;
    padding:28px;
    background:linear-gradient(180deg,#111827,#0b1120);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--sl-shadow);
}

.stat-card::after{
    content:'';
    position:absolute;
    top:-50px;
    right:-50px;
    width:120px;
    height:120px;
    border-radius:50%;
    background:rgba(255,255,255,.03);
}

.stat-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:24px;
}

.stat-icon{
    width:62px;
    height:62px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.si-pink{
    background:rgba(255,77,109,.12);
    color:#ff4d6d;
    border:1px solid rgba(255,77,109,.20);
}

.si-green{
    background:rgba(16,185,129,.12);
    color:#10b981;
    border:1px solid rgba(16,185,129,.20);
}

.si-gray{
    background:rgba(148,163,184,.10);
    color:#94a3b8;
    border:1px solid rgba(148,163,184,.15);
}

.stat-mini{
    font-size:11px;
    color:#64748b;
    text-transform:uppercase;
    letter-spacing:.14em;
}

.stat-value{
    font-size:44px;
    font-weight:800;
    line-height:1;
    margin-bottom:10px;
    color:white;
}

.stat-label{
    font-size:14px;
    color:var(--sl-muted);
}

/* =====================================================
   TABLE
===================================================== */

.table-wrapper{
    background:linear-gradient(180deg,#111827,#0b1120);
    border-radius:34px;
    border:1px solid rgba(255,255,255,.06);
    overflow:hidden;
    box-shadow:var(--sl-shadow);
}

.table-header{
    padding:28px 30px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.table-title{
    font-size:26px;
    font-weight:800;
    color:white;
    margin-bottom:8px;
}

.table-desc{
    color:var(--sl-muted);
    font-size:14px;
}

.search-box{
    width:300px;
    max-width:100%;
    position:relative;
}

.search-box i{
    position:absolute;
    top:50%;
    left:18px;
    transform:translateY(-50%);
    color:#64748b;
    font-size:13px;
}

.search-box input{
    width:100%;
    border:none;
    outline:none;
    padding:16px 18px 16px 48px;
    border-radius:16px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
    color:white;
    font-size:14px;
}

.search-box input::placeholder{
    color:#64748b;
}

/* =====================================================
   TABLE CONTENT
===================================================== */

.table-responsive{
    width:100%;
    overflow-x:auto;
}

.salon-table{
    width:100%;
    border-collapse:collapse;
}

.salon-table thead th{
    padding:18px 28px;
    text-align:left;
    font-size:11px;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:#64748b;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.salon-table tbody tr{
    transition:.2s ease;
    border-bottom:1px solid rgba(255,255,255,.04);
}

.salon-table tbody tr:hover{
    background:rgba(255,255,255,.03);
}

.salon-table td{
    padding:22px 28px;
    vertical-align:middle;
}

/* =====================================================
   SALON CELL
===================================================== */

.salon-cell{
    display:flex;
    align-items:center;
    gap:16px;
}

.salon-avatar{
    width:58px;
    height:58px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg, rgba(255,77,109,.20), rgba(255,117,143,.10));
    border:1px solid rgba(255,77,109,.18);
    color:#ff4d6d;
    font-size:22px;
    flex-shrink:0;
}

.salon-name{
    font-size:15px;
    font-weight:700;
    color:white;
    margin-bottom:4px;
}

.salon-id{
    color:#64748b;
    font-size:12px;
}

/* =====================================================
   TEXT
===================================================== */

.contact-text{
    color:#cbd5e1;
    font-size:14px;
}

.contact-text i{
    color:#64748b;
}

.city-tag{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:12px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.05);
    font-size:13px;
    color:#e2e8f0;
}

.city-tag i{
    color:#94a3b8;
}

.status-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.sb-active{
    background:rgba(16,185,129,.10);
    color:#10b981;
    border:1px solid rgba(16,185,129,.15);
}

.sb-inactive{
    background:rgba(148,163,184,.10);
    color:#94a3b8;
    border:1px solid rgba(148,163,184,.12);
}

/* =====================================================
   ACTIONS
===================================================== */

.action-btns{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.btn-action{
    width:42px;
    height:42px;
    border:none;
    border-radius:14px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:.25s ease;
    text-decoration:none;
}

.btn-edit{
    background:rgba(59,130,246,.10);
    color:#60a5fa;
}

.btn-edit:hover{
    background:rgba(59,130,246,.18);
    color:#93c5fd;
}

.btn-delete{
    background:rgba(239,68,68,.10);
    color:#f87171;
}

.btn-delete:hover{
    background:rgba(239,68,68,.18);
}

/* =====================================================
   EMPTY
===================================================== */

.empty-state{
    padding:90px 20px;
    text-align:center;
}

.empty-icon{
    width:110px;
    height:110px;
    margin:0 auto 22px;
    border-radius:30px;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.06);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:42px;
    color:#64748b;
}

.empty-state h3{
    font-size:24px;
    color:white;
    font-weight:700;
    margin-bottom:12px;
}

.empty-state p{
    color:#94a3b8;
    max-width:520px;
    margin:0 auto 26px;
    line-height:1.8;
}

/* =====================================================
   PAGINATION
===================================================== */

.pagination-wrap{
    padding:24px 30px;
    border-top:1px solid rgba(255,255,255,.05);
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1100px){

    .stats-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){

    .salon-hero{
        padding:30px;
    }

    .salon-title{
        font-size:40px;
    }

    .table-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .search-box{
        width:100%;
    }
}
</style>
@endpush

@section('content')

<div class="salon-root">

    {{-- HERO --}}
    <div class="salon-hero">

        <div class="salon-hero-top">

            <div>

                <div class="salon-eyebrow">
                    {{ __('messages.adm_platform') }}
                </div>

                <h1 class="salon-title">
                    {{ __('messages.adm_salon_management') }}
                </h1>

                <p class="salon-subtitle">
                    Supervisez l'ensemble des salons affiliés,
                    suivez leurs performances, leur activité
                    et gérez facilement les opérations administratives.
                </p>

                <div class="salon-date">
                    <i class="fa-solid fa-calendar-days"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>

            </div>

            <a href="{{ route('admin.salons.create') }}" class="btn-create">
                <i class="fa-solid fa-plus"></i>
                {{ __('messages.adm_create_salon') }}
            </a>

        </div>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert-success-pro">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>

    @endif

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon si-pink">
                    <i class="fa-solid fa-shop"></i>
                </div>

                <div class="stat-mini">
                    Réseau
                </div>

            </div>

            <div class="stat-value">
                {{ $salons->count() }}
            </div>

            <div class="stat-label">
                Total des salons enregistrés
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon si-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="stat-mini">
                    Activité
                </div>

            </div>

            <div class="stat-value">
                {{ $salons->where('is_active', true)->count() }}
            </div>

            <div class="stat-label">
                Salons actuellement actifs
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon si-gray">
                    <i class="fa-solid fa-pause"></i>
                </div>

                <div class="stat-mini">
                    Statut
                </div>

            </div>

            <div class="stat-value">
                {{ $salons->where('is_active', false)->count() }}
            </div>

            <div class="stat-label">
                Salons momentanément inactifs
            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">

        <div class="table-header">

            <div>

                <div class="table-title">
                    Liste des salons
                </div>

                <div class="table-desc">
                    Consultez et gérez tous les salons affiliés à votre plateforme.
                </div>

            </div>

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text"
                       id="searchInput"
                       placeholder="Rechercher un salon...">

            </div>

        </div>

        <div class="table-responsive">

            <table class="salon-table" id="salonTable">

                <thead>

                    <tr>
                        <th>{{ __('messages.salons') }}</th>
                        <th>{{ __('messages.email') }}</th>
                        <th>{{ __('messages.phone') }}</th>
                        <th>{{ __('messages.address') }}</th>
                        <th>{{ __('messages.adm_status') }}</th>
                        <th style="text-align:right">{{ __('messages.adm_actions') }}</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($salons as $salonItem)

                    <tr>

                        {{-- SALON --}}
                        <td>

                            <div class="salon-cell">

                                <div class="salon-avatar">
                                    <i class="fa-solid fa-scissors"></i>
                                </div>

                                <div>

                                    <div class="salon-name">
                                        {{ $salonItem->name }}
                                    </div>

                                    <div class="salon-id">
                                        #{{ $salonItem->id }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        {{-- EMAIL --}}
                        <td>

                            <span class="contact-text">
                                <i class="fa-solid fa-envelope me-2"></i>
                                {{ $salonItem->email ?? '—' }}
                            </span>

                        </td>

                        {{-- PHONE --}}
                        <td>

                            <span class="contact-text">
                                <i class="fa-solid fa-phone me-2"></i>
                                {{ $salonItem->phone ?? '—' }}
                            </span>

                        </td>

                        {{-- CITY --}}
                        <td>

                            <span class="city-tag">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $salonItem->city ?? 'Non défini' }}
                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if($salonItem->is_active)

                                <span class="status-badge sb-active">
                                    <i class="fa-solid fa-circle-check"></i>
                                    {{ __('messages.active') }}
                                </span>

                            @else

                                <span class="status-badge sb-inactive">
                                    <i class="fa-solid fa-clock"></i>
                                    {{ __('messages.adm_inactive_label') }}
                                </span>

                            @endif

                        </td>

                        {{-- ACTIONS --}}
                        <td>

                            <div class="action-btns">

                                <a href="{{ route('admin.salons.edit', $salonItem->id) }}"
                                   class="btn-action btn-edit"
                                   data-edit-url="{{ route('admin.salons.edit', $salonItem->id) }}"
                                   data-edit-title="{{ __('messages.adm_edit_salon_title') }}">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <form action="{{ route('admin.salons.destroy', $salonItem->id) }}"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('Supprimer « {{ $salonItem->name }} » ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i class="fa-solid fa-shop-slash"></i>
                                </div>

                                <h3>
                                    Aucun salon disponible
                                </h3>

                                <p>
                                    Aucun salon affilié n'a encore été créé.
                                    Commencez par ajouter votre premier salon.
                                </p>

                                <a href="{{ route('admin.salons.create') }}"
                                   class="btn-create">

                                    <i class="fa-solid fa-plus"></i>
                                    Créer un salon

                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @if(method_exists($salons, 'links'))

            <div class="pagination-wrap">
                {{ $salons->links() }}
            </div>

        @endif

    </div>

</div>

{{-- SEARCH --}}
<script>
document.getElementById('searchInput').addEventListener('input', function () {

    const value = this.value.toLowerCase();

    document.querySelectorAll('#salonTable tbody tr').forEach(row => {

        row.style.display = row.textContent.toLowerCase().includes(value)
            ? ''
            : 'none';

    });

});
</script>

@endsection
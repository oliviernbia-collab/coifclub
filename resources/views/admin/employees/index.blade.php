@extends('layouts.admin')

@section('title', __('messages.adm_employee_management'))
@section('page-title', __('messages.adm_employee_management'))
@section('page-subtitle', __('messages.employees'))

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
/* ─── HEADER ─────────────────────────────────────── */
.page-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    margin-bottom:24px;
    gap:16px;
    flex-wrap:wrap;
}
.page-eyebrow{
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.1em;
    color:#D4AF37;
    margin-bottom:5px;
    display:flex;
    align-items:center;
    gap:6px;
}
.page-header h1{
    font-size:24px;
    font-weight:800;
    color:var(--text,#111827);
    margin:0;
}
.page-header p{ font-size:13px; color:#9ca3af; margin:4px 0 0; }

.btn-create{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:linear-gradient(135deg,#D4AF37,#f6e27a);
    color:#111827;
    font-size:13px;
    font-weight:700;
    padding:11px 22px;
    border-radius:13px;
    text-decoration:none;
    box-shadow:0 6px 20px rgba(212,175,55,.28);
    transition:.25s;
    white-space:nowrap;
}
.btn-create:hover{
    transform:translateY(-2px);
    color:#111827;
    box-shadow:0 10px 26px rgba(212,175,55,.38);
}

/* ─── ALERT ──────────────────────────────────────── */
.alert-ok{
    display:flex;
    align-items:center;
    gap:10px;
    background:rgba(16,185,129,.08);
    border:1px solid rgba(16,185,129,.18);
    border-radius:14px;
    padding:14px 18px;
    color:#10b981;
    margin-bottom:20px;
    font-size:13.5px;
    font-weight:600;
}

/* ─── STATS ──────────────────────────────────────── */
.stats-row{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;
    margin-bottom:24px;
}
.stat-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    border-radius:18px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:14px;
    transition:.3s;
}
.stat-card:hover{ transform:translateY(-2px); background:rgba(255,255,255,.07); }
.stat-icon{
    width:48px; height:48px;
    border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:18px;
    flex-shrink:0;
}
.si-gold  { background:rgba(212,175,55,.12); color:#D4AF37; }
.si-green { background:rgba(16,185,129,.12); color:#10b981; }
.si-blue  { background:rgba(59,130,246,.12); color:#3b82f6; }
.stat-value{ font-size:22px; font-weight:800; color:var(--text,#111827); line-height:1; }
.stat-label{ font-size:11px; color:#9ca3af; margin-top:4px; font-weight:500; }

/* ─── TABLE CARD ─────────────────────────────────── */
.table-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    border-radius:20px;
    overflow:hidden;
}
.table-card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:18px 22px;
    border-bottom:1px solid rgba(255,255,255,.06);
    flex-wrap:wrap;
    gap:12px;
}
.table-card-header h2{
    font-size:14px;
    font-weight:700;
    margin:0;
    color:var(--text,#111827);
    display:flex;
    align-items:center;
    gap:8px;
}
.search-input{
    display:flex;
    align-items:center;
    gap:10px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:12px;
    padding:9px 14px;
    min-width:230px;
}
.search-input i{ color:#9ca3af; font-size:13px; }
.search-input input{
    background:transparent;
    border:none;
    outline:none;
    width:100%;
    font-size:13px;
    color:var(--text,#111827);
}
.search-input input::placeholder{ color:#6b7280; }

/* ─── TABLE ──────────────────────────────────────── */
.emp-table{ width:100%; border-collapse:collapse; }
.emp-table thead th{
    padding:11px 20px;
    font-size:10.5px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:#6b7280;
    background:rgba(255,255,255,.02);
    border-bottom:1px solid rgba(255,255,255,.06);
    white-space:nowrap;
}
.emp-table tbody tr{
    border-bottom:1px solid rgba(255,255,255,.05);
    transition:.2s;
}
.emp-table tbody tr:hover{ background:rgba(255,255,255,.03); }
.emp-table td{
    padding:15px 20px;
    vertical-align:middle;
    color:var(--text,#111827);
    font-size:13.5px;
}

/* ─── CELLS ──────────────────────────────────────── */
.emp-avatar-cell{ display:flex; align-items:center; gap:13px; }
.avatar-circle{
    width:42px; height:42px;
    border-radius:50%;
    background:rgba(212,175,55,.12);
    border:1.5px solid rgba(212,175,55,.28);
    display:flex; align-items:center; justify-content:center;
    color:#D4AF37;
    font-weight:800;
    font-size:13px;
    text-transform:uppercase;
    flex-shrink:0;
}
.emp-photo{
    width:42px; height:42px;
    border-radius:50%;
    object-fit:cover;
    border:1.5px solid rgba(212,175,55,.28);
    flex-shrink:0;
}
.emp-name{ font-weight:700; font-size:13.5px; color:var(--text,#111827); }
.emp-date{ font-size:11px; color:#9ca3af; margin-top:3px; }
.contact-text{ color:#9ca3af; font-size:13px; }
.badge-active{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:4px 12px;
    border-radius:999px;
    background:rgba(16,185,129,.10);
    color:#10b981;
    font-size:11px;
    font-weight:700;
}

/* ─── ACTIONS ────────────────────────────────────── */
.action-btns{ display:flex; align-items:center; justify-content:flex-end; gap:8px; }
.btn-edit-sm,
.btn-del-sm{
    width:36px; height:36px;
    border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    border:none;
    transition:.2s;
    text-decoration:none;
    cursor:pointer;
}
.btn-edit-sm{
    background:rgba(212,175,55,.10);
    color:#92700a;
    border:1px solid rgba(212,175,55,.2);
}
.btn-edit-sm:hover{ background:#D4AF37; color:#111827; border-color:#D4AF37; }
.btn-del-sm{
    background:rgba(239,68,68,.08);
    color:#ef4444;
    border:1px solid rgba(239,68,68,.18);
}
.btn-del-sm:hover{ background:rgba(239,68,68,.16); }

/* ─── EMPTY ──────────────────────────────────────── */
.empty-row td{ text-align:center; padding:60px 24px !important; }
.empty-emoji{ font-size:46px; opacity:.3; margin-bottom:12px; display:block; }

/* ─── PAGINATION ─────────────────────────────────── */
.pagination-wrap{
    padding:16px 22px;
    display:flex;
    justify-content:flex-end;
    border-top:1px solid rgba(255,255,255,.06);
}

/* ─── RESPONSIVE ─────────────────────────────────── */
@media(max-width:900px){
    .stats-row{ grid-template-columns:repeat(2,1fr); }
    .stat-card:last-child{ grid-column:span 2; }
}

@media(max-width:640px){

    /* Header */
    .page-header{ flex-direction:column; align-items:stretch; gap:14px; }
    .page-header h1{ font-size:20px; }
    .btn-create{ justify-content:center; padding:12px; font-size:13px; }

    /* Stats 2 colonnes */
    .stats-row{ grid-template-columns:repeat(2,1fr); gap:10px; }
    .stat-card:last-child{ grid-column:auto; }
    .stat-card{ padding:14px 16px; gap:11px; }
    .stat-icon{ width:40px; height:40px; font-size:16px; }
    .stat-value{ font-size:19px; }

    /* Table header */
    .table-card-header{ flex-direction:column; align-items:stretch; padding:14px 16px; }
    .search-input{ min-width:0; width:100%; }

    /* ── Table → Cards ── */
    .emp-table thead{ display:none; }

    .emp-table tbody tr{
        display:block;
        margin:0 12px 12px;
        padding:14px 16px;
        background:rgba(255,255,255,.04);
        border:1px solid rgba(255,255,255,.09);
        border-radius:16px;
        border-bottom:1px solid rgba(255,255,255,.09);
    }

    .emp-table td{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:6px 0;
        border:none;
        font-size:13px;
    }

    .emp-table td::before{
        content:attr(data-label);
        font-size:10px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.07em;
        color:#6b7280;
        flex-shrink:0;
        min-width:75px;
    }

    /* Identity card — full width, no label */
    .emp-table td:first-child{
        margin-bottom:10px;
        padding-bottom:12px;
        border-bottom:1px solid rgba(255,255,255,.07);
    }
    .emp-table td:first-child::before{ display:none; }
    .emp-table td:first-child .emp-avatar-cell{ width:100%; }

    /* Actions */
    .emp-table td:last-child{
        justify-content:flex-start;
        margin-top:8px;
        padding-top:12px;
        border-top:1px solid rgba(255,255,255,.07);
    }
    .emp-table td:last-child::before{ display:none; }
    .action-btns{ justify-content:flex-start; gap:10px; }

    .btn-edit-sm,
    .btn-del-sm{
        width:auto;
        height:36px;
        padding:0 14px;
        border-radius:10px;
        gap:7px;
        font-size:12.5px;
        font-weight:700;
    }
    .btn-edit-sm::after{ content:"Modifier"; }
    .btn-del-sm::after{ content:"Supprimer"; }

    /* Pagination */
    .pagination-wrap{ justify-content:center; }
}
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">
            <i class="fa-solid fa-users"></i>
            {{ __('messages.adm_team') }}
        </div>
        <h1>{{ __('messages.adm_employee_management') }}</h1>
        <p>{{ $employees->total() }} {{ __('messages.adm_members_registered') }}</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn-create">
        <i class="fa-solid fa-user-plus"></i>
        {{ __('messages.adm_add_employee') }}
    </a>
</div>

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon si-gold"><i class="fa-solid fa-users"></i></div>
        <div>
            <div class="stat-value">{{ $employees->total() }}</div>
            <div class="stat-label">{{ __('messages.adm_total_employees') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="fa-solid fa-user-check"></i></div>
        <div>
            <div class="stat-value">{{ $employees->count() }}</div>
            <div class="stat-label">{{ __('messages.adm_active_employees') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-blue"><i class="fa-solid fa-calendar-days"></i></div>
        <div>
            <div class="stat-value">{{ $employees->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">{{ __('messages.adm_this_month') }}</div>
        </div>
    </div>
</div>

{{-- SUCCESS --}}
@if(session('success'))
    <div class="alert-ok">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div class="table-card">

    <div class="table-card-header">
        <h2>
            <i class="fa-solid fa-list"></i>
            {{ __('messages.adm_employee_list') }}
        </h2>
        <div class="search-input">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="{{ __('messages.adm_search') }}…">
        </div>
    </div>

    <div class="table-scroll">
    <div style="overflow-x:auto;"><table class="emp-table" id="empTable">
        <thead>
            <tr>
                <th>{{ __('messages.employees') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.phone') }}</th>
                <th>{{ __('messages.adm_status') }}</th>
                <th style="text-align:right">{{ __('messages.adm_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td data-label="">
                        <div class="emp-avatar-cell">
                            @if($employee->employee?->photo)
                                <img src="{{ asset('storage/' . $employee->employee->photo) }}" class="emp-photo" alt="{{ $employee->name }}">
                            @else
                                <div class="avatar-circle">{{ strtoupper(substr($employee->name,0,2)) }}</div>
                            @endif
                            <div>
                                <div class="emp-name">{{ $employee->name }}</div>
                                <div class="emp-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ optional($employee->created_at)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td data-label="Email">
                        <span class="contact-text">
                            <i class="fa-regular fa-envelope" style="margin-right:5px;"></i>
                            {{ $employee->email }}
                        </span>
                    </td>

                    <td data-label="Tél.">
                        <span class="contact-text">
                            @if($employee->employee?->phone)
                                <a href="tel:{{ $employee->employee->phone }}" style="color:#9ca3af;text-decoration:none;">
                                    <i class="fa-solid fa-phone" style="margin-right:5px;"></i>
                                    {{ $employee->employee->phone }}
                                </a>
                            @else
                                —
                            @endif
                        </span>
                    </td>

                    <td data-label="Statut">
                        <span class="badge-active">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ __('messages.active') }}
                        </span>
                    </td>

                    <td data-label="">
                        <div class="action-btns">
                            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                               class="btn-edit-sm"
                               title="Modifier"
                               data-edit-url="{{ route('admin.employees.edit', $employee->id) }}"
                               data-edit-title="{{ __('messages.adm_edit_employee_title') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer « {{ $employee->name }} » ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del-sm" title="Supprimer">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="5">
                        <span class="empty-emoji"><i class="fa-solid fa-users-slash"></i></span>
                        <div style="font-weight:700;margin-bottom:6px;">{{ __('messages.adm_no_employee_found') }}</div>
                        <div style="color:#6b7280;font-size:13px;">{{ __('messages.adm_create_first_emp') }}</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
    </div>

    <div class="pagination-wrap">
        {{ $employees->links() }}
    </div>

</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const v = this.value.toLowerCase();
    document.querySelectorAll('#empTable tbody tr:not(.empty-row)').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection

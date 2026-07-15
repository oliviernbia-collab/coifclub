@extends('layouts.admin')

@section('title', __('messages.users'))
@section('page-title', __('messages.adm_user_management'))

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
    color:#ff4d6d;
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
    line-height:1.2;
}
.page-header p{
    font-size:13px;
    color:#9ca3af;
    margin:4px 0 0;
}
.header-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}
.btn-create,
.btn-print{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 20px;
    border-radius:12px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    transition:.25s;
    white-space:nowrap;
    cursor:pointer;
    border:none;
}
.btn-create{
    background:linear-gradient(135deg,#ff4d6d,#ff758f);
    color:#fff;
    box-shadow:0 4px 16px rgba(255,77,109,.28);
}
.btn-create:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 22px rgba(255,77,109,.42);
    color:#fff;
}
.btn-print{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    color:var(--text,#374151);
}
.btn-print:hover{
    background:rgba(255,255,255,.12);
    color:var(--text,#374151);
}

/* ─── STATS ──────────────────────────────────────── */
.stats-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:24px;
}
.stat-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.09);
    border-radius:18px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:14px;
    transition:.3s;
}
.stat-card:hover{
    transform:translateY(-2px);
    background:rgba(255,255,255,.07);
}
.stat-icon{
    width:48px;
    height:48px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    flex-shrink:0;
}
.si-pink  { background:rgba(255,77,109,.12);  color:#ff4d6d; }
.si-blue  { background:rgba(59,130,246,.12);  color:#3b82f6; }
.si-amber { background:rgba(245,158,11,.12);  color:#f59e0b; }
.si-green { background:rgba(16,185,129,.12);  color:#10b981; }
.stat-value{
    font-size:22px;
    font-weight:800;
    color:var(--text,#111827);
    line-height:1;
}
.stat-label{
    font-size:11px;
    color:#9ca3af;
    margin-top:4px;
    font-weight:500;
}

/* ─── TABLE CARD ─────────────────────────────────── */
.table-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.09);
    border-radius:20px;
    overflow:hidden;
}
.table-card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:18px 22px;
    gap:12px;
    flex-wrap:wrap;
    border-bottom:1px solid rgba(255,255,255,.07);
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
.search-box{
    display:flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:12px;
    padding:9px 14px;
    min-width:220px;
}
.search-box i{ color:#6b7280; font-size:13px; }
.search-box input{
    background:transparent;
    border:none;
    outline:none;
    width:100%;
    font-size:13px;
    color:var(--text,#111827);
}
.search-box input::placeholder{ color:#6b7280; }

/* ─── TABLE ──────────────────────────────────────── */
.usr-table{ width:100%; border-collapse:collapse; }
.usr-table thead th{
    padding:11px 20px;
    font-size:10.5px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:#6b7280;
    background:rgba(255,255,255,.02);
    border-bottom:1px solid rgba(255,255,255,.07);
    white-space:nowrap;
}
.usr-table tbody tr{
    border-bottom:1px solid rgba(255,255,255,.05);
    transition:.2s;
}
.usr-table tbody tr:hover{ background:rgba(255,255,255,.03); }
.usr-table td{
    padding:14px 20px;
    vertical-align:middle;
    color:var(--text,#111827);
}

/* ─── CELLS ──────────────────────────────────────── */
.user-cell{ display:flex; align-items:center; gap:12px; }
.user-avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid rgba(255,77,109,.25);
    flex-shrink:0;
}
.user-name{ font-size:13.5px; font-weight:700; }
.user-id{ font-size:11px; color:#9ca3af; margin-top:2px; }
.user-email{ font-size:13px; color:#9ca3af; }
.user-date{ font-size:12.5px; color:#9ca3af; }

/* ─── ROLE ───────────────────────────────────────── */
.role-badge{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:4px 11px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}
.role-admin       { background:rgba(239,68,68,.10); color:#ef4444; }
.role-employee    { background:rgba(245,158,11,.10); color:#f59e0b; }
.role-client      { background:rgba(59,130,246,.10); color:#3b82f6; }
.role-prestataire { background:rgba(16,185,129,.10); color:#10b981; }
.role-superadmin  { background:linear-gradient(135deg,rgba(168,85,247,.15),rgba(236,72,153,.15)); color:#a855f7; border:1px solid rgba(168,85,247,.3); }

/* ─── ACTIONS ────────────────────────────────────── */
.action-btns{ display:flex; align-items:center; justify-content:flex-end; gap:8px; }
.btn-edit-sm,
.btn-del-sm{
    width:36px;
    height:36px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.2s;
    border:none;
    cursor:pointer;
    text-decoration:none;
}
.btn-edit-sm{
    background:rgba(59,130,246,.10);
    color:#3b82f6;
    border:1px solid rgba(59,130,246,.18);
}
.btn-edit-sm:hover{ background:rgba(59,130,246,.2); color:#3b82f6; }
.btn-del-sm{
    background:rgba(239,68,68,.08);
    color:#ef4444;
    border:1px solid rgba(239,68,68,.18);
}
.btn-del-sm:hover{ background:rgba(239,68,68,.16); }

/* ─── EMPTY ──────────────────────────────────────── */
.empty-state{ text-align:center; padding:60px 24px; }
.empty-icon{ font-size:44px; opacity:.3; margin-bottom:12px; }
.empty-state h3{ font-size:15px; font-weight:700; margin-bottom:6px; }
.empty-state p{ color:#6b7280; font-size:13px; }

/* ─── PAGINATION ─────────────────────────────────── */
.pg-wrap{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 20px;
    border-top:1px solid rgba(255,255,255,.07);
    flex-wrap:wrap;
    gap:10px;
}
.pg-info{ font-size:12px; color:#9ca3af; }
.pg-btns{ display:flex; gap:4px; flex-wrap:wrap; }
.pgb{
    width:34px;
    height:34px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:transparent;
    border:1px solid rgba(255,255,255,.1);
    color:#9ca3af;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    transition:.15s;
    text-decoration:none;
}
.pgb:hover:not(:disabled){ background:rgba(255,255,255,.06); color:var(--text,#fff); }
.pgb.cur{ background:#ff4d6d; color:#fff; border-color:#ff4d6d; }
.pgb:disabled{ opacity:.3; cursor:not-allowed; }

/* ─── RESPONSIVE ─────────────────────────────────── */
@media(max-width:900px){
    .stats-row{ grid-template-columns:repeat(2,1fr); }
}

@media(max-width:640px){

    /* Header mobile */
    .page-header{
        flex-direction:column;
        align-items:stretch;
        gap:14px;
    }
    .page-header h1{ font-size:20px; }
    .header-actions{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:8px;
    }
    .btn-create,
    .btn-print{
        justify-content:center;
        padding:11px 14px;
        font-size:12.5px;
    }

    /* Stats 2×2 */
    .stats-row{ grid-template-columns:repeat(2,1fr); gap:10px; }
    .stat-card{ padding:14px 16px; gap:12px; }
    .stat-icon{ width:42px; height:42px; font-size:16px; }
    .stat-value{ font-size:20px; }

    /* Table header search full width */
    .table-card-header{ flex-direction:column; align-items:stretch; padding:14px 16px; }
    .search-box{ min-width:0; width:100%; }

    /* ── Table → Cards ── */
    .usr-table thead{ display:none; }

    .usr-table tbody tr{
        display:block;
        margin:0 12px 12px;
        padding:14px 16px;
        background:rgba(255,255,255,.04);
        border:1px solid rgba(255,255,255,.09);
        border-radius:16px;
        border-bottom:1px solid rgba(255,255,255,.09);
    }

    .usr-table td{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:6px 0;
        font-size:13px;
        border:none;
    }

    .usr-table td::before{
        content:attr(data-label);
        font-size:10px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.07em;
        color:#6b7280;
        flex-shrink:0;
        min-width:80px;
    }

    /* First cell (user) takes full width */
    .usr-table td:first-child{
        margin-bottom:10px;
        padding-bottom:12px;
        border-bottom:1px solid rgba(255,255,255,.07);
    }
    .usr-table td:first-child::before{ display:none; }
    .usr-table td:first-child .user-cell{ width:100%; }

    /* Actions cell */
    .usr-table td:last-child{
        justify-content:flex-start;
        margin-top:8px;
        padding-top:12px;
        border-top:1px solid rgba(255,255,255,.07);
    }
    .usr-table td:last-child::before{ display:none; }
    .action-btns{ justify-content:flex-start; gap:10px; }

    .btn-edit-sm,
    .btn-del-sm{
        width:auto;
        height:38px;
        padding:0 16px;
        border-radius:10px;
        gap:7px;
        font-size:12.5px;
        font-weight:700;
    }
    .btn-edit-sm::after{ content:"Modifier"; }
    .btn-del-sm::after{ content:"Supprimer"; }

    /* Pagination mobile */
    .pg-wrap{ justify-content:center; }
    .pg-info{ width:100%; text-align:center; }
    .pg-btns{ justify-content:center; }
}
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">
            <i class="fa-solid fa-layer-group"></i>
            {{ __('messages.adm_platform') }}
        </div>
        <h1><i class="fa-solid fa-users" style="margin-right:8px;opacity:.6;"></i>{{ __('messages.adm_user_management') }}</h1>
        <p>{{ $users->total() }} {{ __('messages.adm_accounts_registered') }}</p>
    </div>

    <div class="header-actions">
        <a href="{{ route('users.print') }}" target="_blank" class="btn-print">
            <i class="fa-solid fa-print"></i>
            {{ __('messages.adm_print') }}
        </a>
        <a href="{{ route('admin.users.create') }}" class="btn-create">
            <i class="fa-solid fa-user-plus"></i>
            {{ __('messages.adm_add') }}
        </a>
    </div>
</div>

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon si-pink"><i class="fa-solid fa-users"></i></div>
        <div>
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-label">{{ __('messages.adm_total') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-blue"><i class="fa-solid fa-user"></i></div>
        <div>
            <div class="stat-value">{{ $stats['client'] }}</div>
            <div class="stat-label">{{ __('messages.clients') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-amber"><i class="fa-solid fa-scissors"></i></div>
        <div>
            <div class="stat-value">{{ $stats['employee'] }}</div>
            <div class="stat-label">{{ __('messages.employees') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
            <div class="stat-value">{{ $stats['admin'] }}</div>
            <div class="stat-label">{{ __('messages.admin_title') }}</div>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="table-card">

    <div class="table-card-header">
        <h2>
            <i class="fa-solid fa-table-list"></i>
            {{ __('messages.adm_user_list') }}
        </h2>
        <form method="GET" action="{{ route('admin.users.index') }}" class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                id="searchInput"
                name="search"
                value="{{ old('search', request('search')) }}"
                placeholder="{{ __('messages.adm_search') }}…"
                autocomplete="off"
            >
        </form>
    </div>

    <div class="table-scroll">
    <div style="overflow-x:auto;"><table class="usr-table" id="usrTable">
        <thead>
            <tr>
                <th>{{ __('messages.adm_user') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.adm_role') }}</th>
                <th>{{ __('messages.adm_registration') }}</th>
                <th style="text-align:right">{{ __('messages.adm_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td data-label="">
                        <div class="user-cell">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="user-avatar" alt="{{ $user->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff4d6d&color=fff&size=80" class="user-avatar" alt="{{ $user->name }}">
                            @endif
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-id">#{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>

                    <td data-label="Email">
                        <span class="user-email">{{ $user->email }}</span>
                    </td>

                    <td data-label="Rôle">
                        @if($user->isSuperAdmin())
                            <span class="role-badge role-superadmin"><i class="fa-solid fa-crown"></i> Super Admin</span>
                        @elseif($user->role === 'admin')
                            <span class="role-badge role-admin"><i class="fa-solid fa-shield-halved"></i> Admin</span>
                        @elseif($user->role === 'employee')
                            <span class="role-badge role-employee"><i class="fa-solid fa-scissors"></i> Employée</span>
                        @elseif($user->role === 'prestataire')
                            <span class="role-badge role-prestataire"><i class="fa-solid fa-star"></i> Prestataire</span>
                        @else
                            <span class="role-badge role-client"><i class="fa-solid fa-user"></i> Cliente</span>
                        @endif
                    </td>

                    <td data-label="Inscription">
                        <span class="user-date">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $user->created_at->format('d/m/Y') }}
                        </span>
                    </td>

                    <td data-label="">
                        <div class="action-btns">
                            @unless($user->isSuperAdmin() && !auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="btn-edit-sm"
                               title="Modifier"
                               data-edit-url="{{ route('admin.users.edit', $user->id) }}"
                               data-edit-title="{{ __('messages.adm_edit_user_title') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            @endunless
                            @unless($user->isSuperAdmin())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer « {{ $user->name }} » ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del-sm" title="Supprimer">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endunless
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa-solid fa-users"></i></div>
                            <h3>{{ __('messages.adm_no_user_found') }}</h3>
                            <p>{{ __('messages.adm_create_first_user') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
    </div>

    {{-- PAGINATION --}}
    <div class="pg-wrap">
        <div class="pg-info">
            {{ __('messages.adm_showing') }} {{ $users->firstItem() ?? 0 }} {{ __('messages.adm_to') }} {{ $users->lastItem() ?? 0 }} {{ __('messages.adm_of') }} {{ $users->total() }}
        </div>
        <div class="pg-btns">
            @if ($users->onFirstPage())
                <button class="pgb" disabled>‹</button>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="pgb">‹</a>
            @endif

            @php $start = max(1,$users->currentPage()-2); $end = min($users->lastPage(),$users->currentPage()+2); @endphp
            @if($start > 1)
                <a href="{{ $users->url(1) }}" class="pgb">1</a>
                @if($start > 2)<span class="pgb" style="cursor:default;border-color:transparent;background:transparent;">…</span>@endif
            @endif
            @for($page=$start;$page<=$end;$page++)
                <a href="{{ $users->url($page) }}" class="pgb{{ $users->currentPage()===$page?' cur':'' }}">{{ $page }}</a>
            @endfor
            @if($end < $users->lastPage())
                @if($end < $users->lastPage()-1)<span class="pgb" style="cursor:default;border-color:transparent;background:transparent;">…</span>@endif
                <a href="{{ $users->url($users->lastPage()) }}" class="pgb">{{ $users->lastPage() }}</a>
            @endif

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="pgb">›</a>
            @else
                <button class="pgb" disabled>›</button>
            @endif
        </div>
    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    let t;
    searchInput.addEventListener('input', function () {
        clearTimeout(t);
        t = setTimeout(() => this.form.submit(), 300);
    });
}
</script>

@endsection

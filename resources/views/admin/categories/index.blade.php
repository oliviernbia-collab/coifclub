@extends('layouts.admin')

@section('title', __('messages.adm_cat_title'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --cg-primary: #3b82f6;
    --cg-muted: #94a3b8;
    --cg-border: rgba(255,255,255,.07);
    --cg-shadow: 0 20px 50px rgba(0,0,0,.3);
}

.cg-wrapper { font-family: 'Inter', sans-serif; color: #f8fafc; }

/* ── Page header ──────────────────────────────────────────── */
.cg-page-head {
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 16px;
    margin-bottom: 28px;
}

.cg-page-title { font-size: 24px; font-weight: 700; color: #fff; margin: 0 0 4px; }
.cg-page-sub   { font-size: 14px; color: var(--cg-muted); margin: 0; }

/* ── Stats strip ──────────────────────────────────────────── */
.cg-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.cg-stat {
    border-radius: 20px;
    padding: 22px 24px;
    background: rgba(255,255,255,.04);
    border: 1px solid var(--cg-border);
    display: flex; align-items: center; gap: 16px;
    transition: transform .25s, box-shadow .25s;
}

.cg-stat:hover { transform: translateY(-3px); box-shadow: var(--cg-shadow); }

.cg-stat-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: var(--cg-primary);
    background: rgba(59,130,246,.12); border: 1px solid rgba(59,130,246,.18);
}

.cg-stat-value { font-size: 32px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 4px; }
.cg-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: .1em; color: var(--cg-muted); }

/* ── Table card ───────────────────────────────────────────── */
.cg-card {
    background: linear-gradient(180deg, #111827, #0b1120);
    border: 1px solid var(--cg-border);
    border-radius: 24px; overflow: hidden;
    box-shadow: var(--cg-shadow);
}

.cg-card-head {
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 14px;
    padding: 24px 28px;
    border-bottom: 1px solid rgba(255,255,255,.05);
}

.cg-card-title { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.cg-card-sub   { font-size: 13px; color: var(--cg-muted); }

/* ── Buttons ──────────────────────────────────────────────── */
.cg-btn {
    border: none; outline: none;
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 18px; border-radius: 14px;
    font-size: 13px; font-weight: 700; color: #fff;
    transition: .2s ease; cursor: pointer; text-decoration: none;
}

.cg-btn-primary {
    background: linear-gradient(135deg, var(--cg-primary), #2563eb);
    box-shadow: 0 8px 24px rgba(59,130,246,.25);
}

.cg-btn-primary:hover { transform: translateY(-2px); color: #fff; }

.cg-btn-warning {
    background: rgba(245,158,11,.1);
    border: 1px solid rgba(245,158,11,.2);
    color: #fbbf24; padding: 9px 14px;
}

.cg-btn-warning:hover { background: #f59e0b; color: #fff; border-color: #f59e0b; }

.cg-btn-danger {
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.2);
    color: #f87171; padding: 9px 14px;
}

.cg-btn-danger:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

/* ── Flash alerts ─────────────────────────────────────────── */
.cg-flash {
    margin: 16px 28px 0; padding: 14px 18px; border-radius: 14px;
    font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 10px;
}
.cg-flash-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.2); color: #6ee7b7; }
.cg-flash-error   { background: rgba(239,68,68,.1);  border: 1px solid rgba(239,68,68,.2);  color: #fca5a5; }

/* ── Table (desktop) ──────────────────────────────────────── */
.cg-table-wrap { overflow-x: auto; }

.cg-table {
    width: 100%;
    border-collapse: separate; border-spacing: 0 10px;
    min-width: 680px;
    padding: 8px 20px 16px;
}

.cg-table thead th {
    padding: 0 20px 8px;
    font-size: 11px; text-transform: uppercase; letter-spacing: .12em;
    color: var(--cg-muted); font-weight: 600;
}

.cg-table tbody tr { transition: .2s ease; }
.cg-table tbody tr:hover { transform: translateY(-2px); }

.cg-table td {
    padding: 18px 20px;
    background: rgba(255,255,255,.03);
    border-top: 1px solid rgba(255,255,255,.04);
    border-bottom: 1px solid rgba(255,255,255,.04);
    color: #fff; vertical-align: middle;
}

.cg-table td:first-child {
    border-left: 1px solid rgba(255,255,255,.04);
    border-radius: 16px 0 0 16px;
}

.cg-table td:last-child {
    border-right: 1px solid rgba(255,255,255,.04);
    border-radius: 0 16px 16px 0;
}

.cg-cat-cell { display: flex; align-items: center; gap: 14px; }

.cg-cat-icon {
    width: 44px; height: 44px; border-radius: 13px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.18);
    color: #60a5fa; font-size: 18px;
}

.cg-cat-name { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 3px; }
.cg-cat-id   { font-size: 12px; color: var(--cg-muted); }

.cg-desc {
    max-width: 280px; font-size: 13px; color: #cbd5e1; line-height: 1.7;
}

.cg-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 12px; border-radius: 999px; font-size: 12px; font-weight: 700;
    background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.18);
    color: #6ee7b7;
}

.cg-actions { display: flex; align-items: center; gap: 10px; }

/* ── Mobile cards (< 640px) ───────────────────────────────── */
.cg-mobile-list { display: none; padding: 12px 16px 20px; }

.cg-mobile-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: 18px; padding: 18px;
    margin-bottom: 12px;
    transition: border-color .2s;
}

.cg-mobile-card:hover { border-color: rgba(59,130,246,.25); }

.cg-mobile-head { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }

.cg-mobile-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.18);
    color: #60a5fa; font-size: 17px;
}

.cg-mobile-name { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 2px; }
.cg-mobile-id   { font-size: 11px; color: var(--cg-muted); }

.cg-mobile-desc {
    font-size: 13px; color: #94a3b8; line-height: 1.6; margin-bottom: 14px;
    padding-bottom: 14px; border-bottom: 1px solid rgba(255,255,255,.06);
}

.cg-mobile-footer { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.cg-mobile-actions { display: flex; gap: 8px; }

/* ── Empty ────────────────────────────────────────────────── */
.cg-empty { text-align: center; padding: 60px 24px; }
.cg-empty-icon {
    width: 80px; height: 80px; margin: 0 auto 20px;
    border-radius: 24px; display: flex; align-items: center; justify-content: center;
    font-size: 34px; color: rgba(255,255,255,.3); background: rgba(255,255,255,.04);
}
.cg-empty-title { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 10px; }
.cg-empty-text  { color: var(--cg-muted); font-size: 14px; margin-bottom: 24px; }

/* ── Responsive ───────────────────────────────────────────── */
@media (max-width: 640px) {
    .cg-page-head { flex-direction: column; align-items: flex-start; }
    .cg-stats { grid-template-columns: 1fr 1fr; }
    .cg-card-head { flex-direction: column; align-items: flex-start; }
    .cg-btn-primary { width: 100%; justify-content: center; }
    /* Cacher le tableau, montrer les cards */
    .cg-table-wrap { display: none; }
    .cg-mobile-list { display: block; }
}

@media (max-width: 400px) {
    .cg-stats { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<div class="cg-wrapper">

    {{-- En-tête --------------------------------------------------- --}}
    <div class="cg-page-head">
        <div>
            <h1 class="cg-page-title">{{ __('messages.adm_cat_title') }}</h1>
            <p class="cg-page-sub">{{ __('messages.adm_cat_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="cg-btn cg-btn-primary">
            <i class="fa-solid fa-plus"></i>
            {{ __('messages.adm_new_category') }}
        </a>
    </div>

    {{-- Stats ---------------------------------------------------- --}}
    <div class="cg-stats">
        <div class="cg-stat">
            <div class="cg-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
            <div>
                <div class="cg-stat-value">{{ $categories->count() }}</div>
                <div class="cg-stat-label">{{ __('messages.adm_cat_available') }}</div>
            </div>
        </div>
        <div class="cg-stat">
            <div class="cg-stat-icon"><i class="fa-solid fa-scissors"></i></div>
            <div>
                <div class="cg-stat-value">{{ $categories->sum(fn($c) => $c->services->count()) }}</div>
                <div class="cg-stat-label">{{ __('messages.adm_cat_associated') }}</div>
            </div>
        </div>
    </div>

    {{-- Card principale ------------------------------------------ --}}
    <div class="cg-card">

        <div class="cg-card-head">
            <div>
                <div class="cg-card-title">{{ __('messages.adm_cat_list') }}</div>
                <div class="cg-card-sub">{{ $categories->count() }} {{ __('messages.categories') }}</div>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="cg-flash cg-flash-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="cg-flash cg-flash-error">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @if($categories->isEmpty())
            <div class="cg-empty">
                <div class="cg-empty-icon"><i class="fa-regular fa-folder-open"></i></div>
                <div class="cg-empty-title">{{ __('messages.adm_no_category') }}</div>
                <div class="cg-empty-text">{{ __('messages.adm_no_cat_text') }}</div>
                <a href="{{ route('admin.categories.create') }}" class="cg-btn cg-btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    {{ __('messages.adm_create_category') }}
                </a>
            </div>
        @else

            {{-- ── Vue tableau (desktop ≥ 641px) ─────────────────── --}}
            <div class="cg-table-wrap">
                <table class="cg-table">
                    <thead>
                        <tr>
                            <th>{{ __('messages.adm_cat_header') }}</th>
                            <th>{{ __('messages.adm_description') }}</th>
                            <th>{{ __('messages.services') }}</th>
                            <th>{{ __('messages.adm_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                        <tr>
                            <td>
                                <div class="cg-cat-cell">
                                    <div class="cg-cat-icon"><i class="fa-regular fa-folder-open"></i></div>
                                    <div>
                                        <div class="cg-cat-name">{{ $categorie->nom }}</div>
                                        <div class="cg-cat-id">ID #{{ $categorie->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cg-desc">{{ $categorie->description ?? '—' }}</div>
                            </td>
                            <td>
                                <span class="cg-badge">
                                    <i class="fa-solid fa-scissors"></i>
                                    {{ $categorie->services->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="cg-actions">
                                    <a href="{{ route('admin.categories.edit', $categorie->id) }}"
                                       class="cg-btn cg-btn-warning"
                                       data-edit-url="{{ route('admin.categories.edit', $categorie->id) }}"
                                       data-edit-title="{{ __('messages.adm_edit_cat_title') }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        {{ __('messages.btn_edit') }}
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $categorie->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('{{ __('messages.btn_delete') }} « {{ $categorie->nom }} » ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="cg-btn cg-btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ── Vue cards (mobile ≤ 640px) ─────────────────────── --}}
            <div class="cg-mobile-list">
                @foreach($categories as $categorie)
                <div class="cg-mobile-card">
                    <div class="cg-mobile-head">
                        <div class="cg-mobile-icon"><i class="fa-regular fa-folder-open"></i></div>
                        <div>
                            <div class="cg-mobile-name">{{ $categorie->nom }}</div>
                            <div class="cg-mobile-id">ID #{{ $categorie->id }}</div>
                        </div>
                    </div>
                    @if($categorie->description)
                    <div class="cg-mobile-desc">{{ $categorie->description }}</div>
                    @endif
                    <div class="cg-mobile-footer">
                        <span class="cg-badge">
                            <i class="fa-solid fa-scissors"></i>
                            {{ $categorie->services->count() }} {{ __('messages.services') }}
                        </span>
                        <div class="cg-mobile-actions">
                            <a href="{{ route('admin.categories.edit', $categorie->id) }}"
                               class="cg-btn cg-btn-warning"
                               data-edit-url="{{ route('admin.categories.edit', $categorie->id) }}"
                               data-edit-title="{{ __('messages.adm_edit_cat_title') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                {{ __('messages.btn_edit') }}
                            </a>
                            <form action="{{ route('admin.categories.destroy', $categorie->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('{{ __('messages.btn_delete') }} « {{ $categorie->nom }} » ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="cg-btn cg-btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        @endif

    </div>

</div>

@endsection

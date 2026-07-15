@extends('layouts.admin')

@section('title', __('messages.vip_subscriptions'))

@push('styles')
<style>
/* ══════════════════════════════════════════════
   VIP ADMIN — styles
══════════════════════════════════════════════ */
.vip-wrap { padding: 6px 0 32px; }

/* ── En-tête ── */
.vip-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 14px; margin-bottom: 28px;
}
.vip-head-title  { font-size: 22px; font-weight: 700; color: #f8fafc; margin: 0; }
.vip-head-sub    { font-size: 13px; color: #64748b; margin-top: 4px; }

/* ── Stats ── */
.vip-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 26px;
}
@media(max-width:900px) { .vip-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px) { .vip-stats { grid-template-columns: 1fr; } }

.vip-stat {
    background: linear-gradient(160deg,#111827,#0b1120);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 18px;
    padding: 20px 22px;
    display: flex; align-items: center; gap: 16px;
}
.vip-stat-icon {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
}
.vip-stat-icon.total    { background: rgba(99,102,241,.15); color: #818cf8; }
.vip-stat-icon.active   { background: rgba(16,185,129,.15); color: #34d399; }
.vip-stat-icon.cancelled{ background: rgba(239,68,68,.12);  color: #f87171; }
.vip-stat-icon.revenue  { background: rgba(233,30,140,.15); color: #e91e8c; }

.vip-stat-val  { font-size: 22px; font-weight: 700; color: #f1f5f9; line-height: 1; }
.vip-stat-lbl  { font-size: 12px; color: #64748b; margin-top: 4px; }

/* ── Filtres ── */
.vip-filters {
    display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px;
    align-items: center;
}
.vip-filter-label { font-size: 12px; color: #64748b; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; }
.vip-filter-pill {
    padding: 6px 16px; border-radius: 20px; font-size: 12.5px; font-weight: 600;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
    color: #94a3b8; text-decoration: none; transition: .18s; cursor: pointer;
}
.vip-filter-pill:hover  { background: rgba(255,255,255,.1); color: #e2e8f0; }
.vip-filter-pill.active { background: rgba(233,30,140,.18); border-color: rgba(233,30,140,.4); color: #f471b5; }
.vip-filter-sep { width: 1px; height: 24px; background: rgba(255,255,255,.08); }

/* ── Table ── */
.vip-card {
    background: linear-gradient(180deg,#111827,#0b1120);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,.3);
}
.vip-table-wrap { overflow-x: auto; }
.vip-table {
    width: 100%; border-collapse: collapse;
    font-size: 13.5px; color: #e2e8f0; min-width: 780px;
}
.vip-table thead th {
    padding: 13px 18px;
    text-align: left; font-size: 10.5px; font-weight: 700;
    color: #475569; text-transform: uppercase; letter-spacing: .08em;
    background: rgba(255,255,255,.02);
    border-bottom: 1px solid rgba(255,255,255,.05); white-space: nowrap;
}
.vip-table tbody td { padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,.035); vertical-align: middle; }
.vip-table tbody tr:last-child td { border-bottom: none; }
.vip-table tbody tr:hover { background: rgba(255,255,255,.018); }

/* ── Cellule client ── */
.vip-client { display: flex; align-items: center; gap: 12px; }
.vip-avatar {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    object-fit: cover;
    border: 2px solid rgba(233,30,140,.3);
}
.vip-avatar-fallback {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg,#e91e8c,#c91a78);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 14px; font-weight: 700;
    border: 2px solid rgba(233,30,140,.3);
}
.vip-client-name  { font-weight: 600; color: #f1f5f9; font-size: 13.5px; }
.vip-client-email { font-size: 11.5px; color: #64748b; margin-top: 2px; }

/* ── Badges plan ── */
.plan-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 20px; font-size: 11.5px; font-weight: 700;
}
.plan-monthly   { background: rgba(99,102,241,.15); color: #818cf8; }
.plan-quarterly { background: rgba(233,30,140,.15); color: #f471b5; }
.plan-annual    { background: rgba(245,158,11,.15);  color: #fbbf24; }

/* ── Badge statut ── */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 20px; font-size: 11.5px; font-weight: 600;
}
.status-active    { background: rgba(16,185,129,.12); color: #34d399; }
.status-cancelled { background: rgba(239,68,68,.10);  color: #f87171; }
.status-inactive  { background: rgba(100,116,139,.12); color: #94a3b8; }

/* ── Dot ── */
.dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
.dot-active    { background: #34d399; }
.dot-cancelled { background: #f87171; }
.dot-inactive  { background: #94a3b8; }

/* ── Bouton annuler ── */
.btn-vip-cancel {
    padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
    background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2);
    color: #f87171; cursor: pointer; transition: .18s;
}
.btn-vip-cancel:hover { background: rgba(239,68,68,.22); border-color: rgba(239,68,68,.45); color: #fca5a5; }

/* ── Vide ── */
.vip-empty {
    text-align: center; padding: 56px 24px; color: #475569; font-size: 14px;
}
.vip-empty i { font-size: 36px; color: #1e293b; display: block; margin-bottom: 12px; }

/* ── Pagination ── */
.pagination-wrap { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.05); }
</style>
@endpush

@section('content')

<div class="vip-wrap">

    {{-- En-tête --}}
    <div class="vip-head">
        <div>
            <h1 class="vip-head-title"><i class="bi bi-star-fill" style="color:#e91e8c;margin-right:8px;"></i>{{ __('messages.vip_subscriptions') }}</h1>
            <p class="vip-head-sub">{{ __('messages.vip_manage_desc') }}</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-sm" style="background:rgba(255,255,255,.06);color:#94a3b8;border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:8px 16px;font-size:13px;text-decoration:none;">
            <i class="bi bi-globe" style="margin-right:6px;"></i>{{ __('messages.vip_public_plans') }}
        </a>
    </div>

    {{-- Statistiques --}}
    <div class="vip-stats">
        <div class="vip-stat">
            <div class="vip-stat-icon total"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="vip-stat-val">{{ $stats['total'] }}</div>
                <div class="vip-stat-lbl">{{ __('messages.vip_total_subscribers') }}</div>
            </div>
        </div>
        <div class="vip-stat">
            <div class="vip-stat-icon active"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="vip-stat-val">{{ $stats['active'] }}</div>
                <div class="vip-stat-lbl">{{ __('messages.vip_active_subscriptions') }}</div>
            </div>
        </div>
        <div class="vip-stat">
            <div class="vip-stat-icon cancelled"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="vip-stat-val">{{ $stats['cancelled'] }}</div>
                <div class="vip-stat-lbl">{{ __('messages.vip_cancelled') }}</div>
            </div>
        </div>
        <div class="vip-stat">
            <div class="vip-stat-icon revenue"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="vip-stat-val">{{ number_format($stats['revenue'] / 100, 0, ',', ' ') }}</div>
                <div class="vip-stat-lbl">{{ __('messages.vip_active_revenue') }}</div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="vip-filters">
        <span class="vip-filter-label">{{ __('messages.adm_filter_status') }} :</span>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('status', 'page'), [])) }}"
           class="vip-filter-pill {{ !request('status') ? 'active' : '' }}">{{ __('messages.adm_filter_all') }}</a>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
           class="vip-filter-pill {{ request('status') === 'active' ? 'active' : '' }}">
            <span class="dot dot-active" style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#34d399;"></span> {{ __('messages.vip_filter_active') }}
        </a>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('status', 'page'), ['status' => 'cancelled'])) }}"
           class="vip-filter-pill {{ request('status') === 'cancelled' ? 'active' : '' }}">
            <span class="dot dot-cancelled" style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#f87171;"></span> {{ __('messages.vip_cancelled') }}
        </a>

        <div class="vip-filter-sep"></div>

        <span class="vip-filter-label">{{ __('messages.vip_filter_plan') }} :</span>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('plan', 'page'), [])) }}"
           class="vip-filter-pill {{ !request('plan') ? 'active' : '' }}">{{ __('messages.adm_filter_all') }}</a>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('plan', 'page'), ['plan' => 'monthly'])) }}"
           class="vip-filter-pill {{ request('plan') === 'monthly' ? 'active' : '' }}">{{ __('messages.vip_plan_monthly') }}</a>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('plan', 'page'), ['plan' => 'quarterly'])) }}"
           class="vip-filter-pill {{ request('plan') === 'quarterly' ? 'active' : '' }}">{{ __('messages.vip_plan_quarterly') }}</a>
        <a href="{{ route('admin.vip.index', array_merge(request()->except('plan', 'page'), ['plan' => 'annual'])) }}"
           class="vip-filter-pill {{ request('plan') === 'annual' ? 'active' : '' }}">{{ __('messages.vip_plan_annual') }}</a>
    </div>

    {{-- Table --}}
    <div class="vip-card">
        <div class="vip-table-wrap">
            <table class="vip-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.adm_vip_col_client') }}</th>
                        <th>{{ __('messages.adm_vip_col_plan') }}</th>
                        <th>{{ __('messages.adm_vip_col_price') }}</th>
                        <th>{{ __('messages.adm_vip_col_discount') }}</th>
                        <th>{{ __('messages.adm_vip_col_start') }}</th>
                        <th>{{ __('messages.adm_vip_col_expiry') }}</th>
                        <th>{{ __('messages.adm_vip_col_status') }}</th>
                        <th>{{ __('messages.adm_vip_col_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                    @php
                        $user      = $sub->user;
                        $statusKey = match($sub->status) {
                            'active'    => 'active',
                            'cancelled' => 'cancelled',
                            default     => 'inactive',
                        };
                        $planKey = match($sub->plan) {
                            'monthly'   => 'monthly',
                            'quarterly' => 'quarterly',
                            'annual'    => 'annual',
                            default     => 'monthly',
                        };
                        $planLabel = match($sub->plan) {
                            'monthly'   => __('messages.vip_plan_monthly'),
                            'quarterly' => __('messages.vip_plan_quarterly'),
                            'annual'    => __('messages.vip_plan_annual'),
                            default     => ucfirst($sub->plan),
                        };
                        $statusLabel = match($sub->status) {
                            'active'    => __('messages.status_active'),
                            'cancelled' => __('messages.status_cancelled'),
                            default     => ucfirst($sub->status),
                        };
                        $avatarUrl = $user?->photo
                            ? asset('storage/' . $user->photo)
                            : null;
                        $initials  = $user ? strtoupper(substr($user->name, 0, 1)) : '?';
                    @endphp
                    <tr>
                        {{-- Cliente --}}
                        <td>
                            <div class="vip-client">
                                @if($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="vip-avatar">
                                @else
                                    <div class="vip-avatar-fallback">{{ $initials }}</div>
                                @endif
                                <div>
                                    <div class="vip-client-name">{{ $user?->name ?? __('messages.adm_vip_deleted_user') }}</div>
                                    @if($user?->email)
                                        <div class="vip-client-email">{{ $user->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Plan --}}
                        <td>
                            <span class="plan-badge plan-{{ $planKey }}">
                                <i class="bi bi-{{ $planKey === 'annual' ? 'trophy-fill' : ($planKey === 'quarterly' ? 'star-fill' : 'circle') }}"></i>
                                {{ $planLabel }}
                            </span>
                        </td>

                        {{-- Prix --}}
                        <td style="font-weight:600;color:#f1f5f9;">{{ number_format($sub->price / 100, 2, ',', ' ') }}</td>

                        {{-- Remise --}}
                        <td>
                            @if($sub->discount_percentage)
                                <span style="color:#34d399;font-weight:600;">-{{ $sub->discount_percentage }}%</span>
                            @else
                                <span style="color:#475569;">—</span>
                            @endif
                        </td>

                        {{-- Début --}}
                        <td style="color:#94a3b8;">{{ $sub->started_at?->format('d/m/Y') ?? '—' }}</td>

                        {{-- Expiration --}}
                        <td>
                            @if($sub->ends_at)
                                @php $expired = $sub->ends_at->isPast(); @endphp
                                <span style="color:{{ $expired ? '#f87171' : '#94a3b8' }};">
                                    {{ $sub->ends_at->format('d/m/Y') }}
                                    @if($expired && $sub->status === 'active')
                                        <span style="font-size:10px;color:#f87171;">({{ __('messages.adm_vip_expired') }})</span>
                                    @endif
                                </span>
                            @else
                                <span style="color:#475569;">—</span>
                            @endif
                        </td>

                        {{-- Statut --}}
                        <td>
                            <span class="status-badge status-{{ $statusKey }}">
                                <span class="dot dot-{{ $statusKey }}" style="width:6px;height:6px;border-radius:50%;display:inline-block;background:{{ $statusKey === 'active' ? '#34d399' : ($statusKey === 'cancelled' ? '#f87171' : '#94a3b8') }};"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            @if($sub->status === 'active')
                                @php $confirmMsg = __('messages.adm_vip_cancel_confirm', ['name' => $user?->name ?? __('messages.adm_vip_deleted_user')]); @endphp
                                <form method="POST" action="{{ route('admin.vip.cancel', $sub) }}"
                                      onsubmit="return confirm('{{ addslashes($confirmMsg) }}')">
                                    @csrf
                                    <button type="submit" class="btn-vip-cancel">
                                        <i class="bi bi-x-circle"></i> {{ __('messages.adm_vip_cancel_btn') }}
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#334155;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="vip-empty">
                            <i class="bi bi-star"></i>
                            {{ __('messages.adm_vip_empty_filtered') }}
                            @if(request('status') || request('plan'))
                                <br><a href="{{ route('admin.vip.index') }}" style="color:#e91e8c;font-size:12px;margin-top:6px;display:inline-block;">{{ __('messages.adm_vip_clear_filters') }}</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
        <div class="pagination-wrap">
            {{ $subscriptions->links() }}
        </div>
        @endif
    </div>

</div>

@endsection

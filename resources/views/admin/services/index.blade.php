@extends('layouts.admin')

@section('title', __('messages.services'))

@section('content')

<style>
    /* ===== PAGE LAYOUT ===== */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
    }

    .page-header-left .page-eyebrow {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #ff4d6d;
        margin-bottom: 6px;
    }

    .page-header-left h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0;
        line-height: 1.2;
    }

    .page-header-left p {
        font-size: 14px;
        color: #6b7280;
        margin: 4px 0 0;
    }

    /* ===== BOUTON CRÉER ===== */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #ff4d6d, #ff758f);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 11px 20px;
        border-radius: 12px;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 4px 18px rgba(255, 77, 109, 0.30);
        transition: transform 0.18s, box-shadow 0.18s;
        flex-shrink: 0;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255, 77, 109, 0.38);
        color: #fff;
        text-decoration: none;
    }

    .btn-create svg {
        width: 16px;
        height: 16px;
        stroke: #fff;
        stroke-width: 2.5;
        flex-shrink: 0;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 28px;
    }

    .filter-bar label {
        font-size: 13px;
        font-weight: 600;
        color: #9ca3af;
        white-space: nowrap;
    }

    .filter-bar select {
        flex: 1;
        max-width: 260px;
        padding: 9px 14px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        color: var(--text, #111827);
        font-size: 14px;
        cursor: pointer;
    }

    .filter-bar select:focus {
        outline: none;
        border-color: #ff4d6d;
        box-shadow: 0 0 0 3px rgba(255,77,109,0.15);
    }

    .btn-filter {
        padding: 9px 18px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        color: var(--text, #111827);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-filter:hover {
        background: rgba(255,255,255,0.14);
    }

    /* ===== STATS ROW ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon.pink   { background: rgba(255,77,109,0.12); }
    .stat-icon.blue   { background: rgba(59,130,246,0.12); }
    .stat-icon.green  { background: rgba(16,185,129,0.12); }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--text, #111827);
        line-height: 1;
    }

    .stat-label {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 3px;
    }

    /* ===== CARDS GRID ===== */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    /* ===== SERVICE CARD ===== */
    .service-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.15);
    }

    .service-card-img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        display: block;
        background: rgba(255,255,255,0.04);
    }

    .service-card-img.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        background: linear-gradient(135deg, rgba(255,77,109,0.10), rgba(255,117,143,0.06));
    }

    .service-card-body {
        padding: 18px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .service-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .service-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        background: rgba(255,77,109,0.12);
        color: #ff4d6d;
        white-space: nowrap;
    }

    .service-status {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        flex-shrink: 0;
        margin-top: 5px;
    }

    .service-status.inactive {
        background: #6b7280;
    }

    .service-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0;
        line-height: 1.3;
    }

    .service-desc {
        font-size: 13px;
        color: #9ca3af;
        margin: 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .service-salon {
        font-size: 12px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .service-salon svg {
        width: 13px;
        height: 13px;
        stroke: #9ca3af;
        stroke-width: 2;
        flex-shrink: 0;
    }

    .service-meta {
        display: flex;
        gap: 12px;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .meta-pill {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #111827);
    }

    .meta-pill svg {
        width: 14px;
        height: 14px;
        stroke: #9ca3af;
        stroke-width: 2;
        flex-shrink: 0;
    }

    .service-actions {
        display: flex;
        gap: 8px;
        padding: 0 20px 18px;
    }

    .btn-edit {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 0;
        background: rgba(59,130,246,0.10);
        color: #3b82f6;
        border: 1px solid rgba(59,130,246,0.20);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s;
    }

    .btn-edit:hover {
        background: rgba(59,130,246,0.18);
        color: #3b82f6;
        text-decoration: none;
    }

    .btn-edit svg, .btn-del svg, .btn-rdv svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        flex-shrink: 0;
    }

    .btn-del {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        background: rgba(239,68,68,0.08);
        color: #ef4444;
        border: 1px solid rgba(239,68,68,0.18);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-del:hover {
        background: rgba(239,68,68,0.16);
    }

    .btn-rdv {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        background: linear-gradient(135deg, #ff4d6d, #ff758f);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.15s;
    }

    .btn-rdv:hover {
        opacity: 0.88;
        color: #fff;
        text-decoration: none;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 24px;
        background: rgba(255,255,255,0.03);
        border: 1px dashed rgba(255,255,255,0.12);
        border-radius: 18px;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text, #111827);
        margin: 0 0 6px;
    }

    .empty-state p {
        font-size: 14px;
        color: #6b7280;
        margin: 0 0 20px;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrap{
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:14px;
        margin-top:12px;
        padding-top:22px;
        border-top:1px solid #f1f1f4;
    }

    .pagination-meta{
        font-size:13px;
        color:#6b7280;
        white-space:nowrap;
    }

    .pagination-meta strong{
        color:var(--text, #111827);
        font-weight:700;
    }

    .pagination-wrap nav{
        margin-left:auto;
    }

    .pagination-wrap .pagination{
        display:flex;
        align-items:center;
        gap:4px;
        margin:0;
        padding:0;
        list-style:none;
        flex-wrap:wrap;
    }

    .pagination-wrap .page-item .page-link{
        display:flex;
        align-items:center;
        justify-content:center;
        min-width:36px;
        height:36px;
        padding:0 12px;
        border-radius:10px;
        border:1px solid #e5e7eb;
        background:#fff;
        color:#374151;
        font-size:13.5px;
        font-weight:600;
        text-decoration:none;
        transition:border-color .15s, color .15s, background .15s;
    }

    .pagination-wrap .page-item .page-link:hover{
        border-color:#ff4d6d;
        color:#ff4d6d;
        background:rgba(255,77,109,.06);
    }

    .pagination-wrap .page-item.active .page-link{
        background:linear-gradient(135deg, #ff4d6d, #ff758f);
        border-color:transparent;
        color:#fff;
        box-shadow:0 4px 14px rgba(255,77,109,.32);
    }

    .pagination-wrap .page-item.disabled .page-link{
        color:#c3c7d1;
        background:#f9fafb;
        border-color:#f1f1f4;
        cursor:not-allowed;
        box-shadow:none;
    }

    @media (max-width: 640px){
        .pagination-wrap{ justify-content:center; text-align:center; }
        .pagination-wrap nav{ margin-left:0; width:100%; }
        .pagination-wrap .pagination{ justify-content:center; width:100%; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .stats-row { grid-template-columns: 1fr; }
        .services-grid { grid-template-columns: 1fr; }
        .filter-bar { flex-wrap: wrap; }
    }
</style>

<section>

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-eyebrow">{{ __('messages.services') }}</div>
            <h1>{{ __('messages.adm_service_management') }}</h1>
            <p>{{ $services->total() }} {{ __('messages.services') }}</p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="btn-create">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ __('messages.adm_create_service') }}
        </a>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon pink">✂️</div>
            <div>
                <div class="stat-value">{{ $services->total() }}</div>
                <div class="stat-label">{{ __('messages.services') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">✅</div>
            <div>
                <div class="stat-value">{{ $salons->count() }}</div>
                <div class="stat-label">{{ __('messages.salons') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div>
                <div class="stat-value">{{ $services->where('is_active', true)->count() }}</div>
                <div class="stat-label">{{ __('messages.adm_active_label') }}</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <form class="filter-bar" method="GET" action="{{ route('admin.services.index') }}">
        <label>{{ __('messages.adm_filter') }}</label>
        <select name="salon">
            <option value="">{{ __('messages.adm_all') }}</option>
            @foreach ($salons as $salon)
                <option value="{{ $salon->id }}" @selected(request('salon') == $salon->id)>
                    {{ $salon->nom }}
                </option>
            @endforeach
        </select>
        <button class="btn-filter" type="submit">{{ __('messages.adm_filter') }}</button>
        @if(request('salon'))
            <a href="{{ route('admin.services.index') }}" class="btn-filter" style="text-decoration:none">✕ Réinitialiser</a>
        @endif
    </form>

    {{-- GRID --}}
    <div class="services-grid">

        @forelse ($services as $service)
        <article class="service-card">

            {{-- IMAGE --}}
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}"
                     alt="{{ $service->name }}"
                     class="service-card-img">
            @else
                <div class="service-card-img placeholder">
                    {{ $service->emoji ?? '💇🏾‍♂️' }}
                </div>
            @endif

            <div class="service-card-body">

                <div class="service-card-top">
                    <span class="service-badge">
                        {{ $service->categorie?->nom ?? 'Non classé' }}
                    </span>
                    <div class="service-status {{ $service->is_active ? '' : 'inactive' }}"
                         title="{{ $service->is_active ? 'Actif' : 'Inactif' }}">
                    </div>
                </div>

                <h3 class="service-name">{{ $service->name }}</h3>

                @if($service->description)
                    <p class="service-desc">{{ $service->description }}</p>
                @endif

                <div class="service-salon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $service->salon?->nom ?? 'Non assigné' }}
                </div>

                <div class="service-meta">
                    <div class="meta-pill">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ $service->duration }} min
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="service-actions">
                @auth
                    <a href="{{ route('admin.services.edit', $service) }}"
                       class="btn-edit"
                       data-edit-url="{{ route('admin.services.edit', $service) }}"
                       data-edit-title="{{ __('messages.btn_edit') }}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ __('messages.btn_edit') }}
                    </a>

                    <form action="{{ route('admin.services.destroy', $service->id) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer « {{ $service->name }} » ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-del">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 11v6M14 11v6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                @endauth

                <a href="{{ auth()->check()
                        ? route('booking.start', ['service' => $service->id])
                        : route('login.form') }}"
                   class="btn-rdv">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 2v4M8 2v4M3 10h18" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    RDV
                </a>
            </div>

        </article>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">✂️</div>
                <h3>{{ __('messages.adm_no_service') }}</h3>
                <p>{{ __('messages.adm_service_management') }}</p>
                <a href="{{ route('admin.services.create') }}" class="btn-create">
                    + {{ __('messages.adm_create_service') }}
                </a>
            </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($services->hasPages())
    <div class="pagination-wrap">
        <div class="pagination-meta">
            Affichage de <strong>{{ $services->firstItem() }}</strong>–<strong>{{ $services->lastItem() }}</strong>
            sur <strong>{{ $services->total() }}</strong> {{ __('messages.services') }}
        </div>
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
    @endif

</section>

@endsection
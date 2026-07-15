@extends('layouts.app')

@section('title', 'Gestion Fidélité')

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-light:#ff6ab4;
    --pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);
    --card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);
    --muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.adm-loy-wrap{max-width:1200px;margin:auto;padding:40px 20px 80px;}

.adm-loy-header{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:36px;flex-wrap:wrap;}
.adm-loy-title{font-size:2rem;font-weight:900;color:var(--text);margin-bottom:6px;}
.adm-loy-sub{color:var(--muted);font-size:.95rem;}

.adm-badge{
    background:rgba(233,30,140,.12);color:var(--pink-light);
    border:1px solid rgba(233,30,140,.25);padding:8px 18px;
    border-radius:50px;font-size:.85rem;font-weight:700;
    display:inline-flex;align-items:center;gap:8px;
}

.adm-table-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;overflow:hidden;box-shadow:0 15px 40px rgba(0,0,0,.25);}

.adm-table{width:100%;border-collapse:collapse;}
.adm-table thead tr{background:rgba(233,30,140,.08);border-bottom:1px solid rgba(233,30,140,.15);}
.adm-table th{padding:16px 20px;text-align:left;font-size:.78rem;font-weight:700;color:var(--pink-light);text-transform:uppercase;letter-spacing:1px;}
.adm-table tbody tr{border-bottom:1px solid rgba(255,255,255,.05);transition:.2s;}
.adm-table tbody tr:last-child{border-bottom:none;}
.adm-table tbody tr:hover{background:rgba(233,30,140,.04);}
.adm-table td{padding:16px 20px;color:var(--text);font-size:.9rem;vertical-align:middle;}

.client-name{font-weight:700;color:var(--text);}
.client-avatar{width:36px;height:36px;border-radius:50%;background:var(--gradient);display:inline-flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:.85rem;margin-right:10px;vertical-align:middle;}

.pts-val{font-weight:800;color:var(--text);}
.pts-life{color:var(--muted);font-size:.85rem;}

.tier-badge{display:inline-block;padding:5px 13px;border-radius:50px;font-size:.78rem;font-weight:700;}
.tier-bronze{background:rgba(205,127,50,.15);color:#cd7f32;border:1px solid rgba(205,127,50,.25);}
.tier-silver{background:rgba(192,192,192,.12);color:#c0c0c0;border:1px solid rgba(192,192,192,.2);}
.tier-gold{background:rgba(255,215,0,.1);color:#ffd700;border:1px solid rgba(255,215,0,.2);}
.tier-platinum{background:rgba(233,30,140,.12);color:var(--pink-light);border:1px solid rgba(233,30,140,.25);}
.tier-default{background:rgba(255,255,255,.06);color:var(--muted);border:1px solid rgba(255,255,255,.1);}

.date-cell{color:var(--muted);font-size:.85rem;}

/* pagination */
.pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:24px;}
.pagination .page-link{background:var(--card);border:1px solid var(--card-border);color:var(--text);border-radius:10px;padding:6px 13px;font-size:.85rem;text-decoration:none;transition:.2s;}
.pagination .page-link:hover,.pagination .page-item.active .page-link{background:var(--gradient);border-color:transparent;color:#fff;}
.pagination .page-item.disabled .page-link{opacity:.35;pointer-events:none;}

.empty-row td{text-align:center;padding:50px;color:var(--muted);}

@media(max-width:768px){
    .adm-table th:nth-child(3),.adm-table td:nth-child(3),
    .adm-table th:nth-child(5),.adm-table td:nth-child(5){display:none;}
}
</style>

<div class="adm-loy-wrap">

    <div class="adm-loy-header">
        <div>
            <h1 class="adm-loy-title">Gestion du programme de fidélité</h1>
            <p class="adm-loy-sub">Consultez le solde points et le statut de vos clients.</p>
        </div>
        <div class="adm-badge">
            <i class="fa-solid fa-crown"></i>
            {{ $loyaltyPoints->total() }} clients
        </div>
    </div>

    <div class="adm-table-card">
        <div style="overflow-x:auto;"><table class="adm-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Points</th>
                    <th>Points à vie</th>
                    <th>Statut</th>
                    <th>Mise à jour</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loyaltyPoints as $loyalty)
                <tr>
                    <td>
                        <span class="client-avatar">{{ strtoupper(substr($loyalty->user->name ?? 'U', 0, 1)) }}</span>
                        <span class="client-name">{{ $loyalty->user->name ?? 'Utilisateur supprimé' }}</span>
                    </td>
                    <td><span class="pts-val">{{ number_format($loyalty->balance) }}</span></td>
                    <td><span class="pts-life">{{ number_format($loyalty->lifetime_points) }}</span></td>
                    <td>
                        @php $tier = strtolower($loyalty->tier_name ?? ''); @endphp
                        <span class="tier-badge
                            {{ str_contains($tier,'bronze') ? 'tier-bronze' : (str_contains($tier,'silver') || str_contains($tier,'argent') ? 'tier-silver' : (str_contains($tier,'gold') || str_contains($tier,'or') ? 'tier-gold' : (str_contains($tier,'platinum') || str_contains($tier,'platine') ? 'tier-platinum' : 'tier-default'))) }}">
                            {{ $loyalty->tier_name }}
                        </span>
                    </td>
                    <td class="date-cell">{{ $loyalty->updated_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="5">Aucun point de fidélité enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table></div>
    </div>

    <div class="pagination-wrap">{{ $loyaltyPoints->links() }}</div>

</div>

@endsection

@extends('layouts.client')

@section('title', __('messages.loy_title'))

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

.loy-wrap{max-width:1100px;margin:auto;padding:40px 20px 80px;}

.loy-hero{
    display:flex;align-items:center;justify-content:space-between;gap:24px;
    background:var(--card);border:1px solid rgba(233,30,140,.2);
    border-radius:28px;padding:36px 40px;margin-bottom:36px;
    box-shadow:0 15px 40px rgba(0,0,0,.3);flex-wrap:wrap;
}
.loy-hero-title{font-size:2rem;font-weight:900;color:var(--text);margin-bottom:8px;}
.loy-hero-sub{color:var(--muted);font-size:.95rem;line-height:1.7;}
.balance-box{
    background:var(--gradient);border-radius:20px;padding:22px 32px;
    text-align:center;min-width:180px;flex-shrink:0;
    box-shadow:0 10px 30px rgba(233,30,140,.4);
}
.balance-label{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.75);margin-bottom:8px;}
.balance-num{font-size:3rem;font-weight:900;color:#fff;line-height:1;}
.balance-unit{font-size:.8rem;color:rgba(255,255,255,.7);margin-top:6px;}

.stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:36px;}
.stat-box{background:var(--card);border:1px solid var(--card-border);border-radius:20px;padding:24px;transition:.25s;}
.stat-box:hover{border-color:rgba(233,30,140,.3);}
.stat-box-label{font-size:.75rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px;}
.stat-box-val{font-size:1.6rem;font-weight:900;color:var(--text);}
.stat-box-icon{width:40px;height:40px;border-radius:12px;background:var(--gradient);display:flex;align-items:center;justify-content:center;margin-bottom:14px;font-size:.9rem;color:#fff;}

.loy-grid{display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;}

.loy-card{background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:30px;}
.loy-card-title{font-size:1.15rem;font-weight:800;color:var(--text);margin-bottom:22px;display:flex;align-items:center;gap:10px;}
.loy-card-title i{color:var(--pink);}

.tx-item{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:16px;padding:16px 20px;margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:.2s;}
.tx-item:hover{border-color:rgba(233,30,140,.2);}
.tx-reason{font-weight:700;color:var(--text);font-size:.95rem;margin-bottom:4px;}
.tx-date{font-size:.8rem;color:var(--muted);}
.tx-pts{text-align:right;}
.tx-earn{font-size:.85rem;color:#4ade80;font-weight:600;}
.tx-spend{font-size:.85rem;color:var(--pink-light);font-weight:600;}
.tx-empty{color:var(--muted);font-size:.95rem;padding:30px 0;text-align:center;}

/* pagination override */
.pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:20px;}
.pagination .page-link{background:var(--card);border:1px solid var(--card-border);color:var(--text);border-radius:10px;padding:6px 13px;font-size:.85rem;text-decoration:none;transition:.2s;}
.pagination .page-link:hover,.pagination .page-item.active .page-link{background:var(--gradient);border-color:transparent;color:#fff;}
.pagination .page-item.disabled .page-link{opacity:.35;pointer-events:none;}

.redeem-label{font-size:.8rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;}
.redeem-input{
    width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(233,30,140,.2);
    border-radius:14px;padding:14px 16px;color:var(--text);font-size:1rem;
    outline:none;transition:.25s;
}
.redeem-input:focus{border-color:rgba(233,30,140,.6);background:rgba(233,30,140,.06);}
.redeem-btn{
    width:100%;margin-top:16px;border:none;border-radius:14px;padding:15px;
    background:var(--gradient);color:#fff;font-size:1rem;font-weight:800;
    cursor:pointer;transition:.3s;
    box-shadow:0 8px 20px rgba(233,30,140,.3);
}
.redeem-btn:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(233,30,140,.45);}
.redeem-note{color:var(--muted);font-size:.85rem;line-height:1.6;margin-bottom:20px;}

/* flash */
.flash-ok{background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:14px;padding:14px 18px;color:#4ade80;font-weight:600;margin-bottom:20px;font-size:.9rem;}
.flash-err{background:rgba(233,30,140,.1);border:1px solid rgba(233,30,140,.25);border-radius:14px;padding:14px 18px;color:var(--pink-light);font-weight:600;margin-bottom:20px;font-size:.9rem;}

@media(max-width:900px){.loy-grid{grid-template-columns:1fr;}.stat-row{grid-template-columns:1fr 1fr;}}
@media(max-width:540px){.stat-row{grid-template-columns:1fr;}.loy-hero{padding:24px 20px;}.balance-box{width:100%;}}
</style>

<div class="loy-wrap">

    {{-- Hero --}}
    <div class="loy-hero">
        <div>
            <h1 class="loy-hero-title">{{ __('messages.loy_title') }}</h1>
            <p class="loy-hero-sub">{{ __('messages.loy_subtitle') }}</p>
        </div>
        <div class="balance-box">
            <div class="balance-label">{{ __('messages.loy_balance_label') }}</div>
            <div class="balance-num">{{ $loyalty->balance ?? 0 }}</div>
            <div class="balance-unit">{{ __('messages.loy_balance_unit') }}</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stat-row">
        <div class="stat-box">
            <div class="stat-box-icon"><i class="fa-solid fa-crown"></i></div>
            <div class="stat-box-label">{{ __('messages.loy_stat_level') }}</div>
            <div class="stat-box-val">{{ $loyaltyStats['tier'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-icon"><i class="fa-solid fa-gem"></i></div>
            <div class="stat-box-label">{{ __('messages.loy_stat_lifetime') }}</div>
            <div class="stat-box-val">{{ $loyaltyStats['lifetime'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="stat-box-label">{{ __('messages.loy_stat_next') }}</div>
            <div class="stat-box-val">{{ $loyaltyStats['next_tier_points'] }} pts</div>
        </div>
    </div>

    {{-- Grid --}}
    <div class="loy-grid">

        {{-- Transactions --}}
        <div class="loy-card">
            <div class="loy-card-title">
                <i class="fa-solid fa-clock-rotate-left"></i>
                {{ __('messages.loy_history') }}
            </div>

            @forelse($transactions as $tx)
            <div class="tx-item">
                <div>
                    <div class="tx-reason">{{ ucfirst($tx->reason) }}</div>
                    <div class="tx-date">{{ $tx->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="tx-pts">
                    @if($tx->points_earned)
                    <div class="tx-earn">+{{ $tx->points_earned }} pts</div>
                    @endif
                    @if($tx->points_spent)
                    <div class="tx-spend">-{{ $tx->points_spent }} pts</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="tx-empty">{{ __('messages.loy_empty') }}</div>
            @endforelse

            <div class="pagination-wrap">{{ $transactions->links() }}</div>
        </div>

        {{-- Redeem --}}
        <div class="loy-card">
            <div class="loy-card-title">
                <i class="fa-solid fa-gift"></i>
                {{ __('messages.loy_redeem_title') }}
            </div>

            @if(session('success'))
            <div class="flash-ok"><i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="flash-err"><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}</div>
            @endif

            <p class="redeem-note">{{ __('messages.loy_redeem_note') }}</p>

            <form action="{{ route('client.loyalty.redeem') }}" method="POST">
                @csrf
                <div class="redeem-label">{{ __('messages.loy_redeem_label') }}</div>
                <input type="number" name="points" min="10" step="10" value="100"
                       class="redeem-input" />
                @error('points')
                <div style="color:var(--pink-light);font-size:.82rem;margin-top:6px;">{{ $message }}</div>
                @enderror
                <button type="submit" class="redeem-btn">
                    <i class="fa-solid fa-bolt mr-2"></i>{{ __('messages.loy_redeem_btn') }}
                </button>
            </form>
        </div>

    </div>

</div>

@endsection

@extends('layouts.admin')

@section('title', __('messages.adm_notif_title'))

@section('content')

<style>
.notif-page { max-width: 860px; margin: 0 auto; }

.notif-topbar {
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 14px; margin-bottom: 28px;
}
.notif-heading {
    font-size: 1.55rem; font-weight: 900; color: var(--text);
    display: flex; align-items: center; gap: 12px;
}
.unread-chip {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 24px; height: 24px; background: var(--gradient);
    color: #fff; border-radius: 999px; font-size: .7rem; font-weight: 800; padding: 0 6px;
}
.notif-sub { color: var(--muted); font-size: .88rem; margin-top: 4px; }

.btn-markall {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1); border-radius: 12px;
    color: var(--text); font-size: .82rem; font-weight: 600; cursor: pointer; transition: .25s;
    text-decoration: none;
}
.btn-markall:hover { border-color: rgba(212,175,55,.3); color: var(--primary-lt); }

.notif-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 22px; overflow: hidden; margin-bottom: 0;
}

.notif-item {
    display: flex; gap: 14px; padding: 18px 22px;
    border-bottom: 1px solid rgba(255,255,255,.05); transition: .2s;
}
.notif-item:last-child { border-bottom: none; }
.notif-item.unread { background: rgba(212,175,55,.04); }
.notif-item:hover { background: rgba(255,255,255,.03); }

.notif-icon-box {
    width: 44px; height: 44px; border-radius: 14px;
    flex-shrink: 0; display: flex; align-items: center; justify-content: center;
}
.notif-icon-box.is-read  { background: rgba(255,255,255,.06); }
.notif-icon-box.is-unread { background: rgba(212,175,55,.12); }

.notif-body { flex: 1; min-width: 0; }
.notif-row  { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
.notif-name { font-size: .9rem; font-weight: 600; color: var(--text); }
.notif-name.bold { font-weight: 800; }
.notif-time { font-size: .75rem; color: var(--muted); white-space: nowrap; flex-shrink: 0; }
.notif-msg  { font-size: .84rem; color: var(--muted); margin-top: 4px; line-height: 1.5; }
.notif-link {
    display: inline-flex; align-items: center; gap: 5px;
    margin-top: 8px; font-size: .8rem; font-weight: 600;
    color: var(--primary); text-decoration: none;
}
.notif-link:hover { color: var(--primary-lt); }
.notif-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--primary); flex-shrink: 0; margin-top: 10px;
}

.notif-empty {
    padding: 60px 24px; text-align: center;
}
.notif-empty-icon {
    width: 68px; height: 68px; border-radius: 50%;
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;
}
.notif-empty-title { font-weight: 700; color: var(--text); margin-bottom: 8px; }
.notif-empty-text  { color: var(--muted); font-size: .88rem; }

.pagination { display: flex; gap: 6px; flex-wrap: wrap; padding: 14px 22px; }
.pagination .page-link {
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    color: var(--text); border-radius: 10px; padding: 6px 13px;
    font-size: .85rem; text-decoration: none; transition: .2s;
}
.pagination .page-link:hover,
.pagination .page-item.active .page-link { background: var(--gradient); border-color: transparent; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .35; pointer-events: none; }
</style>

<div class="notif-page">

    {{-- Header --}}
    <div class="notif-topbar">
        <div>
            <div class="notif-heading">
                <i class="fa-regular fa-bell" style="color:var(--primary);"></i>
                {{ __('messages.adm_notif_title') }}
                @if($unreadCount > 0)
                <span class="unread-chip">{{ $unreadCount }}</span>
                @endif
            </div>
            <p class="notif-sub">{{ __('messages.adm_notif_sub') }}</p>
        </div>

        @if($unreadCount > 0)
        <form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
            @csrf
            <button type="submit" class="btn-markall">
                <i class="fa-solid fa-check-double" style="color:var(--primary);"></i>
                {{ __('messages.clt_mark_all_read_btn') }}
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
    <div style="background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:14px;padding:14px 18px;color:#4ade80;font-size:.85rem;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Liste --}}
    <div class="notif-card">
        @if($notifications->isEmpty())
        <div class="notif-empty">
            <div class="notif-empty-icon">
                <i class="fa-regular fa-bell" style="font-size:1.8rem;color:var(--muted);"></i>
            </div>
            <div class="notif-empty-title">{{ __('messages.adm_no_notif_title') }}</div>
            <p class="notif-empty-text">{{ __('messages.adm_no_notif_text') }}</p>
        </div>
        @else
            @foreach($notifications as $notif)
            @php
                $data    = $notif->data;
                $isRead  = !is_null($notif->read_at);
                $icon    = $data['icon']    ?? 'fa-solid fa-bell';
                $color   = $data['color']   ?? '#D4AF37';
                $title   = $data['title']   ?? 'Notification';
                $message = $data['message'] ?? '';
                $link    = $data['link']    ?? null;
            @endphp
            <div class="notif-item {{ $isRead ? '' : 'unread' }}">
                <div class="notif-icon-box {{ $isRead ? 'is-read' : 'is-unread' }}">
                    <i class="{{ $icon }}" style="font-size:18px;color:{{ $isRead ? 'rgba(255,255,255,.3)' : $color }};"></i>
                </div>
                <div class="notif-body">
                    <div class="notif-row">
                        <div class="notif-name {{ $isRead ? '' : 'bold' }}">{{ $title }}</div>
                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                    @if($message)<div class="notif-msg">{{ $message }}</div>@endif
                    @if($link)
                    <a href="{{ $link }}" class="notif-link">
                        {{ __('messages.clt_see_details_link') }}
                        <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                    @endif
                </div>
                @if(!$isRead)<div class="notif-dot"></div>@endif
            </div>
            @endforeach

            @if($notifications->hasPages())
            <div>{{ $notifications->links() }}</div>
            @endif
        @endif
    </div>

</div>

@endsection

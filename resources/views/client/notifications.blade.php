@extends('layouts.client')

@section('title', __('messages.clt_notif_title'))
@section('page-title', __('messages.clt_notif_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.notif-wrap{max-width:760px;}

.notif-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:28px;}
.notif-title{font-size:1.7rem;font-weight:900;color:var(--text);display:flex;align-items:center;gap:12px;}
.unread-chip{display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:24px;background:var(--gradient);color:#fff;border-radius:999px;font-size:.7rem;font-weight:800;padding:0 6px;}
.notif-sub{color:var(--muted);font-size:.88rem;margin-top:4px;}

.btn-markall{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:var(--card);border:1px solid var(--card-border);border-radius:12px;color:var(--text);font-size:.82rem;font-weight:600;cursor:pointer;transition:.25s;}
.btn-markall:hover{border-color:rgba(233,30,140,.3);color:var(--pink-light);}

.notif-list{background:var(--card);border:1px solid var(--card-border);border-radius:24px;overflow:hidden;}

.notif-item{display:flex;gap:14px;padding:18px 22px;border-bottom:1px solid rgba(255,255,255,.05);transition:.2s;}
.notif-item:last-child{border-bottom:none;}
.notif-item.unread{background:rgba(233,30,140,.04);}
.notif-item:hover{background:rgba(255,255,255,.03);}

.notif-icon-box{width:44px;height:44px;border-radius:14px;flex-shrink:0;display:flex;align-items:center;justify-content:center;}
.notif-icon-box.read{background:rgba(255,255,255,.06);}
.notif-icon-box.unread{background:rgba(233,30,140,.12);}

.notif-body{flex:1;min-width:0;}
.notif-top-row{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;}
.notif-name{font-size:.9rem;font-weight:600;color:var(--text);}
.notif-name.bold{font-weight:800;}
.notif-time{font-size:.75rem;color:var(--muted);white-space:nowrap;flex-shrink:0;}
.notif-msg{font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.5;}
.notif-link{display:inline-flex;align-items:center;gap:5px;margin-top:8px;font-size:.8rem;font-weight:600;color:var(--pink);text-decoration:none;}
.notif-link:hover{color:var(--pink-light);}
.notif-dot{width:8px;height:8px;border-radius:50%;background:var(--pink);flex-shrink:0;margin-top:10px;}

.notif-empty{padding:60px 24px;text-align:center;}
.notif-empty-icon{width:68px;height:68px;border-radius:50%;background:rgba(255,255,255,.04);border:1px solid var(--card-border);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;}
.notif-empty-title{font-weight:700;color:var(--text);margin-bottom:8px;font-size:1rem;}
.notif-empty-text{color:var(--muted);font-size:.88rem;}

.prefs-card{margin-top:20px;background:var(--card);border:1px solid var(--card-border);border-radius:24px;padding:24px;}
.prefs-title{font-size:1rem;font-weight:700;color:var(--text);margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.prefs-title i{color:var(--pink);}
.pref-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.05);}
.pref-row:last-of-type{border-bottom:none;}
.pref-left{display:flex;align-items:center;gap:10px;}
.pref-left i{color:var(--muted);width:16px;text-align:center;}
.pref-label{font-size:.87rem;color:var(--text);}
.toggle{position:relative;display:inline-block;width:40px;height:22px;cursor:default;}
.toggle input{opacity:0;width:0;height:0;}
.toggle-track{position:absolute;inset:0;border-radius:999px;transition:.3s;}
.toggle-track.on{background:var(--gradient);}
.toggle-track.off{background:rgba(255,255,255,.12);}
.toggle-thumb{position:absolute;width:16px;height:16px;border-radius:50%;background:#fff;top:3px;transition:.3s;}
.toggle-thumb.on{left:21px;}
.toggle-thumb.off{left:3px;}

.prefs-note{font-size:.78rem;color:var(--muted);margin-top:14px;}

.pagination{display:flex;gap:6px;flex-wrap:wrap;padding:14px 22px;}
.pagination .page-link{background:var(--card);border:1px solid var(--card-border);color:var(--text);border-radius:10px;padding:6px 13px;font-size:.85rem;text-decoration:none;transition:.2s;}
.pagination .page-link:hover,.pagination .page-item.active .page-link{background:var(--gradient);border-color:transparent;color:#fff;}
.pagination .page-item.disabled .page-link{opacity:.35;pointer-events:none;}

@media(max-width:540px){.notif-header{flex-direction:column;align-items:flex-start;}}
</style>

<script>
function togglePref(label, key) {
    const inp   = document.getElementById('inp-' + key);
    const track = document.getElementById('track-' + key);
    const thumb = document.getElementById('thumb-' + key);
    const isOn  = inp.value === '1';
    inp.value   = isOn ? '0' : '1';
    track.className = 'toggle-track ' + (isOn ? 'off' : 'on');
    thumb.className = 'toggle-thumb ' + (isOn ? 'off' : 'on');
}
</script>

<div class="notif-wrap">

    <div class="notif-header">
        <div>
            <h2 class="notif-title">
                {{ __('messages.clt_notif_title') }}
                @if($unreadCount > 0)
                <span class="unread-chip">{{ $unreadCount }}</span>
                @endif
            </h2>
            <p class="notif-sub">{{ __('messages.clt_notif_sub') }}</p>
        </div>
        @if($unreadCount > 0)
        <form method="POST" action="{{ route('client.notifications.markAllRead') }}">
            @csrf
            <button type="submit" class="btn-markall">
                <i class="fa-solid fa-check-double" style="color:var(--pink);"></i> {{ __('messages.clt_mark_all_read_btn') }}
            </button>
        </form>
        @endif
    </div>

    <div class="notif-list">
        @if($notifications->isEmpty())
        <div class="notif-empty">
            <div class="notif-empty-icon">
                <i class="fa-regular fa-bell" style="font-size:1.8rem;color:var(--muted);"></i>
            </div>
            <div class="notif-empty-title">{{ __('messages.clt_no_notif_title') }}</div>
            <p class="notif-empty-text">{{ __('messages.clt_no_notif_text') }}</p>
        </div>
        @else
            @foreach($notifications as $notif)
            @php
                $data    = $notif->data;
                $isRead  = !is_null($notif->read_at);
                $icon    = $data['icon']    ?? 'fa-solid fa-bell';
                $color   = $data['color']   ?? '#e91e8c';
                $title   = $data['title']   ?? 'Notification';
                $message = $data['message'] ?? '';
                $link    = $data['link']    ?? null;
            @endphp
            <div class="notif-item {{ $isRead ? '' : 'unread' }}">
                <div class="notif-icon-box {{ $isRead ? 'read' : 'unread' }}">
                    <i class="{{ $icon }}" style="font-size:18px;color:{{ $isRead ? 'rgba(255,255,255,.3)' : $color }};"></i>
                </div>
                <div class="notif-body">
                    <div class="notif-top-row">
                        <div class="notif-name {{ $isRead ? '' : 'bold' }}">{{ $title }}</div>
                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                    @if($message)<div class="notif-msg">{{ $message }}</div>@endif
                    @if($link)<a href="{{ $link }}" class="notif-link">{{ __('messages.clt_see_details_link') }} <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></a>@endif
                </div>
                @if(!$isRead)<div class="notif-dot"></div>@endif
            </div>
            @endforeach

            @if($notifications->hasPages())
            <div>{{ $notifications->links() }}</div>
            @endif
        @endif
    </div>

    <div class="prefs-card">
        <div class="prefs-title"><i class="fa-solid fa-sliders"></i> {{ __('messages.clt_pref_title') }}</div>

        @if(session('success'))
        <div style="background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:12px;padding:12px 16px;color:#4ade80;font-size:.85rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('client.notifications.preferences') }}" id="prefs-form">
            @csrf
            @php
                $p = $notifPrefs ?? [];
                $items = [
                    ['key'=>'notif_appointments','icon'=>'fa-regular fa-calendar-check','label'=>__('messages.clt_pref_appointments'),'default'=>true],
                    ['key'=>'notif_reminders',   'icon'=>'fa-solid fa-bell',            'label'=>__('messages.clt_pref_reminders'),   'default'=>true],
                    ['key'=>'notif_promotions',  'icon'=>'fa-solid fa-tag',             'label'=>__('messages.clt_pref_promotions'),  'default'=>false],
                ];
            @endphp

            @foreach($items as $item)
            @php $checked = array_key_exists($item['key'], $p) ? (bool)$p[$item['key']] : $item['default']; @endphp
            <div class="pref-row">
                <div class="pref-left">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="pref-label">{{ $item['label'] }}</span>
                </div>
                <label class="toggle" style="cursor:pointer;" onclick="togglePref(this, '{{ $item['key'] }}')">
                    <input type="hidden" name="{{ $item['key'] }}" value="{{ $checked ? '1' : '0' }}" id="inp-{{ $item['key'] }}">
                    <span class="toggle-track {{ $checked ? 'on' : 'off' }}" id="track-{{ $item['key'] }}">
                        <span class="toggle-thumb {{ $checked ? 'on' : 'off' }}" id="thumb-{{ $item['key'] }}"></span>
                    </span>
                </label>
            </div>
            @endforeach

            <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,.05);">
                <button type="submit" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:var(--gradient);border:none;border-radius:13px;color:#fff;font-size:.88rem;font-weight:700;cursor:pointer;box-shadow:0 6px 16px rgba(233,30,140,.3);transition:.25s;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                    <i class="fa-solid fa-floppy-disk"></i> {{ __('messages.clt_save_prefs') }}
                </button>
            </div>
        </form>
    </div>

</div>

@endsection

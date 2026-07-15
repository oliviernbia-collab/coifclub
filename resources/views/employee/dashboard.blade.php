@extends('layouts.employee')

@section('title', __('messages.employee_dashboard'))

@section('content')

<style>
/* ── Grilles ── */
.emp-stats  { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
.emp-grid2  { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
.emp-grid3  { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }

@media(max-width:900px) {
    .emp-stats { grid-template-columns:repeat(2,1fr); }
    .emp-grid2 { grid-template-columns:1fr !important; }
    .emp-grid3 { grid-template-columns:1fr; }
}
@media(max-width:640px) {
    .emp-slide-deco    { display:none; }
    .emp-slide-content { padding:18px 20px; }
    .emp-slide-title   { font-size:1.35rem; }
}
@media(max-width:500px) { .emp-stats { grid-template-columns:1fr 1fr; } }
@media(max-width:400px) {
    .emp-stats        { grid-template-columns:1fr; }
    .emp-slide-content { padding:14px 16px; }
    .emp-slide-title  { font-size:1.1rem; }
}

/* ── Slideshow ── */
.emp-slideshow {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 24px;
    height: 160px;
    border: 1px solid rgba(233,30,140,.15);
}
.emp-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1.2s ease;
}
.emp-slide.active { opacity: 1; }
.emp-slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(26,18,48,.88) 0%, rgba(14,10,28,.6) 60%, rgba(233,30,140,.12) 100%);
}
.emp-slide-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 26px 32px;
    z-index: 2;
}
.emp-slide-eyebrow {
    font-size: .72rem; color: rgba(255,255,255,.6);
    margin-bottom: 6px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .08em;
}
.emp-slide-title {
    font-size: 1.7rem; font-weight: 800;
    color: #fff; margin: 0 0 4px;
    line-height: 1.1;
}
.emp-slide-title span {
    background: linear-gradient(135deg, #e91e8c, #ff6ab4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.emp-slide-sub {
    color: rgba(255,255,255,.6); font-size: .88rem;
    margin: 0; font-weight: 500;
}
.emp-slide-dots {
    position: absolute; bottom: 14px; left: 32px;
    display: flex; gap: 6px; z-index: 3;
}
.emp-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(255,255,255,.35); transition: all .3s;
}
.emp-dot.active { background: #e91e8c; width: 18px; border-radius: 3px; }
.emp-slide-deco {
    position: absolute; right: 0; top: 0; bottom: 0;
    width: 240px; overflow: hidden; pointer-events: none; z-index: 1;
}
.emp-slide-deco-circle {
    position: absolute; right: -20px; top: -20px;
    width: 200px; height: 180px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(233,30,140,.18), rgba(255,106,180,.1));
}
.emp-slide-deco i {
    position: absolute; right: 40px; top: 50%;
    transform: translateY(-50%);
    font-size: 4rem; color: rgba(233,30,140,.18);
}
</style>

{{-- ── Slideshow Hero ── --}}
<div class="emp-slideshow" id="empSlideshow">
    <div class="emp-slide active" style="background-image:url('{{ asset('images/C34.jpg') }}')">
        <div class="emp-slide-overlay"></div>
        <div class="emp-slide-content">
            <div class="emp-slide-eyebrow">{{ __('messages.stylist_space') }}</div>
            <h1 class="emp-slide-title">
                {{ __('messages.hello') }}, <span>{{ auth()->user()->name }}</span>
            </h1>
            <p class="emp-slide-sub">{{ __('messages.dashboard_summary') }}</p>
        </div>
        <div class="emp-slide-deco">
            <div class="emp-slide-deco-circle"></div>
            <i class="fa-solid fa-scissors"></i>
        </div>
    </div>
    <div class="emp-slide" style="background-image:url('{{ asset('images/C44.jpg') }}')">
        <div class="emp-slide-overlay"></div>
        <div class="emp-slide-content">
            <div class="emp-slide-eyebrow">{{ __('messages.my_space') }}</div>
            <h1 class="emp-slide-title">
                {{ __('messages.today_reservations') }}
            </h1>
            <p class="emp-slide-sub">{{ $stats['today'] ?? 0 }} {{ __('messages.reservations') }}</p>
        </div>
        <div class="emp-slide-deco">
            <div class="emp-slide-deco-circle"></div>
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>
    <div class="emp-slide" style="background-image:url('{{ asset('images/C45.jpg') }}')">
        <div class="emp-slide-overlay"></div>
        <div class="emp-slide-content">
            <div class="emp-slide-eyebrow">{{ __('messages.statistics') }}</div>
            <h1 class="emp-slide-title">
                {{ $stats['clients'] ?? 0 }} <span>{{ __('messages.clients') }}</span>
            </h1>
            <p class="emp-slide-sub">{{ __('messages.unique_clients') }}</p>
        </div>
        <div class="emp-slide-deco">
            <div class="emp-slide-deco-circle"></div>
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
    <div class="emp-slide-dots" id="empDots">
        <div class="emp-dot active"></div>
        <div class="emp-dot"></div>
        <div class="emp-dot"></div>
    </div>
</div>

{{-- ── Stats ── --}}
<div class="emp-stats">
    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(107,33,168,.3);">
            <i class="fa-solid fa-calendar-day" style="color:#c084fc;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['today'] ?? 0 }}</div>
            <div class="emp-stat-lbl">{{ __('messages.today_label') }}</div>
            <div class="emp-stat-sub">{{ __('messages.reservations') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(37,99,235,.3);">
            <i class="fa-solid fa-calendar-week" style="color:#60a5fa;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['this_week'] ?? 0 }}</div>
            <div class="emp-stat-lbl">{{ __('messages.week_label') }}</div>
            <div class="emp-stat-sub">{{ __('messages.reservations') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(233,30,140,.25);">
            <i class="fa-solid fa-users" style="color:#ff6ab4;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['clients'] ?? 0 }}</div>
            <div class="emp-stat-lbl">{{ __('messages.clients') }}</div>
            <div class="emp-stat-sub">{{ __('messages.unique_clients') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(5,150,105,.3);">
            <i class="fa-solid fa-wallet" style="color:#34d399;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num" style="font-size:1.1rem;">{{ $stats['revenue'] ?? '0' }}</div>
            <div class="emp-stat-lbl">{{ __('messages.revenues') }}</div>
            <div class="emp-stat-sub">{{ __('messages.fcfa_estimated') }}</div>
        </div>
    </div>
</div>

{{-- ── Réservations d'aujourd'hui ── --}}
<div style="margin-bottom:20px;">
    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-calendar-check" style="color:#e91e8c;margin-right:8px;"></i>
                {{ __('messages.today_reservations') }}
            </h3>
            <a href="{{ route('employee.reservations') }}" class="emp-link">{{ __('messages.view_all') }}</a>
        </div>

        @forelse($todayReservations as $r)
        @php
            $rc = match($r->status ?? '') {
                'confirmed' => ['bg'=>'rgba(74,222,128,.15)','txt'=>'#4ade80','label'=> __('messages.status_confirmed')],
                'done'      => ['bg'=>'rgba(147,197,253,.15)','txt'=>'#93c5fd','label'=> __('messages.status_done')],
                'pending'   => ['bg'=>'rgba(251,191,36,.15)','txt'=>'#fbbf24','label'=> __('messages.status_pending')],
                'cancelled' => ['bg'=>'rgba(248,113,113,.15)','txt'=>'#f87171','label'=> __('messages.status_cancelled')],
                default     => ['bg'=>'rgba(233,30,140,.12)','txt'=>'#ff6ab4','label'=> ucfirst(str_replace('_',' ',$r->status ?? ''))],
            };
        @endphp
        <div class="emp-plan-dark">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="emp-icon-box-dark">
                    <i class="fa-solid fa-scissors" style="color:#e91e8c;font-size:15px;"></i>
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff;">{{ $r->service->name ?? 'Service' }}</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.45);margin-top:2px;">
                        {{ substr($r->start_time, 0, 5) }} · {{ $r->client->name ?? '-' }}
                    </div>
                    @if($r->client->phone ?? null)
                    <div style="font-size:.72rem;color:rgba(255,255,255,.35);">
                        <i class="fa-solid fa-phone" style="margin-right:3px;"></i>{{ $r->client->phone }}
                    </div>
                    @endif
                </div>
            </div>
            <span style="display:inline-block;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:999px;background:{{ $rc['bg'] }};color:{{ $rc['txt'] }};">{{ $rc['label'] }}</span>
        </div>
        @empty
        <div class="emp-empty-dark">
            <i class="fa-regular fa-calendar-xmark"></i>
            {{ __('messages.no_reservations_today') }}
        </div>
        @endforelse
    </div>
</div>

{{-- ── Planning à venir + Actions rapides ── --}}
<div class="emp-grid2" style="grid-template-columns:3fr 2fr;">

    {{-- Planning --}}
    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-calendar-days" style="color:#e91e8c;margin-right:8px;"></i>
                {{ __('messages.upcoming_planning') }}
            </h3>
            @if($nextReservation)
            <span class="emp-badge-dark">{{ __('messages.next_badge') }}</span>
            @endif
        </div>

        <div style="max-height:320px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(233,30,140,.25) transparent;">
        @forelse($upcomingReservations as $r)
        @php
            $rc2 = match($r->status ?? '') {
                'confirmed' => ['bg'=>'rgba(74,222,128,.15)','txt'=>'#4ade80'],
                'pending'   => ['bg'=>'rgba(251,191,36,.15)','txt'=>'#fbbf24'],
                'cancelled' => ['bg'=>'rgba(248,113,113,.15)','txt'=>'#f87171'],
                default     => ['bg'=>'rgba(233,30,140,.12)','txt'=>'#ff6ab4'],
            };
        @endphp
        <div class="emp-plan-dark">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="emp-icon-box-dark">
                    <i class="fa-solid fa-scissors" style="color:#e91e8c;font-size:15px;"></i>
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff;">{{ $r->service->name ?? 'Service' }}</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.45);margin-top:2px;">
                        <i class="fa-regular fa-calendar" style="margin-right:3px;"></i>{{ $r->date->format('d/m/Y') }}
                        <span style="margin:0 4px;">·</span>
                        <i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ substr($r->start_time, 0, 5) }}
                    </div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.4);margin-top:2px;">
                        {{ __('messages.col_client') }} : {{ $r->client->name ?? '-' }}
                    </div>
                </div>
            </div>
            <span style="display:inline-block;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:999px;background:{{ $rc2['bg'] }};color:{{ $rc2['txt'] }};">
                {{ ucfirst(str_replace('_', ' ', $r->status ?? '')) }}
            </span>
        </div>
        @empty
        <div class="emp-empty-dark">
            <i class="fa-solid fa-calendar-check"></i>
            {{ __('messages.no_scheduled_reservations') }}
        </div>
        @endforelse
        </div>
    </div>

    {{-- Résumé + Actions rapides --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        @if($nextReservation)
        <div class="emp-card-dark">
            <div class="emp-card-head">
                <h3 class="emp-card-title">
                    <i class="fa-solid fa-clock-rotate-left" style="color:#e91e8c;margin-right:8px;"></i>
                    {{ __('messages.next_appointment') }}
                </h3>
            </div>
            <div class="emp-card-body">
                <div style="font-size:.95rem;font-weight:700;color:#fff;margin-bottom:10px;">{{ $nextReservation->service->name ?? 'Service' }}</div>
                <div style="display:flex;flex-direction:column;gap:7px;">
                    <div style="font-size:.82rem;color:rgba(255,255,255,.6);display:flex;align-items:center;gap:8px;">
                        <i class="fa-regular fa-calendar" style="color:#e91e8c;width:14px;"></i>
                        {{ $nextReservation->date->format('d/m/Y') }} à {{ substr($nextReservation->start_time, 0, 5) }}
                    </div>
                    <div style="font-size:.82rem;color:rgba(255,255,255,.6);display:flex;align-items:center;gap:8px;">
                        <i class="fa-regular fa-user" style="color:#e91e8c;width:14px;"></i>
                        {{ $nextReservation->client->name ?? '-' }}
                    </div>
                    @if($nextReservation->salon)
                    <div style="font-size:.82rem;color:rgba(255,255,255,.6);display:flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-location-dot" style="color:#e91e8c;width:14px;"></i>
                        {{ $nextReservation->salon->name ?? '-' }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div class="emp-card-dark">
            <div class="emp-card-head">
                <h3 class="emp-card-title">
                    <i class="fa-solid fa-bolt" style="color:#e91e8c;margin-right:8px;"></i>
                    {{ __('messages.quick_actions') }}
                </h3>
            </div>
            <div class="emp-card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <a href="{{ route('employee.profile') }}" class="emp-quick-dark">
                        <i class="fa-regular fa-user" style="color:#e91e8c;font-size:1.3rem;"></i>
                        <span>{{ __('messages.my_profile') }}</span>
                    </a>
                    <a href="{{ route('employee.services') }}" class="emp-quick-dark">
                        <i class="fa-solid fa-scissors" style="color:#e91e8c;font-size:1.3rem;"></i>
                        <span>{{ __('messages.services') }}</span>
                    </a>
                    <a href="{{ route('employee.reservations') }}" class="emp-quick-dark">
                        <i class="fa-solid fa-calendar-days" style="color:#e91e8c;font-size:1.3rem;"></i>
                        <span>{{ __('messages.reservations') }}</span>
                    </a>
                    <a href="{{ route('employee.availability') }}" class="emp-quick-dark">
                        <i class="fa-solid fa-clock" style="color:#e91e8c;font-size:1.3rem;"></i>
                        <span>{{ __('messages.availability') }}</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── Clientes récentes + Prestations ── --}}
<div class="emp-grid3">

    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-users" style="color:#e91e8c;margin-right:8px;"></i>
                {{ __('messages.recent_clients') }}
            </h3>
        </div>
        @if($recentClients->isEmpty())
        <div class="emp-empty-dark">
            <i class="fa-regular fa-user"></i>
            {{ __('messages.no_recent_clients') }}
        </div>
        @else
        @foreach($recentClients as $client)
        <div class="emp-plan-dark">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#e91e8c,#c0156d);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;">
                    {{ strtoupper(substr($client->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff;">{{ $client->name }}</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.4);margin-top:2px;">{{ $client->email }}</div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-briefcase" style="color:#e91e8c;margin-right:8px;"></i>
                {{ __('messages.my_services_title') }}
            </h3>
            <a href="{{ route('employee.services') }}" class="emp-link">{{ __('messages.manage_link') }}</a>
        </div>
        @if($services->isEmpty())
        <div class="emp-empty-dark">
            <i class="fa-solid fa-box-open"></i>
            {{ __('messages.no_services_defined') }}
        </div>
        @else
        @foreach($services as $s)
        <div class="emp-plan-dark">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="emp-icon-box-dark">
                    <i class="fa-solid fa-scissors" style="color:#e91e8c;font-size:14px;"></i>
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff;">{{ $s->name }}</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.4);margin-top:2px;">{{ $s->bookings_count }} {{ __('messages.bookings_count_label') }}</div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

</div>

{{-- ── Horaires disponibles ── --}}
<div class="emp-card-dark" style="margin-bottom:8px;">
    <div class="emp-card-head">
        <h3 class="emp-card-title">
            <i class="fa-solid fa-clock" style="color:#e91e8c;margin-right:8px;"></i>
            {{ __('messages.my_hours') }}
        </h3>
        <a href="{{ route('employee.availability') }}" class="emp-link">{{ __('messages.edit_link') }}</a>
    </div>
    <div class="emp-card-body">
        @if($availabilities->isEmpty())
        <div class="emp-empty-dark" style="padding:16px;">
            <i class="fa-regular fa-clock" style="font-size:1.4rem;"></i>
            {{ __('messages.no_availability_defined') }}
        </div>
        @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;">
            @foreach($availabilities as $av)
            <div class="emp-avail-dark">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                    <div style="font-size:.88rem;font-weight:700;color:#fff;text-transform:capitalize;">{{ $av->day_of_week }}</div>
                    <span style="display:inline-block;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:999px;background:{{ $av->is_active ? 'rgba(74,222,128,.15)' : 'rgba(255,255,255,.07)' }};color:{{ $av->is_active ? '#4ade80' : 'rgba(255,255,255,.4)' }};">
                        {{ $av->is_active ? __('messages.active_label') : __('messages.rest_day') }}
                    </span>
                </div>
                <div style="font-size:.78rem;color:rgba(255,255,255,.45);">{{ $av->start_time }} – {{ $av->end_time }}</div>
                <div style="font-size:.75rem;color:rgba(255,255,255,.35);margin-top:2px;">{{ __('messages.slots_label') }} : {{ $av->slot_duration ?? 30 }} min</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const slides = document.querySelectorAll('#empSlideshow .emp-slide');
    const dots   = document.querySelectorAll('#empDots .emp-dot');
    let current  = 0;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    setInterval(() => goTo(current + 1), 4000);

    dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));
})();
</script>
@endpush

@extends('layouts.employee')

@section('title', __('messages.my_availability'))

@section('content')

<style>
/* ── Header ── */
.availability-header { display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap; margin-bottom:28px; }
.page-title-gradient { font-size:2rem; font-weight:900; color:#fff; margin-bottom:8px; line-height:1.1; }
.page-title-gradient span { background:linear-gradient(135deg,#e91e8c,#ff6ab4); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
.page-subtitle-mod { color:rgba(255,255,255,.45); font-size:1rem; font-weight:500; }

/* ── Grid ── */
.availability-grid { display:grid; grid-template-columns:1.1fr .9fr; gap:24px; align-items:start; }

/* ── Cards ── */
.modern-card { background:rgba(255,255,255,.04); border-radius:24px; padding:28px; border:1px solid rgba(255,255,255,.08); box-shadow:0 4px 24px rgba(0,0,0,.25); position:relative; overflow:hidden; }
.modern-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#e91e8c,#ff6ab4); }
.card-header-mod { display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; gap:15px; flex-wrap:wrap; }
.card-title-mod { font-size:1.15rem; font-weight:700; color:#fff !important; }
.card-badge-dark { padding:8px 14px; border-radius:999px; background:rgba(233,30,140,.1); color:#ff6ab4; font-size:.78rem; font-weight:700; border:1px solid rgba(233,30,140,.2); }

/* ── Day item ── */
.day-item { padding:20px 0; border-bottom:1px solid rgba(255,255,255,.06); }
.day-header { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:16px; flex-wrap:wrap; }
.day-left { display:flex; align-items:center; gap:15px; }
.day-name { font-size:1rem; font-weight:700; text-transform:capitalize; color:#fff; }
.status-pill { padding:6px 14px; border-radius:999px; font-size:.74rem; font-weight:700; display:none; }
.status-active { background:rgba(74,222,128,.12); color:#4ade80; border:1px solid rgba(74,222,128,.2); }
.status-rest { background:rgba(255,255,255,.06); color:rgba(255,255,255,.4); }
.day-item.active .status-active { display:inline-flex; }
.day-item.active .status-rest { display:none; }
.day-item .status-rest { display:inline-flex; }

/* ── Toggle ── */
.toggle-wrapper { position:relative; cursor:pointer; }
.toggle-input { display:none; }
.toggle-switch { width:52px; height:28px; border-radius:999px; background:rgba(255,255,255,.1); position:relative; transition:.3s ease; border:1px solid rgba(255,255,255,.15); }
.toggle-switch::before { content:''; position:absolute; width:22px; height:22px; border-radius:50%; background:rgba(255,255,255,.7); top:2px; left:2px; transition:.3s ease; box-shadow:0 2px 8px rgba(0,0,0,.2); }
.toggle-switch.active { background:rgba(74,222,128,.3); border-color:rgba(74,222,128,.4); }
.toggle-switch.active::before { left:26px; background:#4ade80; }

/* ── Form ── */
.time-grid { display:none; grid-template-columns:repeat(3,1fr); gap:14px; }
.day-item.active .time-grid { display:grid; }
.form-group-mod { display:flex; flex-direction:column; gap:6px; }
.form-label-mod { font-size:.8rem; font-weight:700; color:rgba(255,255,255,.5); }
.form-control-mod { height:48px; border-radius:14px; border:1px solid rgba(255,255,255,.12); padding:0 14px; font-size:.9rem; font-weight:600; transition:.3s ease; background:rgba(255,255,255,.06); color:#fff; outline:none; }
.form-control-mod:focus { border-color:rgba(233,30,140,.4); box-shadow:0 0 0 3px rgba(233,30,140,.1); }

/* ── Save btn ── */
.save-btn { width:100%; height:52px; border:none; border-radius:16px; background:linear-gradient(135deg,#e91e8c,#c0156d); color:#fff; font-size:1rem; font-weight:700; cursor:pointer; transition:.35s ease; margin-top:26px; box-shadow:0 8px 20px rgba(233,30,140,.25); }
.save-btn:hover { transform:translateY(-3px); box-shadow:0 14px 30px rgba(233,30,140,.35); }

/* ── Slot preview ── */
.slot-preview { margin-top:14px; padding:14px; border-radius:14px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); }
.slot-preview-title { font-size:.82rem; font-weight:700; color:rgba(255,255,255,.6); margin-bottom:10px; }
.slot-preview-list { display:flex; flex-wrap:wrap; gap:8px; }
.slot-preview-badge { padding:6px 12px; border-radius:999px; background:rgba(233,30,140,.1); color:#ff6ab4; border:1px solid rgba(233,30,140,.2); font-size:.78rem; font-weight:700; }
.slot-preview-empty { color:rgba(255,255,255,.3); font-size:.82rem; }

/* ── Slots ── */
.slots-wrapper { display:flex; flex-wrap:wrap; gap:10px; }
.slot-badge { padding:8px 16px; border-radius:999px; background:rgba(74,222,128,.1); color:#4ade80; border:1px solid rgba(74,222,128,.2); font-size:.82rem; font-weight:700; transition:.3s ease; }
.slot-badge:hover { transform:translateY(-2px); }

/* ── Booked ── */
.booked-item { display:flex; align-items:center; justify-content:space-between; padding:14px; border-radius:14px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); }

/* ── Empty ── */
.empty-state-dark { text-align:center; padding:24px; color:rgba(255,255,255,.3); }
.empty-state-dark i { font-size:2.5rem; margin-bottom:12px; display:block; opacity:.6; }

/* ── Tips ── */
.tip-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid rgba(255,255,255,.06); }
.tip-item:last-child { border-bottom:none; }
.tip-icon { width:40px; height:40px; border-radius:13px; background:rgba(74,222,128,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(74,222,128,.15); }
.tip-icon i { color:#4ade80; font-size:1rem; }
.tip-text { color:rgba(255,255,255,.5); line-height:1.7; font-size:.86rem; }

/* ── Responsive ── */
@media(max-width:1100px) { .availability-grid { grid-template-columns:1fr; } }
@media(max-width:768px) {
    .page-title-gradient { font-size:1.5rem; }
    .availability-header { flex-direction:column; align-items:stretch; gap:14px; margin-bottom:18px; }
    .modern-card { padding:18px; }
    .day-header { flex-direction:column; align-items:flex-start; gap:10px; }
    .time-grid { grid-template-columns:1fr; gap:10px; }
}
</style>

<div>

    {{-- HEADER --}}
    <div class="availability-header">
        <div>
            <h1 class="page-title-gradient"><span>{{ __('messages.my_availability') }}</span></h1>
            <div class="page-subtitle-mod">{{ __('messages.define_work_hours') }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- GRID --}}
    <div class="availability-grid">

        {{-- LEFT — Weekly form --}}
        <div class="modern-card">
            <div class="card-header-mod">
                <div class="card-title-mod">{{ __('messages.weekly_planning') }}</div>
                <div class="card-badge-dark">{{ __('messages.work_hours_label') }}</div>
            </div>

            <form action="{{ route('employee.availability.save') }}" method="POST" novalidate>
                @csrf

                @foreach($days as $day)
                @php
                    $a = $availabilities[$day] ?? null;
                    $dayActive = old('days.' . $day . '.active', $a?->is_active ? '1' : '0') == '1';
                    $startValue = old('days.' . $day . '.start');
                    $endValue   = old('days.' . $day . '.end');
                    if ($startValue === null) $startValue = $a?->start_time ? \Carbon\Carbon::parse($a->start_time)->format('H:i') : '08:00';
                    if ($endValue   === null) $endValue   = $a?->end_time   ? \Carbon\Carbon::parse($a->end_time)->format('H:i')   : '18:00';
                    $slotValue = old('days.' . $day . '.slot', $a?->slot_duration ?? 30);
                @endphp

                <div class="day-item{{ $dayActive ? ' active' : '' }}" data-day="{{ $day }}">
                    <div class="day-header">
                        <div class="day-left">
                            <label class="toggle-wrapper">
                                <input type="hidden" name="days[{{ $day }}][active]" value="0">
                                <input type="checkbox" class="toggle-input" name="days[{{ $day }}][active]" value="1" {{ $dayActive ? 'checked' : '' }}>
                                <div class="toggle-switch{{ $dayActive ? ' active' : '' }}"></div>
                            </label>
                            <div class="day-name">{{ $day }}</div>
                        </div>
                        <div>
                            <span class="status-pill status-active">{{ __('messages.available_label') }}</span>
                            <span class="status-pill status-rest">{{ __('messages.rest_day_label') }}</span>
                        </div>
                    </div>

                    <div class="time-grid">
                        <div class="form-group-mod">
                            <label class="form-label-mod">{{ __('messages.start_time_label') }}</label>
                            <input type="time" name="days[{{ $day }}][start]" class="form-control-mod" value="{{ $startValue }}" {{ $dayActive ? '' : 'disabled' }} required>
                        </div>
                        <div class="form-group-mod">
                            <label class="form-label-mod">{{ __('messages.end_time_label') }}</label>
                            <input type="time" name="days[{{ $day }}][end]" class="form-control-mod" value="{{ $endValue }}" {{ $dayActive ? '' : 'disabled' }} required>
                        </div>
                        <div class="form-group-mod">
                            <label class="form-label-mod">{{ __('messages.slot_duration_label') }}</label>
                            <select name="days[{{ $day }}][slot]" class="form-control-mod" {{ $dayActive ? '' : 'disabled' }}>
                                @foreach([30,45,60,90,120] as $min)
                                <option value="{{ $min }}" {{ $slotValue == $min ? 'selected' : '' }}>{{ $min }} min</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="slot-preview">
                        <div class="slot-preview-title">{{ __('messages.slot_preview_label') }}</div>
                        <div class="slot-preview-list"></div>
                    </div>
                </div>
                @endforeach

                <button type="submit" class="save-btn">
                    <i class="bi bi-floppy me-2"></i>
                    {{ __('messages.save_planning') }}
                </button>
            </form>
        </div>

        {{-- RIGHT — Info panels --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- Available slots today --}}
            <div class="modern-card">
                <div class="card-header-mod">
                    <div class="card-title-mod">{{ __('messages.available_slots_today') }}</div>
                </div>
                @php $slots = auth()->user()->employee->getAvailableSlots(now()->toDateString()); @endphp
                @if(count($slots) > 0)
                <div class="slots-wrapper">
                    @foreach($slots as $slot)
                    <div class="slot-badge">{{ $slot }}</div>
                    @endforeach
                </div>
                @else
                <div class="empty-state-dark">
                    <i class="bi bi-calendar-x"></i>
                    {{ __('messages.no_slots_today') }}
                </div>
                @endif
            </div>

            {{-- Booked slots today --}}
            <div class="modern-card">
                <div class="card-header-mod">
                    <div class="card-title-mod">{{ __('messages.booked_slots_today') }}</div>
                    <div class="card-badge-dark">{{ __('messages.reservations') }}</div>
                </div>
                @php
                    $today = now()->toDateString();
                    $bookedReservations = auth()->user()->employee->reservations()
                        ->where('date', $today)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->with('client', 'service')
                        ->orderBy('start_time')
                        ->get();
                @endphp
                @if($bookedReservations->count() > 0)
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($bookedReservations as $reservation)
                    <div class="booked-item">
                        <div style="display:flex;flex-direction:column;gap:3px;">
                            <div style="font-weight:700;color:#fff;font-size:.88rem;">{{ $reservation->start_time }} – {{ $reservation->service->name ?? 'Service' }}</div>
                            <div style="color:rgba(255,255,255,.45);font-size:.78rem;">{{ $reservation->client->name ?? 'Client' }}</div>
                        </div>
                        <span style="padding:5px 11px;border-radius:999px;background:{{ $reservation->status === 'confirmed' ? 'rgba(74,222,128,.12)' : 'rgba(251,191,36,.1)' }};color:{{ $reservation->status === 'confirmed' ? '#4ade80' : '#fbbf24' }};font-size:.7rem;font-weight:700;">
                            {{ $reservation->status === 'confirmed' ? __('messages.confirm_status') : __('messages.pending_status') }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state-dark">
                    <i class="bi bi-calendar-check"></i>
                    {{ __('messages.no_booked_slots') }}
                </div>
                @endif
            </div>

            {{-- Upcoming reservations this week --}}
            <div class="modern-card">
                <div class="card-header-mod">
                    <div class="card-title-mod">{{ __('messages.upcoming_reservations_label') }}</div>
                    <div class="card-badge-dark">{{ __('messages.this_week_label') }}</div>
                </div>
                @php
                    $nextWeek = now()->addDays(7)->toDateString();
                    $upcomingReservations = auth()->user()->employee->reservations()
                        ->where('date', '>', now()->toDateString())
                        ->where('date', '<=', $nextWeek)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->with('client', 'service')
                        ->orderBy('date')->orderBy('start_time')
                        ->limit(10)->get()->groupBy('date');
                @endphp
                @if($upcomingReservations->count() > 0)
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach($upcomingReservations as $date => $reservations)
                    <div>
                        <div style="font-weight:700;color:#fff;margin-bottom:8px;font-size:.88rem;">
                            {{ \Carbon\Carbon::parse($date)->locale(app()->getLocale())->isoFormat('dddd D MMMM') }}
                        </div>
                        <div style="display:flex;flex-direction:column;gap:7px;">
                            @foreach($reservations as $reservation)
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);">
                                <div>
                                    <div style="font-weight:600;color:#fff;font-size:.84rem;">{{ $reservation->start_time }} – {{ $reservation->service->name ?? 'Service' }}</div>
                                    <div style="color:rgba(255,255,255,.4);font-size:.74rem;">{{ $reservation->client->name ?? 'Client' }}</div>
                                </div>
                                <span style="padding:4px 9px;border-radius:999px;background:{{ $reservation->status === 'confirmed' ? 'rgba(74,222,128,.12)' : 'rgba(251,191,36,.1)' }};color:{{ $reservation->status === 'confirmed' ? '#4ade80' : '#fbbf24' }};font-size:.68rem;font-weight:700;">
                                    {{ $reservation->status === 'confirmed' ? __('messages.confirm_status') : __('messages.pending_status') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state-dark">
                    <i class="bi bi-calendar-plus"></i>
                    {{ __('messages.no_upcoming_this_week') }}
                </div>
                @endif
            </div>

            {{-- Tips --}}
            <div class="modern-card">
                <div class="card-header-mod">
                    <div class="card-title-mod">{{ __('messages.tips_info') }}</div>
                </div>
                @foreach([
                    ['icon'=>'clock','text'=> __('messages.tip_slots_auto')],
                    ['icon'=>'calendar-x','text'=> __('messages.tip_absence')],
                    ['icon'=>'people','text'=> __('messages.tip_clients_see')],
                ] as $tip)
                <div class="tip-item">
                    <div class="tip-icon"><i class="bi bi-{{ $tip['icon'] }}"></i></div>
                    <div class="tip-text">{{ $tip['text'] }}</div>
                </div>
                @endforeach
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function generateSlots(startTime, endTime, slotDuration) {
        var start = startTime.split(':');
        var end   = endTime.split(':');
        if (start.length !== 2 || end.length !== 2) return [];
        var current = new Date(); current.setHours(+start[0], +start[1], 0, 0);
        var target  = new Date(); target.setHours(+end[0],   +end[1],   0, 0);
        if (current >= target || slotDuration <= 0) return [];
        var slots = [];
        while (current.getTime() + slotDuration * 60000 <= target.getTime()) {
            slots.push(current.getHours().toString().padStart(2,'0') + ':' + current.getMinutes().toString().padStart(2,'0'));
            current.setMinutes(current.getMinutes() + slotDuration);
        }
        return slots;
    }

    function renderPreview(item) {
        var previewList = item.querySelector('.slot-preview-list');
        var active      = item.querySelector('.toggle-input').checked;
        var startInput  = item.querySelector('input[type="time"][name*="[start]"]');
        var endInput    = item.querySelector('input[type="time"][name*="[end]"]');
        var slotSelect  = item.querySelector('select[name*="[slot]"]');
        previewList.innerHTML = '';
        if (!active) { previewList.innerHTML = '<div class="slot-preview-empty">{{ __("messages.rest_day_preview") }}</div>'; return; }
        var slots = generateSlots(startInput.value, endInput.value, parseInt(slotSelect.value, 10));
        if (slots.length === 0) { previewList.innerHTML = '<div class="slot-preview-empty">{{ __("messages.no_valid_slots") }}</div>'; return; }
        slots.forEach(function (slot) {
            var badge = document.createElement('div');
            badge.className = 'slot-preview-badge'; badge.textContent = slot;
            previewList.appendChild(badge);
        });
    }

    document.querySelectorAll('.day-item').forEach(function (item) {
        var checkbox     = item.querySelector('.toggle-input');
        var switchEl     = item.querySelector('.toggle-switch');
        var timeControls = item.querySelectorAll('input[type="time"], select[name*="[slot]"]');

        function syncState() {
            var active = checkbox.checked;
            item.classList.toggle('active', active);
            switchEl.classList.toggle('active', active);
            timeControls.forEach(function (el) { el.disabled = !active; });
            renderPreview(item);
        }

        checkbox.addEventListener('change', syncState);
        timeControls.forEach(function (control) { control.addEventListener('input', function () { renderPreview(item); }); });
        syncState();
    });
});
</script>
@endpush

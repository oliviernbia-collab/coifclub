@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', __('messages.ap_eyebrow'))

@section('content')

@php
$apDays   = __('messages.ap_days');
$apMonths = __('messages.ap_months');
$apLocale = app()->getLocale() === 'fr' ? 'fr-FR' : (app()->getLocale() === 'es' ? 'es-ES' : 'en-US');
@endphp

<style>
:root {
    --pink: #e91e8c;
    --pink-light: #ff6ab4;
    --gradient: linear-gradient(135deg, #e91e8c 0%, #ff6ab4 50%, #c91a78 100%);
    --shadow-pink: 0 10px 30px rgba(233, 30, 140, .3);
}

.ap-wrap { max-width: 900px; margin: auto; padding: 40px 20px 80px; }

/* ── Hero ── */
.ap-hero { text-align: center; margin-bottom: 36px; }
.ap-eyebrow {
    display: inline-block;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.25);
    color: var(--pink-light);
    padding: 7px 18px; border-radius: 50px;
    font-size: .78rem; font-weight: 700;
    letter-spacing: .8px; text-transform: uppercase;
    margin-bottom: 14px;
}
.ap-title { font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
.ap-title span { background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.ap-sub { color: rgba(255,255,255,.55); font-size: .95rem; max-width: 460px; margin: auto; }

/* ── Login banner ── */
.ap-login {
    background: rgba(233,30,140,.08);
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 14px; padding: 14px 20px;
    color: rgba(255,255,255,.75); font-size: .88rem;
    margin-bottom: 20px; text-align: center;
}
.ap-login a { color: var(--pink-light); font-weight: 700; text-decoration: underline; }

/* ── Main card ── */
.ap-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(233,30,140,.15);
    border-radius: 28px; padding: 32px;
    backdrop-filter: blur(16px);
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
}

/* ── Section label ── */
.ap-section-lbl {
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .9px; color: rgba(255,255,255,.35);
    margin-bottom: 14px;
}

/* ── Two-column layout ── */
.ap-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: start;
}
@media(max-width: 680px) { .ap-grid { grid-template-columns: 1fr; } }

/* ── Calendar ── */
.ap-cal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px;
}
.ap-cal-nav {
    width: 36px; height: 36px; border-radius: 10px;
    background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.7); cursor: pointer; transition: .2s;
    display: flex; align-items: center; justify-content: center; font-size: .85rem;
}
.ap-cal-nav:hover { background: rgba(233,30,140,.15); border-color: var(--pink); color: var(--pink-light); }
.ap-cal-month { font-size: 1rem; font-weight: 800; color: #fff; }

.ap-cal-week {
    display: grid; grid-template-columns: repeat(7, 1fr);
    text-align: center; margin-bottom: 6px;
    color: rgba(255,255,255,.3); font-size: .65rem;
    font-weight: 700; text-transform: uppercase; letter-spacing: .3px;
}
.ap-cal-week span:last-child { color: rgba(233,30,140,.4); }

.ap-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 3px; }
.ap-cal-cell {
    aspect-ratio: 1; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 600;
    color: rgba(255,255,255,.7); cursor: pointer; transition: .2s;
}
.ap-cal-cell:not(.ap-dis):not(.ap-empty):hover {
    background: rgba(233,30,140,.2); color: var(--pink-light);
}
.ap-cal-cell.ap-today { border: 1px solid rgba(233,30,140,.4); color: var(--pink-light); }
.ap-cal-cell.ap-sel { background: var(--gradient) !important; color: #fff !important; box-shadow: var(--shadow-pink); border: none !important; }
.ap-cal-cell.ap-dis { color: rgba(255,255,255,.15); cursor: not-allowed; }
.ap-cal-cell.ap-sun { color: rgba(233,30,140,.3); cursor: not-allowed; }
.ap-cal-cell.ap-empty { cursor: default; }

/* ── Divider ── */
.ap-divider {
    width: 1px; background: rgba(255,255,255,.07);
    align-self: stretch; margin: 0 4px;
}
@media(max-width: 680px) { .ap-divider { display: none; } }

/* ── Slots ── */
.ap-slots-wrap { }
.ap-date-label {
    font-size: .88rem; font-weight: 700; color: var(--pink-light);
    margin-bottom: 16px; min-height: 20px;
}
.ap-slot-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 9px;
}
.ap-slot {
    padding: 11px 6px; border-radius: 12px;
    background: rgba(255,255,255,.05);
    border: 2px solid rgba(255,255,255,.08);
    text-align: center; font-weight: 700;
    color: rgba(255,255,255,.8); cursor: pointer;
    transition: .2s; font-size: .82rem; user-select: none;
}
.ap-slot:hover { border-color: var(--pink); transform: translateY(-2px); box-shadow: var(--shadow-pink); }
.ap-slot.ap-slot-sel { background: var(--gradient); border-color: transparent; color: #fff; box-shadow: var(--shadow-pink); }

/* ── Placeholder ── */
.ap-ph {
    text-align: center; padding: 40px 20px;
    color: rgba(255,255,255,.25); font-size: .88rem; line-height: 1.7;
}
.ap-ph i { font-size: 2rem; display: block; margin-bottom: 10px; color: rgba(233,30,140,.25); }

/* ── Loader ── */
.ap-loader { text-align: center; padding: 32px; color: rgba(255,255,255,.35); }
.ap-loader i { font-size: 1.4rem; color: var(--pink-light); animation: ap-spin 1s linear infinite; display: block; margin-bottom: 8px; }
@keyframes ap-spin { to { transform: rotate(360deg); } }

/* ── Admin : sélecteur client ── */
.ap-admin-box {
    margin-top: 24px; border-top: 1px solid rgba(255,255,255,.07); padding-top: 22px;
}
.ap-admin-select {
    width: 100%; background: rgba(255,255,255,.06);
    border: 1px solid rgba(233,30,140,.2); border-radius: 14px;
    padding: 13px 16px; color: #fff; font-size: .9rem; transition: .2s;
    -webkit-appearance: none;
}
.ap-admin-select:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 4px rgba(233,30,140,.1); }
.ap-admin-select option { background: #1a0e2e; color: #fff; }

/* ── Notes ── */
.ap-notes { margin-top: 24px; border-top: 1px solid rgba(255,255,255,.07); padding-top: 24px; }
.ap-textarea {
    width: 100%; background: rgba(255,255,255,.06);
    border: 1px solid rgba(233,30,140,.2); border-radius: 14px;
    padding: 13px 17px; color: #fff; font-size: .9rem;
    resize: none; min-height: 70px; transition: .2s;
}
.ap-textarea:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 4px rgba(233,30,140,.1); }
.ap-textarea::placeholder { color: rgba(255,255,255,.25); }

/* ── Summary + submit ── */
.ap-confirm {
    margin-top: 24px; border-top: 1px solid rgba(255,255,255,.07);
    padding-top: 24px; display: none;
}
.ap-confirm.visible { display: block; }
.ap-confirm-info {
    background: rgba(233,30,140,.08); border: 1px solid rgba(233,30,140,.18);
    border-radius: 16px; padding: 16px 20px;
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    margin-bottom: 16px;
}
.ap-ci-item { display: flex; flex-direction: column; gap: 1px; }
.ap-ci-lbl { font-size: .65rem; text-transform: uppercase; letter-spacing: .7px; color: rgba(255,255,255,.35); font-weight: 700; }
.ap-ci-val { font-size: .88rem; font-weight: 800; color: #fff; }

/* ── Stylist banner ── */
.ap-stylist-banner {
    display: flex; align-items: center; gap: 14px;
    background: rgba(233,30,140,.08);
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 16px; padding: 14px 18px;
    margin-bottom: 20px;
}
.ap-stylist-avatar {
    width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg,#e91e8c,#c91a78);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.2rem; color: #fff; overflow: hidden;
}
.ap-stylist-avatar img { width: 100%; height: 100%; object-fit: cover; }
.ap-stylist-name { font-weight: 800; color: #fff; font-size: .92rem; }
.ap-stylist-svc  { font-size: .78rem; color: rgba(255,255,255,.5); margin-top: 2px; }
.ap-stylist-tag  {
    margin-left: auto; flex-shrink: 0;
    background: rgba(233,30,140,.15); border: 1px solid rgba(233,30,140,.25);
    color: var(--pink-light); padding: 4px 10px; border-radius: 50px;
    font-size: .7rem; font-weight: 700; white-space: nowrap;
}

.ap-submit {
    width: 100%; border: none; border-radius: 16px; padding: 17px;
    background: var(--gradient); color: #fff; font-size: .98rem; font-weight: 800;
    cursor: pointer; transition: .3s; box-shadow: var(--shadow-pink);
}
.ap-submit:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(233,30,140,.5); }

/* ── FAQ ── */
.ap-faq {
    max-width: 900px; margin: 52px auto 0;
}
.ap-faq-header { text-align: center; margin-bottom: 36px; }
.ap-faq-eyebrow {
    display: inline-block;
    background: rgba(233,30,140,.1); border: 1px solid rgba(233,30,140,.2);
    color: var(--pink-light);
    padding: 6px 16px; border-radius: 50px;
    font-size: .72rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase;
    margin-bottom: 14px;
}
.ap-faq-title { font-size: 1.85rem; font-weight: 900; color: #fff; margin-bottom: 8px; }
.ap-faq-sub { color: rgba(255,255,255,.45); font-size: .9rem; }

.ap-faq-list { display: flex; flex-direction: column; gap: 12px; }
.ap-faq-item {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px; overflow: hidden; transition: border-color .25s;
}
.ap-faq-item.open {
    border-color: rgba(233,30,140,.25);
}
.ap-faq-q {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px; cursor: pointer; gap: 14px;
    color: rgba(255,255,255,.85); font-size: .92rem; font-weight: 700;
    user-select: none;
}
.ap-faq-q:hover { color: #fff; }
.ap-faq-icon {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    background: rgba(233,30,140,.12); border: 1px solid rgba(233,30,140,.2);
    color: var(--pink-light); font-size: .7rem;
    display: flex; align-items: center; justify-content: center; transition: .25s;
}
.ap-faq-item.open .ap-faq-icon { background: var(--gradient); border-color: transparent; transform: rotate(45deg); }
.ap-faq-a {
    max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .25s;
    padding: 0 22px; color: rgba(255,255,255,.5); font-size: .87rem; line-height: 1.75;
}
.ap-faq-item.open .ap-faq-a { max-height: 300px; padding: 0 22px 18px; }

@media(max-width: 480px) {
    .ap-wrap { padding: 22px 14px 60px; }
    .ap-title { font-size: 1.75rem; }
    .ap-card { padding: 22px 18px; }
    .ap-faq-title { font-size: 1.5rem; }
}
</style>

<div class="ap-wrap">

    {{-- Hero --}}
    <div class="ap-hero">
        <div class="ap-eyebrow">
            <i class="fa-solid fa-calendar-check me-1"></i>
            {{ __('messages.ap_eyebrow') }}
        </div>
        <h1 class="ap-title">{{ __('messages.ap_title') }}<span>{{ __('messages.ap_title_span') }}</span></h1>
        <p class="ap-sub">{{ __('messages.ap_sub') }}</p>
    </div>

    {{-- Bannière coiffeuse --}}
    @if($employee)
    <div class="ap-stylist-banner">
        <div class="ap-stylist-avatar">
            @if($employee->photo_url)
                <img src="{{ $employee->photo_url }}" alt="{{ $employee->user->name ?? '' }}">
            @else
                {{ strtoupper(substr($employee->user->name ?? '?', 0, 1)) }}
            @endif
        </div>
        <div>
            <div class="ap-stylist-name">{{ $employee->user->name ?? 'Stylist' }}</div>
            @if($service)
            <div class="ap-stylist-svc">{{ $service->name }}</div>
            @else
            <div class="ap-stylist-svc">{{ $employee->specialty ?? '' }}</div>
            @endif
        </div>
        <span class="ap-stylist-tag">
            <i class="fa-solid fa-scissors me-1"></i>{{ __('messages.ap_stylist_tag') }}
        </span>
    </div>
    @endif

    @guest
    <div class="ap-login">
        <i class="fa-solid fa-circle-info me-1"></i>
        {!! __('messages.ap_login_notice', ['url' => route('login')]) !!}
    </div>
    @endguest

    <form id="apForm" method="POST" action="{{ route('booking.appointment.store') }}">
        @csrf
        <input type="hidden" name="date"        id="apDate">
        <input type="hidden" name="start_time"  id="apTime">
        @if($employee)
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
        @endif
        @if($service)
        <input type="hidden" name="service_id"  value="{{ $service->id }}">
        @endif

        <div class="ap-card">

            <div class="ap-grid">

                {{-- ── CALENDRIER ── --}}
                <div>
                    <div class="ap-section-lbl">
                        <i class="fa-regular fa-calendar me-1"></i>
                        {{ __('messages.ap_cal_lbl') }}
                    </div>

                    <div class="ap-cal-header">
                        <button type="button" class="ap-cal-nav" id="apCalPrev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <span class="ap-cal-month" id="apCalMonth"></span>
                        <button type="button" class="ap-cal-nav" id="apCalNext">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="ap-cal-week">
                        @foreach(__('messages.ap_days') as $day)
                        <span>{{ $day }}</span>
                        @endforeach
                    </div>
                    <div class="ap-cal-grid" id="apCalGrid"></div>
                </div>

                {{-- ── CRÉNEAUX ── --}}
                <div class="ap-slots-wrap">
                    <div class="ap-section-lbl">
                        <i class="fa-regular fa-clock me-1"></i>
                        {{ __('messages.ap_slots_lbl') }}
                    </div>
                    <div class="ap-date-label" id="apDateLabel"></div>
                    <div id="apSlotsContainer">
                        <div class="ap-ph">
                            <i class="fa-solid fa-calendar-days"></i>
                            {{ __('messages.ap_slots_pick') }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── ADMIN : choisir le client ── --}}
            @auth
            @if(auth()->user()->isAdmin())
            <div class="ap-admin-box">
                <div class="ap-section-lbl">
                    <i class="fa-solid fa-user-shield me-1"></i>
                    {{ __('messages.ap_admin_lbl') }}
                    <span style="font-weight:400;text-transform:none;letter-spacing:0;">(admin)</span>
                </div>
                <select name="client_id" class="ap-admin-select">
                    <option value="">{{ __('messages.ap_admin_ph') }}</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} — {{ $client->email }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @endauth

            {{-- ── NOTES ── --}}
            <div class="ap-notes">
                <div class="ap-section-lbl">
                    <i class="fa-solid fa-pen me-1"></i>
                    {{ __('messages.ap_notes_lbl') }}
                    <span style="font-weight:400;text-transform:none;letter-spacing:0;">
                        {{ __('messages.ap_notes_opt') }}
                    </span>
                </div>
                <textarea name="notes" class="ap-textarea"
                    placeholder="{{ __('messages.ap_notes_ph') }}"></textarea>
            </div>

            {{-- ── CONFIRMATION ── --}}
            <div class="ap-confirm" id="apConfirm">
                <div class="ap-confirm-info" id="apConfirmInfo"></div>

                @auth
                    <button type="submit" class="ap-submit">
                        <i class="fa-solid fa-calendar-check me-2"></i>
                        {{ __('messages.ap_submit') }}
                    </button>
                @else
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                       class="ap-submit" style="display:block;text-align:center;text-decoration:none;">
                        <i class="fa-solid fa-lock me-2"></i>
                        {{ __('messages.ap_login_confirm') }}
                    </a>
                @endauth
            </div>

        </div>
    </form>

    {{-- ── FAQ ── --}}
    <div class="ap-faq">
        <div class="ap-faq-header">
            <div class="ap-faq-eyebrow">
                <i class="fa-regular fa-circle-question me-1"></i>FAQ
            </div>
            <h2 class="ap-faq-title">{{ __('messages.faq_title') }}</h2>
            <p class="ap-faq-sub">{{ __('messages.faq_sub') }}</p>
        </div>

        <div class="ap-faq-list" id="apFaqList">
            @foreach([
                ['q' => __('messages.faq_q1'), 'a' => __('messages.faq_a1')],
                ['q' => __('messages.faq_q2'), 'a' => __('messages.faq_a2')],
                ['q' => __('messages.faq_q3'), 'a' => __('messages.faq_a3')],
                ['q' => __('messages.faq_q4'), 'a' => __('messages.faq_a4')],
                ['q' => __('messages.faq_q5'), 'a' => __('messages.faq_a5')],
                ['q' => __('messages.faq_q6'), 'a' => __('messages.faq_a6')],
            ] as $faq)
            <div class="ap-faq-item">
                <div class="ap-faq-q" onclick="toggleFaq(this)">
                    <span>{{ $faq['q'] }}</span>
                    <span class="ap-faq-icon"><i class="fa-solid fa-plus"></i></span>
                </div>
                <div class="ap-faq-a">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
const apiSlots   = '{{ route("api.booking.appointment-slots") }}';

const MONTHS     = @json($apMonths);
const AP_LOCALE  = @json($apLocale);

const TXT = {
    loading  : @json(__('messages.ap_loading')),
    noSlots  : @json(__('messages.ap_slots_none')),
    sunday   : @json(__('messages.ap_slots_sunday')),
    error    : @json(__('messages.ap_slots_error')),
    lblDate  : @json(__('messages.ap_confirm_date')),
    lblTime  : @json(__('messages.ap_confirm_time')),
    alert    : @json(__('messages.ap_validate_alert')),
};

const TODAY = new Date();
TODAY.setHours(0, 0, 0, 0);

let calDate      = new Date(TODAY.getFullYear(), TODAY.getMonth(), 1);
let selectedDate = null;
let selectedSlot = null;

// ── CALENDRIER ────────────────────────────────────────────────────────────────
function renderCalendar() {
    const year  = calDate.getFullYear();
    const month = calDate.getMonth();

    document.getElementById('apCalMonth').textContent = MONTHS[month] + ' ' + year;

    const firstDay = new Date(year, month, 1);
    const lastDay  = new Date(year, month + 1, 0);

    let dow = firstDay.getDay();
    dow = dow === 0 ? 6 : dow - 1;

    let html = '';
    for (let i = 0; i < dow; i++) html += '<div class="ap-cal-cell ap-empty"></div>';

    for (let d = 1; d <= lastDay.getDate(); d++) {
        const cell    = new Date(year, month, d);
        const isSun   = cell.getDay() === 0;
        const isPast  = cell < TODAY;
        const isOff   = isPast || isSun;
        const dateStr = fmtDate(cell);
        const isSel   = dateStr === selectedDate;
        const isToday = cell.getTime() === TODAY.getTime();

        let cls = 'ap-cal-cell';
        if (isSun)              cls += ' ap-dis ap-sun';
        else if (isPast)        cls += ' ap-dis';
        if (isSel)              cls += ' ap-sel';
        if (isToday && !isSel)  cls += ' ap-today';

        const click = !isOff ? `onclick="pickDate('${dateStr}')"` : '';
        html += `<div class="${cls}" ${click}>${d}</div>`;
    }

    document.getElementById('apCalGrid').innerHTML = html;
}

function fmtDate(d) {
    return d.getFullYear() + '-' +
        String(d.getMonth() + 1).padStart(2, '0') + '-' +
        String(d.getDate()).padStart(2, '0');
}

document.getElementById('apCalPrev').addEventListener('click', () => {
    const min = new Date(TODAY.getFullYear(), TODAY.getMonth(), 1);
    calDate.setMonth(calDate.getMonth() - 1);
    if (calDate < min) calDate = new Date(min);
    renderCalendar();
});

document.getElementById('apCalNext').addEventListener('click', () => {
    calDate.setMonth(calDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();

// ── SÉLECTION DATE ────────────────────────────────────────────────────────────
function pickDate(dateStr) {
    selectedDate = dateStr;
    selectedSlot = null;
    document.getElementById('apDate').value = dateStr;
    document.getElementById('apTime').value = '';

    renderCalendar();
    updateConfirmPanel();

    const d     = new Date(dateStr + 'T12:00');
    const label = d.toLocaleDateString(AP_LOCALE, { weekday: 'long', day: 'numeric', month: 'long' });
    document.getElementById('apDateLabel').textContent = label;

    // Check Sunday on JS side too (belt-and-suspenders)
    if (d.getDay() === 0) {
        document.getElementById('apSlotsContainer').innerHTML =
            '<div class="ap-ph"><i class="fa-solid fa-door-closed"></i>' + TXT.sunday + '</div>';
        return;
    }

    loadSlots(dateStr);
}

// ── CHARGEMENT CRÉNEAUX ───────────────────────────────────────────────────────
function loadSlots(dateStr) {
    document.getElementById('apSlotsContainer').innerHTML =
        '<div class="ap-loader"><i class="fa-solid fa-spinner"></i>' + TXT.loading + '</div>';

    fetch(apiSlots, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ date: dateStr })
    })
    .then(r => r.json())
    .then(data => renderSlots(data.slots ?? []))
    .catch(() => {
        document.getElementById('apSlotsContainer').innerHTML =
            '<div class="ap-ph"><i class="fa-solid fa-triangle-exclamation"></i>' + TXT.error + '</div>';
    });
}

function renderSlots(slots) {
    if (!slots.length) {
        document.getElementById('apSlotsContainer').innerHTML =
            '<div class="ap-ph"><i class="fa-solid fa-moon"></i>' + TXT.noSlots + '</div>';
        return;
    }

    const html = slots.map(s =>
        `<div class="ap-slot" onclick="pickSlot('${s}', this)">${s}</div>`
    ).join('');

    document.getElementById('apSlotsContainer').innerHTML =
        `<div class="ap-slot-grid">${html}</div>`;
}

// ── SÉLECTION CRÉNEAU ─────────────────────────────────────────────────────────
function pickSlot(time, el) {
    selectedSlot = time;
    document.getElementById('apTime').value = time;

    document.querySelectorAll('.ap-slot').forEach(b => b.classList.remove('ap-slot-sel'));
    el.classList.add('ap-slot-sel');

    updateConfirmPanel();
}

// ── PANNEAU DE CONFIRMATION ───────────────────────────────────────────────────
function updateConfirmPanel() {
    const panel = document.getElementById('apConfirm');

    if (!selectedDate || !selectedSlot) {
        panel.classList.remove('visible');
        return;
    }

    const d    = new Date(selectedDate + 'T12:00');
    const date = d.toLocaleDateString(AP_LOCALE, { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

    document.getElementById('apConfirmInfo').innerHTML = `
        <div class="ap-ci-item">
            <span class="ap-ci-lbl">${TXT.lblDate}</span>
            <span class="ap-ci-val">${date}</span>
        </div>
        <div class="ap-ci-item">
            <span class="ap-ci-lbl">${TXT.lblTime}</span>
            <span class="ap-ci-val">${selectedSlot}</span>
        </div>
    `;

    panel.classList.add('visible');
}

// ── VALIDATION ────────────────────────────────────────────────────────────────
document.getElementById('apForm')?.addEventListener('submit', function(e) {
    if (!selectedDate || !selectedSlot) {
        e.preventDefault();
        alert(TXT.alert);
    }
});

// ── FAQ ACCORDION ─────────────────────────────────────────────────────────────
function toggleFaq(btn) {
    const item = btn.closest('.ap-faq-item');
    const isOpen = item.classList.contains('open');

    document.querySelectorAll('.ap-faq-item.open').forEach(i => i.classList.remove('open'));

    if (!isOpen) item.classList.add('open');
}
</script>

@endsection

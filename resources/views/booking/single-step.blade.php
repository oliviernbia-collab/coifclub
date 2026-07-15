@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', 'Réserver un Rendez-vous')

@section('content')

<style>
:root {
    --pink: #e91e8c;
    --pink-light: #ff6ab4;
    --pink-dark: #c91a78;
    --gradient: linear-gradient(135deg, #e91e8c 0%, #ff6ab4 50%, #c91a78 100%);
    --shadow-pink: 0 10px 30px rgba(233, 30, 140, .3);
    --glass: rgba(255, 255, 255, 0.05);
    --border: rgba(233, 30, 140, 0.15);
}

.sb-wrap { max-width: 1100px; margin: auto; padding: 36px 20px 80px; }

/* ── Hero ── */
.sb-hero { text-align: center; margin-bottom: 36px; }
.sb-eyebrow {
    display: inline-block;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.25);
    color: var(--pink-light);
    padding: 7px 18px;
    border-radius: 50px;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .8px;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.sb-title { font-size: 2.4rem; font-weight: 900; color: #fff; margin-bottom: 12px; line-height: 1.15; }
.sb-title span { background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.sb-sub { color: rgba(255,255,255,.6); font-size: 1rem; max-width: 520px; margin: auto; line-height: 1.6; }

/* ── Card ── */
.sb-card {
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 28px;
    margin-bottom: 20px;
    backdrop-filter: blur(16px);
    box-shadow: 0 15px 45px rgba(0,0,0,.2);
}

/* ── Section title ── */
.sb-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.05rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 20px;
}
.sb-step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--gradient);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 800;
    flex-shrink: 0;
}
.sb-section-title i { color: var(--pink-light); }
.sb-required { color: var(--pink); font-size: .8rem; margin-left: 2px; }

/* ── Services grid ── */
.svc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
}
.svc-card {
    background: rgba(255,255,255,.05);
    border: 2px solid rgba(255,255,255,.08);
    border-radius: 16px;
    padding: 16px;
    cursor: pointer;
    transition: .25s ease;
    user-select: none;
}
.svc-card:hover {
    border-color: var(--pink);
    transform: translateY(-3px);
    box-shadow: var(--shadow-pink);
}
.svc-card.selected {
    background: rgba(233,30,140,.12);
    border-color: var(--pink);
    box-shadow: var(--shadow-pink);
}
.svc-name { font-weight: 800; color: #fff; font-size: .9rem; margin-bottom: 8px; line-height: 1.3; }
.svc-meta { display: flex; justify-content: space-between; align-items: center; gap: 8px; flex-wrap: wrap; }
.svc-price {
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    font-size: .92rem;
}
.svc-dur { color: rgba(255,255,255,.45); font-size: .75rem; white-space: nowrap; }

/* ── Employee grid ── */
.emp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 14px;
}
.emp-card {
    background: rgba(255,255,255,.05);
    border: 2px solid rgba(255,255,255,.08);
    border-radius: 18px;
    padding: 18px 12px;
    text-align: center;
    cursor: pointer;
    transition: .25s ease;
    user-select: none;
}
.emp-card:hover { border-color: var(--pink); transform: translateY(-3px); box-shadow: var(--shadow-pink); }
.emp-card.selected { background: rgba(233,30,140,.12); border-color: var(--pink); box-shadow: var(--shadow-pink); }
.emp-avatar {
    width: 58px; height: 58px;
    border-radius: 50%;
    background: var(--gradient);
    margin: 0 auto 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.3rem; color: #fff;
    overflow: hidden;
}
.emp-avatar img { width: 100%; height: 100%; object-fit: cover; }
.emp-name { font-weight: 800; color: #fff; font-size: .85rem; margin-bottom: 4px; line-height: 1.3; }
.emp-spec { color: rgba(255,255,255,.4); font-size: .73rem; }

/* ── Date + Time layout ── */
.datetime-grid {
    display: grid;
    grid-template-columns: clamp(260px, 28vw, 320px) 1fr;
    gap: clamp(14px, 2vw, 24px);
    align-items: start;
}
@media(max-width: 768px) { .datetime-grid { grid-template-columns: 1fr; } }

/* ── Calendar ── */
.calendar-widget {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    padding: 20px;
}
.cal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.cal-nav {
    width: 34px; height: 34px;
    border-radius: 10px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.7);
    cursor: pointer;
    transition: .2s;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
}
.cal-nav:hover { background: rgba(233,30,140,.15); border-color: var(--pink); color: var(--pink-light); }
.cal-month-year { font-size: .95rem; font-weight: 800; color: #fff; text-align: center; }
.cal-days-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    margin-bottom: 6px;
    color: rgba(255,255,255,.35);
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
}
.cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 3px; }
.cal-cell {
    aspect-ratio: 1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .82rem;
    font-weight: 600;
    color: rgba(255,255,255,.75);
    cursor: pointer;
    transition: .2s;
}
.cal-cell:not(.disabled):not(.empty):hover { background: rgba(233,30,140,.2); color: var(--pink-light); }
.cal-cell.today { border: 1px solid rgba(233,30,140,.45); color: var(--pink-light); }
.cal-cell.selected { background: var(--gradient) !important; color: white !important; box-shadow: var(--shadow-pink); border: none !important; }
.cal-cell.disabled { color: rgba(255,255,255,.18); cursor: not-allowed; }
.cal-cell.empty { cursor: default; }

/* ── Slots panel ── */
.slots-panel { }
.slots-header {
    font-size: .85rem;
    color: rgba(255,255,255,.55);
    font-weight: 600;
    margin-bottom: 14px;
    min-height: 20px;
}
.slot-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}
.slot-btn {
    padding: 11px 6px;
    border-radius: 12px;
    background: rgba(255,255,255,.05);
    border: 2px solid rgba(255,255,255,.08);
    text-align: center;
    font-weight: 700;
    color: rgba(255,255,255,.8);
    cursor: pointer;
    transition: .2s;
    font-size: .82rem;
    user-select: none;
}
.slot-btn:hover { border-color: var(--pink); transform: translateY(-2px); box-shadow: var(--shadow-pink); }
.slot-btn.selected { background: var(--gradient); border-color: transparent; color: #fff; box-shadow: var(--shadow-pink); }

/* ── Placeholder ── */
.sb-placeholder {
    text-align: center;
    padding: 28px 20px;
    color: rgba(255,255,255,.3);
    font-size: .88rem;
    line-height: 1.6;
}
.sb-placeholder i { font-size: 1.8rem; display: block; margin-bottom: 10px; color: rgba(233,30,140,.3); }

/* ── Loader ── */
.sb-loader { text-align: center; padding: 24px; color: rgba(255,255,255,.4); }
.sb-loader i { animation: sbspin 1s linear infinite; display: inline-block; font-size: 1.4rem; color: var(--pink-light); margin-bottom: 8px; display: block; }
@keyframes sbspin { to { transform: rotate(360deg); } }

/* ── Textarea ── */
.sb-textarea {
    width: 100%;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 14px;
    padding: 14px 18px;
    color: #fff;
    font-size: .93rem;
    resize: none;
    min-height: 80px;
    transition: .2s;
}
.sb-textarea:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 4px rgba(233,30,140,.1); }
.sb-textarea::placeholder { color: rgba(255,255,255,.3); }

/* ── Summary bar ── */
.sb-summary {
    background: rgba(233,30,140,.08);
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 18px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.sum-item { display: flex; flex-direction: column; gap: 2px; }
.sum-lbl { font-size: .68rem; text-transform: uppercase; letter-spacing: .8px; color: rgba(255,255,255,.4); font-weight: 700; }
.sum-val { font-size: .88rem; font-weight: 800; color: #fff; }

/* ── Submit ── */
.sb-submit {
    width: 100%;
    border: none;
    border-radius: 16px;
    padding: 18px;
    background: var(--gradient);
    color: #fff;
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    transition: .3s;
    box-shadow: var(--shadow-pink);
}
.sb-submit:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(233,30,140,.5); }
.sb-submit:disabled { background: rgba(255,255,255,.08); color: rgba(255,255,255,.3); cursor: not-allowed; box-shadow: none; }

/* ── Login banner ── */
.login-banner {
    background: rgba(233,30,140,.08);
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 14px;
    padding: 14px 20px;
    color: rgba(255,255,255,.75);
    font-size: .88rem;
    margin-bottom: 20px;
    text-align: center;
}
.login-banner a { color: var(--pink-light); font-weight: 700; text-decoration: underline; }

/* ── Responsive ── */
@media(max-width: 640px) {
    .sb-wrap { padding: 20px 14px 60px; }
    .sb-title { font-size: 1.85rem; }
    .svc-grid { grid-template-columns: repeat(2, 1fr); }
    .emp-grid { grid-template-columns: repeat(3, 1fr); }
    .sb-card { padding: 20px 18px; }
    .sb-summary { gap: 16px; padding: 14px 18px; }
}
@media(max-width: 400px) {
    .svc-grid { grid-template-columns: 1fr; }
    .emp-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="sb-wrap">

    {{-- HERO --}}
    <div class="sb-hero">
        <div class="sb-eyebrow">
            <i class="fa-solid fa-calendar-check me-1"></i>
            Réservation
        </div>
        <h1 class="sb-title">
            Réservez votre <span>rendez-vous</span>
        </h1>
        <p class="sb-sub">
            Choisissez votre prestation, votre coiffeuse, une date et un créneau en une seule étape.
        </p>
    </div>

    @guest
    <div class="login-banner">
        <i class="fa-solid fa-circle-info me-1"></i>
        Vous devrez être <a href="{{ route('login') }}">connectée</a> pour finaliser votre réservation.
    </div>
    @endguest

    <form id="bookingForm"
          method="POST"
          action="{{ route('booking.quick.store') }}"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="service_id"  id="hiddenServiceId">
        <input type="hidden" name="employee_id" id="hiddenEmployeeId">
        <input type="hidden" name="date"         id="hiddenDate">
        <input type="hidden" name="start_time"   id="hiddenStartTime">

        {{-- ── SECTION 1 : PRESTATION ── --}}
        <div class="sb-card">
            <div class="sb-section-title">
                <span class="sb-step-num">1</span>
                <i class="fa-solid fa-scissors"></i>
                Choisir une prestation
                <span class="sb-required">*</span>
            </div>

            <div class="svc-grid" id="servicesGrid">
                @foreach($services as $service)
                <div class="svc-card"
                     data-id="{{ $service->id }}"
                     data-name="{{ $service->name }}"
                     data-price="{{ $service->formatted_price ?? '' }}"
                     data-duration="{{ $service->formatted_duration ?? '' }}"
                     onclick="selectService({{ $service->id }}, this)">
                    <div class="svc-name">{{ $service->name }}</div>
                    <div class="svc-meta">
                        <span class="svc-price">{{ $service->formatted_price ?? '' }}</span>
                        <span class="svc-dur">
                            <i class="fa-regular fa-clock"></i>
                            {{ $service->formatted_duration ?? '' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── SECTION 2 : COIFFEUSE ── --}}
        <div class="sb-card">
            <div class="sb-section-title">
                <span class="sb-step-num">2</span>
                <i class="fa-solid fa-user-hair-buns"></i>
                Choisir une coiffeuse
                <span class="sb-required">*</span>
            </div>
            <div id="employeeContainer">
                <div class="sb-placeholder">
                    <i class="fa-solid fa-scissors"></i>
                    Sélectionnez d'abord une prestation.
                </div>
            </div>
        </div>

        {{-- ── SECTION 3 : DATE + CRÉNEAU ── --}}
        <div class="sb-card">
            <div class="sb-section-title">
                <span class="sb-step-num">3</span>
                <i class="fa-solid fa-calendar-days"></i>
                Choisir une date et un créneau
            </div>

            <div class="datetime-grid">

                {{-- Calendrier --}}
                <div class="calendar-widget">
                    <div class="cal-header">
                        <button type="button" class="cal-nav" id="calPrev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <span class="cal-month-year" id="calMonthYear"></span>
                        <button type="button" class="cal-nav" id="calNext">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="cal-days-header">
                        <span>Lun</span>
                        <span>Mar</span>
                        <span>Mer</span>
                        <span>Jeu</span>
                        <span>Ven</span>
                        <span>Sam</span>
                        <span>Dim</span>
                    </div>
                    <div class="cal-grid" id="calGrid"></div>
                </div>

                {{-- Créneaux --}}
                <div class="slots-panel">
                    <div class="slots-header" id="slotsHeader">
                        <i class="fa-regular fa-clock me-1"></i>
                        Créneaux disponibles
                    </div>
                    <div id="slotsContainer">
                        <div class="sb-placeholder">
                            <i class="fa-solid fa-calendar-days"></i>
                            Choisissez une coiffeuse et une date pour voir les créneaux.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── SECTION 4 : NOTES (optionnel) ── --}}
        <div class="sb-card">
            <div class="sb-section-title">
                <span class="sb-step-num" style="background: rgba(255,255,255,.12);">4</span>
                <i class="fa-solid fa-pen"></i>
                Notes <span style="color: rgba(255,255,255,.4); font-size: .8rem; font-weight: 400;">(optionnel)</span>
            </div>
            <textarea name="model_description"
                      class="sb-textarea"
                      placeholder="Décrivez le style souhaité, vos préférences…"></textarea>
        </div>

        {{-- ── RÉSUMÉ ── --}}
        <div class="sb-summary" id="sbSummary" style="display:none;">
            <div class="sum-item">
                <span class="sum-lbl">Prestation</span>
                <span class="sum-val" id="sumService">—</span>
            </div>
            <div class="sum-item">
                <span class="sum-lbl">Coiffeuse</span>
                <span class="sum-val" id="sumEmployee">—</span>
            </div>
            <div class="sum-item">
                <span class="sum-lbl">Date</span>
                <span class="sum-val" id="sumDate">—</span>
            </div>
            <div class="sum-item">
                <span class="sum-lbl">Heure</span>
                <span class="sum-val" id="sumTime">—</span>
            </div>
            <div class="sum-item">
                <span class="sum-lbl">Prix</span>
                <span class="sum-val" id="sumPrice">—</span>
            </div>
        </div>

        {{-- ── BOUTON ── --}}
        @auth
            <button type="submit" class="sb-submit" id="submitBtn" disabled>
                <i class="fa-solid fa-calendar-check me-2"></i>
                Confirmer et passer au paiement
            </button>
        @else
            <a href="{{ route('login', ['redirect' => url()->current()]) }}"
               class="sb-submit"
               style="display:block; text-align:center; text-decoration:none;">
                <i class="fa-solid fa-lock me-2"></i>
                Se connecter pour réserver
            </a>
        @endauth

    </form>

</div>

<script>
const csrfToken            = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
const apiEmployeesByService = '{{ route("api.booking.employees-by-service") }}';
const apiAvailableSlots     = '{{ route("api.booking.available-slots") }}';

// ── État ──────────────────────────────────────────────────────────────────────
let selectedServiceId    = null;
let selectedServiceName  = null;
let selectedServicePrice = null;
let selectedEmployeeId   = null;
let selectedEmployeeName = null;
let selectedDate         = null;
let selectedSlot         = null;

// ── Calendrier ────────────────────────────────────────────────────────────────
const MONTHS_FR = ['Janvier','Février','Mars','Avril','Mai','Juin',
                   'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

const TODAY = new Date();
TODAY.setHours(0, 0, 0, 0);

let calDate = new Date(TODAY.getFullYear(), TODAY.getMonth(), 1);

function renderCalendar() {
    const year  = calDate.getFullYear();
    const month = calDate.getMonth();

    document.getElementById('calMonthYear').textContent = MONTHS_FR[month] + ' ' + year;

    const firstDay = new Date(year, month, 1);
    const lastDay  = new Date(year, month + 1, 0);

    // Décalage lundi=0 … dimanche=6
    let dow = firstDay.getDay();
    dow = dow === 0 ? 6 : dow - 1;

    let html = '';
    for (let i = 0; i < dow; i++) {
        html += '<div class="cal-cell empty"></div>';
    }

    for (let d = 1; d <= lastDay.getDate(); d++) {
        const cellDate = new Date(year, month, d);
        const isPast   = cellDate < TODAY;
        const dateStr  = fmtDate(cellDate);
        const isSel    = dateStr === selectedDate;
        const isToday  = cellDate.getTime() === TODAY.getTime();

        let cls = 'cal-cell';
        if (isPast)              cls += ' disabled';
        if (isSel)               cls += ' selected';
        if (isToday && !isSel)   cls += ' today';

        const click = !isPast ? `onclick="selectDate('${dateStr}')"` : '';
        html += `<div class="${cls}" ${click}>${d}</div>`;
    }

    document.getElementById('calGrid').innerHTML = html;
}

function fmtDate(d) {
    const y  = d.getFullYear();
    const m  = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${y}-${m}-${dd}`;
}

document.getElementById('calPrev').addEventListener('click', () => {
    const minMonth = new Date(TODAY.getFullYear(), TODAY.getMonth(), 1);
    calDate.setMonth(calDate.getMonth() - 1);
    if (calDate < minMonth) calDate = new Date(minMonth);
    renderCalendar();
});

document.getElementById('calNext').addEventListener('click', () => {
    calDate.setMonth(calDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();

// ── Sélection service ─────────────────────────────────────────────────────────
function selectService(id, el) {
    selectedServiceId    = id;
    selectedServiceName  = el.dataset.name;
    selectedServicePrice = el.dataset.price;

    document.getElementById('hiddenServiceId').value = id;

    document.querySelectorAll('.svc-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    resetEmployee();
    resetSlot();
    updateSummary();
    updateSubmit();

    loadEmployees(id);
}

// ── Chargement coiffeuses ─────────────────────────────────────────────────────
function loadEmployees(serviceId) {
    document.getElementById('employeeContainer').innerHTML =
        '<div class="sb-loader"><i class="fa-solid fa-spinner"></i>Chargement des coiffeuses…</div>';

    fetch(apiEmployeesByService, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ service_id: serviceId })
    })
    .then(r => r.json())
    .then(data => renderEmployees(data.employees ?? []))
    .catch(() => {
        document.getElementById('employeeContainer').innerHTML =
            '<div class="sb-placeholder"><i class="fa-solid fa-triangle-exclamation"></i>Impossible de charger les coiffeuses.</div>';
    });
}

function renderEmployees(employees) {
    if (!employees.length) {
        document.getElementById('employeeContainer').innerHTML =
            '<div class="sb-placeholder"><i class="fa-solid fa-calendar-xmark"></i>Aucune coiffeuse disponible pour cette prestation.</div>';
        return;
    }

    const cards = employees.map(emp => {
        const initial = (emp.name || '?').charAt(0).toUpperCase();
        const avatar  = emp.photo_url
            ? `<img src="${emp.photo_url}" alt="${emp.name}">`
            : initial;
        const name    = (emp.name || '').replace(/'/g, "\\'");
        return `
            <div class="emp-card" data-id="${emp.id}" data-name="${emp.name}"
                 onclick="selectEmployee(${emp.id}, '${name}', this)">
                <div class="emp-avatar">${avatar}</div>
                <div class="emp-name">${emp.name || ''}</div>
                <div class="emp-spec">${emp.specialty || ''}</div>
            </div>
        `;
    }).join('');

    document.getElementById('employeeContainer').innerHTML =
        `<div class="emp-grid">${cards}</div>`;
}

// ── Sélection coiffeuse ───────────────────────────────────────────────────────
function selectEmployee(id, name, el) {
    selectedEmployeeId   = id;
    selectedEmployeeName = name;

    document.getElementById('hiddenEmployeeId').value = id;

    document.querySelectorAll('.emp-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    resetSlot();
    updateSummary();
    updateSubmit();

    if (selectedDate) loadSlots(id, selectedDate);
}

// ── Sélection date (calendrier) ───────────────────────────────────────────────
function selectDate(dateStr) {
    selectedDate = dateStr;
    document.getElementById('hiddenDate').value = dateStr;

    renderCalendar();
    resetSlot();
    updateSummary();
    updateSubmit();

    if (selectedEmployeeId) loadSlots(selectedEmployeeId, dateStr);
}

// ── Chargement créneaux ───────────────────────────────────────────────────────
function loadSlots(employeeId, date) {
    document.getElementById('slotsHeader').textContent = '';
    document.getElementById('slotsContainer').innerHTML =
        '<div class="sb-loader"><i class="fa-solid fa-spinner"></i>Chargement des créneaux…</div>';

    fetch(apiAvailableSlots, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ employee_id: employeeId, date: date })
    })
    .then(r => r.json())
    .then(data => {
        const dateObj = new Date(date + 'T12:00');
        const label   = dateObj.toLocaleDateString('fr-FR', {
            weekday: 'long', day: 'numeric', month: 'long'
        });
        document.getElementById('slotsHeader').textContent = 'Créneaux – ' + label;
        renderSlots(data.slots ?? []);
    })
    .catch(() => {
        document.getElementById('slotsHeader').innerHTML =
            '<i class="fa-regular fa-clock me-1"></i> Créneaux disponibles';
        document.getElementById('slotsContainer').innerHTML =
            '<div class="sb-placeholder"><i class="fa-solid fa-triangle-exclamation"></i>Impossible de charger les créneaux.</div>';
    });
}

function renderSlots(slots) {
    if (!slots.length) {
        document.getElementById('slotsContainer').innerHTML =
            '<div class="sb-placeholder"><i class="fa-solid fa-clock"></i>Aucun créneau disponible pour cette date.</div>';
        return;
    }

    const btns = slots.map(s => {
        // L'API renvoie soit des strings '09:00' soit des objets {start, formatted}
        const start     = typeof s === 'string' ? s : s.start;
        const formatted = typeof s === 'string' ? s : (s.formatted ?? s.start);
        return `<div class="slot-btn" onclick="selectSlot('${start}', '${formatted}', this)">${formatted}</div>`;
    }).join('');

    document.getElementById('slotsContainer').innerHTML = `<div class="slot-grid">${btns}</div>`;
}

function selectSlot(start, formatted, el) {
    selectedSlot = start;
    document.getElementById('hiddenStartTime').value = start;

    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');

    updateSummary();
    updateSubmit();
}

// ── Réinitialisation ──────────────────────────────────────────────────────────
function resetEmployee() {
    selectedEmployeeId   = null;
    selectedEmployeeName = null;
    document.getElementById('hiddenEmployeeId').value = '';
}

function resetSlot() {
    selectedSlot = null;
    document.getElementById('hiddenStartTime').value = '';
    document.getElementById('slotsHeader').innerHTML =
        '<i class="fa-regular fa-clock me-1"></i> Créneaux disponibles';
    document.getElementById('slotsContainer').innerHTML = `
        <div class="sb-placeholder">
            <i class="fa-solid fa-calendar-days"></i>
            Choisissez une coiffeuse et une date pour voir les créneaux.
        </div>
    `;
}

// ── Résumé + bouton ───────────────────────────────────────────────────────────
function updateSummary() {
    const hasAll = selectedServiceId && selectedEmployeeId && selectedDate && selectedSlot;
    document.getElementById('sbSummary').style.display = hasAll ? 'flex' : 'none';

    if (hasAll) {
        document.getElementById('sumService').textContent  = selectedServiceName  ?? '—';
        document.getElementById('sumEmployee').textContent = selectedEmployeeName ?? '—';
        const d = new Date(selectedDate + 'T12:00');
        document.getElementById('sumDate').textContent = d.toLocaleDateString('fr-FR', {
            weekday: 'long', day: 'numeric', month: 'long'
        });
        document.getElementById('sumTime').textContent  = selectedSlot         ?? '—';
        document.getElementById('sumPrice').textContent = selectedServicePrice ?? '—';
    }
}

function updateSubmit() {
    const btn = document.getElementById('submitBtn');
    if (!btn) return;
    btn.disabled = !(selectedServiceId && selectedEmployeeId && selectedDate && selectedSlot);
}

// ── Validation soumission ─────────────────────────────────────────────────────
document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
    if (!selectedServiceId || !selectedEmployeeId || !selectedDate || !selectedSlot) {
        e.preventDefault();
        alert('Veuillez sélectionner une prestation, une coiffeuse, une date et un créneau.');
    }
});

// ── Pré-sélection depuis URL (profil coiffeuse / détail service) ──────────────
@if($preServiceId || $preEmployeeId)
(function() {
    const preServiceId  = {{ $preServiceId  ? (int)$preServiceId  : 'null' }};
    const preEmployeeId = {{ $preEmployeeId ? (int)$preEmployeeId : 'null' }};

    if (preServiceId) {
        const card = document.querySelector(`.svc-card[data-id="${preServiceId}"]`);
        if (card) {
            card.click();

            if (preEmployeeId) {
                const origRender = window.renderEmployees;
                window.renderEmployees = function(employees) {
                    origRender(employees);
                    const empCard = document.querySelector(`.emp-card[data-id="${preEmployeeId}"]`);
                    if (empCard) empCard.click();
                    window.renderEmployees = origRender;
                };
            }
        }
    }
})();
@endif
</script>

@endsection

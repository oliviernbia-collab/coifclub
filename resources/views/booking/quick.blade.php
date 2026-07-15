@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', 'Réservation rapide')

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-light:#ff6ab4;
    --gradient:linear-gradient(135deg,#e91e8c 0%,#ff6ab4 50%,#c91a78 100%);
    --shadow-pink:0 10px 30px rgba(233,30,140,.3);
    --glass:rgba(255,255,255,0.05);
    --border:rgba(233,30,140,0.15);
}

.qb-wrap{ max-width:900px; margin:auto; padding:36px 20px 72px; }

/* ── HERO ── */
.qb-hero{ text-align:center; margin-bottom:40px; }
.qb-eyebrow{
    display:inline-block;
    background:rgba(233,30,140,.12);
    border:1px solid rgba(233,30,140,.25);
    color:var(--pink-light);
    padding:7px 18px;
    border-radius:50px;
    font-size:.8rem;
    font-weight:700;
    letter-spacing:.8px;
    text-transform:uppercase;
    margin-bottom:18px;
}
.qb-title{ font-size:2.4rem; font-weight:900; color:#fff; margin-bottom:12px; line-height:1.2; }
.qb-title span{ background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
.qb-sub{ color:rgba(255,255,255,.6); font-size:1rem; max-width:520px; margin:auto; }

/* ── CARD ── */
.qb-card{
    background:rgba(255,255,255,.05);
    border:1px solid var(--border);
    border-radius:28px;
    padding:32px;
    backdrop-filter:blur(16px);
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    margin-bottom:24px;
}
.qb-section-title{
    font-size:1.1rem;
    font-weight:800;
    color:#fff;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
}
.qb-section-title i{ color:var(--pink-light); }

/* ── ROW 1 : service + date ── */
.qb-row{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
@media(max-width:640px){ .qb-row{ grid-template-columns:1fr; } }

.qb-label{ display:block; font-size:.82rem; font-weight:700; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:.7px; margin-bottom:10px; }

.qb-select, .qb-input{
    width:100%;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(233,30,140,.2);
    border-radius:16px;
    padding:14px 18px;
    color:#fff;
    font-size:.95rem;
    transition:.2s ease;
    -webkit-appearance:none;
}
.qb-select:focus, .qb-input:focus{
    outline:none;
    border-color:var(--pink);
    box-shadow:0 0 0 4px rgba(233,30,140,.12);
}
.qb-select option{ background:#1a0e2e; color:#fff; }

/* ── EMPLOYEES GRID ── */
.emp-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(170px, 1fr));
    gap:16px;
}
.emp-card{
    background:rgba(255,255,255,.05);
    border:2px solid rgba(255,255,255,.08);
    border-radius:20px;
    padding:20px 14px;
    text-align:center;
    cursor:pointer;
    transition:.25s ease;
}
.emp-card:hover{ border-color:var(--pink); transform:translateY(-3px); box-shadow:var(--shadow-pink); }
.emp-card.selected{ background:rgba(233,30,140,.12); border-color:var(--pink); box-shadow:var(--shadow-pink); }
.emp-avatar{
    width:60px; height:60px; border-radius:50%;
    background:var(--gradient); margin:0 auto 12px;
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:1.3rem; color:#fff;
    overflow:hidden;
}
.emp-avatar img{ width:100%; height:100%; object-fit:cover; }
.emp-name{ font-weight:800; color:#fff; font-size:.9rem; margin-bottom:4px; }
.emp-spec{ color:rgba(255,255,255,.45); font-size:.78rem; }

/* ── TIME SLOTS ── */
.slot-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));
    gap:12px;
}
.slot-btn{
    padding:14px;
    border-radius:14px;
    background:rgba(255,255,255,.05);
    border:2px solid rgba(255,255,255,.08);
    text-align:center;
    font-weight:700;
    color:rgba(255,255,255,.85);
    cursor:pointer;
    transition:.25s ease;
    font-size:.9rem;
}
.slot-btn:hover{ border-color:var(--pink); transform:translateY(-2px); box-shadow:var(--shadow-pink); }
.slot-btn.selected{ background:var(--gradient); border-color:transparent; color:#fff; box-shadow:var(--shadow-pink); }

/* ── PLACEHOLDER STATE ── */
.qb-placeholder{
    text-align:center;
    padding:32px 20px;
    color:rgba(255,255,255,.35);
    font-size:.95rem;
}
.qb-placeholder i{ font-size:2.2rem; margin-bottom:12px; display:block; color:rgba(233,30,140,.35); }

/* ── SUMMARY BAR ── */
.summary-bar{
    background:rgba(233,30,140,.08);
    border:1px solid rgba(233,30,140,.2);
    border-radius:20px;
    padding:20px 24px;
    display:flex;
    align-items:center;
    gap:24px;
    flex-wrap:wrap;
    margin-bottom:24px;
}
.sum-item{ display:flex; flex-direction:column; gap:3px; }
.sum-lbl{ font-size:.72rem; text-transform:uppercase; letter-spacing:.8px; color:rgba(255,255,255,.4); font-weight:700; }
.sum-val{ font-size:.95rem; font-weight:800; color:#fff; }

/* ── NOTES ── */
.qb-textarea{
    width:100%;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(233,30,140,.2);
    border-radius:16px;
    padding:14px 18px;
    color:#fff;
    font-size:.93rem;
    resize:none;
    min-height:100px;
    transition:.2s;
}
.qb-textarea:focus{ outline:none; border-color:var(--pink); box-shadow:0 0 0 4px rgba(233,30,140,.1); }
.qb-textarea::placeholder{ color:rgba(255,255,255,.3); }

/* ── SUBMIT ── */
.qb-submit{
    width:100%;
    border:none;
    border-radius:18px;
    padding:18px;
    background:var(--gradient);
    color:#fff;
    font-size:1.05rem;
    font-weight:800;
    cursor:pointer;
    transition:.3s ease;
    box-shadow:var(--shadow-pink);
    margin-top:8px;
}
.qb-submit:hover:not(:disabled){ transform:translateY(-3px); box-shadow:0 15px 40px rgba(233,30,140,.5); }
.qb-submit:disabled{ background:rgba(255,255,255,.08); color:rgba(255,255,255,.3); cursor:not-allowed; box-shadow:none; }

/* ── LOGIN BANNER ── */
.login-banner{
    background:rgba(233,30,140,.08);
    border:1px solid rgba(233,30,140,.2);
    border-radius:16px;
    padding:16px 20px;
    color:rgba(255,255,255,.75);
    font-size:.9rem;
    margin-bottom:16px;
    text-align:center;
}
.login-banner a{ color:var(--pink-light); font-weight:700; text-decoration:underline; }

/* ── LOADER ── */
.qb-loader{ text-align:center; padding:24px; color:rgba(255,255,255,.4); }
.qb-loader i{ animation:spin 1s linear infinite; display:inline-block; font-size:1.5rem; color:var(--pink-light); margin-bottom:8px; }
@keyframes spin{ to{transform:rotate(360deg);} }
</style>

<div class="qb-wrap">

    {{-- HERO --}}
    <div class="qb-hero">
        <div class="qb-eyebrow"><i class="fa-solid fa-bolt me-1"></i> Réservation rapide</div>
        <h1 class="qb-title">Choisissez votre <span>créneau</span></h1>
        <p class="qb-sub">Sélectionnez votre prestation, une date et une coiffeuse disponible en quelques secondes.</p>
    </div>

    @guest
    <div class="login-banner">
        <i class="fa-solid fa-circle-info me-1"></i>
        Vous devrez être <a href="{{ route('login') }}">connectée</a> pour finaliser votre réservation.
    </div>
    @endguest

    <form id="quickForm" method="POST" action="{{ route('booking.quick.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="employee_id" id="hiddenEmployeeId">
        <input type="hidden" name="start_time"  id="hiddenStartTime">

        {{-- ── ÉTAPE 1 : SERVICE + DATE ── --}}
        <div class="qb-card">
            <div class="qb-section-title">
                <i class="fa-solid fa-scissors"></i>
                Prestation & date
            </div>
            <div class="qb-row">
                <div>
                    <label class="qb-label">Prestation souhaitée</label>
                    <select name="service_id" id="serviceSelect" class="qb-select" required>
                        <option value="">— Choisir une prestation —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                data-price="{{ $service->formatted_price }}"
                                data-duration="{{ $service->formatted_duration }}">
                                {{ $service->name }}
                                @if($service->categorie) ({{ $service->categorie->nom }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="qb-label">Date souhaitée</label>
                    <input
                        type="date"
                        name="date"
                        id="dateInput"
                        class="qb-input"
                        min="{{ date('Y-m-d') }}"
                        required
                    >
                </div>
            </div>
        </div>

        {{-- ── ÉTAPE 2 : COIFFEUSE ── --}}
        <div class="qb-card" id="employeeSection">
            <div class="qb-section-title">
                <i class="fa-solid fa-user-hair-buns"></i>
                Choisir une coiffeuse
            </div>
            <div id="employeeContainer">
                <div class="qb-placeholder">
                    <i class="fa-solid fa-scissors"></i>
                    Sélectionnez une prestation et une date pour voir les coiffeuses disponibles.
                </div>
            </div>
        </div>

        {{-- ── ÉTAPE 3 : CRÉNEAU ── --}}
        <div class="qb-card" id="slotSection">
            <div class="qb-section-title">
                <i class="fa-solid fa-clock"></i>
                Choisir un créneau
            </div>
            <div id="slotContainer">
                <div class="qb-placeholder">
                    <i class="fa-solid fa-calendar-days"></i>
                    Choisissez une coiffeuse pour voir ses créneaux disponibles.
                </div>
            </div>
        </div>

        {{-- ── RÉSUMÉ ── --}}
        <div class="summary-bar" id="summaryBar" style="display:none;">
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

        {{-- ── NOTES (optionnel) ── --}}
        <div class="qb-card">
            <div class="qb-section-title">
                <i class="fa-solid fa-pen"></i>
                Notes (optionnel)
            </div>
            <textarea
                name="model_description"
                class="qb-textarea"
                placeholder="Décrivez le style souhaité, vos préférences…"
            ></textarea>
        </div>

        {{-- ── BOUTON ── --}}
        @auth
            <button type="submit" class="qb-submit" id="submitBtn" disabled>
                <i class="fa-solid fa-calendar-check me-2"></i>
                Confirmer et passer au paiement
            </button>
        @else
            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="qb-submit" style="display:block;text-align:center;text-decoration:none;">
                <i class="fa-solid fa-lock me-2"></i>
                Se connecter pour réserver
            </a>
        @endauth

    </form>

</div>

<script>
const csrfToken   = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
const apiEmployees = "{{ route('api.booking.employees') }}";
const apiSlots     = "{{ route('api.booking.slots') }}";

let selectedEmployeeId   = null;
let selectedEmployeeName = null;
let selectedSlot         = null;

const serviceSelect = document.getElementById('serviceSelect');
const dateInput     = document.getElementById('dateInput');

// ── Déclencheur : service ou date change ──────────
serviceSelect.addEventListener('change', maybeLoadEmployees);
dateInput.addEventListener('change',    maybeLoadEmployees);

function maybeLoadEmployees() {
    const serviceId = serviceSelect.value;
    const date      = dateInput.value;
    if (!serviceId || !date) return;

    // Reset selections
    selectedEmployeeId = selectedEmployeeName = selectedSlot = null;
    document.getElementById('hiddenEmployeeId').value = '';
    document.getElementById('hiddenStartTime').value  = '';
    resetSlots();
    updateSummary();
    updateSubmit();

    document.getElementById('employeeContainer').innerHTML = `
        <div class="qb-loader"><i class="fa-solid fa-spinner"></i><br>Recherche des coiffeuses disponibles…</div>
    `;

    fetch(apiEmployees, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ service_id: serviceId, date: date })
    })
    .then(r => r.json())
    .then(data => {
        renderEmployees(data.employees ?? []);
    })
    .catch(() => {
        document.getElementById('employeeContainer').innerHTML = `
            <div class="qb-placeholder"><i class="fa-solid fa-triangle-exclamation"></i>Impossible de charger les coiffeuses.</div>
        `;
    });
}

function renderEmployees(employees) {
    if (!employees.length) {
        document.getElementById('employeeContainer').innerHTML = `
            <div class="qb-placeholder"><i class="fa-solid fa-calendar-xmark"></i>Aucune coiffeuse disponible pour cette date.</div>
        `;
        return;
    }

    document.getElementById('employeeContainer').innerHTML = `
        <div class="emp-grid">
            ${employees.map(emp => `
                <div class="emp-card" data-id="${emp.id}" data-name="${emp.name}" onclick="selectEmployee(${emp.id}, '${emp.name.replace(/'/g,"\\'")}')">
                    <div class="emp-avatar">
                        ${emp.photo_url
                            ? `<img src="${emp.photo_url}" alt="${emp.name}">`
                            : emp.name.charAt(0).toUpperCase()
                        }
                    </div>
                    <div class="emp-name">${emp.name}</div>
                    <div class="emp-spec">${emp.specialty ?? ''}</div>
                </div>
            `).join('')}
        </div>
    `;
}

function selectEmployee(id, name) {
    selectedEmployeeId   = id;
    selectedEmployeeName = name;
    document.getElementById('hiddenEmployeeId').value = id;

    document.querySelectorAll('.emp-card').forEach(c => c.classList.remove('selected'));
    document.querySelector(`.emp-card[data-id="${id}"]`)?.classList.add('selected');

    // Reset créneau
    selectedSlot = null;
    document.getElementById('hiddenStartTime').value = '';
    updateSummary();
    updateSubmit();

    loadSlots(id);
}

function loadSlots(employeeId) {
    const date = dateInput.value;
    document.getElementById('slotContainer').innerHTML = `
        <div class="qb-loader"><i class="fa-solid fa-spinner"></i><br>Chargement des créneaux…</div>
    `;

    fetch(apiSlots, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ employee_id: employeeId, date: date })
    })
    .then(r => r.json())
    .then(data => {
        renderSlots(data.slots ?? []);
    })
    .catch(() => {
        document.getElementById('slotContainer').innerHTML = `
            <div class="qb-placeholder"><i class="fa-solid fa-triangle-exclamation"></i>Impossible de charger les créneaux.</div>
        `;
    });
}

function renderSlots(slots) {
    if (!slots.length) {
        document.getElementById('slotContainer').innerHTML = `
            <div class="qb-placeholder"><i class="fa-solid fa-clock"></i>Aucun créneau disponible pour cette coiffeuse.</div>
        `;
        return;
    }

    document.getElementById('slotContainer').innerHTML = `
        <div class="slot-grid">
            ${slots.map(s => `
                <div class="slot-btn" onclick="selectSlot('${s.start}', '${s.formatted}', this)">
                    ${s.formatted}
                </div>
            `).join('')}
        </div>
    `;
}

function selectSlot(start, formatted, el) {
    selectedSlot = start;
    document.getElementById('hiddenStartTime').value = start;

    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');

    updateSummary();
    updateSubmit();
}

function resetSlots() {
    document.getElementById('slotContainer').innerHTML = `
        <div class="qb-placeholder">
            <i class="fa-solid fa-calendar-days"></i>
            Choisissez une coiffeuse pour voir ses créneaux disponibles.
        </div>
    `;
}

function updateSummary() {
    const serviceOpt = serviceSelect.selectedOptions[0];
    const date       = dateInput.value;
    const hasAll     = serviceOpt?.value && selectedEmployeeId && date && selectedSlot;

    const bar = document.getElementById('summaryBar');
    bar.style.display = hasAll ? 'flex' : 'none';

    if (hasAll) {
        document.getElementById('sumService').textContent  = serviceOpt.text.split(' (')[0];
        document.getElementById('sumEmployee').textContent = selectedEmployeeName;
        document.getElementById('sumDate').textContent     = new Date(date + 'T00:00').toLocaleDateString('fr-FR', {weekday:'long', day:'numeric', month:'long'});
        document.getElementById('sumTime').textContent     = selectedSlot;
        document.getElementById('sumPrice').textContent    = serviceOpt.dataset.price ?? '—';
    }
}

function updateSubmit() {
    const btn = document.getElementById('submitBtn');
    if (!btn) return;
    const serviceId = serviceSelect.value;
    const date      = dateInput.value;
    btn.disabled = !(serviceId && date && selectedEmployeeId && selectedSlot);
}

// ── Soumission : valider avant POST ──────────────
document.getElementById('quickForm')?.addEventListener('submit', function(e) {
    if (!selectedEmployeeId || !selectedSlot) {
        e.preventDefault();
        alert('Veuillez choisir une coiffeuse et un créneau avant de continuer.');
    }
});

// ── Pré-sélection depuis la page coiffeuse ────────
@if($preServiceId || $preEmployeeId)
(function () {
    const preServiceId  = {{ $preServiceId  ? (int)$preServiceId  : 'null' }};
    const preEmployeeId = {{ $preEmployeeId ? (int)$preEmployeeId : 'null' }};

    // 1. Pré-sélectionner le service dans le dropdown
    if (preServiceId) {
        const opt = serviceSelect.querySelector(`option[value="${preServiceId}"]`);
        if (opt) serviceSelect.value = preServiceId;
    }

    // 2. Mettre la date à aujourd'hui si vide
    if (!dateInput.value) {
        dateInput.value = new Date().toISOString().split('T')[0];
    }

    // 3. Charger les coiffeuses automatiquement
    if (serviceSelect.value && dateInput.value) {
        maybeLoadEmployees();

        // 4. Une fois chargées, pré-sélectionner la coiffeuse si indiquée
        if (preEmployeeId) {
            const orig = renderEmployees;
            window.renderEmployees = function(employees) {
                orig(employees);
                const card = document.querySelector(`.emp-card[data-id="${preEmployeeId}"]`);
                if (card) card.click();
                window.renderEmployees = orig;
            };
        }
    }
})();
@endif
</script>

@endsection

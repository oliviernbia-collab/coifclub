@extends('layouts.client')

@section('title', 'Modifier la réservation')
@section('page-title', 'Modifier une réservation')

@section('content')

<style>
:root{
    --pk:#e91e8c;--pk-light:#ff6ab4;--pk-dark:#c91a78;
    --card:#1a1130;--card2:#120e22;
    --border:rgba(255,255,255,.07);--border-pk:rgba(233,30,140,.15);
    --text:#fff;--muted:rgba(255,255,255,.52);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

.rv-form-wrap{ max-width:860px; margin:0 auto; padding:6px 0 60px; }

/* ── HERO ── */
.rv-hero{
    background:linear-gradient(135deg,#120e22 0%,#1a1130 100%);
    border:1px solid var(--border-pk);
    border-radius:22px; padding:26px 30px; margin-bottom:24px;
    display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;
    position:relative; overflow:hidden;
}
.rv-hero::before{
    content:''; position:absolute; top:-50px; right:-70px;
    width:220px; height:220px; border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.1),transparent 70%);
    pointer-events:none;
}
.rv-hero-left{ display:flex; align-items:center; gap:18px; position:relative; z-index:1; }
.rv-hero-icon{
    width:54px; height:54px; border-radius:16px;
    background:rgba(233,30,140,.12); border:1px solid var(--border-pk);
    display:flex; align-items:center; justify-content:center;
    color:var(--pk); font-size:1.4rem; flex-shrink:0;
}
.rv-hero h2{ font-size:1.35rem; font-weight:800; color:var(--text); margin-bottom:3px; }
.rv-hero p{ color:var(--muted); font-size:.85rem; margin:0; }

/* Ref badge */
.rv-ref{
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(233,30,140,.1); border:1px solid var(--border-pk);
    border-radius:10px; padding:8px 14px;
    font-size:.8rem; font-weight:700; color:var(--pk-light);
    position:relative; z-index:1;
}

/* ── SUMMARY CARD ── */
.rv-summary{
    background:var(--card2);
    border:1px solid var(--border);
    border-radius:18px; padding:20px 24px;
    margin-bottom:24px;
    display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
    gap:16px;
}
.rv-sum-item h6{
    font-size:.65rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; color:var(--muted); margin-bottom:5px;
    display:flex; align-items:center; gap:5px;
}
.rv-sum-item h6 i{ color:var(--pk); font-size:.6rem; }
.rv-sum-item p{ font-size:.9rem; font-weight:700; color:var(--text); margin:0; }

/* ── CARD ── */
.rv-form-card{
    background:var(--card);
    border:1px solid var(--border-pk);
    border-radius:22px; padding:30px;
    box-shadow:0 8px 32px rgba(0,0,0,.25);
}

/* ── SECTION LABEL ── */
.rv-section{
    font-size:.68rem; font-weight:700; letter-spacing:.14em;
    text-transform:uppercase; color:var(--pk);
    display:flex; align-items:center; gap:8px;
    margin-bottom:14px; margin-top:26px;
}
.rv-section:first-of-type{ margin-top:0; }
.rv-section::after{ content:''; flex:1; height:1px; background:var(--border-pk); }

/* ── GRID ── */
.rv-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.rv-grid.full{ grid-template-columns:1fr; }

/* ── FIELD ── */
.rv-field{ display:flex; flex-direction:column; gap:6px; }
.rv-label{
    font-size:.78rem; font-weight:700; color:rgba(255,255,255,.7);
    display:flex; align-items:center; gap:6px;
}
.rv-label i{ color:var(--pk); font-size:.7rem; }

.rv-input, .rv-select, .rv-textarea{
    background:rgba(255,255,255,.04); border:1.5px solid rgba(255,255,255,.1);
    border-radius:13px; color:var(--text); padding:12px 15px;
    font-size:.9rem; font-family:inherit; outline:none;
    transition:border-color .2s, box-shadow .2s, background .2s; width:100%;
}
.rv-select option{ background:#1a1130; color:#fff; }
.rv-input:focus, .rv-select:focus, .rv-textarea:focus{
    border-color:var(--pk);
    box-shadow:0 0 0 3px rgba(233,30,140,.12);
    background:rgba(233,30,140,.04);
}
.rv-input::placeholder, .rv-textarea::placeholder{ color:rgba(255,255,255,.28); }
.rv-textarea{ resize:vertical; min-height:100px; }
.rv-error{ font-size:.76rem; color:#f87171; display:flex; align-items:center; gap:5px; margin-top:3px; }

/* ── STATUS SELECTOR ── */
.status-options{ display:flex; flex-wrap:wrap; gap:10px; }
.status-opt input[type="radio"]{ display:none; }
.status-opt label{
    display:inline-flex; align-items:center; gap:7px;
    padding:10px 18px; border-radius:12px;
    border:1.5px solid rgba(255,255,255,.1);
    background:rgba(255,255,255,.04);
    color:rgba(255,255,255,.6); font-size:.84rem; font-weight:600;
    cursor:pointer; transition:.2s; white-space:nowrap;
}
.status-opt input[type="radio"]:checked + label{
    border-color:transparent; color:#fff; font-weight:700;
}
.status-opt.opt-pending input:checked + label{ background:rgba(251,191,36,.18); border-color:rgba(251,191,36,.4); color:#fbbf24; }
.status-opt.opt-confirmed input:checked + label{ background:rgba(74,222,128,.15); border-color:rgba(74,222,128,.35); color:#4ade80; }
.status-opt.opt-done input:checked + label{ background:rgba(148,163,184,.12); border-color:rgba(148,163,184,.3); color:#94a3b8; }
.status-opt.opt-cancelled input:checked + label{ background:rgba(248,113,113,.12); border-color:rgba(248,113,113,.3); color:#f87171; }

/* ── ACTIONS ── */
.rv-actions{
    display:flex; justify-content:space-between; align-items:center;
    margin-top:28px; padding-top:22px; border-top:1px solid var(--border);
    flex-wrap:wrap; gap:12px;
}
.btn-rv-back{
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 22px; border-radius:13px;
    background:rgba(255,255,255,.05); border:1.5px solid rgba(255,255,255,.1);
    color:rgba(255,255,255,.72); font-weight:600; font-size:.88rem;
    text-decoration:none; transition:.2s;
}
.btn-rv-back:hover{ border-color:rgba(255,255,255,.22); color:#fff; background:rgba(255,255,255,.08); }

.btn-rv-save{
    display:inline-flex; align-items:center; gap:9px;
    padding:13px 28px; border-radius:13px;
    background:var(--gradient); border:none;
    color:#fff; font-weight:800; font-size:.9rem;
    cursor:pointer; transition:.25s;
    box-shadow:0 8px 24px rgba(233,30,140,.3);
}
.btn-rv-save:hover{ transform:translateY(-2px); box-shadow:0 12px 30px rgba(233,30,140,.42); }

/* ── RESPONSIVE ── */
@media(max-width:640px){
    .rv-form-card{ padding:20px 18px; }
    .rv-hero{ padding:18px; }
    .rv-hero-left{ gap:12px; }
    .rv-grid{ grid-template-columns:1fr; }
    .rv-actions{ flex-direction:column; align-items:stretch; }
    .btn-rv-back, .btn-rv-save{ justify-content:center; }
    .rv-summary{ grid-template-columns:1fr 1fr; }
    .status-options{ flex-direction:column; }
    .status-opt label{ width:100%; }
}
</style>

<div class="rv-form-wrap">

    {{-- Hero --}}
    <div class="rv-hero">
        <div class="rv-hero-left">
            <div class="rv-hero-icon"><i class="fa-solid fa-calendar-pen"></i></div>
            <div>
                <h2>Modifier la réservation</h2>
                <p>Mettez à jour les informations du rendez-vous</p>
            </div>
        </div>
        @if($reservation->reference ?? null)
        <span class="rv-ref"><i class="fa-solid fa-hashtag"></i>{{ $reservation->reference }}</span>
        @endif
    </div>

    {{-- Résumé actuel --}}
    <div class="rv-summary">
        <div class="rv-sum-item">
            <h6><i class="fa-solid fa-user"></i> Cliente</h6>
            <p>{{ $reservation->client->name ?? '—' }}</p>
        </div>
        <div class="rv-sum-item">
            <h6><i class="fa-solid fa-scissors"></i> Service</h6>
            <p>{{ $reservation->service->name ?? $reservation->service->nom ?? '—' }}</p>
        </div>
        <div class="rv-sum-item">
            <h6><i class="fa-regular fa-calendar"></i> Date actuelle</h6>
            <p>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</p>
        </div>
        <div class="rv-sum-item">
            <h6><i class="fa-regular fa-clock"></i> Heure</h6>
            <p>{{ $reservation->start_time ?? $reservation->heure_reservation ?? '—' }}</p>
        </div>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:16px;padding:16px 20px;margin-bottom:20px;">
        <strong style="color:#f87171;display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <i class="fa-solid fa-triangle-exclamation"></i> Veuillez corriger les erreurs :
        </strong>
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $err)
            <li style="color:rgba(248,113,113,.85);font-size:.84rem;">{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="rv-form-card">
        <form action="{{ route('reservations.update', $reservation) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Client & Service --}}
            <div class="rv-section"><i class="fa-solid fa-users"></i> Client & Service</div>
            <div class="rv-grid">
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-solid fa-user"></i> Cliente</label>
                    <select name="user_id" class="rv-select" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-solid fa-scissors"></i> Service</label>
                    <select name="service_id" class="rv-select" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $reservation->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} — {{ number_format($service->price,0,',',' ') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Date & Heure --}}
            <div class="rv-section"><i class="fa-regular fa-calendar"></i> Date & Heure</div>
            <div class="rv-grid">
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-regular fa-calendar"></i> Date</label>
                    <input type="date" name="date_reservation" class="rv-input"
                           value="{{ $reservation->date }}" required>
                </div>
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-regular fa-clock"></i> Heure</label>
                    <input type="time" name="heure_reservation" class="rv-input"
                           value="{{ $reservation->start_time }}" required>
                </div>
            </div>

            {{-- Statut --}}
            <div class="rv-section"><i class="fa-solid fa-circle-half-stroke"></i> Statut</div>
            <div class="status-options">
                <div class="status-opt opt-pending">
                    <input type="radio" name="status" id="st-pending" value="pending"
                           {{ ($reservation->status == 'pending' || $reservation->status == 'en_attente') ? 'checked' : '' }}>
                    <label for="st-pending"><i class="fa-solid fa-hourglass-half"></i> En attente</label>
                </div>
                <div class="status-opt opt-confirmed">
                    <input type="radio" name="status" id="st-confirmed" value="confirmed"
                           {{ ($reservation->status == 'confirmed' || $reservation->status == 'confirmee') ? 'checked' : '' }}>
                    <label for="st-confirmed"><i class="fa-solid fa-circle-check"></i> Confirmée</label>
                </div>
                <div class="status-opt opt-done">
                    <input type="radio" name="status" id="st-done" value="done"
                           {{ $reservation->status == 'done' ? 'checked' : '' }}>
                    <label for="st-done"><i class="fa-solid fa-flag-checkered"></i> Terminée</label>
                </div>
                <div class="status-opt opt-cancelled">
                    <input type="radio" name="status" id="st-cancelled" value="cancelled"
                           {{ ($reservation->status == 'cancelled' || $reservation->status == 'annulee') ? 'checked' : '' }}>
                    <label for="st-cancelled"><i class="fa-solid fa-circle-xmark"></i> Annulée</label>
                </div>
            </div>

            {{-- Notes --}}
            <div class="rv-section"><i class="fa-regular fa-note-sticky"></i> Notes</div>
            <div class="rv-field">
                <label class="rv-label"><i class="fa-regular fa-comment"></i> Notes / Instructions</label>
                <textarea name="note" class="rv-textarea"
                          placeholder="Informations complémentaires…">{{ $reservation->notes ?? '' }}</textarea>
            </div>

            {{-- Boutons --}}
            <div class="rv-actions">
                <a href="{{ route('reservations.index') }}" class="btn-rv-back">
                    <i class="fa-solid fa-arrow-left"></i> Retour
                </a>
                <button type="submit" class="btn-rv-save">
                    <i class="fa-solid fa-floppy-disk"></i> Mettre à jour
                </button>
            </div>

        </form>
    </div>

</div>

@endsection

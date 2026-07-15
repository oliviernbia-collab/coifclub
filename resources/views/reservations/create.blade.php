@extends('layouts.client')

@section('title', 'Nouvelle réservation')
@section('page-title', 'Créer une réservation')

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
    border-radius:22px;
    padding:26px 30px;
    margin-bottom:24px;
    display:flex; align-items:center; gap:18px;
    position:relative; overflow:hidden;
}
.rv-hero::before{
    content:''; position:absolute; top:-50px; right:-70px;
    width:220px; height:220px; border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.1),transparent 70%);
    pointer-events:none;
}
.rv-hero-icon{
    width:54px; height:54px; border-radius:16px;
    background:rgba(233,30,140,.12); border:1px solid var(--border-pk);
    display:flex; align-items:center; justify-content:center;
    color:var(--pk); font-size:1.4rem; flex-shrink:0;
}
.rv-hero h2{ font-size:1.35rem; font-weight:800; color:var(--text); margin-bottom:3px; }
.rv-hero p{ color:var(--muted); font-size:.85rem; margin:0; }

/* ── CARD ── */
.rv-form-card{
    background:var(--card);
    border:1px solid var(--border-pk);
    border-radius:22px;
    padding:30px;
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
    background:rgba(255,255,255,.04);
    border:1.5px solid rgba(255,255,255,.1);
    border-radius:13px;
    color:var(--text);
    padding:12px 15px;
    font-size:.9rem;
    font-family:inherit;
    outline:none;
    transition:border-color .2s, box-shadow .2s, background .2s;
    width:100%;
}
.rv-select option{ background:#1a1130; color:#fff; }
.rv-input:focus, .rv-select:focus, .rv-textarea:focus{
    border-color:var(--pk);
    box-shadow:0 0 0 3px rgba(233,30,140,.12);
    background:rgba(233,30,140,.04);
}
.rv-input::placeholder, .rv-textarea::placeholder{ color:rgba(255,255,255,.28); }
.rv-textarea{ resize:vertical; min-height:108px; }
.rv-error{ font-size:.76rem; color:#f87171; display:flex; align-items:center; gap:5px; margin-top:3px; }

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

/* ── ERRORS BANNER ── */
.rv-err-box{
    background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.25);
    border-radius:16px; padding:16px 20px; margin-bottom:20px;
}
.rv-err-box strong{ color:#f87171; display:flex; align-items:center; gap:8px; margin-bottom:8px; }
.rv-err-box li{ color:rgba(248,113,113,.85); font-size:.84rem; }

/* ── RESPONSIVE ── */
@media(max-width:640px){
    .rv-form-card{ padding:20px 18px; }
    .rv-hero{ padding:18px; gap:14px; }
    .rv-grid{ grid-template-columns:1fr; }
    .rv-actions{ flex-direction:column; align-items:stretch; }
    .btn-rv-back, .btn-rv-save{ justify-content:center; }
}
</style>

<div class="rv-form-wrap">

    {{-- Hero --}}
    <div class="rv-hero">
        <div class="rv-hero-icon"><i class="fa-solid fa-calendar-plus"></i></div>
        <div>
            <h2>Nouvelle réservation</h2>
            <p>Créez un rendez-vous client en quelques secondes</p>
        </div>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div class="rv-err-box">
        <strong><i class="fa-solid fa-triangle-exclamation"></i> Veuillez corriger les erreurs :</strong>
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="rv-form-card">
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf

            {{-- Client & Service --}}
            <div class="rv-section"><i class="fa-solid fa-users"></i> Client & Service</div>
            <div class="rv-grid">
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-solid fa-user"></i> Cliente</label>
                    <select name="client_id" class="rv-select" required>
                        <option value="">Sélectionner une cliente…</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id')==$client->id?'selected':'' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')<div class="rv-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-solid fa-scissors"></i> Service</label>
                    <select name="service_id" class="rv-select" required>
                        <option value="">Sélectionner un service…</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id')==$service->id?'selected':'' }}>
                                {{ $service->name }} — {{ number_format($service->price,0,',',' ') }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')<div class="rv-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Coiffeuse --}}
            <div class="rv-section"><i class="fa-solid fa-user-tie"></i> Coiffeuse assignée</div>
            <div class="rv-grid full">
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-solid fa-id-badge"></i> Coiffeuse</label>
                    <select name="employee_id" class="rv-select" required>
                        <option value="">Sélectionner une coiffeuse…</option>
                        @foreach($employees ?? collect() as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id')==$emp->id?'selected':'' }}>
                                {{ $emp->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')<div class="rv-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Date & Heure --}}
            <div class="rv-section"><i class="fa-regular fa-calendar"></i> Date & Heure</div>
            <div class="rv-grid">
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-regular fa-calendar"></i> Date du rendez-vous</label>
                    <input type="date" name="date" class="rv-input" value="{{ old('date') }}" required>
                    @error('date')<div class="rv-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
                <div class="rv-field">
                    <label class="rv-label"><i class="fa-regular fa-clock"></i> Heure de début</label>
                    <input type="time" name="start_time" class="rv-input" value="{{ old('start_time') }}" required>
                    @error('start_time')<div class="rv-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Notes --}}
            <div class="rv-section"><i class="fa-regular fa-note-sticky"></i> Notes</div>
            <div class="rv-field">
                <label class="rv-label"><i class="fa-regular fa-comment"></i> Instructions / Préférences</label>
                <textarea name="client_notes" class="rv-textarea"
                          placeholder="Préférences de style, informations utiles…">{{ old('client_notes') }}</textarea>
            </div>

            {{-- Boutons --}}
            <div class="rv-actions">
                <a href="{{ route('reservations.index') }}" class="btn-rv-back">
                    <i class="fa-solid fa-arrow-left"></i> Retour
                </a>
                <button type="submit" class="btn-rv-save">
                    <i class="fa-solid fa-calendar-check"></i> Enregistrer la réservation
                </button>
            </div>

        </form>
    </div>

</div>

@endsection

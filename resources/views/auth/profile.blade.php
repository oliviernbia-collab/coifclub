@extends('layouts.app')

@section('title', 'Mon Profil')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════════════════════════
   TOKENS
══════════════════════════════════════════════════════════════ */
:root {
    --gold:         #C8963C;
    --gold-light:   #E3C07A;
    --gold-dim:     rgba(200,150,60,.14);
    --gold-border:  rgba(200,150,60,.22);
    --wine:         #6B2D3E;
    --wine-deep:    #4A1728;
    --ink:          #09070A;
    --surface:      rgba(16,12,15,.92);
    --surface-lt:   rgba(255,255,255,.04);
    --text-main:    #F2E8D6;
    --text-soft:    rgba(242,232,214,.55);
    --text-muted:   rgba(242,232,214,.3);
    --border:       rgba(200,150,60,.18);
    --border-focus: rgba(200,150,60,.6);
    --radius:       13px;
    --radius-lg:    22px;
    --ease:         cubic-bezier(.4,0,.2,1);
    --ease-spring:  cubic-bezier(.34,1.56,.64,1);
}

/* ══════════════════════════════════════════════════════════════
   FOND IMMERSIF
══════════════════════════════════════════════════════════════ */
.pf-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background:
        url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1600&q=80')
        center / cover no-repeat;
}
.pf-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 70% 50% at 50% 80%, rgba(107,45,62,.5), transparent),
        linear-gradient(to bottom, rgba(9,7,10,.8) 0%, rgba(9,7,10,.55) 50%, rgba(9,7,10,.85) 100%);
}

/* Grain overlay */
.pf-grain {
    position: fixed;
    inset: 0;
    z-index: 1;
    opacity: .032;
    pointer-events: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)'/%3E%3C/svg%3E");
}

/* ══════════════════════════════════════════════════════════════
   LAYOUT
══════════════════════════════════════════════════════════════ */
.pf-page {
    position: relative;
    z-index: 2;
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 52px 20px 60px;
    font-family: 'Outfit', sans-serif;
}

/* Grille 2 colonnes : gauche = identité, droite = formulaires */
.pf-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 22px;
    width: 100%;
    max-width: 900px;
    align-items: start;
}
@media (max-width: 768px) {
    .pf-grid { grid-template-columns: 1fr; }
}

/* ══════════════════════════════════════════════════════════════
   SURFACE PARTAGÉE
══════════════════════════════════════════════════════════════ */
.pf-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    backdrop-filter: blur(20px) saturate(1.3);
    -webkit-backdrop-filter: blur(20px) saturate(1.3);
    box-shadow:
        0 0 0 1px rgba(200,150,60,.06),
        0 28px 56px rgba(0,0,0,.55),
        inset 0 1px 0 rgba(255,255,255,.04);
    overflow: hidden;
    animation: card-in .65s var(--ease) both;
}
@keyframes card-in {
    from { opacity:0; transform: translateY(24px) scale(.985); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}
.pf-card:nth-child(2) { animation-delay: .08s; }
.pf-card:nth-child(3) { animation-delay: .14s; }

/* ══════════════════════════════════════════════════════════════
   COLONNE GAUCHE — Avatar / Identité
══════════════════════════════════════════════════════════════ */
.pf-identity {
    display: flex;
    flex-direction: column;
}

/* En-tête dorée de la carte */
.pf-card-header {
    padding: 26px 24px 20px;
    border-bottom: 1px solid var(--border);
    position: relative;
}
.pf-card-header::before {
    content: '';
    position: absolute;
    top: 0; left: 12%; right: 12%;
    height: 1.5px;
    background: linear-gradient(to right, transparent, var(--gold) 40%, var(--gold-light) 60%, transparent);
    border-radius: 0 0 3px 3px;
    opacity: .65;
}

.pf-section-label {
    font-size: 9.5px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 4px;
}

.pf-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 400;
    color: var(--text-main);
    line-height: 1.15;
}
.pf-section-title em { font-style: italic; color: var(--gold-light); }

/* Avatar */
.pf-avatar-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 28px 24px;
    gap: 16px;
}

.pf-avatar {
    position: relative;
    width: 96px; height: 96px;
    flex-shrink: 0;
}
.pf-avatar-ring {
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: conic-gradient(var(--gold), var(--gold-light), var(--gold));
    opacity: .6;
    animation: spin 8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.pf-avatar-inner {
    position: relative;
    z-index: 1;
    width: 100%; height: 100%;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--wine) 0%, var(--wine-deep) 100%);
    border: 3px solid var(--ink);
    display: grid; place-items: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 300;
    color: var(--gold-light);
    letter-spacing: .02em;
    box-shadow: 0 8px 24px rgba(107,45,62,.4);
}

/* Badges infos */
.pf-info-list {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1px;
}
.pf-info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    transition: background .2s;
}
.pf-info-row:hover { background: var(--surface-lt); }
.pf-info-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    border: 1px solid var(--gold-border);
    background: var(--gold-dim);
    display: grid; place-items: center;
    color: var(--gold);
    font-size: 12px;
    flex-shrink: 0;
}
.pf-info-content { min-width: 0; }
.pf-info-key {
    font-size: 9.5px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 2px;
}
.pf-info-val {
    font-size: 13px;
    color: var(--text-main);
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Badge rôle */
.pf-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 30px;
    border: 1px solid var(--gold-border);
    background: var(--gold-dim);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gold-light);
    margin-top: 4px;
    align-self: flex-start;
    margin-left: 12px;
    margin-bottom: 8px;
}

/* Déconnexion */
.pf-logout-wrap {
    padding: 0 16px 20px;
}
.btn-logout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 11px 16px;
    border-radius: var(--radius);
    border: 1px solid rgba(220,80,80,.25);
    background: rgba(220,80,80,.06);
    color: #E08585;
    font-family: 'Outfit', sans-serif;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background .25s, border-color .25s, color .25s;
}
.btn-logout:hover {
    background: rgba(220,80,80,.14);
    border-color: rgba(220,80,80,.45);
    color: #EFA0A0;
}

/* ══════════════════════════════════════════════════════════════
   COLONNE DROITE — Formulaires empilés
══════════════════════════════════════════════════════════════ */
.pf-right {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

/* Body de carte */
.pf-card-body {
    padding: 28px 28px 32px;
}

/* Champ */
.pf-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.pf-field + .pf-field { margin-top: 18px; }

.pf-field label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--gold);
    transition: color .2s;
}
.pf-field:focus-within label { color: var(--gold-light); }

/* Wrapper icône */
.pf-input-wrap { position: relative; }
.pf-input-wrap .pi-icon {
    position: absolute;
    left: 15px; top: 50%;
    transform: translateY(-50%);
    color: rgba(200,150,60,.38);
    font-size: 13px;
    pointer-events: none;
    transition: color .2s;
}
.pf-input-wrap:focus-within .pi-icon { color: var(--gold); }
.pf-input-wrap .pi-eye {
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 13px;
    padding: 0;
    transition: color .2s;
}
.pf-input-wrap .pi-eye:hover { color: var(--gold-light); }

.pf-input {
    width: 100%;
    height: 50px;
    padding: 0 42px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: rgba(255,255,255,.04);
    color: var(--text-main);
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    outline: none;
    transition: border-color .25s var(--ease), background .25s var(--ease), box-shadow .25s var(--ease);
}
.pf-input::placeholder { color: var(--text-muted); font-size: 13px; }
.pf-input:focus {
    border-color: var(--border-focus);
    background: rgba(200,150,60,.05);
    box-shadow: 0 0 0 3px rgba(200,150,60,.12), 0 4px 16px rgba(200,150,60,.05);
}

/* Grille 2 colonnes dans un formulaire */
.pf-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 500px) { .pf-row { grid-template-columns: 1fr; } }

/* Erreur */
.pf-error {
    font-size: 11.5px;
    color: #E08080;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 3px;
}

/* Bouton submit */
.btn-save {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 28px;
    border-radius: var(--radius);
    border: none;
    background: linear-gradient(135deg, var(--wine) 0%, var(--wine-deep) 55%, var(--wine) 100%);
    background-size: 200% auto;
    color: var(--text-main);
    font-family: 'Outfit', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    cursor: pointer;
    margin-top: 24px;
    transition:
        background-position .5s var(--ease),
        box-shadow .3s var(--ease),
        transform .2s var(--ease-spring);
    box-shadow: 0 4px 20px rgba(107,45,62,.38), inset 0 1px 0 rgba(255,255,255,.06);
}
.btn-save:hover {
    background-position: right center;
    box-shadow: 0 8px 28px rgba(107,45,62,.5);
    transform: translateY(-1px);
}
.btn-save:active { transform: translateY(0); }
/* Shimmer */
.btn-save::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,.12) 50%, transparent 70%);
    transform: translateX(-120%);
    transition: transform .55s var(--ease);
}
.btn-save:hover::after { transform: translateX(120%); }
/* Bord or */
.btn-save::before {
    content: '';
    position: absolute; inset: 0;
    border-radius: inherit;
    border: 1px solid rgba(200,150,60,.18);
    pointer-events: none;
}

/* Alerte succès */
.pf-success {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius);
    border: 1px solid rgba(100,200,120,.25);
    background: rgba(100,200,120,.08);
    color: #90D4A0;
    font-size: 13px;
    margin-bottom: 20px;
    animation: fade-up .4s var(--ease) both;
}

/* Séparateur de section */
.pf-sep {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 22px 0 18px;
    font-size: 9.5px;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--text-muted);
}
.pf-sep::before, .pf-sep::after {
    content: '';
    flex: 1; height: 1px;
    background: linear-gradient(to right, transparent, var(--border), transparent);
}

/* ─── ANIMATIONS ─────────────────────────────────────────── */
@keyframes fade-up {
    from { opacity:0; transform: translateY(12px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ─── SCROLLBAR ──────────────────────────────────────────── */
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: var(--ink); }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
</style>
@endpush

@section('content')

{{-- Fond & grain --}}
<div class="pf-bg" aria-hidden="true"></div>
<div class="pf-grain" aria-hidden="true"></div>

<div class="pf-page">
    <div class="pf-grid">

        {{-- ══════════════════════════════════════════════
             COLONNE GAUCHE — Identité
        ══════════════════════════════════════════════ --}}
        <div class="pf-identity">
            <div class="pf-card">

                {{-- En-tête --}}
                <div class="pf-card-header">
                    <p class="pf-section-label">Votre compte</p>
                    <h2 class="pf-section-title">Mon <em>Profil</em></h2>
                </div>

                {{-- Avatar + initiales --}}
                <div class="pf-avatar-wrap">
                    <div class="pf-avatar">
                        <div class="pf-avatar-ring"></div>
                        <div class="pf-avatar-inner">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                    </div>

                    {{-- Nom sous l'avatar --}}
                    <div style="text-align:center;">
                        <div style="font-family:'Cormorant Garamond',serif;font-size:20px;color:var(--text-main);font-weight:400;">
                            {{ $user->name }}
                        </div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:3px;">
                            Membre depuis {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Badge rôle --}}
                <div class="pf-role-badge">
                    <i class="fa-solid fa-crown" style="font-size:9px;"></i>
                    {{ ucfirst($user->role ?? 'Cliente') }}
                </div>

                {{-- Infos rapides --}}
                <div class="pf-info-list" style="padding: 0 12px 16px;">
                    <div class="pf-info-row">
                        <div class="pf-info-icon"><i class="fa-regular fa-envelope"></i></div>
                        <div class="pf-info-content">
                            <div class="pf-info-key">Email</div>
                            <div class="pf-info-val">{{ $user->email }}</div>
                        </div>
                    </div>
                    @if($user->telephone)
                    <div class="pf-info-row">
                        <div class="pf-info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="pf-info-content">
                            <div class="pf-info-key">Téléphone</div>
                            <div class="pf-info-val">{{ $user->telephone }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="pf-info-row">
                        <div class="pf-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="pf-info-content">
                            <div class="pf-info-key">Ville</div>
                            <div class="pf-info-val">{{ $user->city ?? 'Abidjan' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Déconnexion --}}
                <div class="pf-logout-wrap">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn-logout" type="submit">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Se déconnecter
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             COLONNE DROITE — Formulaires
        ══════════════════════════════════════════════ --}}
        <div class="pf-right">

            {{-- ── CARTE 1 : Informations personnelles ── --}}
            <div class="pf-card" style="animation-delay:.06s;">
                <div class="pf-card-header">
                    <p class="pf-section-label">Modifier</p>
                    <h2 class="pf-section-title">Informations <em>personnelles</em></h2>
                </div>

                <div class="pf-card-body">

                    @if(session('success'))
                        <div class="pf-success">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="pf-row">
                            <div class="pf-field">
                                <label for="name">{{ __('messages.full_name') }}</label>
                                <div class="pf-input-wrap">
                                    <i class="fa-regular fa-user pi-icon"></i>
                                    <input class="pf-input" type="text" id="name" name="name"
                                           value="{{ old('name', $user->name) }}"
                                           placeholder="Jean Dupont" required>
                                </div>
                                @error('name')
                                    <span class="pf-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-field">
                                <label for="telephone">{{ __('messages.about_phone_label') }}</label>
                                <div class="pf-input-wrap">
                                    <i class="fa-solid fa-phone pi-icon"></i>
                                    <input class="pf-input" type="tel" id="telephone" name="telephone"
                                           value="{{ old('telephone', $user->telephone) }}"
                                           placeholder="+225 07 00 00 00">
                                </div>
                                @error('telephone')
                                    <span class="pf-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="pf-field" style="margin-top:18px;">
                            <label for="email">{{ __('messages.salon_info_email_label') }}</label>
                            <div class="pf-input-wrap">
                                <i class="fa-regular fa-envelope pi-icon"></i>
                                <input class="pf-input" type="email" id="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="vous@exemple.com" required>
                            </div>
                            @error('email')
                                <span class="pf-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i>
                            {{ __('messages.save_changes') }}
                        </button>

                    </form>
                </div>
            </div>

            {{-- ── CARTE 2 : Mot de passe ── --}}
            <div class="pf-card" style="animation-delay:.12s;">
                <div class="pf-card-header">
                    <p class="pf-section-label">{{ __('messages.security_section') }}</p>
                    <h2 class="pf-section-title">{{ __('messages.prof_change_pw_btn') }}</h2>
                </div>

                <div class="pf-card-body">

                    @if(session('pw_success'))
                        <div class="pf-success">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('pw_success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="pf-field">
                            <label for="current_password">{{ __('messages.adm_password') }}</label>
                            <div class="pf-input-wrap">
                                <i class="fa-solid fa-lock pi-icon"></i>
                                <input class="pf-input" type="password" id="current_password"
                                       name="current_password" placeholder="••••••••">
                                <button type="button" class="pi-eye" onclick="togglePw('current_password','eye0')">
                                    <i class="fa-regular fa-eye" id="eye0"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <span class="pf-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pf-sep"><span><i class="fa-solid fa-shield-halved" style="margin-right:5px;"></i>Nouveau</span></div>

                        <div class="pf-row">
                            <div class="pf-field">
                                <label for="password">Nouveau mot de passe</label>
                                <div class="pf-input-wrap">
                                    <i class="fa-solid fa-key pi-icon"></i>
                                    <input class="pf-input" type="password" id="password"
                                           name="password" placeholder="••••••••"
                                           oninput="checkStrength(this.value)">
                                    <button type="button" class="pi-eye" onclick="togglePw('password','eye1')">
                                        <i class="fa-regular fa-eye" id="eye1"></i>
                                    </button>
                                </div>
                                {{-- Indicateur de force --}}
                                <div style="display:flex;gap:4px;margin-top:7px;" id="pw-bars">
                                    <div style="flex:1;height:3px;border-radius:2px;background:rgba(255,255,255,.1);transition:.3s;" id="bar1"></div>
                                    <div style="flex:1;height:3px;border-radius:2px;background:rgba(255,255,255,.1);transition:.3s;" id="bar2"></div>
                                    <div style="flex:1;height:3px;border-radius:2px;background:rgba(255,255,255,.1);transition:.3s;" id="bar3"></div>
                                </div>
                                <div style="font-size:10px;letter-spacing:1px;color:var(--text-muted);margin-top:4px;text-transform:uppercase;transition:color .3s;" id="pw-label">Force du mot de passe</div>
                                @error('password')
                                    <span class="pf-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-field">
                                <label for="password_confirmation">Confirmer</label>
                                <div class="pf-input-wrap">
                                    <i class="fa-solid fa-lock pi-icon"></i>
                                    <input class="pf-input" type="password" id="password_confirmation"
                                           name="password_confirmation" placeholder="••••••••">
                                    <button type="button" class="pi-eye" onclick="togglePw('password_confirmation','eye2')">
                                        <i class="fa-regular fa-eye" id="eye2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-shield-halved"></i>
                            Mettre à jour le mot de passe
                        </button>

                    </form>
                </div>
            </div>

        </div>{{-- /pf-right --}}
    </div>{{-- /pf-grid --}}
</div>{{-- /pf-page --}}

@push('scripts')
<script>
/* Toggle visibilité mot de passe */
function togglePw(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.className = show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
}

/* Indicateur de force */
function checkStrength(val) {
    const bars  = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const label = document.getElementById('pw-label');
    bars.forEach(b => { b.style.background = 'rgba(255,255,255,.1)'; });

    if (!val) { label.textContent = 'Force du mot de passe'; label.style.color = ''; return; }

    let score = 0;
    if (val.length >= 8)                              score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val))      score++;
    if (/\d/.test(val) && /[^A-Za-z0-9]/.test(val))  score++;

    const cfg = [
        { color:'#E07070', text:'Faible' },
        { color:'var(--gold)', text:'Moyen' },
        { color:'#70C490', text:'Fort ✓' },
    ];
    const s = cfg[score === 0 ? 0 : score - 1];
    bars.slice(0, score === 0 ? 1 : score).forEach(b => { b.style.background = s.color; });
    label.textContent  = s.text;
    label.style.color  = s.color;
}
</script>
@endpush

@endsection
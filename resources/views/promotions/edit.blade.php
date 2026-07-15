@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('title', 'Modifier une promotion')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
:root{
    --promo-accent: #D4AF37;
    --promo-accent-dim: rgba(212,175,55,.12);
    --promo-surface: rgba(255,255,255,.05);
    --promo-border: rgba(255,255,255,.10);
    --promo-text: #f1f5f9;
    --promo-muted: #94a3b8;
    --promo-radius: 18px;
}

.promo-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 32px;
}

.promo-eyebrow {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .14em;
    color: var(--promo-accent);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.promo-page-title {
    font-size: 28px;
    font-weight: 800;
    color: var(--promo-text);
    margin: 0 0 4px;
    line-height: 1.2;
}

.promo-page-sub {
    font-size: 14px;
    color: var(--promo-muted);
    margin: 0;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    background: var(--promo-surface);
    border: 1px solid var(--promo-border);
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    color: var(--promo-text);
    text-decoration: none;
    transition: background .18s;
    white-space: nowrap;
}
.btn-back:hover {
    background: rgba(255,255,255,.09);
    color: var(--promo-text);
    text-decoration: none;
}

/* ── Status badge ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
}
.status-active   { background: rgba(16,185,129,.12); color: #34d399; border: 1px solid rgba(16,185,129,.25); }
.status-inactive { background: rgba(239,68,68,.10);  color: #f87171; border: 1px solid rgba(239,68,68,.2);   }
.status-draft    { background: rgba(148,163,184,.12); color: #94a3b8; border: 1px solid rgba(148,163,184,.2); }

/* ── Cards layout ── */
.promo-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
    align-items: start;
}

.promo-card {
    background: var(--promo-surface);
    border: 1px solid var(--promo-border);
    border-radius: var(--promo-radius);
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
}

.promo-card::before {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    background: radial-gradient(circle, rgba(212,175,55,.07), transparent 70%);
    border-radius: 50%;
    right: -80px;
    top: -80px;
    pointer-events: none;
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    color: var(--promo-text);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 22px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--promo-border);
}

.form-section-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
    background: var(--promo-accent-dim);
    color: var(--promo-accent);
}

.promo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 18px;
    margin-bottom: 18px;
}

.promo-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.promo-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--promo-muted);
    display: flex;
    align-items: center;
    gap: 5px;
}

.promo-label .req { color: #ff4d6d; }

.promo-input,
.promo-select,
.promo-textarea {
    padding: 12px 15px;
    border-radius: 12px;
    border: 1px solid var(--promo-border);
    background: rgba(255,255,255,.04);
    color: var(--promo-text);
    font-size: 14px;
    font-weight: 500;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
}

.promo-input::placeholder,
.promo-textarea::placeholder { color: #4b5563; }

.promo-input:focus,
.promo-select:focus,
.promo-textarea:focus {
    border-color: var(--promo-accent);
    box-shadow: 0 0 0 3px rgba(212,175,55,.12);
    background: rgba(255,255,255,.07);
}

.promo-select option {
    background: #1e293b;
    color: #f1f5f9;
}

.promo-textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.65;
}

.promo-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--promo-border);
}

.btn-cancel {
    padding: 11px 20px;
    background: var(--promo-surface);
    border: 1px solid var(--promo-border);
    border-radius: 11px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--promo-text);
    text-decoration: none;
    transition: background .18s;
    cursor: pointer;
}
.btn-cancel:hover {
    background: rgba(255,255,255,.09);
    color: var(--promo-text);
    text-decoration: none;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 12px 26px;
    background: linear-gradient(135deg, #D4AF37, #f4d06f);
    color: #111827;
    border: none;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(212,175,55,.28);
    transition: transform .18s, box-shadow .18s;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(212,175,55,.38);
}

/* ── Sidebar info ── */
.promo-sidebar {
    background: var(--promo-surface);
    border: 1px solid var(--promo-border);
    border-radius: var(--promo-radius);
    padding: 24px;
    position: sticky;
    top: 24px;
}

.sidebar-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
    font-size: 13px;
}
.sidebar-info-row:last-child { border-bottom: none; }
.sidebar-info-row span { color: var(--promo-muted); }
.sidebar-info-row strong { color: var(--promo-text); }

.sidebar-section-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .10em;
    color: var(--promo-accent);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 7px;
}

/* ── Alert errors ── */
.alert-err {
    display: flex;
    gap: 10px;
    background: rgba(239,68,68,.07);
    border: 1px solid rgba(239,68,68,.18);
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 22px;
    color: #ef4444;
}
.alert-err ul { margin: 0; padding: 0 0 0 16px; font-size: 13px; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .promo-layout { grid-template-columns: 1fr; }
    .promo-sidebar { display: none; }
}
@media (max-width: 600px) {
    .promo-card { padding: 20px 18px; }
    .promo-header { flex-direction: column; align-items: flex-start; }
    .promo-footer { flex-direction: column; }
    .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
}
</style>

{{-- HEADER --}}
<div class="promo-header">
    <div>
        <div class="promo-eyebrow">
            <i class="fa-solid fa-pen-to-square"></i>
            {{ __('messages.promotions') }}
        </div>
        <h1 class="promo-page-title">Modifier la promotion</h1>
        <p class="promo-page-sub">Mettez à jour les informations de la promotion.</p>
    </div>

    <a href="{{ route('admin.promotions.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        Retour à la liste
    </a>
</div>

{{-- ERRORS --}}
@if($errors->any())
    <div class="alert-err">
        <i class="fa-solid fa-circle-exclamation"></i>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="promo-layout">

    {{-- FORMULAIRE --}}
    <div class="promo-card">

        <div class="form-section-title">
            <div class="form-section-icon"><i class="fa-solid fa-sliders"></i></div>
            Paramètres de la promotion
        </div>

        <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}">
            @csrf
            @method('PUT')

            <div class="promo-grid">

                <div class="promo-field">
                    <label class="promo-label">Code promo <span class="req">*</span></label>
                    <input type="text"
                           name="code"
                           class="promo-input"
                           value="{{ old('code', $promotion->code) }}"
                           required
                           style="text-transform:uppercase; letter-spacing:.08em;">
                </div>

                <div class="promo-field">
                    <label class="promo-label">Type de réduction <span class="req">*</span></label>
                    <select name="type" class="promo-select" required>
                        <option value="percentage"   @selected(old('type',$promotion->type)==='percentage')>Pourcentage (%)</option>
                        <option value="fixed_amount" @selected(old('type',$promotion->type)==='fixed_amount')>Montant fixe</option>
                        <option value="free_service" @selected(old('type',$promotion->type)==='free_service')>Service gratuit</option>
                    </select>
                </div>

                <div class="promo-field">
                    <label class="promo-label">Catégorie <span class="req">*</span></label>
                    <select name="category" class="promo-select" required>
                        <option value="general"      @selected(old('category',$promotion->category)==='general')>Général</option>
                        <option value="black_friday" @selected(old('category',$promotion->category)==='black_friday')>Black Friday</option>
                        <option value="weekend"      @selected(old('category',$promotion->category)==='weekend')>Weekend</option>
                        <option value="student"      @selected(old('category',$promotion->category)==='student')>Étudiant</option>
                    </select>
                </div>

                <div class="promo-field">
                    <label class="promo-label">Valeur</label>
                    <input type="number"
                           name="value"
                           class="promo-input"
                           value="{{ old('value', $promotion->value) }}"
                           min="0" step="any"
                           placeholder="Ex: 10 ou 5000">
                </div>

                <div class="promo-field">
                    <label class="promo-label">Date de début <span class="req">*</span></label>
                    <input type="date"
                           name="valid_from"
                           class="promo-input"
                           value="{{ old('valid_from', $promotion->valid_from->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="promo-field">
                    <label class="promo-label">Date de fin <span class="req">*</span></label>
                    <input type="date"
                           name="valid_until"
                           class="promo-input"
                           value="{{ old('valid_until', $promotion->valid_until->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="promo-field">
                    <label class="promo-label">Statut</label>
                    <select name="status" class="promo-select">
                        <option value="active"   @selected(old('status',$promotion->status)==='active')>Active</option>
                        <option value="inactive" @selected(old('status',$promotion->status)==='inactive')>Inactive</option>
                        <option value="draft"    @selected(old('status',$promotion->status)==='draft')>Brouillon</option>
                    </select>
                </div>

            </div>

            <div class="promo-field" style="margin-bottom:0;">
                <label class="promo-label">Description</label>
                <textarea name="description"
                          rows="4"
                          class="promo-textarea"
                          placeholder="Description de la promotion...">{{ old('description', $promotion->description) }}</textarea>
            </div>

            <div class="promo-footer">
                <a href="{{ route('admin.promotions.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Annuler
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>

    {{-- SIDEBAR --}}
    <div class="promo-sidebar">

        <div class="sidebar-section-title">
            <i class="fa-solid fa-circle-info"></i>
            Infos actuelles
        </div>

        @php
            $statusClass = match($promotion->status) {
                'active'   => 'status-active',
                'inactive' => 'status-inactive',
                default    => 'status-draft',
            };
            $statusLabel = match($promotion->status) {
                'active'   => 'Active',
                'inactive' => 'Inactive',
                default    => 'Brouillon',
            };
        @endphp

        <div class="sidebar-info-row">
            <span>Statut</span>
            <span class="status-badge {{ $statusClass }}">
                <i class="fa-solid fa-circle" style="font-size:6px;"></i>
                {{ $statusLabel }}
            </span>
        </div>

        <div class="sidebar-info-row">
            <span>Code</span>
            <strong style="font-family:monospace;letter-spacing:.08em;">{{ $promotion->code }}</strong>
        </div>

        <div class="sidebar-info-row">
            <span>Valeur</span>
            <strong>
                {{ $promotion->value }}
                {{ $promotion->type === 'percentage' ? '%' : ($promotion->type === 'free_service' ? '—' : '') }}
            </strong>
        </div>

        <div class="sidebar-info-row">
            <span>Début</span>
            <strong>{{ $promotion->valid_from->format('d/m/Y') }}</strong>
        </div>

        <div class="sidebar-info-row">
            <span>Fin</span>
            <strong>{{ $promotion->valid_until->format('d/m/Y') }}</strong>
        </div>

        <div class="sidebar-info-row">
            <span>Créée le</span>
            <strong>{{ $promotion->created_at->format('d/m/Y') }}</strong>
        </div>

    </div>

</div>

@endsection

@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('title', __('messages.adm_edit_cat_title'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

.ec-wrapper {
    font-family: 'Inter', sans-serif;
    color: #f8fafc;
    max-width: 720px;
    margin: 0 auto;
    padding: 8px 0 24px;
}

/* ── Card ───────────────────────────────────────────────── */
.ec-card {
    background: linear-gradient(180deg, #111827, #0b1120);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,.35);
}

.ec-card-head {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 24px 28px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    background: rgba(59,130,246,.05);
}

.ec-card-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: rgba(59,130,246,.12);
    border: 1px solid rgba(59,130,246,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #60a5fa; flex-shrink: 0;
}

.ec-card-title {
    font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 3px;
}

.ec-card-subtitle {
    font-size: 13px; color: #94a3b8;
}

/* ── Alert ──────────────────────────────────────────────── */
.ec-alert {
    margin: 20px 28px 0;
    padding: 16px 20px;
    border-radius: 14px;
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.18);
    color: #fecaca;
    font-size: 13px;
}

.ec-alert strong {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px; font-size: 14px;
}

.ec-alert ul { margin: 0; padding-left: 18px; }
.ec-alert li { margin-bottom: 6px; }

/* ── Form ───────────────────────────────────────────────── */
.ec-form { padding: 28px; }

.ec-group { margin-bottom: 24px; }
.ec-group:last-of-type { margin-bottom: 0; }

.ec-label {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px; font-size: 13px; font-weight: 600;
    color: #e2e8f0; text-transform: uppercase; letter-spacing: .05em;
}

.ec-label i { color: #60a5fa; font-size: 13px; }
.ec-req { color: #f87171; margin-left: 2px; }

.ec-input, .ec-textarea {
    width: 100%;
    border-radius: 14px;
    padding: 14px 18px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    color: #fff; font-size: 14px;
    font-family: 'Inter', sans-serif;
    transition: .2s ease;
    outline: none;
}

.ec-input:focus, .ec-textarea:focus {
    border-color: rgba(59,130,246,.4);
    box-shadow: 0 0 0 4px rgba(59,130,246,.1);
    background: rgba(255,255,255,.06);
}

.ec-input::placeholder, .ec-textarea::placeholder { color: #475569; }

.ec-textarea { resize: vertical; min-height: 120px; line-height: 1.7; }

.ec-hint {
    display: flex; align-items: center; gap: 7px;
    margin-top: 8px; color: #64748b; font-size: 12px;
}

/* ── Footer ─────────────────────────────────────────────── */
.ec-footer {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 28px;
    border-top: 1px solid rgba(255,255,255,.06);
    background: rgba(255,255,255,.02);
    flex-wrap: wrap;
}

.ec-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 22px; border-radius: 14px;
    font-size: 14px; font-weight: 700;
    border: none; cursor: pointer; transition: .2s ease;
    text-decoration: none;
}

.ec-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 8px 24px rgba(59,130,246,.25);
}

.ec-btn-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 12px 30px rgba(59,130,246,.35); }

.ec-btn-secondary {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    color: #94a3b8;
}

.ec-btn-secondary:hover { background: rgba(255,255,255,.09); color: #fff; }

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 640px) {
    .ec-form { padding: 20px 16px; }
    .ec-card-head { padding: 18px 16px; }
    .ec-footer { padding: 16px; }
    .ec-btn { flex: 1; justify-content: center; }
}
</style>
@endpush

@section('content')

<div class="ec-wrapper">

    <div class="ec-card">

        {{-- En-tête compact ---------------------------------------- --}}
        <div class="ec-card-head">
            <div class="ec-card-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div>
                <div class="ec-card-title">{{ __('messages.adm_edit_cat_title') }}</div>
                <div class="ec-card-subtitle">{{ __('messages.adm_edit_cat_subtitle') }}</div>
            </div>
        </div>

        {{-- Erreurs de validation ---------------------------------- --}}
        @if ($errors->any())
        <div class="ec-alert">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> {{ __('messages.validation_error') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Formulaire -------------------------------------------- --}}
        <form method="POST"
              action="{{ route('admin.categories.update', $categorie->id) }}"
              class="ec-form">
            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div class="ec-group">
                <label for="nom" class="ec-label">
                    <i class="fa-solid fa-tag"></i>
                    {{ __('messages.adm_cat_nom_label') }}<span class="ec-req">*</span>
                </label>
                <input type="text" name="nom" id="nom" class="ec-input"
                       value="{{ old('nom', $categorie->nom) }}"
                       placeholder="{{ __('messages.adm_cat_nom_placeholder') }}"
                       required>
                <div class="ec-hint">
                    <i class="fa-regular fa-lightbulb"></i>
                    {{ __('messages.adm_cat_nom_hint') }}
                </div>
            </div>

            {{-- Description --}}
            <div class="ec-group">
                <label for="description" class="ec-label">
                    <i class="fa-solid fa-align-left"></i>
                    {{ __('messages.adm_description') }}
                </label>
                <textarea name="description" id="description" class="ec-textarea"
                          placeholder="{{ __('messages.adm_cat_desc_placeholder') }}"
                >{{ old('description', $categorie->description) }}</textarea>
                <div class="ec-hint">
                    <i class="fa-regular fa-note-sticky"></i>
                    {{ __('messages.adm_cat_desc_hint') }}
                </div>
            </div>

        </form>

        {{-- Pied compact ------------------------------------------ --}}
        <div class="ec-footer">
            <button type="submit" form="ec-form-submit" class="ec-btn ec-btn-primary"
                    onclick="this.closest('.ec-card').querySelector('form').submit()">
                <i class="fa-solid fa-circle-check"></i>
                {{ __('messages.btn_update') }}
            </button>
            <a href="{{ route('admin.categories') }}" class="ec-btn ec-btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                {{ __('messages.btn_back') }}
            </a>
        </div>

    </div>

</div>

@endsection

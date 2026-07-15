@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('title', __('messages.svc_edit_title'))
@section('page-title', __('messages.svc_edit_title'))
@section('page-subtitle', __('messages.svc_edit_subtitle'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

:root {
    --es-bg: #0b1120;
    --es-card: #111827;
    --es-border: rgba(255,255,255,.06);
    --es-text: #f8fafc;
    --es-muted: #94a3b8;
    --es-primary: #ff4d6d;
    --es-primary-dark: #dc3545;
    --es-gold: #d4af37;
    --es-shadow: 0 25px 50px rgba(0,0,0,.35);
}

.es-wrapper { font-family: 'Inter', sans-serif; color: var(--es-text); }

/* ── HERO ── */
.es-hero {
    position: relative;
    overflow: hidden;
    border-radius: 32px;
    padding: 42px;
    margin-bottom: 32px;
    background:
        radial-gradient(circle at top right, rgba(255,77,109,.20), transparent 38%),
        radial-gradient(circle at bottom left, rgba(212,175,55,.12), transparent 38%),
        linear-gradient(145deg, #0f172a, #020617);
    border: 1px solid rgba(255,255,255,.06);
    box-shadow: var(--es-shadow);
}

.es-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 40px 40px;
    opacity: .25;
    pointer-events: none;
}

.es-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--es-primary);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .22em;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.es-eyebrow::before {
    content: '';
    width: 40px;
    height: 1px;
    background: var(--es-primary);
}

.es-title {
    font-family: 'Playfair Display', serif;
    font-size: 50px;
    line-height: 1;
    font-weight: 700;
    color: white;
    margin: 0 0 16px;
}

.es-subtitle {
    max-width: 680px;
    color: rgba(255,255,255,.65);
    line-height: 1.9;
    font-size: 15px;
    margin: 0;
}

.es-date {
    margin-top: 24px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    border-radius: 14px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.06);
    color: #cbd5e1;
    font-size: 13px;
}

/* ── INFO GRID ── */
.es-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.es-info {
    border-radius: 24px;
    padding: 24px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.05);
    backdrop-filter: blur(10px);
    transition: border-color .25s ease, background .25s ease;
}

.es-info:hover {
    border-color: rgba(255,77,109,.2);
    background: rgba(255,77,109,.04);
}

.es-info-icon {
    width: 54px;
    height: 54px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    font-size: 22px;
    background: rgba(255,77,109,.10);
    border: 1px solid rgba(255,77,109,.18);
    color: var(--es-primary);
}

.es-info-title {
    font-size: 16px;
    font-weight: 700;
    color: white;
    margin-bottom: 10px;
}

.es-info-text {
    color: var(--es-muted);
    line-height: 1.8;
    font-size: 14px;
}

/* ── FORM CARD ── */
.es-card {
    background: linear-gradient(180deg, #111827, #0b1120);
    border: 1px solid var(--es-border);
    border-radius: 32px;
    overflow: visible;
    box-shadow: var(--es-shadow);
}

.es-card-head {
    padding: 32px 36px;
    border-bottom: 1px solid rgba(255,255,255,.05);
    display: flex;
    align-items: center;
    gap: 20px;
}

.es-card-head-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: rgba(255,77,109,.12);
    border: 1px solid rgba(255,77,109,.22);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--es-primary);
    flex-shrink: 0;
}

.es-card-title {
    font-size: 22px;
    font-weight: 700;
    color: white;
    margin-bottom: 6px;
}

.es-card-subtitle {
    color: var(--es-muted);
    font-size: 14px;
}

/* ── FORM BODY ── */
.es-form { padding: 36px; }

/* Section dividers */
.es-section {
    margin-bottom: 36px;
    padding-bottom: 36px;
    border-bottom: 1px solid rgba(255,255,255,.05);
}

.es-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.es-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    font-weight: 700;
    color: var(--es-primary);
    text-transform: uppercase;
    letter-spacing: .15em;
    margin-bottom: 24px;
}

.es-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,77,109,.2);
}

/* Grid */
.es-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.es-row.full { grid-template-columns: 1fr; }

/* Group */
.es-group { margin-bottom: 20px; }
.es-group:last-child { margin-bottom: 0; }

.es-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #cbd5e1;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.es-label i { color: var(--es-primary); font-size: 13px; }
.es-label .req { color: var(--es-primary); margin-left: 2px; }

/* Inputs */
.es-input,
.es-select,
.es-textarea {
    width: 100%;
    border: none;
    outline: none;
    border-radius: 16px;
    padding: 16px 20px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    color: white;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    transition: .25s ease;
    appearance: none;
    -webkit-appearance: none;
}

.es-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 44px;
}

.es-select option {
    background: #1e293b;
    color: white;
}

.es-input:focus,
.es-select:focus,
.es-textarea:focus {
    border-color: rgba(255,77,109,.4);
    box-shadow: 0 0 0 4px rgba(255,77,109,.08);
    background: rgba(255,255,255,.06);
}

.es-input::placeholder,
.es-textarea::placeholder {
    color: #475569;
}

.es-textarea {
    resize: vertical;
    min-height: 110px;
    line-height: 1.8;
}

.es-hint {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    color: var(--es-muted);
    font-size: 12px;
}

/* ── ICON PICKER ── */
.es-icon-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 14px;
}

.es-icon-btn {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    border: 1.5px solid rgba(255,255,255,.10);
    background: rgba(255,255,255,.04);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .2s ease;
    user-select: none;
    color: var(--es-muted);
    font-size: 18px;
}

.es-icon-btn:hover {
    border-color: rgba(255,77,109,.45);
    background: rgba(255,77,109,.12);
    color: var(--es-primary);
    transform: scale(1.08);
}

.es-icon-btn.active {
    border-color: var(--es-primary);
    background: rgba(255,77,109,.18);
    color: var(--es-primary);
    box-shadow: 0 0 14px rgba(255,77,109,.22);
}

/* ── IMAGE UPLOAD ── */
.es-upload-area {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.es-preview-img {
    width: 120px;
    height: 120px;
    border-radius: 16px;
    object-fit: cover;
    border: 2px solid rgba(255,77,109,.35);
    flex-shrink: 0;
}

.es-no-image {
    width: 120px;
    height: 120px;
    border-radius: 16px;
    background: rgba(255,255,255,.04);
    border: 2px dashed rgba(255,255,255,.12);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--es-muted);
    font-size: 12px;
    gap: 8px;
    flex-shrink: 0;
}

.es-no-image i { font-size: 28px; color: rgba(255,255,255,.2); }

/* ── TOGGLE ── */
.es-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px;
    border-radius: 16px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.07);
    transition: .2s ease;
}

.es-toggle-row:hover {
    border-color: rgba(255,77,109,.2);
    background: rgba(255,77,109,.04);
}

.es-toggle-label strong {
    display: block;
    color: white;
    font-size: 15px;
    margin-bottom: 4px;
}

.es-toggle-label span {
    color: var(--es-muted);
    font-size: 13px;
}

/* Custom toggle switch */
.es-switch { position: relative; display: inline-block; width: 52px; height: 28px; flex-shrink: 0; }
.es-switch input { opacity: 0; width: 0; height: 0; }
.es-slider {
    position: absolute;
    inset: 0;
    cursor: pointer;
    background: rgba(255,255,255,.1);
    border-radius: 28px;
    transition: .3s;
    border: 1px solid rgba(255,255,255,.1);
}
.es-slider::before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: .3s;
}
.es-switch input:checked + .es-slider {
    background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
    border-color: var(--es-primary);
    box-shadow: 0 0 12px rgba(255,77,109,.3);
}
.es-switch input:checked + .es-slider::before { transform: translateX(24px); }

/* ── ALERT ── */
.es-alert {
    margin: 0 36px 28px;
    padding: 18px 22px;
    border-radius: 18px;
    background: rgba(239,68,68,.10);
    border: 1px solid rgba(239,68,68,.20);
    color: #fecaca;
}

.es-alert strong {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 14px;
}

.es-alert ul { margin: 0; padding-left: 18px; }
.es-alert li { margin-bottom: 6px; font-size: 13px; }

/* ── ACTIONS ── */
.es-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-top: 32px;
    border-top: 1px solid rgba(255,255,255,.05);
    margin-top: 36px;
}

.es-btn {
    border: none;
    outline: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 26px;
    border-radius: 16px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    transition: .25s ease;
    text-decoration: none;
    cursor: pointer;
    letter-spacing: .02em;
}

.es-btn-primary {
    color: white;
    background: linear-gradient(135deg, var(--es-primary), var(--es-primary-dark));
    box-shadow: 0 12px 28px rgba(255,77,109,.25);
}

.es-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 36px rgba(255,77,109,.35);
    color: white;
}

.es-btn-primary:active { transform: translateY(-1px); }

.es-btn-secondary {
    color: #cbd5e1;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
}

.es-btn-secondary:hover {
    background: rgba(255,255,255,.09);
    color: white;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .es-grid { grid-template-columns: 1fr; } }

@media (max-width: 768px) {
    .es-hero { padding: 28px; border-radius: 22px; }
    .es-title { font-size: 34px; }
    .es-row { grid-template-columns: 1fr; }
    .es-form { padding: 24px; }
    .es-card-head { padding: 24px; }
    .es-alert { margin: 0 24px 24px; }
    .es-actions { flex-direction: column; align-items: stretch; }
    .es-btn { justify-content: center; }
    .es-upload-area { flex-direction: column; }
}
</style>
@endpush

@section('content')

<div class="es-wrapper">

    {{-- FORM CARD --}}
    <div class="es-card">

        {{-- Card header --}}
        <div class="es-card-head">
            <div class="es-card-head-icon">
                <i class="fa-solid fa-scissors"></i>
            </div>
            <div>
                <div class="es-card-title">{{ __('messages.svc_card_title') }}</div>
                <div class="es-card-subtitle">{{ __('messages.svc_card_subtitle') }}</div>
            </div>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
        <div class="es-alert" style="margin-top: 28px;">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> {{ __('messages.validation_error') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('admin.services.update', $service) }}"
              method="POST"
              enctype="multipart/form-data"
              class="es-form">
            @csrf
            @method('PATCH')

            {{-- ── SECTION 1 : GÉNÉRAL ── --}}
            <div class="es-section">
                <div class="es-section-title">
                    <i class="fa-solid fa-clipboard-list"></i>
                    {{ __('messages.svc_section_general') }}
                </div>

                <div class="es-row">
                    <div class="es-group">
                        <label for="name" class="es-label">
                            <i class="fa-solid fa-tag"></i>
                            {{ __('messages.svc_field_name') }} <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="es-input"
                               value="{{ old('name', $service->name) }}"
                               placeholder="{{ __('messages.svc_field_name_placeholder') }}"
                               required>
                    </div>

                    <div class="es-group">
                        <label for="categorie_id" class="es-label">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ __('messages.svc_field_category') }} <span class="req">*</span>
                        </label>
                        <select id="categorie_id" name="categorie_id" class="es-select" required>
                            <option value="">{{ __('messages.svc_choose_category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('categorie_id', $service->categorie_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="es-group">
                    <label for="description" class="es-label">
                        <i class="fa-solid fa-align-left"></i>
                        {{ __('messages.svc_field_description') }}
                    </label>
                    <textarea id="description"
                              name="description"
                              class="es-textarea"
                              placeholder="{{ __('messages.svc_desc_placeholder') }}">{{ old('description', $service->description) }}</textarea>
                    <div class="es-hint">
                        <i class="fa-regular fa-lightbulb"></i>
                        {{ __('messages.svc_desc_hint') }}
                    </div>
                </div>
            </div>

            {{-- ── SECTION 2 : DUREE ── --}}
            <div class="es-section">
                <div class="es-section-title">
                    <i class="fa-solid fa-tag"></i>
                    {{ __('messages.svc_field_duration') }}
                </div>

                <div class="es-row">
                    <div class="es-group">
                        <label for="duration" class="es-label">
                            <i class="fa-regular fa-clock"></i>
                            {{ __('messages.svc_field_duration') }} <span class="req">*</span>
                        </label>
                        <input type="number"
                               id="duration"
                               name="duration"
                               class="es-input"
                               value="{{ old('duration', $service->duration) }}"
                               min="15"
                               step="15"
                               placeholder="60"
                               required>
                        <div class="es-hint">
                            <i class="fa-solid fa-circle-info"></i>
                            {{ __('messages.svc_duration_hint') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SECTION 3 : PERSONNALISATION ── --}}
            <div class="es-section">
                <div class="es-section-title">
                    <i class="fa-solid fa-sparkles"></i>
                    {{ __('messages.svc_section_media') }}
                </div>

                <div class="es-row">
                    <div class="es-group">
                        <label for="emoji" class="es-label">
                            <i class="fa-solid fa-icons"></i>
                            {{ __('messages.svc_field_icon') }}
                        </label>
                        <input type="text"
                               id="emoji"
                               name="emoji"
                               class="es-input"
                               value="{{ old('emoji', $service->emoji) }}"
                               maxlength="50"
                               placeholder="{{ __('messages.svc_icon_placeholder') }}"
                               readonly>

                        <div class="es-icon-grid">
                            @foreach([
                                'fa-solid fa-scissors'            => __('messages.svc_icon_scissors'),
                                'fa-solid fa-spa'                 => __('messages.svc_icon_spa'),
                                'fa-solid fa-crown'               => __('messages.svc_icon_crown'),
                                'fa-solid fa-star'                => __('messages.svc_icon_star'),
                                'fa-solid fa-heart'               => __('messages.svc_icon_heart'),
                                'fa-solid fa-leaf'                => __('messages.svc_icon_leaf'),
                                'fa-solid fa-droplet'             => __('messages.svc_icon_droplet'),
                                'fa-solid fa-fire'                => __('messages.svc_icon_fire'),
                                'fa-solid fa-gem'                 => __('messages.svc_icon_gem'),
                                'fa-solid fa-wand-magic-sparkles' => __('messages.svc_icon_sparkles'),
                                'fa-solid fa-hand-sparkles'       => __('messages.svc_icon_hand'),
                                'fa-solid fa-face-smile'          => __('messages.svc_icon_smile'),
                                'fa-solid fa-sun'                 => __('messages.svc_icon_sun'),
                                'fa-solid fa-bolt'                => __('messages.svc_icon_bolt'),
                                'fa-solid fa-shield-halved'       => __('messages.svc_icon_shield'),
                                'fa-solid fa-circle-dot'          => __('messages.svc_icon_dot'),
                            ] as $icon => $label)
                                <div class="es-icon-btn" data-icon="{{ $icon }}" title="{{ $label }}">
                                    <i class="{{ $icon }}"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="es-group">
                        <label for="image" class="es-label">
                            <i class="fa-regular fa-image"></i>
                            {{ __('messages.svc_field_image') }}
                        </label>

                        <div class="es-upload-area">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}"
                                     class="es-preview-img"
                                     alt="{{ $service->name }}">
                            @else
                                <div class="es-no-image">
                                    <i class="fa-regular fa-image"></i>
                                    <span>{{ __('messages.no_image') }}</span>
                                </div>
                            @endif

                            <div style="flex: 1;">
                                <input type="file"
                                       id="image"
                                       name="image"
                                       class="es-input"
                                       accept="image/*">
                                <div class="es-hint" style="margin-top: 10px;">
                                    <i class="fa-solid fa-circle-info"></i>
                                    {{ __('messages.svc_image_hint') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SECTION 4 : STATUT ── --}}
            <div class="es-section">
                <div class="es-section-title">
                    <i class="fa-solid fa-toggle-on"></i>
                    {{ __('messages.svc_section_status') }}
                </div>

                <div class="es-toggle-row">
                    <div class="es-toggle-label">
                        <strong>{{ __('messages.svc_active_label') }}</strong>
                        <span>{{ __('messages.svc_active_desc') }}</span>
                    </div>
                    <label class="es-switch">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                        <span class="es-slider"></span>
                    </label>
                </div>
            </div>

            {{-- ── ACTIONS ── --}}
            <div class="es-actions">
                <button type="submit" class="es-btn es-btn-primary">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ __('messages.btn_update') }}
                </button>
                <a href="{{ route('admin.services.index') }}" class="es-btn es-btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('messages.btn_back') }}
                </a>
            </div>

        </form>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Icon picker ──
    const iconBtns  = document.querySelectorAll('.es-icon-btn');
    const iconInput = document.getElementById('emoji');
    const current   = iconInput.value.trim();

    iconBtns.forEach(btn => {
        if (btn.dataset.icon === current) btn.classList.add('active');

        btn.addEventListener('click', function () {
            iconInput.value = this.dataset.icon;
            iconBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ── Live image preview ──
    const imageInput = document.getElementById('image');
    const previewImg = document.querySelector('.es-preview-img');
    const noImage    = document.querySelector('.es-no-image');

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                if (previewImg) {
                    previewImg.src = e.target.result;
                } else if (noImage) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'es-preview-img';
                    noImage.replaceWith(img);
                }
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush

@endsection

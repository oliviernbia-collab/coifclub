@extends('layouts.app')
@section('title', __('messages.clt_book_take'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ __('messages.clt_book_take') }}</h1>
        <p class="page-subtitle">{{ __('messages.clt_book_subtitle') }}</p>
    </div>
</div>

<div x-data="bookingWizard()" x-init="init()">
    <!-- Stepper -->
    <div style="display:flex;align-items:center;margin-bottom:2rem;max-width:600px;">
        @foreach([__('messages.clt_book_service_step'),__('messages.clt_book_stylist_step'),__('messages.clt_book_datetime_step'),__('messages.clt_book_payment_step')] as $i => $label)
        <div style="display:flex;flex-direction:column;align-items:center;gap:5px;">
            <div style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;transition:all .3s;"
                :style="step > {{ $i+1 }} ? 'background:var(--purple);color:#fff' : (step === {{ $i+1 }} ? 'background:#fff;border:2px solid var(--purple);color:var(--purple)' : 'background:#f0e6da;color:var(--muted)')">
                <span x-show="step > {{ $i+1 }}">✓</span>
                <span x-show="step <= {{ $i+1 }}">{{ $i+1 }}</span>
            </div>
            <span style="font-size:.68rem;white-space:nowrap;" :style="step === {{ $i+1 }} ? 'color:var(--purple);font-weight:600' : 'color:var(--muted)'">{{ $label }}</span>
        </div>
        @if(!$loop->last)
        <div style="flex:1;height:2px;margin:0 6px 18px;" :style="step > {{ $i+1 }} ? 'background:var(--purple)' : 'background:var(--border)'"></div>
        @endif
        @endforeach
    </div>

    <!-- Étape 1 : Choisir la prestation -->
    <div x-show="step === 1">
        <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:1rem;">{{ __('messages.clt_what_service') }}</h2>
        <!-- Filtres catégorie -->
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1rem;">
            <button @click="filterCat='Toutes'" class="btn btn-sm"
                :class="filterCat==='Toutes' ? 'btn-purple' : 'btn-outline'">Toutes</button>
            @foreach(['Tresses','Perruques','Soins','Beauté','Couleur','Extensions'] as $cat)
            <button @click="filterCat='{{ $cat }}'" class="btn btn-sm"
                :class="filterCat==='{{ $cat }}' ? 'btn-purple' : 'btn-outline'">{{ $cat }}</button>
            @endforeach
        </div>
        <div class="grid-3">
            @foreach($services as $s)
            <div @click="selectService({{ $s->id }}, '{{ $s->name }}', {{ $s->price }}, {{ $s->duration }})"
                class="card" style="cursor:pointer;transition:all .2s;"
                :style="booking.service_id === {{ $s->id }} ? 'border:2px solid var(--purple);background:#faf8ff' : 'border:1px solid var(--border)'"
                x-show="filterCat==='Toutes' || filterCat==='{{ $s->category }}'">
                <div style="font-size:1.5rem;margin-bottom:.5rem;">{{ $s->emoji }}</div>
                <span style="font-size:.68rem;background:var(--rose-light);color:var(--rose);padding:2px 8px;border-radius:20px;">{{ $s->category }}</span>
                <h3 style="font-size:.88rem;font-weight:600;margin:.5rem 0 .3rem;">{{ $s->name }}</h3>
                <p style="font-size:.75rem;color:var(--muted);line-height:1.4;">{{ Str::limit($s->description, 60) }}</p>
                <div class="flex-between" style="margin-top:.8rem;padding-top:.7rem;border-top:1px solid #faf5f0;">
                    <span style="font-weight:700;color:var(--purple);font-size:.95rem;">{{ $s->formatted_price }}</span>
                    <span style="font-size:.72rem;color:var(--muted);">{{ $s->formatted_duration }}</span>
                </div>
                <div x-show="booking.service_id === {{ $s->id }}"
                    style="position:absolute;top:10px;right:10px;width:22px;height:22px;border-radius:50%;background:var(--purple);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:#fff;">✓</div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:1.5rem;">
            <button @click="step=2" :disabled="!booking.service_id" class="btn btn-purple"
                :style="!booking.service_id ? 'opacity:.5;cursor:not-allowed' : ''">
                {{ __('messages.clt_continue_stylist') }}
            </button>
        </div>
    </div>

    <!-- Étape 2 : Choisir la coiffeuse + date (pour filtrer les dispo) -->
    <div x-show="step === 2">
        <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:.5rem;">{{ __('messages.clt_choose_date_stylist') }}</h2>
        <p style="font-size:.8rem;color:var(--muted);margin-bottom:1.2rem;">{{ __('messages.clt_date_filter_tip') }}</p>

        <div class="grid-2" style="gap:1rem;margin-bottom:1.2rem;max-width:500px;">
            <div class="form-group">
                <label class="form-label">{{ __('messages.clt_book_desired_date') }} *</label>
                <input type="date" class="form-control purple" x-model="booking.date"
                    :min="today" @change="loadEmployees()">
            </div>
        </div>

        <div x-show="!booking.date" style="color:var(--muted);font-size:.83rem;padding:1rem 0;">
            <i class="ti ti-arrow-up" style="margin-right:5px;"></i>{{ __('messages.clt_book_select_date') }}
        </div>

        <div x-show="booking.date && loadingEmployees" style="text-align:center;padding:2rem;color:var(--muted);">
            <i class="ti ti-loader-2" style="animation:spin 1s linear infinite;display:inline-block;font-size:1.5rem;"></i>
            {{ __('messages.clt_book_loading') }}
        </div>

        <div x-show="booking.date && !loadingEmployees" class="grid-3">
            <template x-for="e in availableEmployees" :key="e.id">
                <div @click="selectEmployee(e)" class="card" style="cursor:pointer;transition:all .2s;"
                    :style="booking.employee_id === e.id ? 'border:2px solid var(--purple);background:#faf8ff' : 'border:1px solid var(--border)'">
                    <div style="width:50px;height:50px;border-radius:12px;background:#f0eefb;display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:700;color:var(--purple);margin-bottom:.7rem;">
                        <span x-text="e.name.split(' ').map(w=>w[0]).join('')"></span>
                    </div>
                    <h3 style="font-size:.88rem;font-weight:600;" x-text="e.name"></h3>
                    <p style="font-size:.75rem;color:var(--purple);margin:.2rem 0;" x-text="e.specialty"></p>
                    <p style="font-size:.72rem;color:var(--muted);" x-text="'⭐ ' + e.rating + ' · ' + e.slots.length + ' créneaux'"></p>
                    <div x-show="booking.employee_id === e.id"
                        style="position:absolute;top:10px;right:10px;width:22px;height:22px;border-radius:50%;background:var(--purple);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:#fff;">✓</div>
                </div>
            </template>
        </div>

        <div x-show="booking.date && !loadingEmployees && availableEmployees.length === 0" class="card" style="text-align:center;padding:2rem;color:var(--muted);">
            {{ __('messages.clt_book_no_stylist') }}
        </div>

        <div style="display:flex;gap:.8rem;margin-top:1.5rem;">
            <button @click="step=1" class="btn btn-outline">{{ __('messages.clt_book_back') }}</button>
            <button @click="step=3" :disabled="!booking.employee_id || !booking.date" class="btn btn-purple"
                :style="!booking.employee_id || !booking.date ? 'opacity:.5;cursor:not-allowed' : ''">
                {{ __('messages.clt_book_continue') }} →
            </button>
        </div>
    </div>

    <!-- Étape 3 : Choisir l'heure -->
    <div x-show="step === 3" style="max-width:500px;">
        <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:1rem;">{{ __('messages.clt_book_choose_slot') }}</h2>
        <div class="card" style="margin-bottom:1rem;">
            <p style="font-size:.8rem;color:var(--muted);margin-bottom:1rem;">
                Créneaux disponibles le <strong x-text="formatDate(booking.date)"></strong>
                avec <strong x-text="selectedEmployee?.name"></strong>
            </p>
            <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                <template x-for="slot in selectedEmployee?.slots ?? []" :key="slot">
                    <div @click="booking.time = slot" style="padding:8px 18px;border-radius:20px;cursor:pointer;font-size:.85rem;font-weight:500;transition:all .2s;"
                        :style="booking.time === slot
                            ? 'background:var(--purple);color:#fff;border:1.5px solid var(--purple)'
                            : 'background:#fff;border:1.5px solid var(--border);color:var(--text)'">
                        <span x-text="slot"></span>
                    </div>
                </template>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('messages.clt_book_note_stylist') }}</label>
            <textarea class="form-control purple" x-model="booking.notes" rows="2"
                placeholder="{{ __('messages.notes') }}"></textarea>
        </div>
        <div style="display:flex;gap:.8rem;">
            <button @click="step=2" class="btn btn-outline">{{ __('messages.clt_book_back') }}</button>
            <button @click="step=4" :disabled="!booking.time" class="btn btn-purple"
                :style="!booking.time ? 'opacity:.5;cursor:not-allowed' : ''">
                {{ __('messages.clt_book_continue') }} →
            </button>
        </div>
    </div>

    <!-- Étape 4 : Paiement -->
    <div x-show="step === 4" style="max-width:480px;">
        <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:1rem;">{{ __('messages.clt_book_summary') }}</h2>

        <!-- Récapitulatif -->
        <div class="card" style="margin-bottom:1rem;">
            <span class="card-title">{{ __('messages.clt_book_your_booking') }}</span>
            @foreach([
                ['key'=>__('messages.clt_book_service_label'),'val'=>'selectedService?.name'],
                ['key'=>__('messages.clt_book_stylist_label'),'val'=>'selectedEmployee?.name'],
                ['key'=>__('messages.clt_book_date_label'),   'val'=>'formatDate(booking.date)'],
                ['key'=>__('messages.clt_book_time_label'),   'val'=>'booking.time'],
                ['key'=>__('messages.clt_book_duration_label'),'val'=>'selectedService?.duration + " min"'],
            ] as $row)
            <div class="flex-between" style="padding:8px 0;border-bottom:1px solid #faf5f0;font-size:.83rem;">
                <span class="text-muted">{{ $row['key'] }}</span>
                <span style="font-weight:500;" x-text="{{ $row['val'] }}"></span>
            </div>
            @endforeach
            <div class="flex-between" style="padding:10px 0;font-size:1rem;">
                <span style="font-weight:700;">{{ __('messages.clt_book_total') }}</span>
                <span style="font-weight:700;color:var(--purple);font-size:1.1rem;" x-text="formatPrice(selectedService?.price)"></span>
            </div>
        </div>

        <!-- Méthode de paiement -->
        <div class="card" style="margin-bottom:1rem;">
            <span class="card-title">{{ __('messages.clt_book_payment_method') }}</span>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">
                @foreach([
                    ['id'=>'orange_money','label'=>'Orange Money','icon'=>'device-mobile','color'=>'#f97316'],
                    ['id'=>'mtn_money','label'=>'MTN Money','icon'=>'device-mobile','color'=>'#eab308'],
                    ['id'=>'wave','label'=>'Wave','icon'=>'device-mobile','color'=>'#3b82f6'],
                    ['id'=>'stripe','label'=>__('messages.clt_pay_card'),'icon'=>'credit-card','color'=>'#6366f1'],
                ] as $m)
                <div @click="booking.payment_method='{{ $m['id'] }}'" style="padding:12px;border-radius:10px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s;"
                    :style="booking.payment_method==='{{ $m['id'] }}' ? 'border:2px solid var(--purple);background:#faf8ff' : 'border:1.5px solid var(--border);background:#fff'">
                    <i class="ti ti-{{ $m['icon'] }}" style="font-size:1.2rem;color:{{ $m['color'] }};"></i>
                    <span style="font-size:.8rem;font-weight:500;">{{ $m['label'] }}</span>
                </div>
                @endforeach
            </div>
            <div x-show="['orange_money','mtn_money','wave'].includes(booking.payment_method)" style="margin-top:1rem;">
                <label class="form-label">{{ __('messages.clt_book_mobile_num') }} *</label>
                <input type="tel" class="form-control purple" x-model="booking.phone_number"
                    placeholder="+225 07 00 00 00">
            </div>
        </div>

        <form id="bookingForm" action="{{ route('client.book.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_id"       x-bind:value="booking.service_id">
            <input type="hidden" name="employee_id"      x-bind:value="booking.employee_id">
            <input type="hidden" name="date"             x-bind:value="booking.date">
            <input type="hidden" name="time"             x-bind:value="booking.time">
            <input type="hidden" name="payment_method"   x-bind:value="booking.payment_method">
            <input type="hidden" name="phone_number"     x-bind:value="booking.phone_number">
            <input type="hidden" name="notes"            x-bind:value="booking.notes">
        </form>

        <div style="display:flex;gap:.8rem;">
            <button @click="step=3" class="btn btn-outline">{{ __('messages.clt_book_back') }}</button>
            <button @click="submitBooking()" :disabled="!booking.payment_method" class="btn btn-purple w-full"
                :style="!booking.payment_method ? 'opacity:.5;cursor:not-allowed' : ''">
                <i class="ti ti-lock" style="margin-right:5px;"></i>
                {{ __('messages.clt_book_pay_confirm') }}
            </button>
        </div>
    </div>
</div>

<style>
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

/* Design tokens & grid system for this booking wizard (absents de layouts.app) */
:root {
    --purple:      #e83e8c;
    --purple-dark: #c91a78;
    --rose:        #c91a78;
    --rose-light:  rgba(232,62,140,.1);
    --border:      rgba(0,0,0,.08);
    --muted:       #6b7280;
    --text:        #1f1f2e;
}

.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.page-title { font-size:1.5rem; font-weight:800; color:#1a1a2e; margin:0 0 4px; }
.page-subtitle { font-size:.85rem; color:var(--muted); margin:0; }

.grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
.grid-2 { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }

.card { position:relative; background:#fff; border-radius:14px; padding:16px; border:1px solid var(--border); box-shadow:0 2px 10px rgba(0,0,0,.04); }
.card-title { display:block; font-size:.8rem; font-weight:700; color:#1a1a2e; margin-bottom:10px; text-transform:uppercase; letter-spacing:.04em; }

.btn { display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:10px 18px; border-radius:10px; border:none; font-size:.85rem; font-weight:600; cursor:pointer; text-decoration:none; transition:.2s; }
.btn-sm { padding:7px 14px; font-size:.78rem; border-radius:20px; }
.btn-purple { background:var(--purple); color:#fff; }
.btn-purple:hover { background:var(--purple-dark); }
.btn-outline { background:#fff; color:var(--text); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--purple); color:var(--purple); }
.w-full { width:100%; }

.form-group { margin-bottom:14px; }
.form-label { display:block; font-size:.78rem; font-weight:600; color:var(--text); margin-bottom:6px; }
.form-control { width:100%; padding:10px 14px; border-radius:10px; border:1.5px solid var(--border); font-size:.85rem; color:var(--text); background:#fff; }
.form-control.purple:focus { outline:none; border-color:var(--purple); }

.flex-between { display:flex; align-items:center; justify-content:space-between; }
.text-muted { color:var(--muted); }

/* ── Responsive : repli mobile de la grille et de la barre d'étapes ── */
@media (max-width:991px) {
    .grid-3 { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:767px) {
    .grid-3, .grid-2 { grid-template-columns:1fr; }
    .page-title { font-size:1.25rem; }
}
</style>
@endsection

@push('scripts')
<script>
function bookingWizard() {
    return {
        step: 1,
        filterCat: 'Toutes',
        today: new Date().toISOString().split('T')[0],
        booking: { service_id:null, employee_id:null, date:'', time:'', payment_method:'', phone_number:'', notes:'' },
        selectedService: null,
        selectedEmployee: null,
        availableEmployees: [],
        loadingEmployees: false,

        init() {},

        selectService(id, name, price, duration) {
            this.booking.service_id = id;
            this.selectedService = { id, name, price, duration };
        },

        selectEmployee(e) {
            this.booking.employee_id = e.id;
            this.selectedEmployee = e;
            this.booking.time = '';
        },

        async loadEmployees() {
            if (!this.booking.date || !this.booking.service_id) return;
            this.loadingEmployees = true;
            this.availableEmployees = [];
            this.booking.employee_id = null;
            try {
                const r = await fetch(`/api/employees?service_id=${this.booking.service_id}&date=${this.booking.date}`, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const d = await r.json();
                this.availableEmployees = d.employees;
            } catch(e) { console.error(e); }
            this.loadingEmployees = false;
        },

        formatDate(d) {
            if (!d) return '';
            const localeMap = {
                fr: 'fr-FR',
                es: 'es-ES',
                en: 'en-US',
            };
            const locale = localeMap['{{ app()->getLocale() }}'] ?? 'en-US';
            return new Date(d).toLocaleDateString(locale, { weekday:'long', day:'numeric', month:'long' });
        },

        formatPrice(p) {
            if (!p) return '';
            const localeMap = {
                fr: 'fr-FR',
                es: 'es-ES',
                en: 'en-US',
            };
            const locale = localeMap['{{ app()->getLocale() }}'] ?? 'en-US';
            return new Intl.NumberFormat(locale).format(p);
        },

        submitBooking() {
            document.getElementById('bookingForm').submit();
        }
    }
}
</script>
@endpush

@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', __('messages.s3_title'))
@section('page-title', __('messages.s3_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-light:#ff6ab4;
    --pink-dark:#c91a78;
    --gradient:linear-gradient(135deg,#e91e8c 0%,#ff6ab4 50%,#c91a78 100%);
    --shadow-pink:0 10px 30px rgba(233,30,140,.3);
    --glass:rgba(255,255,255,0.05);
    --border:rgba(233,30,140,0.15);
}

.booking-container{max-width:1400px;margin:auto;padding:30px 20px 60px;}

.booking-header{text-align:center;margin-bottom:28px;}
.booking-title{font-size:1.9rem;font-weight:800;color:white;margin-bottom:8px;text-shadow:0 3px 10px rgba(0,0,0,.3);}
.booking-subtitle{color:rgba(255,255,255,.75);font-size:.95rem;max-width:600px;margin:auto;}

.booking-progress{display:flex;align-items:center;justify-content:space-between;position:relative;margin-bottom:28px;padding:0 10px;}
.progress-line{position:absolute;top:25px;left:5%;width:90%;height:5px;background:rgba(255,255,255,.15);border-radius:999px;}
.progress-line-active{position:absolute;top:25px;left:5%;width:68%;height:5px;background:var(--gradient);border-radius:999px;box-shadow:0 0 15px rgba(233,30,140,.5);}

.step{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;flex:1;}
.step-circle{width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,.1);border:2px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;backdrop-filter:blur(10px);transition:.3s;}
.step.active .step-circle{background:var(--gradient);border:none;color:white;transform:scale(1.08);box-shadow:var(--shadow-pink);}
.step.completed .step-circle{background:rgba(233,30,140,.35);border-color:rgba(233,30,140,.5);color:var(--pink-light);}
.step-label{margin-top:10px;color:rgba(255,255,255,.75);font-size:.9rem;font-weight:600;}

.datetime-container{display:grid;grid-template-columns:1fr 2fr;gap:35px;margin-bottom:35px;}
@media(max-width:992px){.datetime-container{grid-template-columns:1fr;}}

.date-selection,
.time-selection,
.booking-summary{
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(16px);
    border:1px solid rgba(233,30,140,0.15);
    border-radius:28px;padding:30px;
    box-shadow:0 15px 45px rgba(0,0,0,.25);
}
.date-title,.time-title{font-size:1.4rem;font-weight:800;color:white;margin-bottom:25px;}

.date-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:15px;}
.date-card{
    background:rgba(255,255,255,0.05);border:2px solid rgba(255,255,255,0.08);
    border-radius:18px;padding:18px;text-align:center;cursor:pointer;transition:.3s;
    position:relative;overflow:hidden;color:rgba(255,255,255,.85);
}
.date-card:hover{transform:translateY(-4px);border-color:var(--pink);box-shadow:var(--shadow-pink);}
.date-card.selected{background:var(--gradient);color:white;border-color:transparent;box-shadow:var(--shadow-pink);}
.date-day{font-size:1.1rem;font-weight:800;position:relative;z-index:2;}
.date-date{font-size:.95rem;opacity:.8;position:relative;z-index:2;}

.time-slots{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:14px;}
.time-slot{
    padding:16px;border-radius:16px;background:rgba(255,255,255,0.05);
    border:2px solid rgba(255,255,255,0.08);text-align:center;
    font-weight:700;cursor:pointer;transition:.3s;color:rgba(255,255,255,.85);
}
.time-slot:hover{transform:translateY(-4px);border-color:var(--pink);box-shadow:var(--shadow-pink);}
.time-slot.selected{background:var(--gradient);color:white;border-color:transparent;box-shadow:var(--shadow-pink);}
.time-slot.unavailable{background:rgba(255,255,255,0.03);color:#555;cursor:not-allowed;opacity:.5;}

.summary-header{display:flex;align-items:center;gap:18px;margin-bottom:25px;}
.summary-avatar{width:75px;height:75px;border-radius:50%;object-fit:cover;border:3px solid rgba(233,30,140,.4);}
.summary-info h4{font-size:1.3rem;font-weight:800;color:white;margin-bottom:5px;}
.summary-info p{color:rgba(255,255,255,.55);}
.summary-details{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;}
.summary-item{background:rgba(255,255,255,0.04);border-radius:18px;padding:18px;border:1px solid rgba(233,30,140,.12);}
.summary-label{font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);font-weight:700;display:block;margin-bottom:6px;}
.summary-value{font-size:1rem;font-weight:800;color:white;}

.notes-section{margin-top:30px;}
.notes-label{display:block;margin-bottom:10px;color:rgba(255,255,255,.8);font-weight:700;}
.notes-input{
    width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(233,30,140,.2);
    border-radius:20px;padding:18px;min-height:120px;resize:none;font-size:1rem;
    color:white;box-shadow:0 10px 30px rgba(0,0,0,.15);
}
.notes-input::placeholder{color:rgba(255,255,255,.3);}
.notes-input:focus{outline:none;border-color:var(--pink);box-shadow:var(--shadow-pink);}

.btn-continue{
    width:100%;margin-top:25px;border:none;border-radius:18px;padding:18px;
    background:var(--gradient);color:white;font-size:1.05rem;font-weight:800;
    cursor:pointer;transition:.3s;box-shadow:var(--shadow-pink);
}
.btn-continue:hover{transform:translateY(-3px);box-shadow:0 15px 40px rgba(233,30,140,.5);}
.btn-continue:disabled{background:rgba(255,255,255,.08);color:#555;cursor:not-allowed;box-shadow:none;}

.booking-navigation{display:flex;justify-content:space-between;align-items:center;margin-top:40px;}
.btn-back{
    padding:14px 24px;border-radius:14px;background:rgba(255,255,255,.06);
    color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.12);
    text-decoration:none;font-weight:700;backdrop-filter:blur(10px);transition:.3s;
}
.btn-back:hover{border-color:var(--pink);color:var(--pink-light);}
.text-muted{color:rgba(255,255,255,.45);font-weight:600;}

@media(max-width:768px){
    .booking-title{font-size:2rem;}
    .summary-details{grid-template-columns:1fr;}
    .booking-navigation{flex-direction:column;gap:20px;}
    .date-grid{grid-template-columns:1fr 1fr;}
}
</style>

<div class="booking-container">

    <!-- HEADER -->
    <div class="booking-header">
        <h1 class="booking-title">{{ __('messages.s3_hero_title') }}</h1>

        <p class="booking-subtitle">
            {{ __('messages.s3_hero_subtitle') }}
        </p>
    </div>

    <!-- PROGRESS -->
    <div class="booking-progress">

        <div class="progress-line"></div>
        <div class="progress-line-active"></div>

        <div class="step completed">
            <div class="step-circle">✓</div>
            <div class="step-label">{{ __('messages.step_service') }}</div>
        </div>

        <div class="step completed">
            <div class="step-circle">✓</div>
            <div class="step-label">{{ __('messages.step_stylist') }}</div>
        </div>

        <div class="step active">
            <div class="step-circle">3</div>
            <div class="step-label">{{ __('messages.step_datetime') }}</div>
        </div>

        <div class="step">
            <div class="step-circle">4</div>
            <div class="step-label">{{ __('messages.step_payment') }}</div>
        </div>

    </div>

    <!-- DATETIME -->
    <div class="datetime-container">

        <!-- DATE -->
        <div class="date-selection">

            <h3 class="date-title">
                <i class="fa-solid fa-calendar-days mr-2 text-yellow-600"></i>
                {{ __('messages.s3_choose_date') }}
            </h3>

            <div class="date-grid">

                @if(empty($availableSlots))
                    <div class="text-center text-gray-500 py-8">
                        {{ __('messages.s3_no_slots') }}
                    </div>
                @else
                    @foreach($availableSlots as $dateKey => $dateData)
                        <div class="date-card"
                             data-date="{{ $dateKey }}"
                             onclick="selectDate('{{ $dateKey }}')">
                            <div class="date-day">
                                {{ $dateData['date']->format('D') }}
                            </div>
                            <div class="date-date">
                                {{ $dateData['date']->format('d/m') }}
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

        </div>

        <!-- TIME -->
        <div class="time-selection">

            <h3 class="time-title">
                <i class="fa-solid fa-clock mr-2 text-yellow-600"></i>
                {{ __('messages.s3_available_slots') }}
            </h3>

            <div class="time-slots" id="timeSlots">
                <div class="text-center text-gray-500 py-8">
                    {{ __('messages.s3_select_date_first') }}
                </div>
            </div>

        </div>

    </div>

    <!-- SUMMARY -->
    <div class="booking-summary">

        <div class="summary-header">

            <img src="{{ $employee->image_url ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?q=80&w=100' }}"
                 alt="{{ $employee->name }}"
                 class="summary-avatar">

            <div class="summary-info">
                <h4>{{ $employee->name }}</h4>
                <p>{{ $service->name }}</p>
                <a href="{{ route('stylists.show', $employee->id) }}"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;padding:5px 14px;border-radius:20px;background:rgba(233,30,140,.12);border:1px solid rgba(233,30,140,.3);color:#ff6ab4;font-size:11.5px;font-weight:700;text-decoration:none;transition:.2s;"
                   onmouseover="this.style.background='rgba(233,30,140,.25)'"
                   onmouseout="this.style.background='rgba(233,30,140,.12)'">
                    <i class="fa-solid fa-user-hair-buns" style="font-size:10px;"></i>
                    {{ __('messages.team_view_profile') }}
                </a>
            </div>

        </div>

        <div class="summary-details">

            <div class="summary-item">
                <span class="summary-label">{{ __('messages.summary_service') }}</span>
                <span class="summary-value">{{ $service->name }}</span>
            </div>

            <div class="summary-item">
                <span class="summary-label">{{ __('messages.summary_price') }}</span>
                <span class="summary-value">{{ $service->formatted_price }}</span>
            </div>

            <div class="summary-item">
                <span class="summary-label">{{ __('messages.summary_duration') }}</span>
                <span class="summary-value">{{ $service->formatted_duration }}</span>
            </div>

            <div class="summary-item" id="selectedDateTime">
                <span class="summary-label">{{ __('messages.step_datetime') }}</span>
                <span class="summary-value">{{ __('messages.s3_select_label') }}</span>
            </div>

        </div>

    </div>

    <!-- NOTES -->
    <div class="notes-section">

        <label class="notes-label">
            {{ __('messages.s3_notes_label') }}
        </label>

        <textarea id="notes"
                  class="notes-input"
                  placeholder="{{ __('messages.s3_notes_placeholder') }}"></textarea>

    </div>

    <!-- FORM -->
    <form id="datetimeForm"
          method="POST"
          action="{{ route('booking.datetime') }}"
          enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="date" id="selectedDate">
        <input type="hidden" name="start_time" id="selectedTime">
        <input type="hidden" name="notes" id="selectedNotes">

        <div class="photo-upload-grid">
            <div class="photo-card">
                <label class="photo-label" for="current_hair_image">
                    <i class="fa-solid fa-camera"></i>
                    {{ __('messages.s3_current_hair') }}
                </label>
                <input type="file" id="current_hair_image" name="current_hair_image" accept="image/*">
                <p class="photo-hint">{{ __('messages.s3_current_hair_hint') }}</p>
            </div>
            <div class="photo-card">
                <label class="photo-label" for="desired_style_image">
                    <i class="fa-solid fa-image"></i>
                    {{ __('messages.s3_desired_style') }}
                </label>
                <input type="file" id="desired_style_image" name="desired_style_image" accept="image/*">
                <p class="photo-hint">Montrez la coiffure ou le style que vous souhaitez.</p>
            </div>
        </div>

        <button type="submit"
                class="btn-continue"
                id="continueBtn"
                disabled>

            <i class="fa-solid fa-credit-card mr-2"></i>
            {{ __('messages.s3_continue_btn') }}

        </button>

    </form>

    <!-- NAVIGATION -->
    <div class="booking-navigation">

        <a href="{{ route('booking.start') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Recommencer
        </a>

        <div class="text-muted">
            {{ __('messages.step_of', ['current' => 3, 'total' => 4]) }}
        </div>

    </div>

</div>

<style>
.photo-upload-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;margin-bottom:1.5rem;}
.photo-card{background:rgba(255,255,255,.05);padding:18px;border-radius:18px;border:1px solid rgba(233,30,140,.15);}
.photo-label{display:inline-flex;align-items:center;gap:10px;font-weight:700;margin-bottom:12px;color:rgba(255,255,255,.85);}
.photo-label i{color:var(--pink-light);}
.photo-card input[type="file"]{width:100%;padding:10px 12px;border:1px solid rgba(233,30,140,.2);border-radius:12px;background:rgba(255,255,255,.06);color:rgba(255,255,255,.7);}
.photo-hint{margin-top:10px;color:rgba(255,255,255,.4);font-size:.92rem;}
@media(max-width:768px){.photo-upload-grid{grid-template-columns:1fr;}}
</style>

<script>
let selectedDate = null;
let selectedTime = null;

const availableSlots = @json($availableSlots);

// Debug temporaire - Afficher les données
console.log('Available slots data:', availableSlots);
console.log('Number of available dates:', Object.keys(availableSlots || {}).length);

if (!availableSlots || Object.keys(availableSlots).length === 0) {
    console.error('No available slots found!');
}

function selectDate(dateKey){

    selectedDate = dateKey;

    document.querySelectorAll('.date-card').forEach(card=>{
        card.classList.remove('selected');
    });

    document.querySelector(`[data-date="${dateKey}"]`)
        .classList.add('selected');

    showTimeSlots(dateKey);

    updateSummary();

    checkContinueButton();
}

function showTimeSlots(dateKey){

    const slots = availableSlots[dateKey]?.slots || [];

    const container = document.getElementById('timeSlots');

    if(slots.length === 0){

        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                {{ __('messages.s3_no_slots') }}
            </div>
        `;

        return;
    }

    container.innerHTML = slots.map(slot => `
        <div class="time-slot"
             onclick="selectTime('${slot.start}', this)">
             ${slot.formatted}
        </div>
    `).join('');
}

function selectTime(time, element){

    selectedTime = time;

    document.querySelectorAll('.time-slot').forEach(slot=>{
        slot.classList.remove('selected');
    });

    element.classList.add('selected');

    updateSummary();

    checkContinueButton();
}

function updateSummary(){

    const summary = document.getElementById('selectedDateTime');

    if(selectedDate && selectedTime){

        const dateObj = new Date(selectedDate);

        const localeMap = { fr: 'fr-FR', es: 'es-ES', en: 'en-US' };
        const locale = localeMap['{{ app()->getLocale() }}'] ?? 'en-US';
        const formattedDate = dateObj.toLocaleDateString(locale,{
            weekday:'long',
            day:'numeric',
            month:'long'
        });

        summary.innerHTML = `
            <span class="summary-label">{{ __('messages.step_datetime') }}</span>
            <span class="summary-value">
                ${formattedDate}<br>${selectedTime}
            </span>
        `;
    }
}

function checkContinueButton(){

    const btn = document.getElementById('continueBtn');

    btn.disabled = !(selectedDate && selectedTime);
}

document.getElementById('notes').addEventListener('input',function(){

    document.getElementById('selectedNotes').value = this.value;
});

document.getElementById('datetimeForm').addEventListener('submit',function(e){

    if(!selectedDate || !selectedTime){

        e.preventDefault();

        alert('{{ __('messages.s3_choose_date') }}');

        return;
    }

    document.getElementById('selectedDate').value = selectedDate;
    document.getElementById('selectedTime').value = selectedTime;
});
</script>

@endsection
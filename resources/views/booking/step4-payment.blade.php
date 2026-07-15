@extends('layouts.client')

@section('title', 'Paiement')
@section('page-title', 'Finaliser votre réservation')

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-light:#ff6ab4;
    --pink-dark:#c91a78;
    --gradient:linear-gradient(135deg,#e91e8c 0%,#ff6ab4 50%,#c91a78 100%);
    --shadow:0 20px 50px rgba(0,0,0,0.25);
    --shadow-pink:0 15px 40px rgba(233,30,140,.3);
}

.booking-container{max-width:1100px;margin:auto;padding:20px;}

.booking-header{
    position:relative;overflow:hidden;border-radius:22px;padding:30px 36px;
    margin-bottom:24px;
    background:linear-gradient(rgba(0,0,0,.75),rgba(0,0,0,.75)),
               url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=1600');
    background-size:cover;background-position:center;text-align:center;
    box-shadow:0 12px 40px rgba(0,0,0,.3);border:1px solid rgba(233,30,140,.2);
}
.booking-header::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(233,30,140,.15),transparent);}
.booking-title{position:relative;font-size:1.9rem;font-weight:900;color:white;margin-bottom:8px;letter-spacing:.3px;}
.booking-subtitle{position:relative;color:rgba(255,255,255,.75);font-size:.92rem;max-width:550px;margin:auto;line-height:1.7;}

.booking-progress{position:relative;display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;padding:0 10px;}
.progress-line{position:absolute;top:24px;left:5%;width:90%;height:5px;border-radius:999px;background:rgba(255,255,255,.1);}
.progress-line-active{position:absolute;top:24px;left:5%;width:90%;height:5px;border-radius:999px;background:var(--gradient);box-shadow:0 0 15px rgba(233,30,140,.4);}

.step{position:relative;z-index:2;text-align:center;flex:1;}
.step-circle{width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,.08);color:rgba(255,255,255,.4);display:flex;align-items:center;justify-content:center;margin:auto auto 10px;font-weight:800;transition:.3s;border:3px solid rgba(255,255,255,.12);box-shadow:0 5px 20px rgba(0,0,0,.2);}
.step.completed .step-circle,.step.active .step-circle{background:var(--gradient);color:white;border-color:transparent;}
.step-label{font-size:.95rem;font-weight:700;color:rgba(255,255,255,.45);}
.step.active .step-label,.step.completed .step-label{color:var(--pink-light);}

.card-luxury{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);border:1px solid rgba(233,30,140,.15);border-radius:28px;padding:35px;margin-bottom:30px;box-shadow:var(--shadow);}
.section-title{font-size:1.5rem;font-weight:800;color:white;margin-bottom:25px;display:flex;align-items:center;gap:12px;}
.section-title i{color:var(--pink-light);}

.summary-row{display:flex;justify-content:space-between;align-items:center;padding:18px 0;border-bottom:1px solid rgba(255,255,255,.06);}
.summary-row:last-child{border-top:2px dashed rgba(233,30,140,.3);border-bottom:none;margin-top:10px;padding-top:24px;}
.summary-label{color:rgba(255,255,255,.5);font-weight:600;}
.summary-value{font-weight:700;color:white;}
.summary-total{color:var(--pink-light);font-size:1.4rem;font-weight:900;}

.method-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px;}
.input-grid{display:grid;gap:18px;margin-top:24px;}
.input-field{display:flex;flex-direction:column;gap:8px;}
.input-field label{font-weight:700;color:rgba(255,255,255,.7);}
.input-field input,.input-field select{
    border:1px solid rgba(233,30,140,.2);border-radius:16px;padding:16px 18px;
    font-size:1rem;color:white;background:rgba(255,255,255,.06);
}
.input-field input::placeholder{color:rgba(255,255,255,.3);}
.input-field select option{background:#1a0535;color:white;}
.input-field input:focus,.input-field select:focus{outline:none;border-color:var(--pink);box-shadow:0 0 0 3px rgba(233,30,140,.15);}
.payment-details{display:none;margin-top:24px;}
.payment-details.active{display:block;}
.payment-details .section-subtitle{margin-bottom:16px;color:rgba(255,255,255,.5);font-size:.95rem;}

.payment-method{
    position:relative;overflow:hidden;border-radius:22px;
    border:2px solid rgba(255,255,255,.08);padding:30px 20px;
    text-align:center;cursor:pointer;transition:.35s ease;
    background:rgba(255,255,255,.04);
}
.payment-method:hover{transform:translateY(-6px);border-color:var(--pink);box-shadow:0 15px 35px rgba(233,30,140,.2);}
.payment-method.selected{border-color:var(--pink);background:rgba(233,30,140,.12);box-shadow:0 20px 45px rgba(233,30,140,.2);}
.payment-method.selected::after{content:'✓';position:absolute;top:12px;right:14px;width:28px;height:28px;border-radius:50%;background:var(--gradient);color:white;line-height:28px;text-align:center;font-size:.9rem;font-weight:bold;}
.method-icon{width:70px;height:70px;margin:auto auto 16px;border-radius:20px;background:rgba(233,30,140,.12);display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--pink-light);}
.method-name{font-size:1rem;font-weight:800;color:white;}
.method-description{margin-top:6px;font-size:.9rem;color:rgba(255,255,255,.45);}

.deposit-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:18px;}
.deposit-option{border-radius:22px;border:2px solid rgba(255,255,255,.08);padding:24px;text-align:center;cursor:pointer;transition:.3s ease;background:rgba(255,255,255,.04);color:white;}
.deposit-option:hover{transform:translateY(-4px);border-color:var(--pink);}
.deposit-option.selected{border-color:var(--pink);background:var(--gradient);color:white;box-shadow:0 15px 40px rgba(233,30,140,.3);}
.deposit-percentage{font-size:1.6rem;font-weight:900;margin-bottom:8px;}
.deposit-amount{font-size:.95rem;font-weight:600;}

.terms-section ul li{margin-bottom:12px;color:rgba(255,255,255,.65);}
.terms-grid{display:flex;flex-direction:column;gap:14px;margin-top:20px;}
.terms-item{display:flex;align-items:flex-start;gap:14px;cursor:pointer;color:rgba(255,255,255,.75);font-weight:600;line-height:1.6;}
.terms-item input[type="checkbox"]{flex-shrink:0;transform:scale(1.25);margin-top:3px;accent-color:var(--pink);}
.terms-notice{margin-top:22px;padding:16px 20px;border-radius:16px;background:rgba(233,30,140,.08);border:1px solid rgba(233,30,140,.2);}
.terms-text{color:rgba(255,255,255,.55);line-height:1.7;margin:0;}
.terms-link{color:var(--pink-light);font-weight:700;text-decoration:none;}
.terms-link:hover{text-decoration:underline;}

.security-notice{
    background:rgba(233,30,140,.08);border:1px solid rgba(233,30,140,.2);
    border-radius:24px;padding:35px;text-align:center;margin-bottom:30px;
    box-shadow:var(--shadow);
}
.security-icon{width:80px;height:80px;margin:auto auto 20px;border-radius:50%;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;box-shadow:var(--shadow-pink);}
.security-text{color:rgba(255,255,255,.6);line-height:1.8;}

.btn-confirm-booking{width:100%;border:none;border-radius:60px;padding:20px;font-size:1.15rem;font-weight:800;color:white;background:var(--gradient);cursor:pointer;transition:.35s ease;box-shadow:var(--shadow-pink);}
.btn-confirm-booking:hover{transform:translateY(-4px);box-shadow:0 20px 50px rgba(233,30,140,.5);}
.btn-confirm-booking:disabled{opacity:.35;cursor:not-allowed;transform:none;box-shadow:none;}

.booking-navigation{margin-top:35px;display:flex;justify-content:space-between;align-items:center;}
.btn-back{padding:14px 26px;border-radius:50px;text-decoration:none;color:rgba(255,255,255,.7);border:2px solid rgba(233,30,140,.25);font-weight:700;transition:.3s;background:rgba(255,255,255,.04);}
.btn-back:hover{background:var(--gradient);color:white;transform:translateY(-2px);}

@media(max-width:768px){
    .booking-container{padding:14px;}
    .booking-header{padding:36px 22px;border-radius:22px;margin-bottom:22px;}
    .booking-title{font-size:1.9rem;margin-bottom:10px;}
    .booking-subtitle{font-size:.92rem;}
    .booking-progress{margin-bottom:24px;padding:0 2px;}
    .step-circle{width:42px;height:42px;font-size:.85rem;}
    .progress-line,.progress-line-active{top:21px;}
    .step-label{font-size:.75rem;}
    .card-luxury{padding:20px 18px;border-radius:20px;margin-bottom:18px;}
    .section-title{font-size:1.15rem;margin-bottom:16px;}
    .summary-row{flex-direction:column;align-items:flex-start;gap:4px;padding:12px 0;}
    .method-grid{grid-template-columns:repeat(2,1fr);gap:12px;}
    .payment-method{padding:20px 14px;border-radius:18px;}
    .method-icon{width:52px;height:52px;font-size:1.5rem;border-radius:14px;margin-bottom:10px;}
    .method-name{font-size:.85rem;}.method-description{font-size:.75rem;}
    .input-field input,.input-field select{padding:13px 14px;font-size:.95rem;border-radius:13px;}
    #payment-card-details .input-grid .input-grid{grid-template-columns:1fr !important;}
    .deposit-grid{gap:10px;}
    .deposit-option{padding:16px 10px;border-radius:16px;}
    .deposit-percentage{font-size:1.35rem;}.deposit-amount{font-size:.78rem;}
    .terms-section ul{font-size:.88rem;padding-left:1.2rem;}.terms-item{font-size:.88rem;}
    .security-notice{padding:24px 18px;border-radius:18px;margin-bottom:20px;}
    .security-icon{width:62px;height:62px;font-size:1.5rem;margin-bottom:14px;}
    .security-text{font-size:.9rem;}
    .btn-confirm-booking{padding:17px;font-size:1rem;border-radius:50px;}
    .booking-navigation{flex-direction:column;gap:14px;margin-top:22px;}
    .btn-back{width:100%;text-align:center;padding:13px 20px;}
}
@media(max-width:480px){
    .booking-container{padding:10px;}
    .booking-header{padding:28px 16px;border-radius:18px;}
    .booking-title{font-size:1.55rem;}.booking-subtitle{display:none;}
    .step-circle{width:36px;height:36px;font-size:.8rem;border-width:3px;}
    .progress-line,.progress-line-active{top:18px;}
    .step-label{font-size:.65rem;}
    .card-luxury{padding:16px 14px;border-radius:18px;}
    .method-icon{width:44px;height:44px;font-size:1.2rem;}.method-name{font-size:.8rem;}
    .deposit-option{padding:13px 8px;}.deposit-percentage{font-size:1.2rem;}.deposit-amount{font-size:.72rem;}
}
</style>

<div class="booking-container">

    @php
        $selectedPaymentMethod = old('payment_method', 'card');
        $selectedDepositPercentage = old('deposit_percentage', 50);
        $selectedDepositAmount = number_format($reservation->amount * $selectedDepositPercentage / 100, 0, ',', ' ');
    @endphp

    <!-- HEADER -->
    <div class="booking-header">
        <h1 class="booking-title">
            {{ __('messages.booking_finalize_title') }}
        </h1>
        <p class="booking-subtitle">
            {{ __('messages.booking_finalize_subtitle') }}
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

        <div class="step completed">
            <div class="step-circle">✓</div>
            <div class="step-label">{{ __('messages.step_date') }}</div>
        </div>

        <div class="step active">
            <div class="step-circle">4</div>
            <div class="step-label">{{ __('messages.step_payment') }}</div>
        </div>

    </div>

    <!-- SUMMARY -->
    <div class="card-luxury">
        <h3 class="section-title">
            <i class="fa-solid fa-receipt"></i>
            {{ __('messages.booking_summary') }}
        </h3>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_service') }}</span>
            <span class="summary-value">{{ $reservation->service->name }}</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_stylist') }}</span>
            <span class="summary-value">{{ $reservation->employee->name }}</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_datetime') }}</span>
            <span class="summary-value">
                {{ \Carbon\Carbon::parse($reservation->date)->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY') }}
                {{ __('messages.booking_at') }} {{ $reservation->start_time }}
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_duration') }}</span>
            <span class="summary-value">{{ $reservation->service->formatted_duration }}</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_total_price') }}</span>
            <span class="summary-value">
                {{ number_format($reservation->amount,0,',',' ') }}
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">{{ __('messages.summary_deposit_selected') }}</span>
            <span class="summary-value" id="depositAmountValue">
                {{ $selectedDepositAmount }}
            </span>
        </div>
    </div>

    <form id="paymentForm" method="POST" action="{{ route('booking.confirm') }}" enctype="multipart/form-data">
        @csrf

        <!-- PAYMENT — CASH ONLY -->
        <div class="card-luxury">

            <h3 class="section-title">
                <i class="fa-solid fa-money-bill-wave"></i>
                {{ __('messages.payment_method') }}
            </h3>

            @if($errors->any())
                <div style="margin-bottom:24px;padding:18px 22px;border-radius:20px;background:#fee2e2;border:1px solid #fecaca;color:#991b1b;">
                    <strong>{{ __('messages.correct_errors') }}</strong>
                    <ul style="margin:12px 0 0 1.2rem;list-style:disc;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info paiement sur place -->
            <div style="display:flex;align-items:center;gap:20px;padding:28px;border-radius:20px;background:rgba(233,30,140,.08);border:1px solid rgba(233,30,140,.2);margin-bottom:24px;">
                <div class="method-icon" style="flex-shrink:0;">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <div class="method-name" style="font-size:1.1rem;margin-bottom:6px;">{{ __('messages.pay_cash_name') }}</div>
                    <div class="method-description" style="font-size:.92rem;line-height:1.6;">{{ __('messages.pay_cash_desc') }}</div>
                </div>
            </div>

            <!-- Champs cachés -->
            <input type="hidden" name="reservation_id"     value="{{ $reservation->id }}">
            <input type="hidden" name="payment_method"     id="selectedPaymentMethod"  value="cash">
            <input type="hidden" name="deposit_percentage" id="depositPercentageInput" value="{{ $selectedDepositPercentage }}">
            <input type="hidden" name="deposit_amount"     id="depositAmountInput"     value="{{ $reservation->amount * $selectedDepositPercentage / 100 }}">

        </div>

        <!-- DEPOSIT -->
        <div class="card-luxury">

            <h3 class="section-title">
                <i class="fa-solid fa-wallet"></i>
                {{ __('messages.choose_deposit') }}
            </h3>

            <div class="deposit-grid">

                <div class="deposit-option {{ $selectedDepositPercentage == 50 ? 'selected' : '' }}"
                     data-percentage="50"
                     onclick="selectDeposit(50)">
                    <div class="deposit-percentage">50%</div>
                    <div class="deposit-amount">{{ number_format($reservation->amount * 0.5,0,',',' ') }}</div>
                </div>

                <div class="deposit-option {{ $selectedDepositPercentage == 70 ? 'selected' : '' }}"
                     data-percentage="70"
                     onclick="selectDeposit(70)">
                    <div class="deposit-percentage">70%</div>
                    <div class="deposit-amount">{{ number_format($reservation->amount * 0.7,0,',',' ') }}</div>
                </div>

                <div class="deposit-option {{ $selectedDepositPercentage == 100 ? 'selected' : '' }}"
                     data-percentage="100"
                     onclick="selectDeposit(100)">
                    <div class="deposit-percentage">100%</div>
                    <div class="deposit-amount">{{ number_format($reservation->amount,0,',',' ') }}</div>
                </div>

            </div>

        </div>

        <!-- TERMS -->
        <div class="card-luxury terms-section">

            <h3 class="section-title">
                <i class="fa-solid fa-file-contract"></i>
                {{ __('messages.booking_conditions_title') }}
            </h3>

            <ul>
                <li>{{ __('messages.cancel_48h') }}</li>
                <li>{{ __('messages.cancel_24h') }}</li>
                <li>{{ __('messages.late_30min') }}</li>
            </ul>

            <div class="terms-grid">
                <label class="terms-item">
                    <input type="checkbox" class="terms-checkbox-item" id="terms_conditions" name="terms_conditions" value="1" {{ old('terms_conditions') ? 'checked' : '' }}>
                    <span>{{ __('messages.accept_general_terms') }}</span>
                </label>
                <label class="terms-item">
                    <input type="checkbox" class="terms-checkbox-item" id="terms_delays" name="terms_delays" value="1" {{ old('terms_delays') ? 'checked' : '' }}>
                    <span>{{ __('messages.accept_delay_rules') }}</span>
                </label>
                <label class="terms-item">
                    <input type="checkbox" class="terms-checkbox-item" id="terms_refunds" name="terms_refunds" value="1" {{ old('terms_refunds') ? 'checked' : '' }}>
                    <span>{{ __('messages.accept_refund_policy') }}</span>
                </label>
            </div>

            <div class="terms-notice">
                <p class="terms-text">{{ __('messages.terms_electronic_signature') }}</p>
            </div>

        </div>

        <!-- SECURITY -->
        <div class="security-notice">
            <div class="security-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="security-text">
                <strong>{{ __('messages.payment_secure_title') }}</strong><br>
                {{ __('messages.payment_ssl_text') }}
            </div>
        </div>

        <button type="submit"
                class="btn-confirm-booking"
                id="confirmBtn"
                disabled>
            <i class="fa-solid fa-lock me-2"></i>
            {{ __('messages.confirm_booking_btn') }}
        </button>

    </form>

    <!-- NAVIGATION -->
    <div class="booking-navigation">
        <a href="{{ route('booking.start') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            {{ __('messages.back') }}
        </a>
        <div class="text-muted fw-bold">
            {{ __('messages.step_of', ['current' => 4, 'total' => 4]) }}
        </div>
    </div>

</div>

<script>

let selectedDepositPercentage = {{ $selectedDepositPercentage }};

const paymentForm = document.getElementById('paymentForm');
const confirmBtn  = document.getElementById('confirmBtn');
const termsCheckboxes = document.querySelectorAll('.terms-checkbox-item');

function selectDeposit(percentage) {
    selectedDepositPercentage = percentage;

    document.querySelectorAll('.deposit-option').forEach(item => item.classList.remove('selected'));

    const selectedEl = document.querySelector(`[data-percentage="${percentage}"]`);
    if (selectedEl) selectedEl.classList.add('selected');

    document.getElementById('depositPercentageInput').value = percentage;
    updateDepositSummary();
}

function updateDepositSummary() {
    const total  = {{ $reservation->amount }};
    const amount = Math.round(total * selectedDepositPercentage / 100);

    const depositValue = document.getElementById('depositAmountValue');
    const depositInput = document.getElementById('depositAmountInput');

    if (depositValue) {
        const localeMap = { fr: 'fr-FR', es: 'es-ES', en: 'en-US' };
        const locale = localeMap['{{ app()->getLocale() }}'] ?? 'en-US';
        depositValue.textContent = amount.toLocaleString(locale, { maximumFractionDigits: 0 });
    }
    if (depositInput) depositInput.value = amount;
}

function checkConfirmButton() {
    const allTermsChecked = Array.from(termsCheckboxes).every(cb => cb.checked);
    if (confirmBtn) confirmBtn.disabled = !allTermsChecked;
}

termsCheckboxes.forEach(cb => cb.addEventListener('change', checkConfirmButton));

if (paymentForm) {
    paymentForm.addEventListener('submit', function () {
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.textContent = '{{ __('messages.confirm_booking_loading') }}';
        }
    });
}

updateDepositSummary();
checkConfirmButton();

</script>

@endsection

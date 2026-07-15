@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', __('messages.s2_title'))
@section('page-title', __('messages.s2_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;
    --pink-light:#ff6ab4;
    --pink-dark:#c91a78;
    --glass:rgba(255,255,255,0.05);
    --border:rgba(233,30,140,0.15);
    --gradient:linear-gradient(135deg,#e91e8c 0%,#ff6ab4 50%,#c91a78 100%);
}

.employee-page{position:relative;overflow:hidden;}
.employee-page::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(circle at top left,rgba(233,30,140,0.12),transparent 25%),
               radial-gradient(circle at bottom right,rgba(233,30,140,0.08),transparent 25%);
}
.employee-container{max-width:1100px;margin:auto;padding:36px 20px 70px;position:relative;z-index:2;}

/* ── HERO ── */
.employee-hero{
    background:linear-gradient(rgba(0,0,0,0.76),rgba(0,0,0,0.8)),
               url('{{ asset('images/C34.jpg') }}');
    background-size:cover;background-position:center;
    border-radius:22px;padding:26px 32px;margin-bottom:22px;
    border:1px solid rgba(233,30,140,0.2);overflow:hidden;position:relative;
    box-shadow:0 10px 32px rgba(0,0,0,0.3);
}
.employee-hero::after{content:'';position:absolute;inset:0;background:linear-gradient(120deg,rgba(233,30,140,0.12),transparent 40%);}
.employee-hero-content{position:relative;z-index:2;max-width:600px;}

.hero-badge{
    display:inline-flex;align-items:center;gap:8px;
    background:rgba(233,30,140,0.12);color:var(--pink-light);
    border:1px solid rgba(233,30,140,0.25);padding:6px 13px;
    border-radius:50px;margin-bottom:12px;font-weight:700;font-size:.82rem;
}
.hero-title{font-size:1.8rem;font-weight:900;line-height:1.15;color:white;margin-bottom:8px;}
.hero-title span{background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.hero-subtitle{font-size:.9rem;line-height:1.65;color:rgba(255,255,255,0.68);}

/* ── PROGRESS ── */
.progress-wrapper{background:var(--glass);backdrop-filter:blur(20px);border:1px solid var(--border);border-radius:18px;padding:18px 24px;margin-bottom:24px;box-shadow:0 6px 20px rgba(0,0,0,0.2);}
.booking-progress{display:flex;justify-content:space-between;position:relative;}
.progress-track{position:absolute;top:24px;left:8%;right:8%;height:3px;background:rgba(255,255,255,0.08);border-radius:20px;}
.progress-active{position:absolute;top:24px;left:8%;width:42%;height:3px;background:var(--gradient);border-radius:20px;}

.step{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;flex:1;}
.step-circle{width:44px;height:44px;border-radius:50%;background:#1F1F1F;border:2px solid rgba(255,255,255,0.08);color:#999;display:flex;align-items:center;justify-content:center;font-weight:700;margin-bottom:8px;font-size:.9rem;}
.step.completed .step-circle{background:rgba(233,30,140,0.2);color:var(--pink-light);border-color:rgba(233,30,140,0.25);}
.step.active .step-circle{background:var(--gradient);color:white;border:none;box-shadow:0 8px 24px rgba(233,30,140,0.4);}
.step-label{color:#aaa;font-weight:600;font-size:0.82rem;}
.step.active .step-label,.step.completed .step-label{color:white;}

/* ── BODY GRID (desktop 2-col) ── */
.step2-body{
    display:grid;
    grid-template-columns:1fr 290px;
    gap:22px;
    align-items:start;
}
.step2-aside{position:sticky;top:20px;}

/* ── SERVICE SUMMARY CARD (aside) ── */
.ssc-aside{
    background:rgba(255,255,255,0.05);
    border:1.5px solid rgba(233,30,140,0.22);
    border-radius:22px;overflow:hidden;
    box-shadow:0 10px 32px rgba(233,30,140,0.1);
}
.ssc-aside-img{position:relative;overflow:hidden;}
.ssc-aside-img img{width:100%;height:170px;object-fit:cover;display:block;transition:.5s;}
.ssc-aside-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(14,10,28,.6),transparent 50%);}
.ssc-aside-badge{
    position:absolute;top:12px;left:12px;z-index:3;
    background:var(--gradient);color:#fff;
    padding:5px 13px;border-radius:99px;
    font-size:.72rem;font-weight:800;
    box-shadow:0 4px 14px rgba(233,30,140,.4);
}
.ssc-aside-body{padding:18px 20px;}
.ssc-aside-label{font-size:.65rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--pink-light);margin-bottom:6px;display:flex;align-items:center;gap:6px;}
.ssc-aside-name{font-size:1.2rem;font-weight:900;color:#fff;line-height:1.2;margin-bottom:10px;}
.ssc-aside-desc{color:rgba(255,255,255,.5);font-size:.8rem;line-height:1.6;margin-bottom:14px;}
.ssc-aside-metas{display:flex;flex-direction:column;gap:8px;}
.ssc-aside-meta{
    display:flex;align-items:center;gap:9px;
    background:rgba(233,30,140,.08);border:1px solid rgba(233,30,140,.16);
    border-radius:10px;padding:8px 12px;
}
.ssc-aside-meta i{color:var(--pink-light);font-size:.82rem;width:14px;text-align:center;}
.ssc-aside-meta-val{font-weight:800;color:#fff;font-size:.9rem;}
.ssc-aside-meta-lbl{font-size:.68rem;color:rgba(255,255,255,.4);margin-left:2px;}

/* ── MAIN (employees) ── */
.step2-main{}

/* info banner */
.s2-info-banner{
    display:flex;align-items:center;gap:12px;
    padding:12px 18px;border-radius:14px;
    background:rgba(233,30,140,.07);border:1px solid rgba(233,30,140,.2);
    margin-bottom:20px;
}
.s2-info-banner i{color:#ff6ab4;font-size:1rem;flex-shrink:0;}
.s2-info-banner span{color:rgba(255,255,255,.8);font-size:.86rem;}

/* section title */
.employees-section-title{
    font-size:.68rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;
    color:var(--pink-light);display:flex;align-items:center;gap:10px;
    margin-bottom:18px;
}
.employees-section-title::after{content:'';flex:1;height:1px;background:rgba(233,30,140,.2);}

/* ── EMPLOYEE GRID ── */
.employees-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px;}

.employee-card{
    background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);
    border-radius:22px;overflow:hidden;transition:.35s ease;cursor:pointer;position:relative;
}
.employee-card:hover{
    transform:translateY(-6px);border-color:rgba(233,30,140,0.28);
    box-shadow:0 18px 44px rgba(0,0,0,0.3),0 0 0 1px rgba(233,30,140,0.08);
}
.employee-image{height:190px;position:relative;overflow:hidden;}
.employee-image::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.6),transparent 55%);}
.employee-image img{width:100%;height:100%;object-fit:cover;transition:0.6s ease;}
.employee-card:hover img{transform:scale(1.06);}

.employee-badge{
    position:absolute;top:12px;left:12px;z-index:3;
    background:var(--gradient);color:white;
    padding:5px 13px;border-radius:50px;font-size:0.74rem;font-weight:800;
}
.employee-content{padding:18px 20px;}
.employee-name{font-size:1.2rem;font-weight:900;color:white;margin-bottom:4px;line-height:1.2;}
.employee-specialty{color:var(--pink-light);font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;font-size:0.75rem;}
.employee-description{color:rgba(255,255,255,.55);line-height:1.65;margin-bottom:16px;font-size:.84rem;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.employee-stats{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
.employee-rating{color:var(--pink-light);font-weight:700;font-size:.84rem;}
.employee-exp{color:rgba(255,255,255,.5);font-weight:600;font-size:.8rem;}
.employee-btn{
    width:100%;border:none;border-radius:13px;padding:12px;
    font-size:.88rem;font-weight:800;background:var(--gradient);color:white;transition:.3s ease;
    cursor:pointer;
}
.employee-btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(233,30,140,0.4);}

/* ── EMPTY ── */
.empty-state{text-align:center;padding:60px 24px;background:rgba(255,255,255,0.04);border-radius:24px;border:1px solid rgba(255,255,255,0.06);}
.empty-icon{font-size:3.5rem;margin-bottom:16px;}
.empty-title{color:white;font-size:1.5rem;font-weight:800;margin-bottom:12px;}
.empty-text{color:#aaa;max-width:420px;margin:auto;line-height:1.75;margin-bottom:24px;font-size:.9rem;}
.empty-btn{display:inline-flex;align-items:center;gap:9px;background:var(--gradient);color:white;padding:13px 24px;border-radius:14px;text-decoration:none;font-weight:800;font-size:.88rem;}

/* ── FOOTER ── */
.booking-footer{margin-top:28px;display:flex;justify-content:space-between;align-items:center;padding-top:22px;border-top:1px solid rgba(255,255,255,0.07);}
.back-btn{display:inline-flex;align-items:center;gap:9px;padding:11px 20px;border-radius:13px;text-decoration:none;color:white;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);transition:.3s ease;font-size:.86rem;}
.back-btn:hover{border-color:rgba(233,30,140,0.35);color:var(--pink-light);}
.step-indicator{color:rgba(255,255,255,.45);font-weight:600;font-size:.84rem;}

/* ── RESPONSIVE ── */
@media(max-width:900px){
    .step2-body{grid-template-columns:1fr;}
    .step2-aside{position:static;order:-1;}
    .ssc-aside-img img{height:210px;}
    .ssc-aside{display:grid;grid-template-columns:180px 1fr;}
    .ssc-aside-img img{height:100%;min-height:160px;}
    .ssc-aside-img::after{background:linear-gradient(to right,transparent 60%,rgba(14,10,28,.5));}
    .employees-grid{grid-template-columns:1fr;}
}
@media(max-width:640px){
    .ssc-aside{display:block;}
    .ssc-aside-img img{height:180px;}
    .employee-hero{padding:20px 18px;border-radius:18px;margin-bottom:16px;}
    .hero-title{font-size:1.45rem;}
    .progress-wrapper{padding:14px 16px;border-radius:16px;margin-bottom:18px;}
    .step-label{font-size:0.68rem;}
    .step-circle{width:38px;height:38px;font-size:.82rem;}
    .booking-footer{flex-direction:column;gap:14px;}
}
</style>

<div class="employee-page">
<div class="employee-container">

    {{-- HERO --}}
    <div class="employee-hero">
        <div class="employee-hero-content">
            <div class="hero-badge">
                <i class="fa-solid fa-scissors"></i>
                {{ __('messages.s2_hero_badge') }}
            </div>
            <h1 class="hero-title">
                {{ __('messages.s2_hero_title_1') }}
                <span>{{ __('messages.s2_hero_title_2') }}</span>
            </h1>
            <p class="hero-subtitle">{{ __('messages.s2_hero_subtitle') }}</p>
        </div>
    </div>

    {{-- PROGRESS --}}
    <div class="progress-wrapper">
        <div class="booking-progress">
            <div class="progress-track"></div>
            <div class="progress-active"></div>
            <div class="step completed">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <div class="step-label">{{ __('messages.step_service') }}</div>
            </div>
            <div class="step active">
                <div class="step-circle">2</div>
                <div class="step-label">{{ __('messages.step_stylist') }}</div>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-label">{{ __('messages.step_datetime') }}</div>
            </div>
            <div class="step">
                <div class="step-circle">4</div>
                <div class="step-label">{{ __('messages.step_payment') }}</div>
            </div>
        </div>
    </div>

    {{-- BODY: 2 colonnes desktop --}}
    <div class="step2-body">

        {{-- MAIN : employees --}}
        <div class="step2-main">

            @if(($employees ?? collect())->count() === 1)
            <div class="s2-info-banner">
                <i class="fa-solid fa-circle-info"></i>
                <span>
                    Vous avez sélectionné <strong style="color:#ff6ab4;">{{ ($employees->first())->name }}</strong>. Cliquez sur son profil pour confirmer.
                </span>
            </div>
            @endif

            <div class="employees-section-title">
                <i class="fa-solid fa-user-tie"></i>
                {{ __('messages.s2_hero_badge') }}
            </div>

            @if(($employees ?? collect())->count() > 0)

            <form id="employeeForm" method="POST" action="{{ route('booking.employee') }}">
                @csrf
                <div class="employees-grid">
                    @foreach($employees ?? collect() as $employee)
                    <div class="employee-card" onclick="selectEmployee({{ $employee->id }})">

                        <div class="employee-image">
                            <div class="employee-badge">{{ __('messages.specialist_badge') }}</div>
                            <img src="{{ $employee->image_url ?? '{{ asset('images/MAROL3.jpg') }}' }}"
                                 alt="{{ $employee->name }}">
                        </div>

                        <div class="employee-content">
                            <h3 class="employee-name">{{ $employee->name }}</h3>
                            <div class="employee-specialty">{{ $service->name }}</div>
                            <p class="employee-description">
                                {{ $employee->bio ?? __('messages.employee_default_bio') }}
                            </p>
                            <div class="employee-stats">
                                <div class="employee-rating">
                                    <i class="fa-solid fa-star"></i>
                                    @php $empAvg = $employee->reviews->avg('rating') ?: 0; @endphp
                                    {{ number_format($empAvg, 1) }} • {{ $employee->reviews->count() }} {{ __('messages.reviews_label') }}
                                </div>
                                <div class="employee-exp">{{ __('messages.exp_years') }}</div>
                            </div>
                            <button type="button" class="employee-btn" onclick="selectEmployee({{ $employee->id }})">
                                <i class="fa-solid fa-user-check"></i>
                                {{ __('messages.choose_this_stylist') }}
                            </button>
                        </div>

                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="employee_id" id="selectedEmployeeId">
            </form>

            @else

            <div class="empty-state">
                <div class="empty-icon">😔</div>
                <h3 class="empty-title">{{ __('messages.no_stylist_title') }}</h3>
                <p class="empty-text">{{ __('messages.no_stylist_text') }}</p>
                <a href="{{ route('booking.start') }}" class="empty-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('messages.choose_other_service') }}
                </a>
            </div>

            @endif

            {{-- FOOTER --}}
            <div class="booking-footer">
                <a href="{{ route('booking.start') }}" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('messages.change_service') }}
                </a>
                <div class="step-indicator">
                    {{ __('messages.step_of', ['current' => 2, 'total' => 4]) }}
                </div>
            </div>

        </div>

        {{-- ASIDE : service sélectionné --}}
        <div class="step2-aside">
            <div class="ssc-aside">

                <div class="ssc-aside-img">
                    <div class="ssc-aside-badge">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ __('messages.summary_service') }}
                    </div>
                    <img src="{{ $service->image ? asset('storage/'.$service->image) : '{{ asset('images/C34.jpg') }}' }}"
                         alt="{{ $service->name }}"
                         onerror="this.src='{{ asset('images/C34.jpg') }}'">
                </div>

                <div class="ssc-aside-body">
                    <div class="ssc-aside-label">
                        <i class="fa-solid fa-scissors"></i>
                        {{ __('messages.your_reservation') }}
                    </div>
                    <div class="ssc-aside-name">{{ $service->name }}</div>
                    @if($service->description)
                    <div class="ssc-aside-desc">{{ \Illuminate\Support\Str::limit($service->description, 90) }}</div>
                    @endif
                    <div class="ssc-aside-metas">
                        <div class="ssc-aside-meta">
                            <i class="fa-solid fa-tag"></i>
                            <span class="ssc-aside-meta-val">{{ $service->formatted_price }}</span>
                        </div>
                        @if($service->formatted_duration)
                        <div class="ssc-aside-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span class="ssc-aside-meta-val">{{ $service->formatted_duration }}</span>
                            <span class="ssc-aside-meta-lbl">durée</span>
                        </div>
                        @endif
                        @if($service->salon)
                        <div class="ssc-aside-meta">
                            <i class="fa-solid fa-location-dot"></i>
                            <span class="ssc-aside-meta-val" style="font-size:.82rem">{{ $service->salon->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
</div>

<script>
function selectEmployee(employeeId) {
    document.getElementById('selectedEmployeeId').value = employeeId;
    document.getElementById('employeeForm').submit();
}
</script>

@endsection

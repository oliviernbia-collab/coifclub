@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', 'Réserver un Rendez-vous')
@section('page-title', 'Réservation Premium')

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

.booking-page{position:relative;overflow:hidden;}
.booking-page::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(circle at top left,rgba(233,30,140,0.12),transparent 25%),
               radial-gradient(circle at bottom right,rgba(233,30,140,0.08),transparent 25%);
}

.booking-container{max-width:1400px;margin:auto;padding:40px 20px 80px;position:relative;z-index:2;}

.booking-hero{
    background:linear-gradient(rgba(0,0,0,0.72),rgba(0,0,0,0.78)),
               url('{{ asset('images/C34.jpg') }}');
    background-size:cover;background-position:center;
    border-radius:26px;padding:38px 44px;margin-bottom:28px;
    position:relative;overflow:hidden;
    border:1px solid rgba(233,30,140,0.2);
    box-shadow:0 12px 40px rgba(0,0,0,0.3);
}
.booking-hero::after{
    content:'';position:absolute;inset:0;
    background:linear-gradient(120deg,rgba(233,30,140,0.15),transparent 40%);
}
.booking-hero-content{position:relative;z-index:2;max-width:700px;}

.booking-badge{
    display:inline-flex;align-items:center;gap:10px;
    background:rgba(233,30,140,0.15);border:1px solid rgba(233,30,140,0.25);
    color:var(--pink-light);padding:10px 18px;border-radius:50px;
    font-weight:600;margin-bottom:25px;
}
.booking-title{font-size:2.4rem;line-height:1.15;font-weight:900;color:white;margin-bottom:14px;}
.booking-title span{background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.booking-subtitle{font-size:1.2rem;line-height:1.8;color:rgba(255,255,255,0.78);}

.booking-progress-wrapper{
    background:var(--glass);backdrop-filter:blur(20px);
    border:1px solid var(--border);border-radius:22px;
    padding:20px 28px;margin-bottom:28px;box-shadow:0 8px 28px rgba(0,0,0,0.2);
}
.booking-progress{display:flex;justify-content:space-between;position:relative;}
.progress-track{position:absolute;top:24px;left:8%;right:8%;height:4px;background:rgba(255,255,255,0.08);border-radius:20px;}
.progress-active{position:absolute;top:24px;left:8%;width:18%;height:4px;background:var(--gradient);border-radius:20px;}

.step{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;flex:1;}
.step-circle{
    width:52px;height:52px;border-radius:50%;background:#1F1F1F;
    border:2px solid rgba(255,255,255,0.08);color:#999;
    display:flex;align-items:center;justify-content:center;
    font-weight:700;margin-bottom:12px;transition:0.4s ease;
}
.step.active .step-circle{background:var(--gradient);color:white;border:none;box-shadow:0 10px 30px rgba(233,30,140,0.4);}
.step-label{color:#aaa;font-weight:600;font-size:0.95rem;}
.step.active .step-label{color:white;}

.category-section{margin-bottom:60px;}
.category-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:25px;}
.category-title{font-size:2rem;font-weight:800;color:white;position:relative;padding-left:18px;}
.category-title::before{content:'';position:absolute;left:0;top:0;bottom:0;width:6px;border-radius:20px;background:var(--gradient);}
.category-count{background:rgba(233,30,140,0.12);color:var(--pink-light);padding:8px 18px;border-radius:50px;font-size:0.9rem;border:1px solid rgba(233,30,140,0.15);}

.services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(360px,1fr));gap:30px;}

.service-card{
    position:relative;background:rgba(255,255,255,0.04);backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.06);border-radius:30px;overflow:hidden;
    transition:0.5s ease;cursor:pointer;
}
.service-card:hover{
    transform:translateY(-10px);border-color:rgba(233,30,140,0.35);
    box-shadow:0 25px 60px rgba(0,0,0,0.35),0 0 0 1px rgba(233,30,140,0.08);
}
.service-image{height:260px;position:relative;overflow:hidden;}
.service-image::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.6),transparent);}
.service-image img{width:100%;height:100%;object-fit:cover;transition:0.8s ease;}
.service-card:hover img{transform:scale(1.08);}

.service-badge{position:absolute;top:18px;left:18px;z-index:3;background:var(--gradient);color:white;padding:8px 15px;border-radius:50px;font-size:0.8rem;font-weight:800;}
.service-content{padding:28px;}
.service-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;}
.service-title{font-size:1.5rem;font-weight:800;color:white;}
.service-rating{color:var(--pink-light);font-size:0.9rem;white-space:nowrap;}
.service-description{color:#b9b9b9;line-height:1.8;margin-bottom:24px;min-height:70px;}
.service-meta{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;}
.service-price{font-size:1.8rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.service-duration{color:#999;font-weight:600;display:flex;align-items:center;gap:8px;}

.service-btn{
    width:100%;border:none;border-radius:18px;padding:16px;
    font-size:1rem;font-weight:800;background:var(--gradient);color:white;transition:0.4s ease;
}
.service-btn:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(233,30,140,0.4);}

.booking-footer{margin-top:70px;display:flex;justify-content:space-between;align-items:center;padding-top:30px;border-top:1px solid rgba(255,255,255,0.08);}
.back-btn{
    display:inline-flex;align-items:center;gap:10px;padding:14px 24px;border-radius:16px;
    text-decoration:none;color:white;background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);transition:0.4s ease;
}
.back-btn:hover{border-color:rgba(233,30,140,0.35);color:var(--pink-light);}
.step-indicator{color:#999;font-weight:600;}

/* ── 768 px : tablette ── */
@media(max-width:768px){
    .booking-container{ padding:24px 16px 60px; }
    .booking-hero{
        padding:48px 28px;
        border-radius:26px;
        margin-bottom:32px;
    }
    .booking-title{ font-size:2.6rem; }
    .booking-subtitle{ font-size:1.05rem; }
    .booking-progress-wrapper{
        padding:24px 20px;
        margin-bottom:34px;
        border-radius:22px;
    }
    .step-circle{ width:44px; height:44px; font-size:.88rem; margin-bottom:10px; }
    .step-label{ font-size:.72rem; }
    .services-grid{ grid-template-columns:1fr; gap:22px; }
    .service-image{ height:230px; }
    .booking-footer{ flex-direction:column; gap:16px; align-items:stretch; text-align:center; }
    .back-btn{ justify-content:center; }
}

/* ── 480 px : smartphones ── */
@media(max-width:480px){
    .booking-container{ padding:14px 12px 48px; }

    /* Hero : titre toujours bien lisible */
    .booking-hero{
        padding:36px 20px;
        border-radius:20px;
        margin-bottom:22px;
        /* Renforce le contraste pour lire le texte */
        background:
            linear-gradient(rgba(0,0,0,.78),rgba(0,0,0,.82)),
            url('{{ asset('images/C34.jpg') }}');
        background-size:cover;
        background-position:center;
    }
    .booking-title{
        font-size:2rem;
        line-height:1.2;
        margin-bottom:14px;
        word-break:break-word;
    }
    /* Fallback couleur visible si gradient-clip non supporté */
    .booking-title span{
        color:#ff6ab4;
        -webkit-text-fill-color:#ff6ab4;
    }
    @supports(-webkit-background-clip:text){
        .booking-title span{
            background:var(--gradient);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
    }
    .booking-subtitle{ font-size:.92rem; line-height:1.75; }

    /* Barre de progression */
    .booking-progress-wrapper{
        padding:18px 12px;
        border-radius:18px;
        margin-bottom:24px;
    }
    .progress-track,
    .progress-active{ top:18px; }
    .step-circle{
        width:36px; height:36px;
        font-size:.75rem;
        margin-bottom:6px;
    }
    .step-label{
        font-size:.6rem;
        max-width:52px;
        text-align:center;
        line-height:1.3;
        white-space:normal;
    }

    /* Cartes services */
    .service-image{ height:195px; }
    .service-card{ border-radius:22px; }
    .service-content{ padding:18px; }
    .service-title{ font-size:1.2rem; }
    .service-price{ font-size:1.55rem; }
    .service-description{ font-size:.88rem; min-height:0; }
    .service-btn{ padding:14px; font-size:.9rem; border-radius:14px; }

    /* Catégorie */
    .category-title{ font-size:1.5rem; padding-left:14px; }
    .category-title::before{ width:5px; }
    .category-section{ margin-bottom:40px; }

    /* Footer */
    .booking-footer{ padding-top:20px; margin-top:40px; }
}

/* ── 360 px : très petit écran ── */
@media(max-width:360px){
    .booking-title{ font-size:1.75rem; }
    .step-label{ font-size:.55rem; max-width:44px; }
    .step-circle{ width:32px; height:32px; }
    .progress-track,.progress-active{ top:16px; }
}
</style>

<div class="booking-page">

    <div class="booking-container">

        {{-- HERO --}}
        <div class="booking-hero">

            <div class="booking-hero-content">

                {{-- <div class="booking-badge">
                    <i class="fa-solid fa-crown"></i>
                    Réservation Luxury Experience
                </div> --}}

                <h1 class="booking-title">
                    {{ __('messages.bk1_title_1') }}
                    <span>{{ __('messages.bk1_title_2') }}</span>
                </h1>

                <p class="booking-subtitle">
                    {{ __('messages.bk1_subtitle') }}
                </p>

            </div>

        </div>

        {{-- PROGRESS --}}
        <div class="booking-progress-wrapper">

            <div class="booking-progress">

                <div class="progress-track"></div>
                <div class="progress-active"></div>

                <div class="step active">
                    <div class="step-circle">1</div>
                    <div class="step-label">{{ __('messages.bk1_step1') }}</div>
                </div>

                <div class="step">
                    <div class="step-circle">2</div>
                    <div class="step-label">{{ __('messages.bk1_step2') }}</div>
                </div>

                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">{{ __('messages.bk1_step3') }}</div>
                </div>

                <div class="step">
                    <div class="step-circle">4</div>
                    <div class="step-label">{{ __('messages.bk1_step4') }}</div>
                </div>

            </div>

        </div>

        {{-- FORM --}}
        <form id="serviceForm"
              method="POST"
              action="{{ route('booking.service') }}">

            @csrf

            @foreach($services as $category => $categoryServices)

            <div class="category-section">

                <div class="category-header">

                    <h2 class="category-title">
                        {{ $category ?: __('messages.bk1_default_cat') }}
                    </h2>

                    <div class="category-count">
                        {{ count($categoryServices) }} services
                    </div>

                </div>

                <div class="services-grid">

                    @foreach($categoryServices as $service)

                    <div class="service-card"
                         onclick="selectService({{ $service->id }})">

                        <div class="service-image">

                            <div class="service-badge">
                                {{ __('messages.bk1_svc_badge') }}
                            </div>

                            <img
                                src="{{ $service->image_url ?? asset('images/C34.jpg') }}"
                                alt="{{ $service->name }}"
                            >

                        </div>

                        <div class="service-content">

                            <div class="service-top">

                                <h3 class="service-title">
                                    {{ $service->name }}
                                </h3>

                                <div class="service-rating">
                                    <i class="fa-solid fa-star"></i>
                                    4.9
                                </div>

                            </div>

                            <p class="service-description">
                                {{ Str::limit($service->description ?? __('messages.bk1_svc_default_desc'), 120) }}
                            </p>

                            <div class="service-meta">

                                <div class="service-price">
                                    {{ $service->formatted_price ?? '25 000' }}
                                </div>

                                <div class="service-duration">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $service->formatted_duration ?? '2h 30min' }}
                                </div>

                            </div>

                            <button type="button"
                                    class="service-btn"
                                    onclick="selectService({{ $service->id }})">

                                <i class="fa-solid fa-calendar-check mr-2"></i>
                                {{ __('messages.bk1_book') }}

                            </button>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

            @endforeach

            <input type="hidden"
                   name="service_id"
                   id="selectedServiceId">

        </form>

        {{-- FOOTER --}}
        <div class="booking-footer">

            <a href="{{ route('home') }}"
               class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>
                {{ __('messages.bk1_back') }}

            </a>

            <div class="step-indicator">
                {{ __('messages.bk1_step_indicator') }}
            </div>

        </div>

    </div>

</div>

<script>
function selectService(serviceId)
{
    document.getElementById('selectedServiceId').value = serviceId;

    document.getElementById('serviceForm').submit();
}
</script>

@endsection
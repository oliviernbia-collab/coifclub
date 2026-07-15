@extends('layouts.employee')

@section('title', 'Ajouter un service')

@section('content')

{{-- GOOGLE FONT --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;600;700;800&display=swap" rel="stylesheet">

{{-- FONT AWESOME --}}
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

:root{
    --primary:#d4af37;
    --primary-dark:#b89022;
    --dark:#0f172a;
    --dark-2:#111827;
    --gray:#64748b;
    --light:#f8fafc;
    --white:#ffffff;
    --border:#e2e8f0;
    --danger:#ef4444;
}

/* =========================
   PAGE
========================= */

body{
    background:var(--light);
    font-family:'Inter',sans-serif;
}

/* =========================
   WRAPPER
========================= */

.service-wrapper{
    max-width:1150px;
    margin:auto;
    padding:10px 0 50px;
}

/* =========================
   HERO
========================= */

.service-hero{
    position:relative;
    overflow:hidden;
    border-radius:34px;
    padding:60px;
    margin-bottom:35px;
    background:
        linear-gradient(
            135deg,
            rgba(15,23,42,.95),
            rgba(17,24,39,.92)
        ),
        url('/images/gallery-hero.jpg') center/cover no-repeat;
}

.service-hero::before{
    content:'';
    position:absolute;
    width:380px;
    height:380px;
    border-radius:50%;
    background:rgba(212,175,55,.10);
    top:-160px;
    right:-120px;
}

.service-hero::after{
    content:'';
    position:absolute;
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,.04);
    bottom:-80px;
    left:-80px;
}

.hero-content{
    position:relative;
    z-index:2;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:12px 22px;
    border-radius:999px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.10);
    color:#fff;
    font-weight:600;
    backdrop-filter:blur(12px);
    margin-bottom:28px;
}

.hero-title{
    font-family:'Playfair Display',serif;
    color:#fff;
    font-size:clamp(2.6rem,5vw,4.8rem);
    font-weight:700;
    line-height:1.1;
    margin-bottom:20px;
}

.hero-title span{
    color:var(--primary);
}

.hero-text{
    color:rgba(255,255,255,.72);
    line-height:1.9;
    max-width:700px;
    font-size:1.02rem;
}

/* =========================
   FORM CARD
========================= */

.service-card{
    background:#fff;
    border-radius:32px;
    border:1px solid var(--border);
    overflow:hidden;
    box-shadow:
        0 20px 60px rgba(15,23,42,.06);
}

/* =========================
   SECTION
========================= */

.form-section{
    padding:38px;
    border-bottom:1px solid rgba(226,232,240,.7);
}

.form-section:last-child{
    border-bottom:none;
}

.section-header{
    margin-bottom:30px;
}

.section-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(212,175,55,.10);
    color:var(--primary-dark);
    border-radius:999px;
    padding:10px 18px;
    font-size:.82rem;
    font-weight:700;
    margin-bottom:16px;
}

.section-title{
    font-size:1.7rem;
    font-weight:800;
    color:var(--dark);
    margin-bottom:10px;
}

.section-text{
    color:var(--gray);
    line-height:1.8;
}

/* =========================
   GRID
========================= */

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:22px;
}

.form-group{
    margin-bottom:22px;
}

.form-group.full{
    grid-column:1/-1;
}

/* =========================
   LABEL
========================= */

.form-label{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    color:var(--dark);
    font-weight:700;
    font-size:.94rem;
}

.form-label i{
    color:var(--primary);
}

/* =========================
   INPUT
========================= */

.form-control{
    width:100%;
    border:1px solid rgba(15,23,42,.10);
    background:#fff;
    border-radius:18px;
    padding:16px 18px;
    font-size:.96rem;
    color:var(--dark);
    transition:.3s ease;
}

.form-control:focus{
    outline:none;
    border-color:rgba(212,175,55,.55);
    box-shadow:
        0 0 0 5px rgba(212,175,55,.12);
}

textarea.form-control{
    resize:none;
    min-height:140px;
}

/* =========================
   FILE INPUT
========================= */

.file-upload{
    position:relative;
    border:2px dashed rgba(212,175,55,.35);
    border-radius:24px;
    padding:30px;
    text-align:center;
    background:rgba(212,175,55,.04);
    transition:.3s ease;
}

.file-upload:hover{
    background:rgba(212,175,55,.08);
}

.file-upload i{
    font-size:2rem;
    color:var(--primary);
    margin-bottom:14px;
}

.file-upload h5{
    font-weight:700;
    color:var(--dark);
    margin-bottom:8px;
}

.file-upload p{
    color:var(--gray);
    font-size:.92rem;
    margin-bottom:0;
}

.file-upload input{
    position:absolute;
    inset:0;
    opacity:0;
    cursor:pointer;
}

/* =========================
   SWITCH
========================= */

.status-box{
    height:100%;
    display:flex;
    align-items:center;
    justify-content:flex-start;
}

.switch{
    position:relative;
    display:inline-flex;
    align-items:center;
    gap:14px;
    cursor:pointer;
    user-select:none;
}

.switch input{
    display:none;
}

.switch-slider{
    position:relative;
    width:62px;
    height:34px;
    border-radius:999px;
    background:#dbe4ef;
    transition:.3s ease;
}

.switch-slider::before{
    content:'';
    position:absolute;
    width:26px;
    height:26px;
    border-radius:50%;
    background:#fff;
    top:4px;
    left:4px;
    transition:.3s ease;
    box-shadow:0 4px 10px rgba(0,0,0,.12);
}

.switch input:checked + .switch-slider{
    background:linear-gradient(
        135deg,
        var(--primary),
        #f5d06f
    );
}

.switch input:checked + .switch-slider::before{
    transform:translateX(28px);
}

.switch-text{
    font-weight:700;
    color:var(--dark);
}

/* =========================
   ALERT
========================= */

.alert-danger{
    border:none;
    border-radius:24px;
    background:rgba(239,68,68,.08);
    border:1px solid rgba(239,68,68,.14);
    padding:24px;
    margin-bottom:30px;
}

.alert-danger strong{
    display:block;
    margin-bottom:10px;
    color:#b91c1c;
}

.alert-danger ul{
    margin:0;
    padding-left:18px;
    color:#991b1b;
}

/* =========================
   BUTTONS
========================= */

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:16px;
    padding:34px 38px;
    background:#fcfcfc;
}

.btn-cancel{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    border-radius:18px;
    padding:16px 26px;
    background:#fff;
    border:1px solid rgba(15,23,42,.10);
    color:var(--dark);
    font-weight:700;
    transition:.3s ease;
}

.btn-cancel:hover{
    background:#f8fafc;
    color:var(--dark);
}

.btn-save{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    border:none;
    border-radius:18px;
    padding:16px 30px;
    background:
        linear-gradient(
            135deg,
            var(--primary),
            #f5d06f
        );
    color:#111827;
    font-weight:800;
    transition:.3s ease;
    box-shadow:
        0 18px 40px rgba(212,175,55,.22);
}

.btn-save:hover{
    transform:translateY(-3px);
    box-shadow:
        0 25px 50px rgba(212,175,55,.28);
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:992px){

    .service-hero{
        padding:45px 35px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    .service-wrapper{
        padding-bottom:30px;
    }

    .service-hero{
        border-radius:28px;
        padding:40px 24px;
    }

    .hero-title{
        font-size:2.5rem;
    }

    .form-section{
        padding:28px 22px;
    }

    .form-actions{
        padding:24px 22px;
        flex-direction:column;
    }

    .btn-cancel,
    .btn-save{
        width:100%;
    }

}

</style>

<div class="service-wrapper">

    {{-- HERO --}}
    <section class="service-hero">

        <div class="hero-content">

            <div class="hero-badge">
                <i class="fa-solid fa-scissors"></i>
                Gestion Premium des Services
            </div>

            <h1 class="hero-title">
                Ajouter un <span>nouveau service</span>
            </h1>

            <p class="hero-text">
                Créez une prestation professionnelle avec une présentation
                élégante, une description détaillée et des informations
                adaptées à votre salon premium.
            </p>

        </div>

    </section>

    {{-- ERRORS --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Certaines informations sont invalides :
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    {{-- FORM --}}
    <form
        action="{{ route('employee.services.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="service-card">

            {{-- INFORMATIONS --}}
            <div class="form-section">

                <div class="section-header">

                    <div class="section-badge">
                        <i class="fa-solid fa-layer-group"></i>
                        Informations générales
                    </div>

                    <h2 class="section-title">
                        Détails du service
                    </h2>

                    <p class="section-text">
                        Ajoutez les informations essentielles concernant
                        votre prestation beauté ou coiffure.
                    </p>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-shop"></i>
                            Salon
                        </label>

                        <select
                            name="salon_id"
                            class="form-control"
                            required
                        >
                            <option value="">
                                Choisir un salon
                            </option>

                            @foreach($salons as $salon)

                                <option
                                    value="{{ $salon->id }}"
                                    {{ old('salon_id') == $salon->id ? 'selected' : '' }}
                                >
                                    {{ $salon->name ?? $salon->nom }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-tags"></i>
                            Catégorie
                        </label>

                        <select
                            name="categorie_id"
                            class="form-control"
                            required
                        >
                            <option value="">
                                Choisir une catégorie
                            </option>

                            @foreach($categories as $categorie)

                                <option
                                    value="{{ $categorie->id }}"
                                    {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}
                                >
                                    {{ $categorie->nom }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-scissors"></i>
                            Nom du service
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', old('nom')) }}"
                            placeholder="Ex : Knotless Braids Premium"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-clock"></i>
                            Durée (minutes)
                        </label>

                        <input
                            type="number"
                            name="duration"
                            class="form-control"
                            value="{{ old('duration', old('duree')) }}"
                            placeholder="Ex : 120"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-face-smile"></i>
                            Emoji
                        </label>

                        <input
                            type="text"
                            name="emoji"
                            class="form-control"
                            value="{{ old('emoji') }}"
                            placeholder="✨ 💇🏽‍♀️ 👑"
                        >

                    </div>

                    <div class="form-group full">

                        <label class="form-label">
                            <i class="fa-solid fa-align-left"></i>
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            placeholder="Décrivez le service proposé..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>

            </div>

            {{-- MEDIA --}}
            <div class="form-section">

                <div class="section-header">

                    <div class="section-badge">
                        <i class="fa-solid fa-image"></i>
                        Média & visibilité
                    </div>

                    <h2 class="section-title">
                        Personnalisation
                    </h2>

                    <p class="section-text">
                        Ajoutez une image élégante et choisissez le statut
                        du service dans votre catalogue.
                    </p>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label class="form-label">
                            <i class="fa-solid fa-upload"></i>
                            Image du service
                        </label>

                        <div class="file-upload">

                            <input
                                type="file"
                                name="image"
                            >

                            <i class="fa-solid fa-cloud-arrow-up"></i>

                            <h5>
                                Glissez votre image ici
                            </h5>

                            <p>
                                PNG, JPG ou WEBP haute qualité
                            </p>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="status-box">

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                >

                                <span class="switch-slider"></span>

                                <span class="switch-text">
                                    Service actif
                                </span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="form-actions">

                <a
                    href="{{ route('employee.services') }}"
                    class="btn-cancel"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Annuler
                </a>

                <button
                    type="submit"
                    class="btn-save"
                >
                    <i class="fa-solid fa-check"></i>
                    Créer le service
                </button>

            </div>

        </div>

    </form>

</div>

@endsection
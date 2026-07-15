@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('title', __('messages.adm_edit_salon_title'))
@section('page-title', __('messages.adm_edit_salon_title'))
@section('page-subtitle', __('messages.adm_salon_management'))

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap');

    :root{
        --gold:#d4af37;
        --dark:#0f172a;
        --muted:#94a3b8;
        --border:rgba(255,255,255,0.08);
        --glass:rgba(255,255,255,0.04);
    }

    .edit-page{
        font-family:'Inter',sans-serif;
    }

    /* HEADER */
    .edit-header{
        margin-bottom:30px;
    }

    .edit-eyebrow{
        font-size:11px;
        letter-spacing:.14em;
        text-transform:uppercase;
        color:var(--gold);
        font-weight:700;
        margin-bottom:10px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .edit-title{
        font-family:'Cormorant Garamond',serif;
        font-size:38px;
        color:#fff;
        margin:0;
        font-weight:700;
    }

    .edit-subtitle{
        margin-top:8px;
        color:var(--muted);
        font-size:14px;
    }

    /* CARD */
    .edit-card{
        background:linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border:1px solid var(--border);
        border-radius:26px;
        padding:28px;
        backdrop-filter:blur(10px);
    }

    .section-title{
        display:flex;
        align-items:center;
        gap:10px;
        font-weight:700;
        color:#fff;
        margin-bottom:18px;
        font-size:15px;
    }

    .section-title i{
        color:var(--gold);
    }

    /* INPUTS */
    .form-label{
        font-size:13px;
        color:#e2e8f0;
        font-weight:600;
        margin-bottom:6px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .form-label i{
        color:var(--gold);
        font-size:12px;
    }

    .form-control{
        width:100%;
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(255,255,255,0.08);
        border-radius:14px;
        padding:12px 14px;
        color:#fff;
        font-size:14px;
        transition:.2s ease;
    }

    .form-control:focus{
        outline:none;
        border-color:rgba(212,175,55,0.5);
        box-shadow:0 0 0 4px rgba(212,175,55,0.12);
    }

    /* GRID */
    .grid{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:18px;
    }

    /* BUTTONS */
    .btn-save{
        background:linear-gradient(135deg,#d4af37,#f4d06f);
        color:#111827;
        border:none;
        padding:14px 22px;
        border-radius:14px;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:10px;
        cursor:pointer;
        transition:.2s;
        box-shadow:0 12px 30px rgba(212,175,55,0.25);
    }

    .btn-save:hover{
        transform:translateY(-2px);
    }

    .btn-cancel{
        background:rgba(255,255,255,0.05);
        border:1px solid rgba(255,255,255,0.08);
        color:#e2e8f0;
        padding:14px 20px;
        border-radius:14px;
        text-decoration:none;
        font-weight:600;
        transition:.2s;
        display:inline-flex;
        align-items:center;
        gap:10px;
    }

    .btn-cancel:hover{
        background:rgba(255,255,255,0.08);
        color:#fff;
    }

    .actions{
        margin-top:24px;
        display:flex;
        gap:12px;
        flex-wrap:wrap;
    }

    /* RESPONSIVE */
    @media(max-width:768px){
        .grid{
            grid-template-columns:1fr;
        }

        .edit-title{
            font-size:30px;
        }
    }

</style>

<div class="edit-page">

    {{-- HEADER --}}
    <div class="edit-header">

        <div class="edit-eyebrow">
            <i class="fa-solid fa-pen-to-square"></i>
            {{ __('messages.adm_modify_salon') }}
        </div>

        <h1 class="edit-title">{{ __('messages.adm_edit_salon_title') }}</h1>

        <p class="edit-subtitle">
            {{ __('messages.adm_edit_salon_desc') }}
        </p>

    </div>

    {{-- CARD --}}
    <div class="edit-card">

        <div class="section-title">
            <i class="fa-solid fa-gear"></i>
            {{ __('messages.adm_salon_info_title') }}
        </div>

        <form method="POST" action="{{ route('admin.salons.update', $salon->id) }}">
            @csrf
            @method('PUT')

            <div class="grid">

                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-shop"></i>
                        {{ __('messages.adm_salon_name') }}
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $salon->name) }}">
                </div>

                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-envelope"></i>
                        {{ __('messages.email') }}
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $salon->email) }}">
                </div>

                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-phone"></i>
                        {{ __('messages.phone') }}
                    </label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone', $salon->phone) }}">
                </div>

                <div>
                    <label class="form-label">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ __('messages.adm_city') }}
                    </label>
                    <input type="text"
                           name="city"
                           class="form-control"
                           value="{{ old('city', $salon->city) }}">
                </div>

            </div>

            <div style="margin-top:18px;">
                <label class="form-label">
                    <i class="fa-solid fa-map"></i>
                    {{ __('messages.address') }}
                </label>

                <input type="text"
                       name="address"
                       class="form-control"
                       value="{{ old('address', $salon->address) }}">
            </div>

            <div class="actions">

                <button class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ __('messages.adm_update_btn') }}
                </button>

                <a href="{{ route('admin.salons') }}" class="btn-cancel">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('messages.btn_cancel') }}
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
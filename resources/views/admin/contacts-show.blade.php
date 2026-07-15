@extends('layouts.admin')

@section('title', __('messages.adm_reply_to_client'))
@section('page-title', __('messages.adm_reply_to_client'))
@section('page-subtitle', __('messages.adm_contacts_subtitle'))

@section('content')

<div class="container-fluid px-4">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))

        <div class="success-alert mb-4">

            <div class="success-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h5>{{ __('messages.adm_reply_sent') }}</h5>
                <p class="mb-0">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif

    {{-- HERO --}}
    <div class="reply-hero mb-4">

        <div class="reply-hero-content">

            <div class="hero-left">

                <div class="hero-icon">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>

                <div>

                    <span class="hero-badge">
                        {{ __('messages.adm_msg_center_badge') }}
                    </span>

                    <h1>
                        {{ __('messages.adm_reply_to_client') }}
                    </h1>

                    <p>
                        {{ __('messages.adm_reply_hero_desc') }}
                    </p>

                </div>

            </div>

            <div class="hero-right">

                <div class="status-card {{ $contact->replied_at ? 'success' : 'pending' }}">

                    <span>{{ __('messages.adm_contact_status') }}</span>

                    <strong>
                        {{ $contact->replied_at ? __('messages.adm_contact_replied') : __('messages.pending') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4">

        {{-- MESSAGE DETAILS --}}
        <div class="col-xl-5">

            <div class="premium-card message-card">

                <div class="card-header-custom">

                    <div>

                        <h3>
                            <i class="fa-solid fa-envelope-open-text"></i>
                            {{ __('messages.adm_client_message_title') }}
                        </h3>

                        <p>
                            {{ __('messages.adm_client_msg_info') }}
                        </p>

                    </div>

                    <div class="message-date">
                        {{ $contact->created_at->diffForHumans() }}
                    </div>

                </div>

                {{-- USER --}}
                <div class="client-profile">

                    <div class="client-avatar">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>

                    <div>

                        <h4>{{ $contact->name }}</h4>

                        <span>
                            {{ __('messages.adm_client_visitor') }}
                        </span>

                    </div>

                </div>

                {{-- DETAILS --}}
                <div class="details-wrapper">

                    <div class="detail-box">

                        <div class="detail-icon primary">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>
                            <small>{{ __('messages.adm_detail_email') }}</small>
                            <strong>{{ $contact->email }}</strong>
                        </div>

                    </div>

                    <div class="detail-box">

                        <div class="detail-icon success">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div>
                            <small>{{ __('messages.adm_detail_phone') }}</small>
                            <strong>
                                {{ $contact->phone ?? __('messages.adm_not_provided') }}
                            </strong>
                        </div>

                    </div>

                    <div class="detail-box">

                        <div class="detail-icon warning">
                            <i class="fa-solid fa-tag"></i>
                        </div>

                        <div>
                            <small>{{ __('messages.adm_detail_subject') }}</small>
                            <strong>{{ $contact->subject }}</strong>
                        </div>

                    </div>

                    <div class="detail-box align-items-start">

                        <div class="detail-icon dark">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>

                        <div class="w-100">
                            <small>{{ __('messages.adm_detail_message') }}</small>

                            <div class="message-content">
                                {{ $contact->message }}
                            </div>
                        </div>

                    </div>

                    @if($contact->reply)

                        <div class="last-reply-box">

                            <div class="reply-title">
                                <i class="fa-solid fa-reply"></i>
                                {{ __('messages.adm_last_reply_title') }}
                            </div>

                            <p>
                                {{ $contact->reply }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- REPLY FORM --}}
        <div class="col-xl-7">

            <div class="premium-card form-card">

                <div class="card-header-custom mb-4">

                    <div>

                        <h3>
                            <i class="fa-solid fa-paper-plane"></i>
                            {{ __('messages.adm_send_reply_title') }}
                        </h3>

                        <p>
                            {{ __('messages.adm_send_reply_desc') }}
                        </p>

                    </div>

                </div>

                <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">

                    @csrf

                    {{-- RESPONSE FIELD --}}
                    <div class="mb-4">

                        <label class="form-label-custom">
                            {{ __('messages.adm_reply_label') }}
                        </label>

                        <div class="textarea-wrapper">

                            <textarea
                                name="reply"
                                class="form-control premium-textarea @error('reply') is-invalid @enderror"
                                rows="12"
                                placeholder="{{ __('messages.adm_reply_placeholder') }}"
                                required
                            >{{ old('reply', $contact->reply) }}</textarea>

                        </div>

                        @error('reply')

                            <div class="error-message">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    {{-- ACTIONS --}}
                    <div class="form-actions">

                        <a href="{{ route('admin.contacts') }}"
                           class="btn-cancel">

                            <i class="fa-solid fa-arrow-left"></i>
                            {{ __('messages.btn_back') }}

                        </a>

                        <button type="submit" class="btn-send">

                            <i class="fa-solid fa-paper-plane"></i>

                            {{ $contact->replied_at ? __('messages.adm_update_reply') : __('messages.adm_send_reply_btn') }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<style>

    body{
        background: #f4f7fb;
    }

    /* SUCCESS ALERT */

    .success-alert{
        background: white;
        border-radius: 22px;
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #dcfce7;
        box-shadow: 0 12px 35px rgba(16,185,129,.08);
    }

    .success-icon{
        width: 55px;
        height: 55px;
        border-radius: 18px;
        background: rgba(16,185,129,.12);
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .success-alert h5{
        font-weight: 800;
        margin-bottom: .2rem;
        color: #0f172a;
    }

    /* HERO */

    .reply-hero{
        background:
            radial-gradient(circle at top right, rgba(99,102,241,.18), transparent 30%),
            linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 30px;
        padding: 2rem;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(15,23,42,.18);
    }

    .reply-hero-content{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-left{
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .hero-icon{
        width: 90px;
        height: 90px;
        border-radius: 28px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.1);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .hero-badge{
        background: rgba(255,255,255,.12);
        color: #cbd5e1;
        padding: .45rem .85rem;
        border-radius: 50px;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .reply-hero h1{
        color: white;
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: .7rem;
    }

    .reply-hero p{
        color: rgba(255,255,255,.72);
        max-width: 650px;
        margin: 0;
        line-height: 1.7;
    }

    .status-card{
        min-width: 180px;
        padding: 1rem 1.3rem;
        border-radius: 22px;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,.08);
    }

    .status-card.success{
        background: rgba(16,185,129,.12);
    }

    .status-card.pending{
        background: rgba(148,163,184,.12);
    }

    .status-card span{
        display: block;
        color: rgba(255,255,255,.65);
        margin-bottom: .45rem;
    }

    .status-card strong{
        color: white;
        font-size: 1.3rem;
        font-weight: 800;
    }

    /* CARD */

    .premium-card{
        background: white;
        border-radius: 30px;
        border: 1px solid #eef2f7;
        box-shadow: 0 20px 50px rgba(15,23,42,.06);
        overflow: hidden;
        padding: 2rem;
        height: 100%;
    }

    .card-header-custom{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .card-header-custom h3{
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: .45rem;
    }

    .card-header-custom p{
        color: #64748b;
        margin: 0;
    }

    .message-date{
        background: #f8fafc;
        color: #475569;
        padding: .7rem 1rem;
        border-radius: 14px;
        font-size: .85rem;
        font-weight: 700;
    }

    /* PROFILE */

    .client-profile{
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0;
        padding: 1.4rem;
        background: #f8fbff;
        border-radius: 24px;
        border: 1px solid #eef2f7;
    }

    .client-avatar{
        width: 70px;
        height: 70px;
        border-radius: 22px;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 800;
        box-shadow: 0 15px 35px rgba(79,70,229,.25);
    }

    .client-profile h4{
        margin-bottom: .3rem;
        font-weight: 800;
        color: #0f172a;
    }

    .client-profile span{
        color: #94a3b8;
    }

    /* DETAILS */

    .details-wrapper{
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-box{
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fafc;
        border-radius: 20px;
        padding: 1rem;
        border: 1px solid #eef2f7;
    }

    .detail-icon{
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .detail-icon.primary{
        background: rgba(79,70,229,.1);
        color: #4f46e5;
    }

    .detail-icon.success{
        background: rgba(16,185,129,.1);
        color: #10b981;
    }

    .detail-icon.warning{
        background: rgba(245,158,11,.1);
        color: #f59e0b;
    }

    .detail-icon.dark{
        background: rgba(15,23,42,.08);
        color: #0f172a;
    }

    .detail-box small{
        display: block;
        color: #94a3b8;
        margin-bottom: .2rem;
    }

    .detail-box strong{
        color: #0f172a;
        font-size: .95rem;
    }

    .message-content{
        margin-top: .7rem;
        background: white;
        border-radius: 16px;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        color: #334155;
        line-height: 1.8;
        white-space: pre-line;
    }

    /* LAST REPLY */

    .last-reply-box{
        background: linear-gradient(to right, #eef2ff, #f8fafc);
        border-radius: 24px;
        padding: 1.4rem;
        margin-top: 1rem;
        border: 1px solid #dbeafe;
    }

    .reply-title{
        display: flex;
        align-items: center;
        gap: .6rem;
        color: #4338ca;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .last-reply-box p{
        margin: 0;
        color: #334155;
        line-height: 1.8;
        white-space: pre-line;
    }

    /* FORM */

    .form-label-custom{
        display: block;
        margin-bottom: .9rem;
        font-weight: 700;
        color: #0f172a;
    }

    .textarea-wrapper{
        position: relative;
    }

    .premium-textarea{
        border-radius: 24px;
        border: 1px solid #dbe3ee;
        padding: 1.3rem;
        font-size: .96rem;
        line-height: 1.8;
        resize: none;
        box-shadow: none !important;
        transition: .3s ease;
    }

    .premium-textarea:focus{
        border-color: #4f46e5;
        box-shadow: 0 0 0 5px rgba(79,70,229,.08) !important;
    }

    .error-message{
        margin-top: .8rem;
        color: #ef4444;
        font-size: .88rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ACTIONS */

    .form-actions{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-cancel{
        height: 54px;
        padding: 0 1.4rem;
        border-radius: 18px;
        border: 1px solid #dbe3ee;
        background: white;
        color: #475569;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: .7rem;
        text-decoration: none;
        transition: .3s ease;
    }

    .btn-cancel:hover{
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-send{
        height: 56px;
        padding: 0 1.8rem;
        border: none;
        border-radius: 18px;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: .7rem;
        box-shadow: 0 18px 35px rgba(79,70,229,.25);
        transition: .3s ease;
    }

    .btn-send:hover{
        transform: translateY(-2px);
        box-shadow: 0 22px 40px rgba(79,70,229,.35);
    }

    /* MOBILE */

    @media(max-width: 992px){

        .reply-hero h1{
            font-size: 1.8rem;
        }

        .premium-card{
            padding: 1.4rem;
        }

    }

</style>

@endsection
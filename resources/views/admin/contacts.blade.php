@extends('layouts.admin')

@section('title', __('messages.adm_contacts_title'))
@section('page-title', __('messages.adm_contacts_title'))
@section('page-subtitle', __('messages.adm_contacts_subtitle'))

@section('content')

<div class="container-fluid px-4">

    {{-- HERO HEADER --}}
    <div class="contact-hero mb-4">

        <div class="hero-content">

            <div class="hero-left">

                <div class="hero-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>

                <div>
                    <span class="hero-badge">
                        {{ __('messages.admin_control_panel') }}
                    </span>

                    <h1>
                        {{ __('messages.adm_contacts_title') }}
                    </h1>

                    <p>
                        {{ __('messages.adm_contacts_subtitle') }}
                    </p>
                </div>

            </div>

            <div class="hero-right">

                <div class="hero-mini-card">
                    <span>{{ __('messages.adm_hero_total') }}</span>
                    <strong>{{ $totalContacts }}</strong>
                </div>

                <div class="hero-mini-card success">
                    <span>{{ __('messages.adm_contact_today') }}</span>
                    <strong>{{ $todayContacts }}</strong>
                </div>

                <div class="hero-mini-card warning">
                    <span>{{ __('messages.adm_contact_unreplied') }}</span>
                    <strong>{{ $unrepliedCount }}</strong>
                </div>

                <div class="hero-mini-card success">
                    <span>{{ __('messages.adm_contact_replied') }}</span>
                    <strong>{{ $repliedCount }}</strong>
                </div>

            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-4 col-md-6">
            <div class="premium-stat-card">

                <div class="stat-glow primary"></div>

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <span class="stat-label">
                            {{ __('messages.adm_received_messages') }}
                        </span>

                        <h2>
                            {{ $contacts->total() }}
                        </h2>

                        <p>
                            {{ __('messages.adm_all_messages') }}
                        </p>
                    </div>

                    <div class="premium-icon primary">
                        <i class="fa-solid fa-inbox"></i>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="premium-stat-card">

                <div class="stat-glow success"></div>

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <span class="stat-label">
                            {{ __('messages.adm_contact_today') }}
                        </span>

                        <h2>
                            {{ $contacts->where('created_at', '>=', now()->startOfDay())->count() }}
                        </h2>

                        <p>
                            {{ __('messages.adm_new_today') }}
                        </p>
                    </div>

                    <div class="premium-icon success">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="premium-stat-card">

                <div class="stat-glow warning"></div>

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <span class="stat-label">
                            {{ __('messages.adm_last_activity') }}
                        </span>

                        <h2 class="small-text">
                            {{ optional($contacts->first())->created_at?->diffForHumans() ?? '—' }}
                        </h2>

                        <p>
                            {{ __('messages.adm_last_message_received') }}
                        </p>
                    </div>

                    <div class="premium-icon warning">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="premium-table-card">

        {{-- TABLE HEADER --}}
        <div class="premium-table-header">

            <div>

                <h3>
                    <i class="fa-solid fa-comments"></i>
                    {{ __('messages.adm_inbox') }}
                </h3>

                <p>
                    {{ __('messages.adm_inbox_subtitle') }}
                </p>

            </div>

            <div class="table-header-actions">

                <form method="GET" class="d-flex align-items-center gap-2">
                    <label for="statusFilter" class="mb-0 text-muted">{{ __('messages.adm_filter_label') }}</label>
                    <select id="statusFilter" name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="" {{ $status === null ? 'selected' : '' }}>{{ __('messages.adm_filter_all') }}</option>
                        <option value="unanswered" {{ $status === 'unanswered' ? 'selected' : '' }}>{{ __('messages.adm_filter_unanswered') }}</option>
                        <option value="answered" {{ $status === 'answered' ? 'selected' : '' }}>{{ __('messages.adm_filter_answered') }}</option>
                    </select>
                </form>

                <div class="messages-count ms-3">
                    <i class="fa-solid fa-envelope-circle-check"></i>
                    {{ $contacts->total() }} {{ __('messages.adm_msg_count') }}
                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table premium-table align-middle mb-0">

                <thead>
                    <tr>
                        <th>{{ __('messages.adm_col_user') }}</th>
                        <th>{{ __('messages.adm_col_coordinates') }}</th>
                        <th>{{ __('messages.adm_col_subject') }}</th>
                        <th>{{ __('messages.adm_col_content') }}</th>
                        <th>{{ __('messages.adm_col_reception') }}</th>
                        <th>{{ __('messages.adm_col_actions') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($contacts as $contact)

                        <tr class="{{ $contact->replied_at ? '' : 'table-row-unreplied' }}">

                            {{-- USER --}}
                            <td width="260">

                                <div class="user-cell">

                                    <div class="user-avatar">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <h6>
                                            {{ $contact->name }}
                                        </h6>

                                        <span>
                                            {{ __('messages.adm_client_visitor') }}
                                        </span>

                                    </div>

                                </div>

                            </td>

                            {{-- CONTACT --}}
                            <td width="280">

                                <div class="contact-block">

                                    <div class="contact-item">
                                        <i class="fa-solid fa-envelope"></i>

                                        <div>
                                            <small>{{ __('messages.email') }}</small>
                                            <strong>{{ $contact->email }}</strong>
                                        </div>
                                    </div>

                                    <div class="contact-item">
                                        <i class="fa-solid fa-phone"></i>

                                        <div>
                                            <small>{{ __('messages.phone') }}</small>
                                            <strong>
                                                {{ $contact->phone ?? __('messages.adm_not_provided') }}
                                            </strong>
                                        </div>
                                    </div>

                                </div>

                            </td>

                            {{-- SUBJECT --}}
                            <td width="180">

                                <span class="subject-pill">
                                    {{ $contact->subject }}
                                </span>

                            </td>

                            {{-- MESSAGE --}}
                            <td style="min-width: 350px;">

                                <div class="message-preview">

                                    <div class="message-quote">
                                        <i class="fa-solid fa-quote-left"></i>
                                    </div>

                                    <p>
                                        {{ Str::limit($contact->message, 220) }}
                                    </p>

                                </div>

                            </td>

                            {{-- DATE --}}
                            <td width="180">

                                <div class="date-widget">

                                    <div class="date-day">
                                        {{ $contact->created_at->format('d') }}
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $contact->created_at->format('M Y') }}
                                        </strong>

                                        <span>
                                            {{ $contact->created_at->format('H:i') }}
                                        </span>

                                        <small>
                                            {{ $contact->created_at->diffForHumans() }}
                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- ACTIONS --}}
                            <td width="160">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-admin btn-sm">
                                        <i class="fa-solid fa-reply"></i> {{ __('messages.adm_btn_reply') }}
                                    </a>

                                    @if($contact->replied_at)
                                        <span class="badge bg-success text-white">
                                            {{ __('messages.adm_replied_on') }} {{ $contact->replied_at->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary text-white">
                                            {{ __('messages.pending') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5">

                                <div class="empty-wrapper">

                                    <div class="empty-animation">
                                        <i class="fa-regular fa-envelope-open"></i>
                                    </div>

                                    <h3>
                                        {{ __('messages.adm_no_messages') }}
                                    </h3>

                                    <p>
                                        {{ __('messages.adm_no_messages_text') }}
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($contacts->hasPages())

            <div class="premium-pagination">
                {{ $contacts->links() }}
            </div>

        @endif

    </div>

</div>

<style>

    body{ background: #0e0a1c; }

    /* HERO */

    .contact-hero{
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg, #0f172a 0%, #1a1400 100%);
        border-radius: 30px;
        padding: 2rem;
        overflow: hidden;
        position: relative;
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.18);
    }

    .hero-content{
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
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        border: 1px solid rgba(255,255,255,.15);
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

    .contact-hero h1{
        color: white;
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: .6rem;
    }

    .contact-hero p{
        color: rgba(255,255,255,.75);
        max-width: 650px;
        margin: 0;
        line-height: 1.7;
    }

    .hero-right{
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-mini-card{
        min-width: 150px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 22px;
        padding: 1rem 1.2rem;
        backdrop-filter: blur(14px);
    }

    .hero-mini-card span{
        color: rgba(255,255,255,.65);
        display: block;
        margin-bottom: .5rem;
        font-size: .85rem;
    }

    .hero-mini-card strong{
        color: white;
        font-size: 1.6rem;
        font-weight: 800;
    }

    .table-row-unreplied {
        background: rgba(239,68,68,.08) !important;
        border-left: 4px solid #f97316;
    }

    /* STATS */

    .premium-stat-card{
        position: relative;
        background: rgba(255,255,255,.06);
        border-radius: 26px;
        padding: 1.8rem;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 15px 40px rgba(0,0,0,.2);
        transition: .35s ease;
        height: 100%;
    }

    .premium-stat-card:hover{
        transform: translateY(-6px);
        box-shadow: 0 22px 60px rgba(0,0,0,.3);
        border-color: rgba(212,175,55,.25);
    }

    .stat-glow{
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        opacity: .12;
    }

    .stat-glow.primary{ background: #D4AF37; }
    .stat-glow.success{ background: #10b981; }
    .stat-glow.warning{ background: #f59e0b; }

    .stat-label{
        color: rgba(255,255,255,.45);
        text-transform: uppercase;
        letter-spacing: .8px;
        font-size: .75rem;
        font-weight: 700;
    }

    .premium-stat-card h2{
        font-size: 2.2rem;
        font-weight: 800;
        margin: .8rem 0 .4rem;
        color: rgba(255,255,255,.9);
    }

    .premium-stat-card h2.small-text{ font-size: 1.3rem; }

    .premium-stat-card p{
        color: rgba(255,255,255,.35);
        margin: 0;
    }

    .premium-icon{
        width: 68px;
        height: 68px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .premium-icon.primary{ background: rgba(212,175,55,.15); color: #D4AF37; }
    .premium-icon.success{ background: rgba(16,185,129,.15); color: #10b981; }
    .premium-icon.warning{ background: rgba(245,158,11,.15); color: #f59e0b; }

    /* TABLE */

    .premium-table-card{
        background: rgba(255,255,255,.05);
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 20px 50px rgba(0,0,0,.25);
    }

    .premium-table-header{
        padding: 1.8rem 2rem;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .premium-table-header h3{
        font-size: 1.35rem;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        margin-bottom: .45rem;
    }

    .premium-table-header p{
        margin: 0;
        color: rgba(255,255,255,.45);
    }

    .table-header-actions{ display: flex; align-items: center; flex-wrap: wrap; gap: 1rem; }

    .table-header-actions .form-select{
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.12);
        color: rgba(255,255,255,.8);
        border-radius: 12px;
    }

    .table-header-actions .form-select option{ background: #1a1230; }
    .table-header-actions .text-muted{ color: rgba(255,255,255,.45) !important; }

    .messages-count{
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white;
        padding: .9rem 1.2rem;
        border-radius: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: .6rem;
        box-shadow: 0 15px 30px rgba(212,175,55,.25);
    }

    .premium-table{ --bs-table-color: rgba(255,255,255,.8); --bs-table-bg: transparent; }

    .premium-table thead th{
        background: rgba(255,255,255,.04);
        color: rgba(255,255,255,.45);
        text-transform: uppercase;
        letter-spacing: .7px;
        font-size: .75rem;
        font-weight: 800;
        border: none;
        padding: 1.2rem 1.4rem;
    }

    .premium-table tbody tr{
        border-bottom: 1px solid rgba(255,255,255,.06);
        transition: .25s ease;
    }

    .premium-table tbody tr:hover{ background: rgba(255,255,255,.04); }

    .premium-table td{
        border: none;
        padding: 1.4rem;
        vertical-align: middle;
        color: rgba(255,255,255,.8);
    }

    /* USER */

    .user-cell{ display: flex; align-items: center; gap: 1rem; }

    .user-avatar{
        width: 58px;
        height: 58px;
        border-radius: 20px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 30px rgba(212,175,55,.25);
        flex-shrink: 0;
    }

    .user-cell h6{ margin: 0 0 .3rem; font-weight: 800; color: rgba(255,255,255,.9); }
    .user-cell span{ color: rgba(255,255,255,.4); font-size: .88rem; }

    /* CONTACT */

    .contact-block{ display: flex; flex-direction: column; gap: .8rem; }
    .contact-item{ display: flex; align-items: center; gap: .8rem; }

    .contact-item i{
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(255,255,255,.08);
        color: #D4AF37;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-item small{ display: block; color: rgba(255,255,255,.4); margin-bottom: .1rem; }
    .contact-item strong{ color: rgba(255,255,255,.85); font-size: .92rem; }

    /* SUBJECT */

    .subject-pill{
        background: rgba(212,175,55,.12);
        color: #D4AF37;
        border: 1px solid rgba(212,175,55,.2);
        padding: .7rem 1rem;
        border-radius: 14px;
        font-weight: 700;
        display: inline-block;
    }

    /* MESSAGE */

    .message-preview{
        position: relative;
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 20px;
        padding: 1.2rem 1.2rem 1.2rem 3rem;
    }

    .message-quote{ position: absolute; top: 1rem; left: 1rem; color: rgba(255,255,255,.2); font-size: 1rem; }
    .message-preview p{ margin: 0; color: rgba(255,255,255,.7); line-height: 1.7; }

    /* DATE */

    .date-widget{ display: flex; align-items: center; gap: .9rem; }

    .date-day{
        width: 55px;
        height: 55px;
        border-radius: 16px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .date-widget strong{ display: block; color: rgba(255,255,255,.9); margin-bottom: .2rem; }
    .date-widget span{ display: block; color: rgba(255,255,255,.5); font-size: .9rem; }
    .date-widget small{ color: rgba(255,255,255,.35); }

    /* EMPTY */

    .empty-wrapper{ text-align: center; padding: 5rem 2rem; }

    .empty-animation{
        width: 110px;
        height: 110px;
        margin: 0 auto 1.8rem;
        border-radius: 30px;
        background: rgba(212,175,55,.1);
        color: #D4AF37;
        font-size: 2.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-wrapper h3{ font-weight: 800; color: rgba(255,255,255,.9); margin-bottom: .8rem; }
    .empty-wrapper p{ color: rgba(255,255,255,.45); max-width: 520px; margin: auto; line-height: 1.7; }

    /* PAGINATION */

    .premium-pagination{
        padding: 1.6rem;
        border-top: 1px solid rgba(255,255,255,.07);
        display: flex;
        justify-content: center;
    }

    /* MOBILE */

    @media(max-width: 992px){

        .contact-hero h1{
            font-size: 1.8rem;
        }

        .premium-table td,
        .premium-table th{
            white-space: nowrap;
        }

    }

</style>

@endsection
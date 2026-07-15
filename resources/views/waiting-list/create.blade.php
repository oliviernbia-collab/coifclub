@extends('layouts.app')

@section('title', __('messages.waiting_list_title'))

@section('content')

<style>
body { background: #0e0a1c; color: rgba(255,255,255,.85); }

.wl-wrap {
    max-width: 860px;
    margin: 0 auto;
    padding: 40px 20px;
}

.wl-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 28px;
    padding: 32px;
    box-shadow: 0 24px 60px rgba(0,0,0,.3);
}

.wl-header {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}

.wl-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: rgba(255,255,255,.9);
    margin-bottom: 0.4rem;
}

.wl-header p {
    color: rgba(255,255,255,.5);
    font-size: 1rem;
    max-width: 560px;
    margin: 0;
}

.wl-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.8);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 16px;
    padding: 12px 20px;
    text-decoration: none;
    font-weight: 600;
    transition: .2s ease;
    white-space: nowrap;
}

.wl-back:hover {
    background: rgba(255,255,255,.13);
    color: white;
    text-decoration: none;
}

.wl-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 28px;
}

.wl-info-box {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    padding: 20px;
}

.wl-info-label {
    color: rgba(255,255,255,.45);
    font-weight: 700;
    font-size: .85rem;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin: 0 0 8px;
}

.wl-info-value {
    color: rgba(255,255,255,.85);
    font-size: 1rem;
    margin: 0;
}

.wl-form {
    display: grid;
    gap: 20px;
}

.wl-field label {
    display: block;
    font-weight: 700;
    color: rgba(255,255,255,.7);
    font-size: .9rem;
    margin-bottom: 8px;
}

.wl-input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,.12);
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.9);
    font-size: 1rem;
    outline: none;
    transition: border-color .2s, background .2s;
}

.wl-input::placeholder { color: rgba(255,255,255,.3); }

.wl-input:focus {
    border-color: rgba(201,169,110,.5);
    background: rgba(255,255,255,.08);
}

.wl-input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) opacity(.5);
}

.wl-submit {
    background: linear-gradient(135deg, #c9a96e, #a07840);
    color: #fff;
    border: none;
    border-radius: 18px;
    padding: 15px 22px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: .25s ease;
    box-shadow: 0 12px 30px rgba(201,169,110,.25);
}

.wl-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 40px rgba(201,169,110,.35);
}

@media(max-width: 640px) {
    .wl-info-grid { grid-template-columns: 1fr; }
    .wl-header { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="wl-wrap">
    <div class="wl-card">

        <div class="wl-header">
            <div>
                <h1>{{ __('messages.waiting_list_title') }}</h1>
                <p>{{ __('messages.waiting_list_description') }}</p>
            </div>
            <a href="{{ url()->previous() }}" class="wl-back">
                ← {{ __('messages.back') }}
            </a>
        </div>

        <div class="wl-info-grid">
            <div class="wl-info-box">
                <p class="wl-info-label">{{ __('messages.service_requested') }}</p>
                <p class="wl-info-value">{{ $service ? $service->name : __('messages.service_not_specified') }}</p>
            </div>
            <div class="wl-info-box">
                <p class="wl-info-label">{{ __('messages.preferred_stylist') }}</p>
                <p class="wl-info-value">{{ $employee ? $employee->name : __('messages.no_preference') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('waiting-list.store') }}" class="wl-form">
            @csrf

            <input type="hidden" name="service_id" value="{{ $service?->id }}">
            <input type="hidden" name="employee_id" value="{{ $employee?->id }}">

            <div class="wl-field">
                <label>{{ __('messages.desired_date') }}</label>
                <input type="date" name="preferred_date" class="wl-input" value="{{ old('preferred_date') }}">
            </div>

            <div class="wl-field">
                <label>{{ __('messages.desired_time') }}</label>
                <input type="text" name="preferred_time" placeholder="Ex: 15:00" class="wl-input" value="{{ old('preferred_time') }}">
            </div>

            <div class="wl-field">
                <label>{{ __('messages.notes') }}</label>
                <textarea name="notes" rows="5" class="wl-input">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="wl-submit">{{ __('messages.join_waiting_list') }}</button>
        </form>

    </div>
</div>

@endsection

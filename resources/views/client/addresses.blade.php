@extends('layouts.client')

@section('title', __('messages.clt_addr_title'))
@section('page-title', __('messages.clt_addr_title'))

@section('content')

<style>
:root{
    --pink:#e91e8c;--pink-light:#ff6ab4;--pink-dark:#c91a78;
    --card:rgba(255,255,255,.05);--card-border:rgba(255,255,255,.08);
    --text:rgba(255,255,255,.9);--muted:rgba(255,255,255,.45);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}
.adr *{box-sizing:border-box;}
.adr-wrap{max-width:960px;}

/* Flash */
.flash-ok{background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:14px;padding:13px 18px;display:flex;align-items:center;gap:10px;margin-bottom:20px;color:#4ade80;font-size:.88rem;font-weight:600;}
.flash-err{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:14px;padding:13px 18px;display:flex;align-items:center;gap:10px;margin-bottom:20px;color:#f87171;font-size:.88rem;font-weight:600;}

/* Banner */
.adr-banner{position:relative;background:var(--card);border:1px solid rgba(233,30,140,.2);border-radius:24px;padding:28px 32px;margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;gap:16px;overflow:hidden;flex-wrap:wrap;}
.adr-banner::before{content:'';position:absolute;right:0;top:0;bottom:0;width:200px;background:radial-gradient(circle at right,rgba(233,30,140,.08),transparent 70%);}
.adr-banner-sub{font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;}
.adr-banner-title{font-size:1.6rem;font-weight:900;color:var(--text);margin-bottom:4px;}
.adr-banner-desc{color:var(--pink-light);font-size:.85rem;font-weight:500;}

/* Buttons */
.btn-primary-adr{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;background:var(--gradient);border:none;border-radius:14px;color:#fff;font-size:.85rem;font-weight:700;cursor:pointer;transition:.25s;text-decoration:none;flex-shrink:0;}
.btn-primary-adr:hover{opacity:.9;transform:translateY(-1px);color:#fff;}
.btn-secondary-adr{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:12px;color:var(--text);font-size:.85rem;font-weight:600;cursor:pointer;transition:.2s;}
.btn-secondary-adr:hover{background:rgba(255,255,255,.1);}

/* Panel */
.adr-panel{max-height:0;overflow:hidden;transition:max-height .35s ease,opacity .25s ease;opacity:0;}
.adr-panel.open{max-height:700px;opacity:1;}

/* Input */
.adr-label{display:block;font-size:.8rem;font-weight:600;color:var(--muted);margin-bottom:5px;text-transform:uppercase;letter-spacing:.04em;}
.adr-input{width:100%;padding:11px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(233,30,140,.2);border-radius:12px;color:var(--text);font-size:.875rem;outline:none;transition:.25s;font-family:inherit;}
.adr-input:focus{border-color:rgba(233,30,140,.5);background:rgba(233,30,140,.05);}
.adr-input::placeholder{color:var(--muted);}
.req{color:var(--pink);}

/* Add form card */
.add-form-card{background:rgba(233,30,140,.04);border:1px solid rgba(233,30,140,.15);border-radius:20px;padding:26px;margin-bottom:24px;}
.add-form-head{display:flex;align-items:center;gap:12px;margin-bottom:20px;}
.add-form-icon{width:40px;height:40px;border-radius:12px;background:var(--gradient);display:flex;align-items:center;justify-content:center;flex-shrink:0;}

/* Grid */
.adr-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
@media(max-width:680px){.adr-grid{grid-template-columns:1fr;}}

/* Address card */
.adr-card{background:var(--card);border:1px solid var(--card-border);border-radius:20px;padding:22px;position:relative;transition:.25s;}
.adr-card:hover{border-color:rgba(233,30,140,.2);transform:translateY(-2px);}
.adr-card.primary-card{border-color:rgba(233,30,140,.35);background:rgba(233,30,140,.04);}
.primary-badge{position:absolute;top:16px;right:16px;background:var(--gradient);color:#fff;font-size:.68rem;font-weight:700;padding:3px 11px;border-radius:999px;}
.adr-card-head{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
.adr-card-icon{width:44px;height:44px;border-radius:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.adr-card-name{font-weight:700;color:var(--text);font-size:1rem;}
.adr-card-type{font-size:.75rem;color:var(--muted);margin-top:2px;}
.adr-info-box{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:12px;padding:14px;margin-bottom:16px;}
.adr-info-row{display:flex;align-items:flex-start;gap:8px;margin-bottom:6px;}
.adr-info-row:last-child{margin-bottom:0;}
.adr-info-row i{color:var(--pink);font-size:11px;margin-top:3px;flex-shrink:0;width:14px;text-align:center;}
.adr-info-text{font-size:.875rem;color:var(--text);}
.adr-actions{display:flex;gap:8px;}

.btn-edit-adr{flex:1;padding:8px 12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:10px;color:var(--pink-light);font-size:.78rem;font-weight:600;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;justify-content:center;gap:5px;}
.btn-edit-adr:hover{background:rgba(233,30,140,.1);border-color:rgba(233,30,140,.3);}
.btn-star-adr{flex:1;padding:8px 12px;background:rgba(74,222,128,.06);border:1px solid rgba(74,222,128,.2);border-radius:10px;color:#4ade80;font-size:.78rem;font-weight:600;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;justify-content:center;gap:5px;width:100%;}
.btn-star-adr:hover{background:rgba(74,222,128,.12);}
.btn-del-adr{padding:8px 12px;background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);border-radius:10px;color:#f87171;font-size:.78rem;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;justify-content:center;}
.btn-del-adr:hover{background:rgba(239,68,68,.14);}
.btn-save-adr{padding:9px 18px;background:var(--gradient);border:none;border-radius:10px;color:#fff;font-size:.82rem;font-weight:700;cursor:pointer;transition:.2s;}
.btn-save-adr:hover{opacity:.9;}

/* Edit inline */
.edit-panel{max-height:0;overflow:hidden;transition:max-height .35s ease,opacity .25s ease;opacity:0;}
.edit-panel.open{max-height:500px;opacity:1;}
.edit-panel-inner{margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,.05);}
.edit-panel-label{font-size:.8rem;font-weight:700;color:var(--pink-light);margin-bottom:12px;display:flex;align-items:center;gap:6px;}

/* Empty */
.adr-empty{background:var(--card);border:1.5px dashed rgba(233,30,140,.2);border-radius:20px;padding:60px 24px;text-align:center;}
.adr-empty-icon{width:76px;height:76px;border-radius:50%;background:rgba(233,30,140,.06);border:1px solid rgba(233,30,140,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;}
.adr-empty-title{font-weight:700;color:var(--text);margin:0 0 8px;font-size:1.05rem;}
.adr-empty-text{color:var(--muted);font-size:.88rem;margin:0 0 20px;}

/* Tip */
.adr-tip{margin-top:16px;background:rgba(233,30,140,.05);border:1px dashed rgba(233,30,140,.2);border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;}
.adr-tip p{margin:0;font-size:.82rem;color:var(--muted);}

/* Modal */
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;}
.modal-bg.show{display:flex;}
.modal-box{background:#1a1235;border:1px solid rgba(233,30,140,.2);border-radius:24px;padding:32px;max-width:380px;width:90%;text-align:center;animation:pop .2s ease;}
@keyframes pop{from{transform:scale(.92);opacity:0}to{transform:scale(1);opacity:1}}
.modal-icon{width:60px;height:60px;border-radius:50%;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
.modal-title{font-size:1.05rem;font-weight:700;color:var(--text);margin:0 0 8px;}
.modal-text{font-size:.85rem;color:var(--muted);margin:0 0 24px;}
.btn-confirm-del{padding:10px 22px;background:linear-gradient(135deg,#ef4444,#dc2626);border:none;border-radius:12px;color:#fff;font-size:.88rem;font-weight:700;cursor:pointer;}
</style>

<div class="adr adr-wrap">

@if(session('success'))
<div class="flash-ok"><i class="fa-solid fa-circle-check" style="flex-shrink:0;"></i>{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="flash-err"><i class="fa-solid fa-circle-exclamation" style="flex-shrink:0;"></i>
    <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
</div>
@endif

{{-- Banner --}}
<div class="adr-banner">
    <div>
        <div class="adr-banner-sub">{{ __('messages.clt_addr_banner_sub') }}</div>
        <h2 class="adr-banner-title">{{ __('messages.clt_addr_title') }}</h2>
        <p class="adr-banner-desc">{{ __('messages.clt_addr_banner_desc') }}</p>
    </div>
    <button onclick="toggleAddForm()" id="btn-add-toggle" class="btn-primary-adr">
        <i class="fa-solid fa-plus" id="btn-add-icon"></i>
        <span id="btn-add-text">{{ __('messages.clt_add_address') }}</span>
    </button>
</div>

{{-- Add form --}}
<div id="add-panel" class="adr-panel">
    <div class="add-form-card">
        <div class="add-form-head">
            <div class="add-form-icon"><i class="fa-solid fa-location-dot" style="color:#fff;font-size:16px;"></i></div>
            <div>
                <div style="font-size:1rem;font-weight:700;color:var(--text);">{{ __('messages.clt_new_address') }}</div>
                <div style="font-size:.78rem;color:var(--muted);">{{ __('messages.clt_fill_fields') }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('client.addresses.store') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label class="adr-label">{{ __('messages.clt_addr_label') }} <span class="req">*</span></label>
                    <input type="text" name="label" class="adr-input" placeholder="Ex : Domicile, Bureau…" value="{{ old('label') }}" required>
                </div>
                <div>
                    <label class="adr-label">{{ __('messages.clt_addr_phone') }}</label>
                    <input type="text" name="phone" class="adr-input" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="adr-label">{{ __('messages.clt_addr_address') }} <span class="req">*</span></label>
                    <input type="text" name="address" class="adr-input" placeholder="Numéro et nom de rue" value="{{ old('address') }}" required>
                </div>
                <div>
                    <label class="adr-label">{{ __('messages.clt_addr_city') }} <span class="req">*</span></label>
                    <input type="text" name="city" class="adr-input" placeholder="Chicago" value="{{ old('city') }}" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div>
                        <label class="adr-label">{{ __('messages.clt_addr_state') }}</label>
                        <input type="text" name="state" class="adr-input" placeholder="IL" value="{{ old('state') }}">
                    </div>
                    <div>
                        <label class="adr-label">{{ __('messages.clt_addr_zip') }}</label>
                        <input type="text" name="zip_code" class="adr-input" placeholder="60636" value="{{ old('zip_code') }}">
                    </div>
                </div>
                <div style="grid-column:1/-1;display:flex;justify-content:flex-end;gap:10px;padding-top:6px;border-top:1px solid rgba(255,255,255,.06);margin-top:4px;">
                    <button type="button" onclick="toggleAddForm()" class="btn-secondary-adr"><i class="fa-solid fa-xmark"></i> {{ __('messages.clt_addr_cancel') }}</button>
                    <button type="submit" class="btn-primary-adr"><i class="fa-solid fa-floppy-disk"></i> {{ __('messages.clt_addr_save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Address grid --}}
@if($addresses->isEmpty())
<div class="adr-empty">
    <div class="adr-empty-icon"><i class="fa-solid fa-map-location-dot" style="font-size:2rem;color:rgba(233,30,140,.4);"></i></div>
    <h5 class="adr-empty-title">{{ __('messages.clt_no_addr_title') }}</h5>
    <p class="adr-empty-text">{{ __('messages.clt_no_addr_text') }}</p>
    <button onclick="toggleAddForm()" class="btn-primary-adr"><i class="fa-solid fa-plus"></i> {{ __('messages.clt_add_first_address') }}</button>
</div>
@else
<div class="adr-grid">
    @foreach($addresses as $addr)
    @php
        $icons = ['domicile'=>'fa-house','bureau'=>'fa-briefcase','travail'=>'fa-briefcase','autre'=>'fa-map-pin'];
        $icon  = $icons[strtolower($addr->label)] ?? 'fa-location-dot';
    @endphp
    <div class="adr-card {{ $addr->is_primary ? 'primary-card' : '' }}">
        @if($addr->is_primary)<span class="primary-badge">{{ __('messages.clt_primary_badge') }}</span>@endif

        <div class="adr-card-head">
            <div class="adr-card-icon" style="background:{{ $addr->is_primary ? 'var(--gradient)' : 'rgba(255,255,255,.08)' }};">
                <i class="fa-solid {{ $icon }}" style="font-size:18px;color:{{ $addr->is_primary ? '#fff' : 'var(--pink-light)' }};"></i>
            </div>
            <div>
                <div class="adr-card-name">{{ $addr->label }}</div>
                <div class="adr-card-type">{{ $addr->is_primary ? __('messages.clt_addr_primary_label') : __('messages.clt_addr_secondary_label') }}</div>
            </div>
        </div>

        <div class="adr-info-box">
            <div class="adr-info-row"><i class="fa-solid fa-road"></i><span class="adr-info-text">{{ $addr->address }}</span></div>
            <div class="adr-info-row"><i class="fa-solid fa-city"></i><span class="adr-info-text">{{ $addr->city }}{{ $addr->state ? ', '.$addr->state : '' }}{{ $addr->zip_code ? ' '.$addr->zip_code : '' }}</span></div>
            <div class="adr-info-row"><i class="fa-solid fa-flag"></i><span class="adr-info-text">{{ $addr->country }}</span></div>
            @if($addr->phone)
            <div class="adr-info-row" style="padding-top:6px;border-top:1px solid rgba(255,255,255,.05);margin-top:4px;">
                <i class="fa-solid fa-phone"></i><span class="adr-info-text" style="color:var(--muted);">{{ $addr->phone }}</span>
            </div>
            @endif
        </div>

        <div class="adr-actions">
            <button onclick="toggleEdit({{ $addr->id }})" class="btn-edit-adr"><i class="fa-regular fa-pen-to-square"></i> {{ __('messages.clt_addr_edit') }}</button>
            @if(!$addr->is_primary)
            <form method="POST" action="{{ route('client.addresses.setPrimary', $addr) }}" style="flex:1;">
                @csrf
                <button type="submit" class="btn-star-adr"><i class="fa-regular fa-star"></i> {{ __('messages.clt_addr_set_primary') }}</button>
            </form>
            @endif
            <button onclick="openDeleteModal({{ $addr->id }})" class="btn-del-adr" title="{{ __('messages.clt_addr_delete') }}"><i class="fa-regular fa-trash-can"></i></button>
            <form id="del-form-{{ $addr->id }}" method="POST" action="{{ route('client.addresses.delete', $addr) }}" style="display:none;">@csrf @method('DELETE')</form>
        </div>

        <div id="edit-{{ $addr->id }}" class="edit-panel">
            <div class="edit-panel-inner">
                <div class="edit-panel-label"><i class="fa-solid fa-pencil"></i> {{ __('messages.clt_edit_this_address') }}</div>
                <form method="POST" action="{{ route('client.addresses.update', $addr) }}">
                    @csrf @method('PUT')
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div>
                            <label class="adr-label">{{ __('messages.clt_addr_label') }} <span class="req">*</span></label>
                            <input type="text" name="label" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->label }}" required>
                        </div>
                        <div>
                            <label class="adr-label">{{ __('messages.clt_addr_phone') }}</label>
                            <input type="text" name="phone" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->phone }}">
                        </div>
                        <div style="grid-column:1/-1;">
                            <label class="adr-label">{{ __('messages.clt_addr_address') }} <span class="req">*</span></label>
                            <input type="text" name="address" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->address }}" required>
                        </div>
                        <div>
                            <label class="adr-label">{{ __('messages.clt_addr_city') }} <span class="req">*</span></label>
                            <input type="text" name="city" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->city }}" required>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div>
                                <label class="adr-label">{{ __('messages.clt_addr_state') }}</label>
                                <input type="text" name="state" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->state }}">
                            </div>
                            <div>
                                <label class="adr-label">{{ __('messages.clt_addr_zip') }}</label>
                                <input type="text" name="zip_code" class="adr-input" style="padding:8px 12px;font-size:.82rem;" value="{{ $addr->zip_code }}">
                            </div>
                        </div>
                        <div style="grid-column:1/-1;display:flex;justify-content:flex-end;gap:8px;padding-top:8px;">
                            <button type="button" onclick="toggleEdit({{ $addr->id }})" class="btn-secondary-adr" style="font-size:.8rem;padding:8px 14px;"><i class="fa-solid fa-xmark"></i> {{ __('messages.clt_addr_cancel') }}</button>
                            <button type="submit" class="btn-save-adr"><i class="fa-solid fa-floppy-disk"></i> {{ __('messages.clt_addr_save_btn') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="adr-tip">
    <i class="fa-solid fa-circle-info" style="color:var(--pink);font-size:16px;flex-shrink:0;"></i>
    <p>{{ __('messages.clt_addr_tip') }}</p>
</div>
@endif

{{-- Delete Modal --}}
<div id="delete-modal" class="modal-bg">
    <div class="modal-box">
        <div class="modal-icon"><i class="fa-regular fa-trash-can" style="font-size:1.6rem;color:#f87171;"></i></div>
        <h4 class="modal-title">{{ __('messages.clt_delete_confirm_title') }}</h4>
        <p class="modal-text">{{ __('messages.clt_delete_confirm_text') }}</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="closeDeleteModal()" class="btn-secondary-adr">{{ __('messages.clt_addr_cancel') }}</button>
            <button onclick="confirmDelete()" class="btn-confirm-del"><i class="fa-solid fa-trash mr-1"></i> {{ __('messages.clt_confirm_delete_btn') }}</button>
        </div>
    </div>
</div>

</div>

<script>
function toggleAddForm(){
    const p=document.getElementById('add-panel'),i=document.getElementById('btn-add-icon'),t=document.getElementById('btn-add-text');
    const o=p.classList.toggle('open');
    i.className=o?'fa-solid fa-xmark':'fa-solid fa-plus';
    t.textContent=o?'{{ __('messages.clt_close') }}':'{{ __('messages.clt_add_address') }}';
    if(o)p.scrollIntoView({behavior:'smooth',block:'nearest'});
}
function toggleEdit(id){
    const p=document.getElementById('edit-'+id);
    p.classList.toggle('open');
    if(p.classList.contains('open'))p.scrollIntoView({behavior:'smooth',block:'nearest'});
}
let _delId=null;
function openDeleteModal(id){_delId=id;document.getElementById('delete-modal').classList.add('show');}
function closeDeleteModal(){document.getElementById('delete-modal').classList.remove('show');_delId=null;}
function confirmDelete(){if(_delId!==null)document.getElementById('del-form-'+_delId).submit();}
document.getElementById('delete-modal').addEventListener('click',function(e){if(e.target===this)closeDeleteModal();});
@if($errors->any()) toggleAddForm(); @endif
</script>

@endsection

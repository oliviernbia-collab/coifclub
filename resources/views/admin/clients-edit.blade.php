@extends(request()->ajax() ? 'layouts.empty' : 'layouts.admin')

@section('title', __('messages.adm_edit_client_title'))

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            {{-- CARD --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- HEADER --}}
                <div class="card-header bg-dark text-white py-3 d-flex align-items-center justify-content-between">

                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-pen text-warning fs-5"></i>
                        <h5 class="mb-0 fw-bold">{{ __('messages.adm_edit_client_title') }}</h5>
                    </div>

                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                        ID #{{ $client->id }}
                    </span>

                </div>

                <div class="card-body p-4">

                    {{-- AVATAR --}}
                    <div class="text-center mb-4">

                        <div class="mx-auto mb-3"
                             style="width:90px;height:90px;border-radius:50%;
                                    background:#0d6efd;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:28px;color:white;font-weight:bold;
                                    box-shadow:0 10px 20px rgba(0,0,0,0.15);">

                            {{ strtoupper(substr($client->name,0,1)) }}

                        </div>

                        <h5 class="mb-0 fw-bold">{{ $client->name }}</h5>
                        <small class="text-muted">{{ __('messages.adm_premium_client_label') }}</small>

                    </div>

                    {{-- FORM --}}
                    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NOM --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user me-1 text-primary"></i>
                                {{ __('messages.adm_client_full_name') }}
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control form-control-lg rounded-3"
                                   value="{{ old('name', $client->name) }}"
                                   required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-envelope me-1 text-primary"></i>
                                {{ __('messages.email') }}
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control form-control-lg rounded-3"
                                   value="{{ old('email', $client->email) }}"
                                   required>
                        </div>

                        {{-- TELEPHONE --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-phone me-1 text-primary"></i>
                                {{ __('messages.phone') }}
                            </label>

                            <input type="text"
                                   name="phone"
                                   class="form-control form-control-lg rounded-3"
                                   value="{{ old('phone', $client->phone) }}">
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-shield me-1 text-primary"></i>
                                {{ __('messages.adm_client_role') }}
                            </label>

                            <input type="text"
                                   name="role"
                                   class="form-control form-control-lg rounded-3"
                                   value="{{ old('role', $client->role) }}">
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <a href="{{ route('admin.clients') }}"
                               class="btn btn-outline-secondary px-4 rounded-pill">
                                <i class="fa-solid fa-arrow-left me-1"></i>
                                {{ __('messages.btn_back') }}
                            </a>

                            <button type="submit"
                                    class="btn btn-warning px-4 rounded-pill fw-semibold shadow-sm">

                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                {{ __('messages.adm_save_client') }}
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection
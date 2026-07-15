@extends('layouts.admin')

@section('title', 'Politique d\'annulation')

@section('content')

<style>
body { background: #0e0a1c; }
.pol-header{
    background:
        radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
        linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
    border-radius: 28px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
}
.pol-header h1 { color: white; font-size: 2rem; font-weight: 800; margin-bottom: .6rem; }
.pol-header p  { color: rgba(255,255,255,.6); margin: 0; }
.pol-card{
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 22px;
    padding: 1.8rem;
    height: 100%;
}
.pol-card h3 { color: rgba(255,255,255,.9); font-weight: 800; margin-bottom: 1rem; }
.pol-card .form-label { color: rgba(255,255,255,.65); font-weight: 600; }
.pol-card .form-control{
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    color: rgba(255,255,255,.9);
    border-radius: 14px;
}
.pol-card .form-control:focus{
    background: rgba(255,255,255,.09);
    border-color: rgba(212,175,55,.5);
    color: rgba(255,255,255,.9);
    box-shadow: none;
}
.pol-card .form-control::placeholder { color: rgba(255,255,255,.3); }
.pol-card .text-muted { color: rgba(255,255,255,.4) !important; }
.pol-refund-badge{
    display: inline-flex;
    align-items: center;
    padding: .5rem 1rem;
    border-radius: 999px;
    background: rgba(212,175,55,.15);
    color: #D4AF37;
    border: 1px solid rgba(212,175,55,.25);
    font-weight: 800;
    font-size: .9rem;
}
.pol-btn{
    background: linear-gradient(135deg,#D4AF37,#B8860B);
    color: white;
    border: none;
    border-radius: 14px;
    padding: .65rem 1.4rem;
    font-weight: 700;
    transition: .2s;
}
.pol-btn:hover{ transform: translateY(-2px); color: white; }
.pol-empty{
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 22px;
    padding: 3rem;
    text-align: center;
    color: rgba(255,255,255,.5);
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="pol-header">
                <h1><i class="fa-solid fa-shield-halved me-2"></i>Politique d'annulation</h1>
                <p>Découvrez comment nous gérons les remboursements selon le moment de votre annulation.</p>
            </div>

            <div class="row g-4">
                @forelse($policies as $policy)
                    <div class="col-md-6">
                        <div class="pol-card">
                            @if(auth()->check() && auth()->user()->hasRole('admin'))
                                <form action="{{ route('admin.cancellation-policies.update', $policy) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h3>{{ ucfirst($policy->name) }}</h3>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Description de la politique">{{ old('description', $policy->description) }}</textarea>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 gap-3">
                                        <div>
                                            <label class="form-label mb-1">Remboursement (%)</label>
                                            <input type="number" name="refund_percentage" value="{{ old('refund_percentage', $policy->refund_percentage) }}" min="0" max="100" class="form-control" aria-label="Pourcentage de remboursement">
                                        </div>
                                        <button type="submit" class="pol-btn mt-4">Mettre à jour</button>
                                    </div>
                                    <div class="mt-3 text-muted small">
                                        <span>{{ $policy->updated_at ? $policy->updated_at->diffForHumans() : '' }}</span>
                                    </div>
                                </form>
                            @else
                                <h3>{{ ucfirst($policy->name) }}</h3>
                                <p class="text-muted">{{ $policy->description ?? 'Pourcentage de remboursement selon le délai.' }}</p>
                                <div class="d-flex align-items-center justify-content-between mt-4">
                                    <span class="pol-refund-badge">{{ $policy->refund_percentage }}% remboursé</span>
                                    <span class="text-muted small">{{ $policy->updated_at ? $policy->updated_at->diffForHumans() : '' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="pol-empty">Aucune politique d'annulation définie pour le moment.</div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@endsection

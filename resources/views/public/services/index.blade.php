@extends('main.index')

@push('styles')
<style>
.service-card{transition:box-shadow .2s,transform .18s;cursor:pointer;}
.service-card:hover{box-shadow:0 8px 28px rgba(0,0,0,.1)!important;transform:translateY(-2px);}
.cert-badge{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:.68rem;padding:2px 7px;border-radius:999px;}
</style>
@endpush

@section('content')
<div class="custom-container py-6  pt-12 px-10">

    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-bold mb-1">Services</h2>
            <p class="text-secondary small mb-0">{{ $services->count() }} service(s) trouve(s)</p>
        </div>
    </div>

    @if(session('error'))<div class="alert alert-warning alert-dismissible fade show mb-4">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body py-3 px-4">
            <form method="GET" action="{{ route('services.index') }}" class="d-flex gap-3 flex-wrap align-items-center">
                @if($lat)<input type="hidden" name="lat" value="{{ $lat }}">@endif
                @if($lng)<input type="hidden" name="lng" value="{{ $lng }}">@endif
                <input type="text" name="search" class="form-control form-control-sm" style="max-width:260px;" placeholder="Nom ou description..." value="{{ request('search') }}">
                <select name="categorie" class="form-select form-select-sm" style="max-width:200px;">
                    <option value="">Toutes categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('categorie')===$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <select name="tri" class="form-select form-select-sm" style="max-width:200px;">
                    <option value="proximite" {{ request('tri','proximite')==='proximite'?'selected':'' }}>@if($lat)Plus proche @else Par defaut @endif</option>
                    <option value="score"     {{ request('tri')==='score'?'selected':'' }}>Mieux note</option>
                    <option value="prix_asc"  {{ request('tri')==='prix_asc'?'selected':'' }}>Prix croissant</option>
                    <option value="prix_desc" {{ request('tri')==='prix_desc'?'selected':'' }}>Prix decroissant</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
                <a href="{{ route('services.index', array_filter(['lat'=>$lat,'lng'=>$lng])) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
            </form>
        </div>
    </div>

    @if($services->isEmpty())
    <div class="text-center py-6 text-secondary">Aucun service trouve pour ces criteres.</div>
    @else
    <div class="row g-4">
        @foreach($services as $s)
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('commerces.show', array_merge(['commerce'=>$s->commerce->id], array_filter(['lat'=>$lat,'lng'=>$lng]))) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 rounded-4 service-card overflow-hidden">
                <div class="position-relative overflow-hidden" style="height:160px;">
                    @if($s->photo)
                        <img src="{{ asset('storage/'.$s->photo) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $s->nomService }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/><path d="M12 3v18"/><path d="M4 7l8 4l8 -4"/></svg>
                        </div>
                    @endif
                    @if(isset($s->distance))
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark bg-opacity-75 text-white" style="font-size:.7rem;">{{ $s->distance }} km</span>
                    @endif
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-1 text-dark small">{{ $s->nomService }}</h6>
                    @if($s->description)<p class="text-secondary mb-2" style="font-size:.78rem;line-clamp:2;">{{ Str::limit($s->description,70) }}</p>@endif
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-primary small">{{ number_format($s->prixService,0,',',' ') }} FCFA</span>
                        @if($s->scoringService > 0)
                        <div class="d-flex align-items-center gap-1">
                            @foreach(range(1,5) as $i)
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 16 16" fill="{{ $i <= $s->scoringService ? '#f59e0b' : '#e5e7eb' }}"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @if($s->commerce)
                    <div class="d-flex align-items-center gap-1">
                        <span class="badge bg-info-subtle text-info rounded-pill" style="font-size:.68rem;">{{ $s->commerce->categorie }}</span>
                        @if($s->commerce && $s->commerce->user && $s->commerce->user->isCertified)<span class="cert-badge">✓</span>@endif
                        <span class="text-secondary" style="font-size:.72rem;">{{ $s->commerce->nomCormmercial }}</span>
                    </div>
                    @endif
                </div>
            </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@include('main.navbar')

@push('scripts')
<script>
const hasPos = new URLSearchParams(location.search).has('lat');
if (!hasPos && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
        const p = new URLSearchParams(location.search);
        p.set('lat', pos.coords.latitude.toFixed(6));
        p.set('lng', pos.coords.longitude.toFixed(6));
        window.location.search = p.toString();
    });
}
</script>
@endpush

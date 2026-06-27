@extends('main.index')

@push('styles')
<style>
.commerce-card{transition:box-shadow .25s,transform .2s;cursor:pointer;}
.commerce-card:hover{box-shadow:0 12px 40px rgba(0,0,0,.12)!important;transform:translateY(-3px);}
.commerce-card img{transition:transform .4s;}
.commerce-card:hover img{transform:scale(1.05);}
.cert-badge{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:.7rem;padding:2px 8px;border-radius:999px;}
</style>
@endpush

@section('content')
<div class="custom-container py-6">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-bold mb-1">Commerces</h2>
            <p class="text-secondary small mb-0">{{ $commerces->count() }} commerce(s) trouve(s)</p>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show mb-4">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm mb-5 pt-12 px-10">
        <div class="card-body py-3 px-4">
            <form method="GET" action="{{ route('commerces.index') }}" class="d-flex gap-3 flex-wrap align-items-center" id="filterForm">
                @if($lat)<input type="hidden" name="lat" value="{{ $lat }}">@endif
                @if($lng)<input type="hidden" name="lng" value="{{ $lng }}">@endif
                <input type="text" name="search" class="form-control form-control-sm" style="max-width:260px;" placeholder="Nom, ville, categorie..." value="{{ request('search') }}">
                <select name="categorie" class="form-select form-select-sm" style="max-width:200px;">
                    <option value="">Toutes categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('categorie')===$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <select name="tri" class="form-select form-select-sm" style="max-width:180px;">
                    <option value="proximite" {{ request('tri','proximite')==='proximite'?'selected':'' }}>@if($lat)Plus proche @else Par defaut @endif</option>
                    <option value="score" {{ request('tri')==='score'?'selected':'' }}>Mieux note</option>
                    <option value="recent" {{ request('tri')==='recent'?'selected':'' }}>Plus recent</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
                <a href="{{ route('commerces.index', array_filter(['lat'=>$lat,'lng'=>$lng])) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
            </form>
        </div>
    </div>

    @if($commerces->isEmpty())
    <div class="text-center py-6 text-secondary">Aucun commerce trouve pour ces criteres.</div>
    @else
    <div class="row g-4">
        @foreach($commerces as $c)
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('commerces.show', array_merge(['commerce'=>$c->id], array_filter(['lat'=>$lat,'lng'=>$lng]))) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 commerce-card">
                <div class="position-relative overflow-hidden" style="height:170px;">
                    @if(!empty($c->photos[0]))
                        <img src="{{ asset('storage/'.$c->photos[0]) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $c->nomCormmercial }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#ccc" stroke-width="1" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0"/><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/></svg>
                        </div>
                    @endif
                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                        <span class="badge bg-info-subtle text-info rounded-pill" style="font-size:.7rem;">{{ $c->categorie }}</span>
                        @if($c->user && $c->user->isCertified)<span class="cert-badge">✓ Certifie</span>@endif
                    </div>
                    @if(isset($c->distance))
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark bg-opacity-75 text-white" style="font-size:.7rem;">{{ $c->distance }} km</span>
                    @endif
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-1 text-dark">{{ $c->nomCormmercial }}</h6>
                    <p class="text-secondary small mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 11m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/></svg>{{ $c->ville }}</p>
                    @if($c->scoringCommerce > 0)
                    <div class="d-flex align-items-center gap-1">
                        @foreach(range(1,5) as $i)
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 16 16" fill="{{ $i <= $c->scoringCommerce ? '#f59e0b' : '#e5e7eb' }}"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                        @endforeach
                        <span class="text-secondary ms-1" style="font-size:.7rem;">{{ number_format($c->scoringCommerce,1) }}/5</span>
                    </div>
                    @endif
                    @if($c->user)
                    <p class="text-secondary small mb-0 mt-1">
                        par {{ $c->user->prenom }} {{ $c->user->name }}
                        @if($c->user->scoringArtisant > 0)<span class="ms-1 text-warning small">★ {{ number_format($c->user->scoringArtisant,1) }}</span>@endif
                    </p>
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

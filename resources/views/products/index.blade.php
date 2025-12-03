@extends('layouts.app')

@section('content')
<div class="container py-5">

@push('styles')
<style>
/* HERO styles only - keep minimal and non-duplicative */
.products-hero { 
    background: linear-gradient(135deg,#0055cc 0%, #1a6fff 40%, #66aaff 100%); 
    border-radius: 14px; 
    padding: 1.5rem; 
    box-shadow: 0 18px 50px rgba(13,110,253,0.14); 
    margin-bottom: 1rem; 
    color: #fff; 
    overflow: hidden; 
    position: relative;
}
body.day-mode .products-hero {
    background: linear-gradient(135deg,#4dabff 0%, #74c0ff 40%, #a5d8ff 100%);
}

/* card hover */
.hover-top { transition: transform .3s, box-shadow .3s; }
.hover-top:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important; }

/* focus outline */
button:focus, .btn:focus, a:focus, input:focus { outline: 3px solid rgba(13,110,253,0.12); outline-offset: 2px; }
/* subtle decorative overlay on the right to give depth (non-interactive) */
.products-hero::after {
    content: '';
    position: absolute;
    right: -40px;
    top: 10%;
    width: 360px;
    height: 200px;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.18), rgba(255,255,255,0) 40%);
    transform: rotate(10deg);
    pointer-events: none;
    filter: blur(18px);
    border-radius: 20px;
}
</style>
@endpush

<!-- keep only the pagination redirect script; UI/decoration handled globally -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    try {
        const url = new URL(window.location.href);
        if (url.searchParams.has('page')) {
            const pageVal = url.searchParams.get('page');
            if (pageVal && pageVal !== '1') {
                url.searchParams.delete('page');
                window.location.replace(url.toString());
                return;
            }
        }
    } catch(e){}
});
</script>
@endpush

<!-- ============================================================
   HERO + SEARCHBAR
============================================================ -->
<div class="row justify-content-center mb-5 product-card-anim products-hero position-relative" style="z-index:2;">

    <div class="col-lg-10 hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7 text-center text-lg-start mb-4">
                <h2 class="fw-bold text-white display-5 mb-2">🛍️ Temukan Gadget Impianmu</h2>
                <p class="text-white-50 lead mb-3">Jelajahi koleksi elektronik terbaik dengan harga terjangkau. Dapatkan penawaran dan produk terlaris setiap minggu.</p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">Lihat Semua</a>
                    <a href="{{ route('products.index', ['sort'=>'popular']) }}" class="btn btn-outline-light btn-sm">Terlaris</a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0" style="border-radius: 15px; overflow:hidden;">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-2 align-items-end">
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small">Cari Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-0" placeholder="Contoh: iPhone 13, Laptop...">
                                </div>
                            </div>

                            <div class="col-7">
                                <label class="form-label fw-bold text-muted small">Kategori</label>
                                <select name="category" class="form-select bg-light border-0">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-5 d-grid">
                                <button class="btn btn-primary w-100 fw-bold">Filter & Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
   DAFTAR PRODUK
============================================================ -->
<div class="row" style="z-index:2;">
@forelse($products as $p)
    <div class="col-md-3 mb-4 product-card-anim">
        <div class="card h-100 border-0 shadow-sm hover-top" style="border-radius:12px; overflow:hidden;">

            <div class="position-relative" style="height:220px; background:#f8f9fa;">
                @if($p->image)
                    <img src="{{ asset('storage/'.$p->image) }}" class="w-100 h-100" style="object-fit:cover;">
                @else
                    <div class="d-flex justify-content-center align-items-center h-100 text-muted">No Image</div>
                @endif

                @if($p->category)
                <span class="badge bg-white text-dark position-absolute top-0 start-0 m-3 shadow-sm">
                    {{ $p->category->name }}
                </span>
                @endif
            </div>

            <div class="card-body d-flex flex-column p-4">
                <h5 class="fw-bold text-dark mb-1">{{ Str::limit($p->name, 40) }}</h5>

                <div class="mb-3">
                    <h5 class="text-primary fw-bold">Rp {{ number_format($p->price,0,',','.') }}</h5>
                    @if($p->stock > 0)
                        <small class="text-success"><i class="bi bi-check-circle-fill"></i> Stok Tersedia</small>
                    @else
                        <small class="text-danger"><i class="bi bi-x-circle-fill"></i> Habis</small>
                    @endif
                </div>

                <a href="{{ route('products.show', $p) }}" 
                   class="btn btn-outline-primary rounded-pill w-100 mt-auto fw-bold">
                    Lihat Detail
                </a>
            </div>

        </div>
    </div>

@empty
    <div class="col-12 text-center py-5">
        <div style="font-size:4rem;">😢</div>
        <h4 class="fw-bold">Produk tidak ditemukan</h4>
        <p class="text-muted">Coba kata kunci lain atau reset filter</p>
        <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-pill px-4">Reset Pencarian</a>
    </div>
@endforelse
</div>

<div class="mt-5 d-flex justify-content-center">
    {{ $products->links() }}
</div>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="page-bg">

    <!-- Bintang & Komet -->
    <div class="page-stars" aria-hidden="true"></div>
    <div class="comet" aria-hidden="true"></div>

    <!-- Toggle Mode (pojok kanan atas) -->
    <button id="modeToggle" 
        class="btn btn-light shadow-sm rounded-circle p-2"
        style="z-index:999; width:45px; height:45px; position: fixed; top: 18px; right: 18px;">
        🌙
    </button>

    <div class="container py-5">

<style>
/* ----------------------------
   RESET POINTER / UX FIX
   Pastikan dekorasi TIDAK menangkap pointer.
   Hanya elemen interaktif (a, button, input, select) dapat menerima pointer.
   Ini memperbaiki bug "kursor seperti menyentuh button terus".
   ---------------------------- */
.page-bg, .page-bg * {
    cursor: default !important;
}

/* Biarkan elemen interaktif memiliki cursor pointer */
a, a.btn, button, input, select, .page-bg .form-control {
    cursor: pointer !important;
}

/* ============================================================
   MODE MALAM — LANGIT GELAP + BINTANG
============================================================ */
.page-bg { 
    min-height: 100vh; 
    position: relative; 
    overflow: hidden; 
    background: linear-gradient(180deg,#001b33 0%, #00264d 40%, #003366 100%);
}

/* soft nebula */
.page-bg::before{
    content:''; 
    position:absolute; 
    inset:0; 
    background: 
        radial-gradient(circle at 20% 30%, rgba(255,255,255,0.06), transparent 25%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.03), transparent 25%);
    pointer-events: none;
    z-index: 0;
}

/* BINTANG (tidak menerima pointer) */
.page-stars { position:absolute; inset:0; z-index:1; pointer-events:none; }
.page-stars .star { 
    position:absolute;
    width:3px; 
    height:3px; 
    border-radius:50%; 
    background: rgba(255,255,255,0.95);
    box-shadow:0 0 8px rgba(255,255,255,0.7);
    pointer-events:none;
}

/* Komet (pointer-events none) */
.comet {
    position: absolute;
    top: -50px;
    left: -200px;
    width: 6px;
    height: 6px;
    background: radial-gradient(circle at 35% 35%, #fff, #ffd27f 60%);
    border-radius: 50%;
    box-shadow: 0 0 16px rgba(255,220,140,0.9);
    opacity: 0;
    transform: rotate(45deg);
    z-index: 5;
    pointer-events: none;
}

/* Komet trail (visual only via box-shadow / blur) */
/* Animasi komet */
@keyframes cometFly {
    0% { opacity: 0; transform: translate(-120px,-120px) scale(0.6) rotate(45deg); }
    6% { opacity: 1; }
    45% { transform: translate(900px,700px) scale(1.1) rotate(45deg); opacity: 1; }
    65% { opacity: 0; }
    100% { transform: translate(1000px,800px) scale(1.1) rotate(45deg); }
}

/* ============================================================
   MODE SIANG — LANGIT CERAH (TANPA AWAN sesuai permintaan)
============================================================ */
body.day-mode .page-bg {
    background: linear-gradient(180deg,#bfe8ff 0%, #e9f7ff 40%, #ffffff 100%);
}
body.day-mode .page-bg::before {
    background: 
        radial-gradient(circle at 20% 30%, rgba(255,255,255,0.5), transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.4), transparent 40%);
}
body.day-mode .page-stars .star { opacity: 0; }
body.day-mode .comet { opacity: 0 !important; }

/* HERO */
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

/* tombol toggle */
#modeToggle { font-size: 20px; z-index:9999; }

/* card hover */
.hover-top {
    transition: transform .3s, box-shadow .3s;
}
.hover-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
}

/* kecilkan outline focus default yang kadang besar di beberapa browser */
button:focus, .btn:focus, a:focus, input:focus {
    outline: 3px solid rgba(13,110,253,0.12);
    outline-offset: 2px;
}
</style>

<!-- ===========================
     SCRIPTS: BINTANG, KOMET, TOGGLE, FIX PAGE=...
     =========================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* --------------------------
       Redirect to page 1 if URL contains ?page=N (N != 1)
       This ensures the listing shows page 1 as you requested.
       -------------------------- */
    try {
        const url = new URL(window.location.href);
        if (url.searchParams.has('page')) {
            const pageVal = url.searchParams.get('page');
            if (pageVal && pageVal !== '1') {
                // remove page param and redirect to same URL without it (this loads page 1)
                url.searchParams.delete('page');
                // use replace so back button isn't polluted
                window.location.replace(url.toString());
                return; // stop further initialization until reload
            }
        }
    } catch (e) {
        // ignore URL errors
    }

    /* --------------------------
       Generate background stars (visual only, pointer-events:none)
       -------------------------- */
    (function generateStars(){
        var wrap = document.querySelector('.page-stars');
        if(!wrap) return;
        var count = 35;
        for (var i=0;i<count;i++){
            var s = document.createElement('span');
            s.className = 'star';
            s.style.left = (Math.random()*100) + '%';
            s.style.top = (Math.random()*100) + '%';
            var size = Math.random()*3 + 1; // 1..4
            s.style.width = size + 'px';
            s.style.height = size + 'px';
            s.style.opacity = (Math.random()*0.9).toFixed(2);
            // ensure not interactive
            s.setAttribute('aria-hidden','true');
            wrap.appendChild(s);
        }
    })();

    /* --------------------------
       Komet: summon periodically
       -------------------------- */
    (function initComet(){
        var c = document.querySelector('.comet');
        if (!c) return;

        function flyOnce(){
            // reset animation
            c.style.animation = 'none';
            void c.offsetWidth;
            // randomize start top (a bit) so path changes
            var topOffset = Math.random()*120 - 60; // -60 .. +60
            c.style.top = (-120 + topOffset) + 'px';
            c.style.left = (-180) + 'px';
            c.style.opacity = 1;
            c.style.animation = 'cometFly 2.6s cubic-bezier(.26,.9,.2,1)';
            // after animation, hide
            setTimeout(function(){ c.style.opacity = 0; }, 2600);
        }

        // first fly after small delay
        setTimeout(function(){ flyOnce(); }, 1500 + Math.random()*1000);

        // repeat with random interval
        function schedule(){
            var delay = 5000 + Math.random()*8000; // 5s..13s
            setTimeout(function(){
                flyOnce();
                schedule();
            }, delay);
        }
        schedule();
    })();

    /* --------------------------
       Toggle Night/Day Mode  (persist to localStorage)
       -------------------------- */
    (function initToggle(){
        const toggleBtn = document.getElementById('modeToggle');
        if (!toggleBtn) return;

        // initialize from storage
        var saved = localStorage.getItem('mode');
        if (saved === 'day') {
            document.body.classList.add('day-mode');
            toggleBtn.innerHTML = '🌚';
            // optional badge text if present
            var mb = document.getElementById('modeBadge'); if(mb) mb.textContent = 'Mode Siang Aktif';
        } else {
            toggleBtn.innerHTML = '🌙';
            var mb = document.getElementById('modeBadge'); if(mb) mb.textContent = 'Mode Malam Aktif';
        }

        toggleBtn.addEventListener('click', function(e){
            e.preventDefault();
            document.body.classList.toggle('day-mode');
            var enabled = document.body.classList.contains('day-mode');
            localStorage.setItem('mode', enabled ? 'day' : 'night');
            toggleBtn.innerHTML = enabled ? '🌚' : '🌙';
            var mb = document.getElementById('modeBadge'); if(mb) mb.textContent = enabled ? 'Mode Siang Aktif' : 'Mode Malam Aktif';
        });
    })();

});
</script>

<!-- ============================================================
   HERO + SEARCHBAR
============================================================ -->
<div class="row justify-content-center mb-5 product-card-anim products-hero position-relative" style="z-index:2;">
    <div class="products-stars" aria-hidden="true" style="pointer-events:none;"></div>

    <div class="col-lg-10 hero-content">
        <div class="text-center mb-4 d-flex align-items-center justify-content-center flex-column flex-sm-row">
            <h2 class="fw-bold text-dark display-6 mb-2 mb-sm-0">🛍️ Temukan Gadget Impianmu</h2>
            <span id="modeBadge" class="badge hero-mode-badge ms-0 ms-sm-3 mt-2 mt-sm-0">Mode Malam Aktif</span>
            <p class="text-muted mt-2 w-100">Jelajahi koleksi elektronik terbaik dengan harga terjangkau</p>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-bold text-muted small">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control bg-light border-0" placeholder="Contoh: iPhone 13, Laptop...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small">Kategori</label>
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" @if(request('category')==$c->id) selected @endif>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 fw-bold h-100">Filter & Cari</button>
                    </div>
                </form>
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
</div>
@endsection

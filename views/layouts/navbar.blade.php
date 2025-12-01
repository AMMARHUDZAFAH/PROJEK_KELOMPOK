<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">🛒 ElectroHub</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/products">📦 Produk</a></li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">👨‍💼 Admin Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">📋 Pesanan Saya</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- Cart Icon for Regular Users --}}
                    @if(Auth::user()->role !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                🛒 Keranjang
                                @php
                                    $cart = Auth::user()->cart;
                                    $cartCount = $cart ? $cart->count() : 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                        <span class="visually-hidden">items in cart</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif

                    {{-- User Dropdown Menu --}}
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        👤 Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        📊 Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.products.index') }}">
                                        🛠️ Kelola Produk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        📦 Kelola Pesanan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        👤 Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        📋 Pesanan Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cart.index') }}">
                                        🛒 Keranjang
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form action="/logout" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        🚪 Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/login">🔐 Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">✍️ Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

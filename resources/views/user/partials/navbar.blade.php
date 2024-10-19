<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <a class="navbar-brand size-navbar name-navbar" href="{{url('/user/home')}}" style="font-size: 1.5rem;">
        <img src="{{ asset('build/assets/images/logo_app.svg') }}" alt="SIUM Logo" class="logo-navbar" style="width: 100px; height: auto;">
    </a>
    <button class="navbar-toggler hamburger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <input class="checkbox" type="checkbox" />
        <svg fill="none" viewBox="0 0 50 50" height="50" width="50">
            <path class="lineTop line" stroke-linecap="round" stroke-width="4" stroke="black" d="M6 11L44 11"></path>
            <path stroke-linecap="round" stroke-width="4" stroke="black" d="M6 24H43" class="lineMid line"></path>
            <path stroke-linecap="round" stroke-width="4" stroke="black" d="M6 37H43" class="lineBottom line"></path>
        </svg>
    </button>
    <div class="collapse navbar-collapse links-navbar" id="navbarNav">
        <ul class="navbar-nav home-nav mx-auto">
            <li class="nav-item buttom-style">
                <a class="nav-link" href="{{ url('/user/home') }}">Inicio</a>
            </li>
            <li class="nav-item buttom-style">
                <a class="nav-link" href="{{ url('/user/apartado')}}">Apartados</a>
            </li>
        </ul>
        <!-- Vista móvil -->
        <ul class="navbar-nav ms-auto d-lg-none">
            <li class="nav-item">
                <a href="{{url ('user/wishlist')}}" class="nav-link text-secondary">
                    <i class="bi bi-heart"></i> Favoritos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url ('user/carrito')}}" class="nav-link text-secondary">
                    <i class="bi bi-cart"></i> Carrito
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="text-secondary nav-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person">{{ Auth::user()->name }}</i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Vista escritorio -->
    <div class="d-flex justify-content-end align-items-center size-navbar icons-navbar d-none d-lg-flex">
        <a href="{{ url('user/wishlist') }}" class="me-2 text-secondary nav-icon">
            <i class="bi bi-heart"></i>
        </a>
        <a href="{{ url('user/carrito') }}" class="me-2 text-secondary nav-icon position-relative">
            <i class="bi bi-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count" style="display: {{ $totalItems > 0 ? 'inline' : 'none' }};">
            {{ $totalItems }}
            </span>
        </a>
        <div class="dropdown">
            <a href="#" class="text-secondary nav-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person">{{ Auth::user()->name }}</i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item custom-dropdown-item" href="{{ url('user/perfil') }}">
                        {{ __('Perfil') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item custom-dropdown-out-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                </li>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>

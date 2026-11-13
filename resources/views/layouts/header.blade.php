<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Buka menu"><i class="fas fa-bars"></i></a></li>
        <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-flex align-items-center mr-3"><span class="text-muted small">{{ auth()->user()->nama ?? auth()->user()->username }}</span></li>
        <li class="nav-item d-flex align-items-center">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-sign-out-alt mr-1"></i> Keluar</button>
            </form>
        </li>
    </ul>
</nav>
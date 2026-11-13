<div class="sidebar">
    @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ auth()->user()->image ?: asset('adminlte/dist/img/avatar.png') }}"
                    alt="Foto profil {{ auth()->user()->nama ?? auth()->user()->username }}"
                    class="img-circle elevation-2"
                    style="width: 34px; height: 34px; object-fit: cover;"
                    onerror="this.onerror=null;this.src='{{ asset('adminlte/dist/img/avatar.png') }}';"
                >
            </div>
            <div class="info">
                <span class="d-block text-white">{{ auth()->user()->nama ?? auth()->user()->username }}</span>
                <small class="text-muted">{{ auth()->user()->level->level_nama ?? 'Pengguna' }}</small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ ($activeMenu ?? '') === 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link {{ ($activeMenu ?? '') === 'profile' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Profile</p>
                    </a>
                </li>

                <li class="nav-header">USER DATA</li>
                <li class="nav-item">
                    <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu ?? '') === 'level' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Level User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu ?? '') === 'user' ? 'active' : '' }}">
                        <i class="nav-icon far fa-user"></i>
                        <p>Data User</p>
                    </a>
                </li>

                <li class="nav-header">ITEM DATA</li>
                <li class="nav-item">
                    <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu ?? '') === 'kategori' ? 'active' : '' }}">
                        <i class="nav-icon far fa-bookmark"></i>
                        <p>Kategori Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu ?? '') === 'barang' ? 'active' : '' }}">
                        <i class="nav-icon far fa-list-alt"></i>
                        <p>Data Barang</p>
                    </a>
                </li>

                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="{{ url('/stok') }}" class="nav-link {{ in_array(($activeMenu ?? ''), ['stok', 'Stok'], true) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Stok Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{ ($activeMenu ?? '') === 'penjualan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Penjualan</p>
                    </a>
                </li>

                <li class="nav-header">AKUN</li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin keluar?')">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-left w-100">
                            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    @else
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>Login</p>
                    </a>
                </li>
            </ul>
        </nav>
    @endauth
</div>

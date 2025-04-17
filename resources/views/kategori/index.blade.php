@extends('layouts.template')


@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                {{-- Filter Dropdown --}}
                <form method="GET" action="{{ url('kategori') }}" class="form-inline">
                    <label class="mr-2 font-weight-bold">Filter:</label>
                    <select name="kategori_nama" class="form-control mr-2" onchange="this.form.submit()">
                        <option value="">- Semua -</option>
                        @foreach ($kategoriDropdown as $item)
                            <option value="{{ $item->kategori_nama }}" {{ request('kategori_nama') == $item->kategori_nama ? 'selected' : '' }}>
                                {{ $item->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div>
                {{-- Search Box --}}
                <form method="GET" action="{{ url('kategori') }}" class="form-inline">
                    <label class="mr-2 font-weight-bold">Search:</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama kategori..." value="{{ request('search') }}" onkeydown="if(event.key==='Enter'){ this.form.submit(); }">
                </form>
            </div>
        </div>        
    <script>
        // Submit form otomatis saat dropdown berubah
        document.querySelector('select[name="kategori_nama"]').addEventListener('change', function () {
            this.form.submit();
        });
    
        // Submit form otomatis saat mengetik di search box (dengan delay)
        let typingTimer;
        const searchInput = document.querySelector('input[name="search"]');
        searchInput.addEventListener('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                this.form.submit();
            }, 500); // 0.5 detik setelah berhenti mengetik
        });
    
        // Optional: Enter langsung submit
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    </script>
    
        
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode kategori</th>
                    <th>Nama kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori->kategori_kode }}</td>
                    <td>{{ $kategori->kategori_nama }}</td>
                    <td>
                        <a href="{{ url('kategori/'.$kategori->kategori_id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ url('kategori/'.$kategori->kategori_id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                        <form class="d-inline-block" method="POST" action="{{ url('kategori/'.$kategori->kategori_id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
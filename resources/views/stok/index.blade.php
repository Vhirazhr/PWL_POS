@extends('layouts.template')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row mb-3">
    <div class="col-md-12">
        <form method="GET" action="{{ url('stok') }}" class="form-inline">
            <label class="mr-2">Filter Kategori:</label>
            <select name="kategori_id" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">- Semua -</option>
                @foreach($kategori as $item)
                    <option value="{{ $item->kategori_id }}" {{ request('kategori_id') == $item->kategori_id ? 'selected' : '' }}>
                        {{ $item->kategori_nama }}
                    </option>
                @endforeach
            </select>
            <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
        </form>
    </div>
</div>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stok as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->stock_tanggal)->format('d-m-Y H:i') }}</td>
                        <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                        <td>{{ $item->stock_jumlah }}</td>
                        <td>
                            <a href="{{ url('stok/' . $item->stock_id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ url('stok/' . $item->stock_id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ url('stok/' . $item->stock_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Data tidak tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>

    <div class="card-body">
        @if (!$stok)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Data stok tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $stok->stock_id }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $stok->stock_tanggal }}</td>
                </tr>
                <tr>
                    <th>Barang</th>
                    <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $stok->barang->kategori->kategori_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $stok->stock_jumlah }}</td>
                </tr>
                <tr>
                    <th>User Input</th>
                    <td>{{ $stok->user->username ?? '-' }}</td>
                </tr>
            </table>
        @endif

        <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

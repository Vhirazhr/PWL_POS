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

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Pembeli</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->penjualan_tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->penjualan_kode }}</td>
                        <td>{{ $item->pembeli }}</td>
                        <td>
                            <a href="{{ url('penjualan/' . $item->penjualan_id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ url('penjualan/' . $item->penjualan_id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ url('penjualan/' . $item->penjualan_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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

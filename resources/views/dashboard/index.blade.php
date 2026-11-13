@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalBarang) }}</h3>
                    <p>Barang Terdaftar</p>
                </div>
                <div class="icon"><i class="fas fa-boxes"></i></div>
                <a href="{{ route('barang.index') }}" class="small-box-footer">Lihat barang <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalStok) }}</h3>
                    <p>Total Stok Barang</p>
                </div>
                <div class="icon"><i class="fas fa-cubes"></i></div>
                <a href="{{ route('stok.index') }}" class="small-box-footer">Kelola stok <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($jumlahTransaksiBulanIni) }}</h3>
                    <p>Transaksi Bulan Ini</p>
                </div>
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                <a href="{{ route('penjualan.index') }}" class="small-box-footer">Lihat transaksi <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 style="font-size: 1.55rem;">Rp{{ number_format($omzetBulanIni, 0, ',', '.') }}</h3>
                    <p>Omzet Bulan Ini</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
                <a href="{{ route('penjualan.index') }}" class="small-box-footer">Lihat penjualan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Transaksi Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-tool">Lihat semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Pembeli</th>
                                    <th>Kasir</th>
                                    <th>Tanggal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td>
                                            <a href="{{ route('penjualan.show', $transaksi->penjualan_id) }}">
                                                {{ $transaksi->penjualan_kode }}
                                            </a>
                                        </td>
                                        <td>{{ $transaksi->pembeli }}</td>
                                        <td>{{ $transaksi->user->nama ?? $transaksi->user->username ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->penjualan_tanggal)->format('d/m/Y') }}</td>
                                        <td class="text-right">
                                            Rp{{ number_format($transaksi->details->sum(fn ($detail) => $detail->harga * $detail->jumlah), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada transaksi penjualan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary float-right">
                        <i class="fas fa-plus mr-1"></i> Buat Penjualan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Data</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Kategori Barang
                            <span class="badge badge-primary badge-pill">{{ number_format($totalKategori) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Pengguna
                            <span class="badge badge-primary badge-pill">{{ number_format($totalUser) }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary btn-sm btn-block mb-2">Kelola Kategori</a>
                    <a href="{{ url('/user') }}" class="btn btn-outline-secondary btn-sm btn-block">Kelola Pengguna</a>
                </div>
            </div>

            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Akses Cepat</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('barang.index') }}" class="btn btn-light btn-block text-left mb-2">
                        <i class="fas fa-box mr-2 text-info"></i> Data Barang
                    </a>
                    <a href="{{ route('stok.index') }}" class="btn btn-light btn-block text-left mb-2">
                        <i class="fas fa-cubes mr-2 text-success"></i> Stok Barang
                    </a>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-light btn-block text-left">
                        <i class="fas fa-receipt mr-2 text-warning"></i> Riwayat Penjualan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

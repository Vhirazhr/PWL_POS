@extends('layouts.template')

@section('content')
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>

    <div class="card-body">
        <h5>Informasi Umum</h5>
        <table class="table table-borderless">
            <tr>
                <th>Kode Penjualan</th>
                <td>: {{ $penjualan->penjualan_kode }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>: {{ $penjualan->penjualan_tanggal }}</td>
            </tr>
            <tr>
                <th>User Input</th>
                <td>: {{ $penjualan->user->username }}</td>
            </tr>
            <tr>
                <th>Nama Pembeli</th>
                <td>: {{ $penjualan->pembeli }}</td>
            </tr>
        </table>

        <hr>

        <h5>Rincian Barang</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($penjualan->details as $detail)
                @php
                    $subtotal = $detail->harga * $detail->jumlah;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detail->barang->barang_nama }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->harga) }}</td>
                    <td>{{ number_format($subtotal) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th>{{ number_format($total) }}</th>
                </tr>
            </tbody>
        </table>

        <a href="{{ url('penjualan') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
</div>
@endsection

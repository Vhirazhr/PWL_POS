@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    
    <div class="card-body">
        @empty($stok)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Data stok tidak ditemukan.
            </div>
            <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/stok/'.$stok->stock_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                {{-- Barang --}}
                <div class="form-group row">
                    <label class="col-2 col-form-label">Barang</label>
                    <div class="col-10">
                        <select name="barang_id" class="form-control" required>
                            @foreach($barang as $item)
                                <option value="{{ $item->barang_id }}" {{ $item->barang_id == $stok->barang_id ? 'selected' : '' }}>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="form-group row">
                    <label class="col-2 col-form-label">Jumlah</label>
                    <div class="col-10">
                        <input type="number" name="stock_jumlah" class="form-control" required value="{{ old('stock_jumlah', $stok->stock_jumlah) }}">
                        @error('stock_jumlah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="form-group row">
                    <label class="col-2 col-form-label">Tanggal</label>
                    <div class="col-10">
                        <input type="datetime-local" name="stock_tanggal" class="form-control" required value="{{ old('stock_tanggal', \Carbon\Carbon::parse($stok->stock_tanggal)->format('Y-m-d\TH:i')) }}">
                        @error('stock_tanggal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="form-group row">
                    <div class="col-10 offset-2">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{ url('stok') }}" class="btn btn-default btn-sm ml-1">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

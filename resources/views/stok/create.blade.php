@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>

    
    <div class="card-body">
        <form method="POST" action="{{ url('stok') }}" class="form-horizontal">
            @csrf

            {{-- Barang --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Barang</label>
                <div class="col-10">
                    <select name="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
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
                    <input type="number" name="stock_jumlah" class="form-control" required value="{{ old('stock_jumlah') }}">
                    @error('stock_jumlah')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Tanggal</label>
                <div class="col-10">
                    <input type="datetime-local" name="stock_tanggal" class="form-control" required value="{{ old('stock_tanggal') }}">
                    @error('stock_tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- User Input --}}
<div class="form-group row">
    <label class="col-2 col-form-label">User</label>
    <div class="col-10">
        <select name="user_id" class="form-control" required>
            <option value="">- Pilih User -</option>
            @foreach($user as $u)
                <option value="{{ $u->user_id }}">{{ $u->username }}</option>
            @endforeach
        </select>
        @error('user_id')
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
    </div>
</div>
@endsection

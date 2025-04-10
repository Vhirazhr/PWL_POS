@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ url('kategori') }}" class="form-horizontal">
            @csrf

            {{-- KATEGORI KODE --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Kode Kategori</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="kategori_kode" value="{{ old('kategori_kode') }}" required>
                    @error('kategori_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- KATEGORI NAMA --}}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Kategori</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="kategori_nama" value="{{ old('kategori_nama') }}" required>
                    @error('kategori_nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ route('barang.export_excel') }}" class="btn btn-sm btn-primary mt-1">
    <i class="fa fa-file-excel"></i> Export Barang</a>
            <button onclick="modalAction('{{ url('barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            <button onclick="modalAction('{{ route('barang.import') }}')" class="btn btn-sm btn-info mt-1"><i class="fa fa-file-import"></i> Import</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Filter Kategori --}}
        <form method="GET" action="{{ url('barang') }}">
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Filter:</label>
                <div class="col-3">
                    <select class="form-control" name="kategori_id" onchange="this.form.submit()">
                        <option value="">- Semua -</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->kategori_id }}" {{ request('kategori_id') == $item->kategori_id ? 'selected' : '' }}>
                                {{ $item->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- Tabel DataTables --}}
        <table id="barang-table" class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}

$(document).ready(function() {
    $('#barang-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/barang/list') }}",
            data: function (d) {
                d.kategori_id = $('select[name=kategori_id]').val(); // kirim filter
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'barang_kode', name: 'barang_kode' },
            { data: 'barang_nama', name: 'barang_nama' },
            { data: 'kategori.kategori_nama', name: 'kategori.kategori_nama' },
            { data: 'harga_beli', name: 'harga_beli' },
            { data: 'harga_jual', name: 'harga_jual' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reload DataTables saat filter diubah
    $('select[name=kategori_id]').on('change', function () {
        $('#barang-table').DataTable().ajax.reload();
    });
});
</script>
@endpush

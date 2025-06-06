@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
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
        <form method="GET" action="{{ url('stok') }}">
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

        {{-- DataTables --}}
        <table id="stok-table" class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
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

$(document).ready(function () {
    $('#stok-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/stok/list') }}",
            data: function (d) {
                d.kategori_id = $('select[name=kategori_id]').val(); // Kirim filter ke server
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'stock_tanggal', name: 'stock_tanggal' },
            { data: 'barang.barang_nama', name: 'barang.barang_nama' },
            { data: 'stock_jumlah', name: 'stock_jumlah' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reload DataTables saat filter diubah
    $('select[name=kategori_id]').on('change', function () {
        $('#stok-table').DataTable().ajax.reload();
    });
});
</script>
@endpush

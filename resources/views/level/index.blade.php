@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('level/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table id="level-table" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Aksi</th>
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
    $('#level-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/level/list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'level_kode', name: 'level_kode' },
            { data: 'level_nama', name: 'level_nama' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush

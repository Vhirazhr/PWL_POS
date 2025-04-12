@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>

    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ url('penjualan') }}">
            @csrf

            {{-- Username / User Input --}}
<div class="form-group row">
    <label class="col-2 col-form-label">User Input</label>
    <div class="col-10">
        <select name="user_id" class="form-control" required>
            <option value="">-- Pilih User --</option>
            @foreach ($users as $u)
            <option value="{{ $u->user_id }}">{{ $u->username }}</option>
            @endforeach
        </select>
    </div>
</div>

            {{-- Nama Pembeli --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Nama Pembeli</label>
                <div class="col-10">
                    <input type="text" name="pembeli" class="form-control" value="{{ old('pembeli') }}" required>
                </div>
            </div>

            {{-- Kode Penjualan --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Kode Penjualan</label>
                <div class="col-10">
                    <input type="text" name="penjualan_kode" class="form-control" value="{{ old('penjualan_kode') }}" required>
                </div>
            </div>

            {{-- Tanggal Penjualan --}}
            <div class="form-group row">
                <label class="col-2 col-form-label">Tanggal Penjualan</label>
                <div class="col-10">
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control" value="{{ old('penjualan_tanggal') ?? now()->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>

            <hr>

            {{-- Detail Penjualan --}}
            <h5>Detail Barang</h5>
            <table class="table table-bordered" id="detail-barang">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>
                            <button type="button" class="btn btn-success btn-sm" id="btn-tambah-barang">Tambah</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="barang-row">
                        <td>
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $b)
                                <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                    {{ $b->barang_nama }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="harga[]" class="form-control harga-input" readonly required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus-barang">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                <a href="{{ url('penjualan') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailTable = document.querySelector('#detail-barang tbody');
        const btnTambah = document.querySelector('#btn-tambah-barang');

        // Tambah baris
        btnTambah.addEventListener('click', () => {
            const row = detailTable.querySelector('.barang-row').cloneNode(true);

            // Reset value semua input & select
            row.querySelectorAll('select, input').forEach(el => {
                el.value = '';
            });

            detailTable.appendChild(row);
        });

        // Hapus baris
        detailTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-hapus-barang')) {
                const rows = detailTable.querySelectorAll('.barang-row');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                } else {
                    alert('Minimal 1 barang harus ada!');
                }
            }
        });

        // Auto isi harga dari data-harga
        detailTable.addEventListener('change', function (e) {
            if (e.target.classList.contains('barang-select')) {
                const selected = e.target.options[e.target.selectedIndex];
                const harga = selected.getAttribute('data-harga') || '';
                const hargaInput = e.target.closest('tr').querySelector('.harga-input');
                hargaInput.value = harga;
            }
        });
    });
</script>
@endpush

@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">Edit Struk Penjualan</div>
        <div class="card-body">
            <form action="{{ route('penjualan.update', $penjualan->penjualan_id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Penjualan --}}
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" class="form-control" value="{{ $penjualan->penjualan_kode }}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($penjualan->penjualan_tanggal)) }}" required>
                </div>
                <div class="form-group">
                    <label>User Input</label>
                    <select name="user_id" class="form-control" required>
                        @foreach ($users as $u)
                            <option value="{{ $u->user_id }}" {{ $u->user_id == $penjualan->user_id ? 'selected' : '' }}>
                                {{ $u->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" value="{{ $penjualan->pembeli }}" required>
                </div>

                <hr>

                {{-- Detail Barang --}}
                <h5>Detail Barang</h5>
                <table class="table table-bordered" id="detail-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->details as $index => $detail)
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-control barang-select" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($barang as $b)
                                            <option 
                                                value="{{ $b->barang_id }}" 
                                                data-harga="{{ $b->harga_jual }}"
                                                {{ $b->barang_id == $detail->barang_id ? 'selected' : '' }}>
                                                {{ $b->barang_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control" value="{{ $detail->jumlah }}" required>
                                </td>
                                <td>
                                    <input type="number" name="harga[]" class="form-control harga-input" value="{{ $detail->harga }}" readonly required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                </td>
                                <input type="hidden" name="detail_id[]" value="{{ $detail->detail_id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" id="add-row" class="btn btn-success btn-sm mb-3">+ Tambah Barang</button>

                <br>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    {{-- Script Tambah/Hapus + Harga Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Harga Otomatis
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('barang-select')) {
                    const selected = e.target.options[e.target.selectedIndex];
                    const harga = selected.getAttribute('data-harga');
                    const hargaInput = e.target.closest('tr').querySelector('.harga-input');
                    if (hargaInput) {
                        hargaInput.value = harga;
                    }
                }
            });

            // Tambah Baris
            document.getElementById('add-row').addEventListener('click', function () {
                const tableBody = document.querySelector('#detail-table tbody');
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td>
                        <select name="barang_id[]" class="form-control barang-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control" required></td>
                    <td><input type="number" name="harga[]" class="form-control harga-input" readonly required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                `;

                tableBody.appendChild(newRow);
            });

            // Hapus Baris
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                }
            });
        });
    </script>
@endsection

@empty($barang)
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                    Data barang tidak ditemukan.
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit-barang">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- Kategori --}}
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select class="form-control" name="kategori_id" id="kategori_id" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->kategori_id }}" {{ $item->kategori_id == $barang->kategori_id ? 'selected' : '' }}>
                                    {{ $item->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-kategori_id" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Kode Barang --}}
                    <div class="form-group">
                        <label for="barang_kode">Kode Barang</label>
                        <input type="text" name="barang_kode" id="barang_kode" class="form-control" value="{{ $barang->barang_kode }}" required>
                        <small id="error-barang_kode" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Nama Barang --}}
                    <div class="form-group">
                        <label for="barang_nama">Nama Barang</label>
                        <input type="text" name="barang_nama" id="barang_nama" class="form-control" value="{{ $barang->barang_nama }}" required>
                        <small id="error-barang_nama" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Harga Beli --}}
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="{{ $barang->harga_beli }}" required>
                        <small id="error-harga_beli" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Harga Jual --}}
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="{{ $barang->harga_jual }}" required>
                        <small id="error-harga_jual" class="form-text text-danger error-text"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-edit-barang").validate({
                rules: {
                    kategori_id: { required: true },
                    barang_kode: { required: true, minlength: 2, maxlength: 20 },
                    barang_nama: { required: true, minlength: 2, maxlength: 50 },
                    harga_beli: { required: true, number: true, min: 0 },
                    harga_jual: { required: true, number: true, min: 0 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#barang-table').DataTable().ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty

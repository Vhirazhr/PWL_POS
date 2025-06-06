@empty($kategori)
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
                    Data kategori tidak ditemukan.
                </div>
                <a href="{{ url('/kategori') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kategori/' . $kategori->kategori_id . '/update_ajax') }}" method="POST" id="form-edit-kategori">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- Kategori Kode --}}
                    <div class="form-group">
                        <label for="kategori_kode">Kode Kategori</label>
                        <input type="text" name="kategori_kode" id="kategori_kode" class="form-control"
                               value="{{ $kategori->kategori_kode }}" required>
                        <small id="error-kategori_kode" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Kategori Nama --}}
                    <div class="form-group">
                        <label for="kategori_nama">Nama Kategori</label>
                        <input type="text" name="kategori_nama" id="kategori_nama" class="form-control"
                               value="{{ $kategori->kategori_nama }}" required>
                        <small id="error-kategori_nama" class="form-text text-danger error-text"></small>
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
            $("#form-edit-kategori").validate({
                rules: {
                    kategori_kode: { required: true, minlength: 2, maxlength: 20 },
                    kategori_nama: { required: true, minlength: 2, maxlength: 50 }
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
                                $('#kategori-table').DataTable().ajax.reload();
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

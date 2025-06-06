<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah-penjualan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- USER --}}
                <div class="form-group">
                    <label for="user_id">User Input</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->user_id }}">{{ $u->username }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="form-text text-danger error-text"></small>
                </div>

                {{-- PEMBELI --}}
                <div class="form-group">
                    <label for="pembeli">Nama Pembeli</label>
                    <input type="text" class="form-control" name="pembeli" id="pembeli" required>
                    <small id="error-pembeli" class="form-text text-danger error-text"></small>
                </div>

                {{-- KODE --}}
                <div class="form-group">
                    <label for="penjualan_kode">Kode Penjualan</label>
                    <input type="text" class="form-control" name="penjualan_kode" id="penjualan_kode" required>
                    <small id="error-penjualan_kode" class="form-text text-danger error-text"></small>
                </div>

                {{-- TANGGAL --}}
                <div class="form-group">
                    <label for="penjualan_tanggal">Tanggal Penjualan</label>
                    <input type="datetime-local" class="form-control" name="penjualan_tanggal" id="penjualan_tanggal" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    <small id="error-penjualan_tanggal" class="form-text text-danger error-text"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah-penjualan").validate({
            rules: {
                user_id: { required: true },
                pembeli: { required: true, minlength: 2 },
                penjualan_kode: { required: true, minlength: 2 },
                penjualan_tanggal: { required: true }
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
                            $('#penjualan-table').DataTable().ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
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

<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah-stok">
    @csrf
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Barang --}}
                <div class="form-group">
                    <label for="barang_id">Barang</label>
                    <select class="form-control" name="barang_id" id="barang_id" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="form-text text-danger error-text"></small>
                </div>

                {{-- Jumlah --}}
                <div class="form-group">
                    <label for="stock_jumlah">Jumlah</label>
                    <input type="number" class="form-control" name="stock_jumlah" id="stock_jumlah" required>
                    <small id="error-stock_jumlah" class="form-text text-danger error-text"></small>
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label for="stock_tanggal">Tanggal</label>
                    <input type="datetime-local" class="form-control" name="stock_tanggal" id="stock_tanggal" required>
                    <small id="error-stock_tanggal" class="form-text text-danger error-text"></small>
                </div>

                {{-- User --}}
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select class="form-control" name="user_id" id="user_id" required>
                        <option value="">- Pilih User -</option>
                        @foreach($user as $u)
                            <option value="{{ $u->user_id }}">{{ $u->username }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="form-text text-danger error-text"></small>
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
        $("#form-tambah-stok").validate({
            rules: {
                barang_id: { required: true },
                stock_jumlah: { required: true, number: true, min: 0 },
                stock_tanggal: { required: true },
                user_id: { required: true }
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
                            $('#stok-table').DataTable().ajax.reload();
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

@empty($stok)
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
                    Data stok tidak ditemukan.
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stock_id . '/update_ajax') }}" method="POST" id="form-edit-stok">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Stok</h5>
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
                                <option value="{{ $item->barang_id }}" {{ $item->barang_id == $stok->barang_id ? 'selected' : '' }}>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-barang_id" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Jumlah --}}
                    <div class="form-group">
                        <label for="stock_jumlah">Jumlah</label>
                        <input type="number" name="stock_jumlah" id="stock_jumlah" class="form-control" value="{{ $stok->stock_jumlah }}" required>
                        <small id="error-stock_jumlah" class="form-text text-danger error-text"></small>
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">
                        <label for="stock_tanggal">Tanggal</label>
                        <input type="datetime-local" name="stock_tanggal" id="stock_tanggal" class="form-control"
                            value="{{ \Carbon\Carbon::parse($stok->stock_tanggal)->format('Y-m-d\TH:i') }}" required>
                        <small id="error-stock_tanggal" class="form-text text-danger error-text"></small>
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
            $("#form-edit-stok").validate({
                rules: {
                    barang_id: { required: true },
                    stock_jumlah: { required: true, number: true, min: 0 },
                    stock_tanggal: { required: true }
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

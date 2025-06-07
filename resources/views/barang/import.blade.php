<form action="{{ url('/barang/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template Excel</label><br>
                    <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-success btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>

                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <input type="file" name="file_barang" class="form-control" required>
                    <small class="text-danger error-text" id="error-file_barang"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>

<script>
$(function () {
    $('#form-import').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Sukses', res.message, 'success');
                    $('#barang-table').DataTable().ajax.reload();
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                    $('.error-text').text('');
                    if (res.msgField) {
                        $.each(res.msgField, function (key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    }
                }
            }
        });
    });
});
</script>

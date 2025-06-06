<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            @if (empty($stok))
                <div class="modal-header">
                    <h5 class="modal-title">Kesalahan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            @else
                <div class="modal-header">
                    <h5 class="modal-title">Detail Stok</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <tr>
                            <th class="text-right col-4">ID</th>
                            <td>{{ $stok->stock_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Tanggal</th>
                            <td>{{ $stok->stock_tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Barang</th>
                            <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Kategori</th>
                            <td>{{ $stok->barang->kategori->kategori_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Jumlah</th>
                            <td>{{ $stok->stock_jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">User Input</th>
                            <td>{{ $stok->user->username ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#modal-detail').modal('show');

        $('#modal-detail').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    });
</script>

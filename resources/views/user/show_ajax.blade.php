<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @empty($user)
                <div class="modal-header">
                    <h5 class="modal-title">Kesalahan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                </div>
            @else
                <div class="modal-header">
                    <h5 class="modal-title">Detail User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">ID User</th>
                            <td class="col-9">{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level Pengguna</th>
                            <td class="col-9">{{ $user->level->level_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Username</th>
                            <td class="col-9">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama</th>
                            <td class="col-9">{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Password</th>
                            <td class="col-9">********</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
                </div>
            @endempty
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="{{ route('/user') }}">Kembali</a>
    <form method="post" action="{{ route('/user/ubah_simpan', $data->user_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Username</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="username" value="{{ $data->username }}">
        <br><br>

        <label>Nama</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="nama" value="{{ $data->nama }}">
        <br><br>

        <label>Level ID</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="number" name="level_id" value="{{ $data->level_id }}">
        <br><br>

        <input type="submit" name="btn btn-success" value="Ubah">
    </form>
</body>
</html>

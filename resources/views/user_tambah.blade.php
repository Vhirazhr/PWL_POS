<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <a href="{{route('/user')}}">Kembali</a>
    
    <form method="post" action="{{ route('/user/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>Username</label>
        <br>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>

        <label>Nama</label>
        <br>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>

        <label>Password</label>
        <br>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>

        <label>Level ID</label>
        <br>
        <input type="number" name="level_id">
        <br>

        <input type="submit" name="btn btn-success" value="Simpan">
    </form>
</body>



</html>

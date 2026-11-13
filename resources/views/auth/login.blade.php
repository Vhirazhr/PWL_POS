<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | PWL POS</title>
    <style>
        :root {font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:#17243a;background:#f7f9fc}
        *{box-sizing:border-box}body{margin:0;min-height:100vh}
        .shell{display:grid;grid-template-columns:minmax(280px,1fr) minmax(340px,1fr);min-height:100vh}
        .brand{background:#17243a;color:#fff;padding:clamp(32px,5vw,84px);display:flex;flex-direction:column;justify-content:space-between}
        .mark{font-weight:800;letter-spacing:.08em;font-size:24px}
        .brand h1{font-size:clamp(32px,4vw,58px);line-height:1.13;margin:0 0 18px}
        .brand p{color:#ccd7e5;line-height:1.75;max-width:480px}
        .brand footer{color:#96a8c0;font-size:13px}
        .content{display:grid;place-items:center;padding:32px}
        .panel{width:100%;max-width:425px}
        .eyebrow{font-weight:700;color:#059669;font-size:12px;letter-spacing:.13em;text-transform:uppercase}
        h2{font-size:32px;letter-spacing:-.04em;margin:12px 0 8px}
        .hint{color:#64748b;line-height:1.6;margin-bottom:32px}
        label{display:block;font-size:13px;font-weight:700;margin:18px 0 8px}
        input[type=text],input[type=password]{width:100%;min-height:48px;border:1px solid #dce2ea;border-radius:10px;background:white;padding:12px 14px;font:inherit;outline-offset:3px}
        input:focus{border-color:#10b981;outline:2px solid #a7f3d0}
        .check{display:flex;align-items:center;gap:9px;margin:20px 0;color:#475569;font-size:13px}
        .check label{margin:0;font-weight:500}
        button{width:100%;border:0;border-radius:10px;min-height:48px;background:#059669;color:white;font-size:15px;font-weight:700;cursor:pointer}
        button:hover{background:#047857}
        .error{border:1px solid #fecaca;background:#fef2f2;padding:12px;border-radius:10px;color:#b91c1c;font-size:13px}
        .field-error{color:#b91c1c;font-size:12px;margin-top:5px}
        @media(max-width:760px){.shell{grid-template-columns:1fr}.brand{padding:26px;min-height:180px}.brand h1{font-size:28px}.brand footer{display:none}.content{padding:35px 24px}}
    </style>
</head>
<body>
    <main class="shell">
        <section class="brand" aria-label="Tentang PWL POS">
            <div class="mark">PWL POS</div>
            <div><h1>Kelola operasional bisnis dengan lebih teratur.</h1><p>Masuk untuk mengelola barang, kategori, stok, pengguna, dan transaksi penjualan pada sistem PWL POS.</p></div>
            <footer>Point of Sale &amp; Inventory Management</footer>
        </section>
        <section class="content">
            <div class="panel">
                <div class="eyebrow">Akses pengguna</div>
                <h2>Masuk ke PWL POS</h2>
                <p class="hint">Gunakan akun yang sudah terdaftar pada sistem untuk melanjutkan.</p>
                @if ($errors->any())
                    <div class="error" role="alert">Login gagal. Periksa username dan password.</div>
                @endif
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" required autocomplete="username" value="{{ old('username') }}" autofocus>
                    @error('username') <div class="field-error">{{ $message }}</div> @enderror
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password">
                    @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    <div class="check"><input type="checkbox" id="remember" name="remember" value="1"><label for="remember">Ingat saya</label></div>
                    <button type="submit">Masuk</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>

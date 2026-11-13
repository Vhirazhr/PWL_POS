<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        /* Background Image */
        body {
            background-image: url("{{ asset('background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            position: relative;
        }
        
        /* Overlay untuk meningkatkan keterbacaan */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        /* Login Box */
        .login-box {
            width: 360px;
            margin-top: 5vh;
        }
        
        .login-logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .login-card {
            border-radius: 10px;
            background: rgba(255,255,255,0.9);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .btn-login {
            background: #4e73df;
            border: none;
            padding: 10px;
            font-weight: 600;
        }
        
        .btn-login:hover {
            background: #2e59d9;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>PWL</b>POS
        </div>
        
        <div class="card login-card">
            <div class="card-body login-card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
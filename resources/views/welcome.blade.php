<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PWL POS membantu mengelola transaksi penjualan, data barang, kategori, dan persediaan toko dalam satu sistem yang praktis.">
    <meta name="theme-color" content="#f7f9fc">
    <title>PWL POS | Sistem Kasir dan Manajemen Toko</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #17243b;
            --muted: #68758b;
            --blue: #315ee8;
            --blue-dark: #2348c6;
            --mint: #dff7ee;
            --line: #e8edf5;
            --surface: #ffffff;
            --page: #f7f9fc;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: var(--page);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button, a { -webkit-tap-highlight-color: transparent; }
        .site-shell { overflow: hidden; }
        .container { width: min(1160px, calc(100% - 48px)); margin: 0 auto; }
        .topbar {
            height: 82px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(225,232,243,.8);
            background: rgba(255,255,255,.78);
        }
        .nav { display: flex; align-items: center; justify-content: space-between; gap: 28px; }
        .brand { display: inline-flex; align-items: center; gap: 12px; min-width: 190px; }
        .brand-mark {
            width: 42px; height: 42px; display: grid; place-items: center;
            color: #fff; border-radius: 13px;
            background: linear-gradient(145deg, #426df4, #244bc8);
            box-shadow: 0 8px 18px rgba(49,94,232,.24);
        }
        .brand-name { display: block; font: 800 18px/1 'Manrope', sans-serif; letter-spacing: -.7px; }
        .brand-caption { display: block; margin-top: 5px; color: #8792a5; font-size: 10px; letter-spacing: 1.25px; font-weight: 700; }
        .nav-links { display: flex; align-items: center; gap: 34px; color: #647188; font-size: 13px; font-weight: 600; }
        .nav-links a:hover { color: var(--blue); }
        .nav-actions { display: flex; align-items: center; gap: 18px; }
        .login-link { color: #34425a; font-size: 13px; font-weight: 700; }
        .button {
            display: inline-flex; align-items: center; justify-content: center; gap: 9px;
            min-height: 48px; padding: 0 20px; border-radius: 12px;
            font-size: 13px; font-weight: 700; transition: .2s ease;
        }
        .button-primary { color: white; background: var(--blue); box-shadow: 0 9px 20px rgba(49,94,232,.2); }
        .button-primary:hover { color: white; background: var(--blue-dark); transform: translateY(-2px); box-shadow: 0 12px 24px rgba(49,94,232,.25); }
        .button-secondary { color: #34425a; background: #fff; border: 1px solid #e3e9f3; }
        .button-secondary:hover { border-color: #b9c9fa; color: var(--blue); }
        .hero { position: relative; padding: 76px 0 88px; }
        .hero::before {
            content: ''; position: absolute; width: 660px; height: 660px; border-radius: 50%;
            right: -310px; top: -230px; pointer-events: none;
            background: radial-gradient(circle, rgba(87,129,255,.11), rgba(87,129,255,0) 68%);
        }
        .hero-grid { display: grid; grid-template-columns: .92fr 1.08fr; align-items: center; gap: 58px; position: relative; }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 9px; padding: 8px 12px;
            color: #3157c8; border: 1px solid #dce6ff; border-radius: 30px;
            background: #eef3ff; font-size: 10px; font-weight: 800; letter-spacing: 1.1px;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #4772ef; box-shadow: 0 0 0 4px #dce6ff; }
        h1, h2, h3, p { margin-top: 0; }
        .hero h1 { margin: 23px 0 19px; max-width: 540px; font: 800 clamp(38px, 4.5vw, 58px)/1.12 'Manrope', sans-serif; letter-spacing: -2.8px; }
        .hero h1 span { color: var(--blue); }
        .hero-copy { max-width: 480px; color: var(--muted); font-size: 15px; line-height: 1.85; }
        .hero-buttons { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 29px; }
        .hero-note { display: flex; align-items: center; gap: 9px; margin-top: 27px; color: #8792a5; font-size: 11px; }
        .hero-note svg { color: #1b9a70; }
        .preview-wrap { position: relative; padding: 17px; border: 1px solid #e6ebf4; border-radius: 24px; background: rgba(255,255,255,.72); box-shadow: 0 30px 70px rgba(30,49,91,.11); transform: perspective(1200px) rotateY(-4deg) rotateX(2deg); }
        .preview-label { position: absolute; top: -13px; right: 26px; padding: 7px 11px; color: #71809a; border: 1px solid #e5eaf3; border-radius: 20px; background: white; font-size: 9px; font-weight: 800; letter-spacing: .9px; }
        .preview { overflow: hidden; border: 1px solid #e9edf4; border-radius: 15px; background: #f8faff; }
        .preview-top { height: 47px; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; background: #fff; border-bottom: 1px solid #edf0f5; }
        .preview-brand { display: flex; align-items: center; gap: 8px; font: 800 11px 'Manrope', sans-serif; }
        .mini-mark { width: 22px; height: 22px; display: grid; place-items: center; color: white; background: var(--blue); border-radius: 7px; }
        .preview-user { display: flex; align-items: center; gap: 7px; color: #8792a5; font-size: 9px; }
        .avatar { width: 23px; height: 23px; display: grid; place-items: center; color: #385bd0; background: #e9efff; border-radius: 50%; font-size: 9px; font-weight: 800; }
        .preview-body { display: grid; grid-template-columns: 116px 1fr; min-height: 355px; }
        .preview-side { padding: 19px 11px; background: #182642; color: #aab6cc; }
        .side-label { margin: 0 0 12px 7px; color: #7585a1; font-size: 7px; font-weight: 800; letter-spacing: 1px; }
        .side-item { display: flex; align-items: center; gap: 8px; padding: 9px 8px; margin-bottom: 4px; border-radius: 7px; font-size: 8px; }
        .side-item.active { color: white; background: #315ee8; }
        .side-item svg { width: 12px; height: 12px; }
        .preview-main { padding: 18px 17px; }
        .preview-heading { display: flex; justify-content: space-between; align-items: center; margin-bottom: 13px; }
        .preview-heading strong { font: 800 13px 'Manrope', sans-serif; }
        .preview-date { color: #8792a5; font-size: 8px; }
        .metric-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; }
        .metric { padding: 11px 10px; border: 1px solid #edf0f5; border-radius: 9px; background: #fff; }
        .metric span { display: block; color: #8b96a8; font-size: 7px; }
        .metric strong { display: block; margin-top: 6px; font: 800 14px 'Manrope', sans-serif; letter-spacing: -.4px; }
        .metric small { display: block; margin-top: 4px; color: #15966b; font-size: 7px; }
        .preview-lower { display: grid; grid-template-columns: 1.25fr .75fr; gap: 8px; margin-top: 9px; }
        .chart-card, .stock-card { padding: 12px; border: 1px solid #edf0f5; border-radius: 9px; background: #fff; }
        .card-title { display: flex; justify-content: space-between; color: #526079; font-size: 8px; font-weight: 700; }
        .chart-bars { height: 91px; display: flex; align-items: end; justify-content: space-around; gap: 8px; padding-top: 13px; border-bottom: 1px solid #edf0f5; }
        .bar { width: 13px; border-radius: 4px 4px 0 0; background: #b8c9ff; }
        .bar:nth-child(2n) { background: #5278f0; }
        .chart-days { display: flex; justify-content: space-around; margin-top: 6px; color: #a1aabb; font-size: 7px; }
        .stock-row { display: flex; align-items: center; justify-content: space-between; gap: 4px; margin-top: 13px; color: #647188; font-size: 7px; }
        .stock-pill { padding: 4px 6px; border-radius: 5px; color: #b56a16; background: #fff2dd; font-weight: 700; white-space: nowrap; }
        .preview-foot { display: flex; align-items: center; gap: 6px; margin-top: 10px; color: #9aa4b4; font-size: 8px; }
        .preview-foot i { width: 5px; height: 5px; border-radius: 50%; background: #e9a23b; }
        .section { padding: 86px 0; }
        .section-white { background: #fff; }
        .section-heading { max-width: 620px; margin: 0 auto 42px; text-align: center; }
        .section-kicker { margin-bottom: 12px; color: var(--blue); font-size: 10px; font-weight: 800; letter-spacing: 1.4px; }
        .section-heading h2 { margin-bottom: 13px; font: 800 clamp(27px, 3vw, 38px)/1.2 'Manrope', sans-serif; letter-spacing: -1.3px; }
        .section-heading p { margin-bottom: 0; color: var(--muted); font-size: 14px; line-height: 1.8; }
        .feature-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
        .feature-card { padding: 25px 22px; border: 1px solid var(--line); border-radius: 16px; background: #fff; transition: .2s ease; }
        .feature-card:hover { transform: translateY(-5px); border-color: #cbd8ff; box-shadow: 0 15px 35px rgba(30,49,91,.07); }
        .feature-icon { width: 45px; height: 45px; display: grid; place-items: center; margin-bottom: 21px; border-radius: 13px; color: #315ee8; background: #edf2ff; }
        .feature-card:nth-child(2) .feature-icon { color: #16845f; background: #e8f8f1; }
        .feature-card:nth-child(3) .feature-icon { color: #b36c1b; background: #fff4e5; }
        .feature-card:nth-child(4) .feature-icon { color: #7954ca; background: #f2edff; }
        .feature-card h3 { margin-bottom: 9px; font: 800 15px 'Manrope', sans-serif; }
        .feature-card p { margin-bottom: 0; color: #778398; font-size: 12px; line-height: 1.8; }
        .workflow { display: grid; grid-template-columns: repeat(4,1fr); gap: 0; position: relative; }
        .workflow::before { content: ''; position: absolute; top: 23px; left: 12%; right: 12%; border-top: 1px dashed #cbd5e5; }
        .step { position: relative; padding: 0 17px; text-align: center; }
        .step-number { position: relative; z-index: 1; width: 47px; height: 47px; display: grid; place-items: center; margin: 0 auto 17px; color: var(--blue); border: 5px solid white; border-radius: 50%; background: #eaf0ff; font: 800 13px 'Manrope', sans-serif; box-shadow: 0 0 0 1px #dfe7fb; }
        .step h3 { margin-bottom: 7px; font: 800 14px 'Manrope', sans-serif; }
        .step p { max-width: 210px; margin: 0 auto; color: #7b879a; font-size: 11px; line-height: 1.75; }
        .cta { padding: 0 0 86px; background: #fff; }
        .cta-panel { position: relative; overflow: hidden; display: flex; align-items: center; justify-content: space-between; gap: 30px; padding: 43px 48px; border-radius: 22px; color: white; background: linear-gradient(115deg, #1c3262, #315ee8); }
        .cta-panel::after { content: ''; position: absolute; width: 330px; height: 330px; right: 12%; top: -220px; border: 1px solid rgba(255,255,255,.13); border-radius: 50%; box-shadow: 0 0 0 35px rgba(255,255,255,.035), 0 0 0 70px rgba(255,255,255,.025); }
        .cta-copy { position: relative; z-index: 1; max-width: 590px; }
        .cta-copy h2 { margin-bottom: 9px; font: 800 clamp(23px, 3vw, 31px)/1.2 'Manrope', sans-serif; letter-spacing: -.8px; }
        .cta-copy p { margin: 0; color: #d0dcff; font-size: 13px; line-height: 1.7; }
        .cta .button { position: relative; z-index: 1; flex-shrink: 0; color: #254bc8; background: white; }
        .footer { padding: 25px 0; background: #fff; border-top: 1px solid #edf0f5; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 18px; color: #8a95a7; font-size: 11px; }
        .footer-brand { color: #34425a; font-weight: 800; }
        @media (max-width: 980px) {
            .hero-grid { grid-template-columns: 1fr; gap: 45px; }
            .hero-copy { max-width: 620px; }
            .preview-wrap { max-width: 650px; width: 100%; margin: 0 auto; transform: none; }
            .feature-grid { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 700px) {
            .container { width: min(100% - 34px, 560px); }
            .topbar { height: 70px; }
            .nav-links, .login-link { display: none; }
            .brand { min-width: 0; }
            .nav-actions .button { min-height: 41px; padding: 0 13px; font-size: 11px; }
            .hero { padding: 57px 0 65px; }
            .hero h1 { letter-spacing: -1.8px; }
            .hero-copy { font-size: 13px; }
            .preview-wrap { padding: 9px; border-radius: 17px; }
            .preview-body { grid-template-columns: 82px 1fr; min-height: 300px; }
            .preview-side { padding: 15px 7px; }
            .side-item { gap: 5px; padding: 8px 5px; font-size: 7px; }
            .preview-main { padding: 13px 9px; }
            .metric { padding: 8px 6px; }
            .metric strong { font-size: 11px; }
            .preview-lower { grid-template-columns: 1fr; }
            .stock-card { display: none; }
            .section { padding: 65px 0; }
            .feature-grid { gap: 10px; }
            .feature-card { padding: 18px 15px; }
            .feature-card h3 { font-size: 13px; }
            .feature-card p { font-size: 11px; }
            .workflow { grid-template-columns: repeat(2,1fr); gap: 28px 10px; }
            .workflow::before { display: none; }
            .step { padding: 0 5px; }
            .cta { padding-bottom: 60px; }
            .cta-panel { align-items: flex-start; flex-direction: column; padding: 30px 25px; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 390px) {
            .hero h1 { font-size: 35px; }
            .hero-buttons { align-items: stretch; flex-direction: column; }
            .hero-buttons .button { width: 100%; }
            .feature-grid { grid-template-columns: 1fr; }
            .preview-user span { display: none; }
        }
    </style>
</head>
<body>
<div class="site-shell">
    <header class="topbar">
        <div class="container nav">
            <a href="{{ route('home') }}" class="brand" aria-label="PWL POS Beranda">
                <span class="brand-mark" aria-hidden="true">
                    <svg width="23" height="23" viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="3" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h2m2 0h4M8 16h8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                </span>
                <span><span class="brand-name">PWL POS</span><span class="brand-caption">POINT OF SALE SYSTEM</span></span>
            </a>
            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="#fitur">Fitur</a>
                <a href="#alur">Cara kerja</a>
                <a href="#tentang">Tentang sistem</a>
            </nav>
            <div class="nav-actions">
                <a class="login-link" href="{{ route('login') }}">Masuk</a>
                <a class="button button-primary" href="{{ route('login') }}">Buka aplikasi <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <div class="eyebrow"><span class="eyebrow-dot"></span> SISTEM KASIR & MANAJEMEN TOKO</div>
                    <h1>Kelola toko lebih <span>mudah</span>, setiap hari.</h1>
                    <p class="hero-copy">PWL POS menyatukan pencatatan penjualan, pengelolaan barang, dan pemantauan stok dalam satu sistem. Bantu operasional toko berjalan lebih teratur tanpa pencatatan yang tercecer.</p>
                    <div class="hero-buttons">
                        <a class="button button-primary" href="{{ route('login') }}">Masuk ke aplikasi <span aria-hidden="true">→</span></a>
                        <a class="button button-secondary" href="#fitur">Kenali fitur</a>
                    </div>
                    <div class="hero-note">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Satu tempat untuk data barang, stok, dan transaksi.
                    </div>
                </div>

                <div class="preview-wrap" aria-label="Ilustrasi tampilan dashboard PWL POS">
                    <span class="preview-label">ILUSTRASI DASHBOARD</span>
                    <div class="preview">
                        <div class="preview-top">
                            <div class="preview-brand"><span class="mini-mark">P</span> PWL POS</div>
                            <div class="preview-user"><span>Administrator</span><span class="avatar">A</span></div>
                        </div>
                        <div class="preview-body">
                            <aside class="preview-side">
                                <p class="side-label">MENU UTAMA</p>
                                <div class="side-item active"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/></svg>Dashboard</div>
                                <div class="side-item"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 13H5L4 7Z" stroke="currentColor" stroke-width="2"/><path d="M9 7a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2"/></svg>Barang</div>
                                <div class="side-item"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM8 9h8M8 13h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>Kategori</div>
                                <div class="side-item"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16v13H4zM8 7V4h8v3M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>Stok</div>
                                <div class="side-item"><svg viewBox="0 0 24 24" fill="none"><path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>Penjualan</div>
                            </aside>
                            <div class="preview-main">
                                <div class="preview-heading"><strong>Ringkasan dashboard</strong><span class="preview-date">Contoh tampilan</span></div>
                                <div class="metric-grid">
                                    <div class="metric"><span>Total barang</span><strong>128</strong><small>Data produk</small></div>
                                    <div class="metric"><span>Stok tersedia</span><strong>864</strong><small>Unit persediaan</small></div>
                                    <div class="metric"><span>Transaksi</span><strong>42</strong><small>Periode contoh</small></div>
                                </div>
                                <div class="preview-lower">
                                    <div class="chart-card">
                                        <div class="card-title"><span>Aktivitas penjualan</span><span>Ilustrasi</span></div>
                                        <div class="chart-bars">
                                            <span class="bar" style="height:35%"></span><span class="bar" style="height:55%"></span><span class="bar" style="height:44%"></span><span class="bar" style="height:76%"></span><span class="bar" style="height:61%"></span><span class="bar" style="height:90%"></span><span class="bar" style="height:70%"></span>
                                        </div>
                                        <div class="chart-days"><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span></div>
                                    </div>
                                    <div class="stock-card">
                                        <div class="card-title"><span>Ringkasan stok</span></div>
                                        <div class="stock-row"><span>Produk A</span><span class="stock-pill">Menipis</span></div>
                                        <div class="stock-row"><span>Produk B</span><span class="stock-pill">Menipis</span></div>
                                        <div class="stock-row"><span>Produk C</span><span style="color:#16845f;font-weight:700">Aman</span></div>
                                    </div>
                                </div>
                                <div class="preview-foot"><i></i> Data pada ilustrasi ini hanya contoh visual, bukan data toko.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-white" id="fitur">
            <div class="container">
                <div class="section-heading">
                    <div class="section-kicker">FITUR UTAMA</div>
                    <h2>Semua kebutuhan operasional, lebih terorganisir.</h2>
                    <p>Fokus pada pekerjaan penting sehari-hari. Data tersimpan dalam satu alur yang saling terhubung.</p>
                </div>
                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM8 9h8M8 13h5M8 17h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
                        <h3>Transaksi penjualan</h3>
                        <p>Catat transaksi, data pembeli, barang yang terjual, dan detail jumlah pembelian.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="m12 3 9 5-9 5-9-5 9-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m3 12 9 5 9-5M3 16l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></div>
                        <h3>Kontrol persediaan</h3>
                        <p>Kelola stok masuk dan pantau perubahan jumlah barang melalui transaksi.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 7h16v13H4zM8 7V4h8v3M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        <h3>Data barang & kategori</h3>
                        <p>Susun katalog produk, harga, dan kategori agar data barang mudah dikelola.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 19V5m0 14h17M8 16v-4m5 4V8m5 8V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
                        <h3>Ringkasan dashboard</h3>
                        <p>Lihat ringkasan barang, persediaan, transaksi, dan omzet dalam satu tampilan.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="alur">
            <div class="container">
                <div class="section-heading">
                    <div class="section-kicker">ALUR KERJA</div>
                    <h2>Dari data barang sampai transaksi tercatat.</h2>
                    <p>Alur sederhana membantu pekerjaan toko lebih konsisten dan mudah dipantau.</p>
                </div>
                <div class="workflow">
                    <article class="step"><div class="step-number">01</div><h3>Atur data barang</h3><p>Masukkan produk, kategori, serta harga barang.</p></article>
                    <article class="step"><div class="step-number">02</div><h3>Catat persediaan</h3><p>Kelola jumlah stok yang tersedia di toko.</p></article>
                    <article class="step"><div class="step-number">03</div><h3>Proses penjualan</h3><p>Catat barang dan jumlah yang dibeli pelanggan.</p></article>
                    <article class="step"><div class="step-number">04</div><h3>Pantau ringkasan</h3><p>Periksa transaksi dan kondisi persediaan melalui dashboard.</p></article>
                </div>
            </div>
        </section>

        <section class="cta" id="tentang">
            <div class="container">
                <div class="cta-panel">
                    <div class="cta-copy">
                        <h2>Siap mengelola operasional toko dengan lebih rapi?</h2>
                        <p>Masuk ke PWL POS untuk mulai mengelola data barang, stok, dan transaksi penjualan.</p>
                    </div>
                    <a class="button" href="{{ route('login') }}">Masuk ke PWL POS <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <span><span class="footer-brand">PWL POS</span> · Sistem kasir dan manajemen toko.</span>
            <span>© {{ date('Y') }} PWL POS. All rights reserved.</span>
        </div>
    </footer>
</div>
</body>
</html>

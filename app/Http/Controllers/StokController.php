<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use App\Models\UserModel;

class StokController extends Controller
{
    // TAMPILKAN SEMUA STOCK
    public function index(Request $request)
{
    $breadcrumb = (object)[
        'title' => 'Daftar Stok',
        'list' => ['Home', 'Stok']
    ];

    $page = (object)[
        'title' => 'Data Stok'
    ];

    $activeMenu = 'Stok';

    $kategori = KategoriModel::all();

    $stok = StokModel::with(['barang.kategori']);

    // Filter jika ada kategori_id
    if ($request->filled('kategori_id')) {
        $stok->whereHas('barang', function ($query) use ($request) {
            $query->where('kategori_id', $request->kategori_id);
        });
    }

    $stok = $stok->get();

    return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'stok', 'kategori'));
}


    // TAMPILKAN FORM TAMBAH
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Stok'
        ];

        $activeMenu = 'Stok';
        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.create', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'user'));
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stock_tanggal' => 'required|date',
            'stock_jumlah' => 'required|integer',
        ]);

        $stok = StokModel::where('barang_id', $request->barang_id)->first();

    if ($stok) {
        $stok->stock_jumlah += $request->stock_jumlah;
        $stok->save();
    } else {
        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stock_jumlah' => $request->stock_jumlah,
            'stock_tanggal' => $request->stock_tanggal,
        ]);
    }

        return redirect('/stok')->with('success', 'Data stok berhasil ditambahkan.');
    }

    // TAMPILKAN DETAIL
    public function show($id)
{
    $stok = StokModel::with(['barang', 'user'])->findOrFail($id);

    $breadcrumb = (object)[
        'title' => 'Detail Stok',
        'list' => ['Home', 'Stok', 'Detail']
    ];

    $page = (object)[
        'title' => 'Detail Data Stok'
    ];

    $activeMenu = 'Stok';

    return view('stok.show', compact('breadcrumb', 'page', 'activeMenu', 'stok'));
}

    // TAMPILKAN FORM EDIT
    public function edit($id)
    {
        $stok = StokModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Form Edit Stok'
        ];

        $activeMenu = 'Stok';
        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.edit', compact('breadcrumb', 'page', 'activeMenu', 'stok', 'barang', 'user'));
    }

    // SIMPAN PERUBAHAN
    public function update(Request $request, $id)
{
    $request->validate([
        'barang_id' => 'required|exists:m_barang,barang_id',
        'stock_tanggal' => 'required|date',
        'stock_jumlah' => 'required|integer',
    ]);

    $stok = StokModel::findOrFail($id);

    // EDIT = GANTI jumlah
    $stok->barang_id = $request->barang_id;
    $stok->stock_tanggal = $request->stock_tanggal;
    $stok->stock_jumlah = $request->stock_jumlah; // ⬅️ GANTI jumlah, BUKAN tambah
    $stok->save();

    return redirect('/stok')->with('success', 'Stok berhasil diperbarui.');
}



    // HAPUS DATA
    public function destroy($id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan.');
        }

        try {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus.');
        }
    }
}

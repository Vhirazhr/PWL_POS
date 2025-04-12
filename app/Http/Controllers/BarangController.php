<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // TAMPILKAN SEMUA BARANG
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'List barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Barang';
        $kategori = KategoriModel::all();

        $barang = BarangModel::with('kategori');

        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        $barang = $barang->get();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori', 'barang'));
    }

    // FORM TAMBAH
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Form Tambah Barang Baru'
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'Barang';

        return view('barang.create', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    // SIMPAN DATA BARANG
    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
        ]);

        BarangModel::create($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan.');
    }

    // DETAIL
    public function show($id)
{
    $barang = BarangModel::with('kategori')->findOrFail($id);

    $breadcrumb = (object)[
        'title' => 'Detail Barang',
        'list' => ['Home', 'Barang', 'Detail']
    ];

    $page = (object)[
        'title' => 'Detail Data Barang'
    ];

    $activeMenu = 'Barang';

    return view('barang.show', compact('barang', 'page', 'activeMenu', 'breadcrumb'));
}


    // FORM EDIT
public function edit($id)
{
    $barang = BarangModel::findOrFail($id);

    $breadcrumb = (object)[
        'title' => 'Edit Barang',
        'list' => ['Home', 'Barang', 'Edit']
    ];

    $page = (object)[
        'title' => 'Edit Data Barang'
    ];

    $activeMenu = 'Barang';

    // ambil semua kategori
    $kategori = KategoriModel::all();

    return view('barang.edit', compact('barang', 'page', 'activeMenu', 'breadcrumb', 'kategori'));
}


    // SIMPAN PERUBAHAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
        ]);

        $barang = BarangModel::findOrFail($id);
        $barang->update($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil diubah.');
    }

    // HAPUS
    public function destroy($id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan.');
        }

        try {
            $barang->delete();
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena sedang digunakan.');
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\BarangModel;


class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
        'barang_nama' => 'required|string|max:100',
        'kategori_id' => 'required|integer',
        'harga_beli' => 'required|numeric',
        'harga_jual' => 'required|numeric',
        'barang_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    if ($request->hasFile('barang_gambar')) {
        $gambarPath = $request->file('barang_gambar')->store('uploads/barang', 'public');
    } else {
        $gambarPath = null;
    }

    $barang = BarangModel::create([
        'barang_kode' => $request->barang_kode,
        'barang_nama' => $request->barang_nama,
        'kategori_id' => $request->kategori_id,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'barang_gambar' => $gambarPath,
    ]);

    if ($barang) {
        return response()->json([
            'success' => true,
            'data' => $barang,
        ], 201);
    }

    return response()->json([
        'success' => false,
        'message' => 'Gagal menyimpan data barang.',
    ], 409);
}


    public function show(BarangModel $barang)
{
    return response()->json($barang);
}


    public function update(Request $request, BarangModel $barang)
{
    $validator = Validator::make($request->all(), [
        'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
        'barang_nama' => 'required|string|max:100',
        'kategori_id' => 'required|integer',
        'harga_beli' => 'required|numeric',
        'harga_jual' => 'required|numeric',
        'barang_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    if ($request->hasFile('barang_gambar')) {
        // hapus gambar lama jika ada
        if ($barang->barang_gambar && Storage::disk('public')->exists($barang->barang_gambar)) {
            Storage::disk('public')->delete($barang->barang_gambar);
        }
        $gambarPath = $request->file('barang_gambar')->store('uploads/barang', 'public');
    } else {
        $gambarPath = $barang->barang_gambar;
    }

    $barang->update([
        'barang_kode' => $request->barang_kode,
        'barang_nama' => $request->barang_nama,
        'kategori_id' => $request->kategori_id,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'barang_gambar' => $gambarPath,
    ]);

    return response()->json([
        'success' => true,
        'data' => $barang,
    ]);
}


    public function destroy(BarangModel $barang)
    {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}

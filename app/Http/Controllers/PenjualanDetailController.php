<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;

class PenjualanDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1'
        ]);

        PenjualanDetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah
        ]);

        return redirect('/penjualan/' . $request->penjualan_id)->with('success', 'Barang berhasil ditambahkan ke penjualan');
    }

    public function destroy(string $id)
    {
        $detail = PenjualanDetailModel::findOrFail($id);
        $penjualan_id = $detail->penjualan_id;
        $detail->delete();

        return redirect('/penjualan/' . $penjualan_id)->with('success', 'Detail barang berhasil dihapus');
    }
}

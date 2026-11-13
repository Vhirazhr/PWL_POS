<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'penjualan_id' => ['required', 'exists:m_penjualan,penjualan_id'],
            'barang_id' => ['required', 'exists:m_barang,barang_id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $penjualan = PenjualanModel::findOrFail($data['penjualan_id']);
        $barang = BarangModel::findOrFail($data['barang_id']);

        PenjualanDetailModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang->barang_id,
            'harga' => $barang->harga_jual,
            'jumlah' => $data['jumlah'],
        ]);

        return redirect('/penjualan/' . $penjualan->penjualan_id)
            ->with('success', 'Barang berhasil ditambahkan ke penjualan.');
    }

    public function destroy(string $id)
    {
        $detail = PenjualanDetailModel::findOrFail($id);
        $penjualanId = $detail->penjualan_id;
        $detail->delete();

        return redirect('/penjualan/' . $penjualanId)
            ->with('success', 'Detail barang berhasil dihapus.');
    }
}

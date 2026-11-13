<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenjualanDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'penjualan_id' => ['required', 'exists:m_penjualan,penjualan_id'],
            'barang_id' => ['required', 'exists:m_barang,barang_id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($data) {
            $penjualan = PenjualanModel::lockForUpdate()->findOrFail($data['penjualan_id']);
            $barang = BarangModel::findOrFail($data['barang_id']);
            $stok = StokModel::where('barang_id', $barang->barang_id)->lockForUpdate()->first();
            $available = (int) ($stok->stock_jumlah ?? 0);

            if (!$stok || $available < $data['jumlah']) {
                throw ValidationException::withMessages([
                    'barang_id' => "Stok {$barang->barang_nama} tidak mencukupi. Tersedia {$available}, dibutuhkan {$data['jumlah']}.",
                ]);
            }

            $stok->stock_jumlah = $available - $data['jumlah'];
            $stok->stock_tanggal = now();
            $stok->user_id = auth()->id() ?? $stok->user_id;
            $stok->save();

            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang->barang_id,
                'harga' => $barang->harga_jual,
                'jumlah' => $data['jumlah'],
            ]);
        });

        return redirect('/penjualan/' . $data['penjualan_id'])
            ->with('success', 'Barang berhasil ditambahkan ke penjualan dan stok diperbarui.');
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $detail = PenjualanDetailModel::lockForUpdate()->findOrFail($id);
            $stok = StokModel::where('barang_id', $detail->barang_id)->lockForUpdate()->first();

            if ($stok) {
                $stok->stock_jumlah += $detail->jumlah;
                $stok->stock_tanggal = now();
                $stok->user_id = auth()->id() ?? $stok->user_id;
                $stok->save();
            } else {
                StokModel::create([
                    'barang_id' => $detail->barang_id,
                    'user_id' => auth()->id(),
                    'stock_tanggal' => now(),
                    'stock_jumlah' => $detail->jumlah,
                ]);
            }

            $penjualanId = $detail->penjualan_id;
            $detail->delete();
        });

        $penjualanId = PenjualanDetailModel::find($id)?->penjualan_id;

        return redirect('/penjualan/' . ($penjualanId ?? ''))
            ->with('success', 'Detail barang berhasil dihapus dan stok dikembalikan.');
    }
}

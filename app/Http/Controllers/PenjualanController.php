<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar penjualan yang tercatat dalam sistem'
        ];

        $activeMenu = 'penjualan';
        $penjualans = PenjualanModel::with('user')->get();

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'penjualans'));
    }

    public function create()
{
    $breadcrumb = (object)[
        'title' => 'Tambah Penjualan',
        'list' => ['Home', 'Penjualan', 'Tambah']
    ];

    $page = (object)[
        'title' => 'Tambah Penjualan Baru'
    ];

    // data barang yang dibutuhkan untuk dropdown
    $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();
    $users = UserModel::select('user_id', 'username')->get();

    $activeMenu = 'penjualan';

    return view('penjualan.create', compact('breadcrumb', 'page', 'activeMenu', 'users', 'barang'));
}




public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:m_user,user_id',
        'pembeli' => 'required|string|max:100',
        'penjualan_kode' => 'required|string|unique:m_penjualan,penjualan_kode',
        'penjualan_tanggal' => 'required|date',
        'barang_id' => 'required|array|min:1',
        'barang_id.*' => 'required|exists:m_barang,barang_id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'required|integer|min:1',
        'harga' => 'required|array',
        'harga.*' => 'required|integer|min:0',
    ]);

    DB::beginTransaction();
    try {
        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
        ]);

        foreach ($request->barang_id as $i => $barangId) {
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barangId,
                'harga' => $request->harga[$i],
                'jumlah' => $request->jumlah[$i],
            ]);
        }

        DB::commit();
        return redirect('penjualan')->with('success', 'Data penjualan berhasil disimpan');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan data penjualan: ' . $e->getMessage());
    }
}

public function show($id)
{
    $penjualan = PenjualanModel::with(['user', 'details.barang'])->findOrFail($id);

    $breadcrumb = (object)[
        'title' => 'Detail Penjualan',
        'list' => ['Home', 'Penjualan', 'Detail']
    ];

    $page = (object)[
        'title' => 'Struk Penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualan.show', compact('penjualan', 'breadcrumb', 'page', 'activeMenu'));
}



public function edit(string $id)
{

    $penjualan = PenjualanModel::with('details')->findOrFail($id);
    $barang = BarangModel::all();
    $users = UserModel::all();

    $breadcrumb = (object)[
        'title' => 'Edit Penjualan',
        'list' => ['Home', 'Penjualan', 'Edit']
    ];

    $page = (object)[
        'title' => 'Edit penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualan.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'users', 'barang'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'penjualan_kode' => 'required',
        'penjualan_tanggal' => 'required',
        'user_id' => 'required|exists:m_user,user_id',
        'pembeli' => 'required|string|max:100',
        'barang_id' => 'required|array|min:1',
        'barang_id.*' => 'required|exists:m_barang,barang_id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'required|integer|min:1',
        'harga' => 'required|array',
        'harga.*' => 'required|integer|min:0',
    ]);

    DB::transaction(function () use ($request, $id) {
    $penjualan = PenjualanModel::findOrFail($id);
    $penjualan->update([
        'penjualan_kode' => $request->penjualan_kode,
        'penjualan_tanggal' => $request->penjualan_tanggal,
        'user_id' => $request->user_id,
        'pembeli' => $request->pembeli,
    ]);

    // Ambil semua detail_id yang dikirim
    $existingDetailIds = $request->detail_id ?? [];

    // Only permit editing detail IDs belonging to this sale.
    $existing = PenjualanDetailModel::where('penjualan_id', $penjualan->penjualan_id)
        ->whereIn('detail_id', $existingDetailIds)->pluck('detail_id')->map(fn ($id) => (string) $id)->all();
    if (count(array_unique(array_map('strval', $existingDetailIds))) !== count($existing)) {
        throw \Illuminate\Validation\ValidationException::withMessages(['detail_id' => 'Detail transaksi tidak valid.']);
    }

    // Hapus detail yang tidak ada di request
    PenjualanDetailModel::where('penjualan_id', $penjualan->penjualan_id)
        ->whereNotIn('detail_id', $existingDetailIds)
        ->delete();

    // Simpan ulang semua detail
    foreach ($request->barang_id as $index => $barangId) {
        $detailId = $request->detail_id[$index] ?? null;

        $dataDetail = [
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barangId,
            'jumlah' => $request->jumlah[$index],
            'harga' => $request->harga[$index],
        ];

        if ($detailId) {
            PenjualanDetailModel::where('detail_id', $detailId)
                ->where('penjualan_id', $penjualan->penjualan_id)->update($dataDetail);
        } else {
            PenjualanDetailModel::create($dataDetail);
        }
    }

    });

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
}



public function destroy(string $id)
{
    $penjualan = PenjualanModel::find($id);
    if (!$penjualan) {
        return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
    }

    try {
        $penjualan->details()->delete();
        $penjualan->delete();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
    } catch (\Exception $e) {
        return redirect('/penjualan')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
    }
}

}

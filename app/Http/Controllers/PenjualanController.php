<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan'],
        ];

        $page = (object) [
            'title' => 'Daftar penjualan yang tercatat dalam sistem',
        ];

        $activeMenu = 'penjualan';
        $penjualans = PenjualanModel::with('user')->latest('penjualan_tanggal')->get();

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'penjualans'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah Penjualan Baru',
        ];

        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->orderBy('barang_nama')->get();
        $users = UserModel::select('user_id', 'username')->orderBy('username')->get();
        $activeMenu = 'penjualan';

        return view('penjualan.create', compact('breadcrumb', 'page', 'activeMenu', 'users', 'barang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:m_user,user_id'],
            'pembeli' => ['required', 'string', 'max:50'],
            'penjualan_kode' => ['required', 'string', 'max:20', 'unique:m_penjualan,penjualan_kode'],
            'penjualan_tanggal' => ['required', 'date'],
            'barang_id' => ['required', 'array', 'min:1'],
            'barang_id.*' => ['required', 'exists:m_barang,barang_id'],
            'jumlah' => ['required', 'array', 'min:1'],
            'jumlah.*' => ['required', 'integer', 'min:1'],
        ]);

        if (count($data['barang_id']) !== count($data['jumlah'])) {
            throw ValidationException::withMessages([
                'jumlah' => 'Jumlah barang dan kuantitas tidak sesuai.',
            ]);
        }

        $barang = BarangModel::whereIn('barang_id', $data['barang_id'])->get()->keyBy('barang_id');

        DB::transaction(function () use ($data, $barang) {
            foreach ($data['barang_id'] as $index => $barangId) {
                $this->reduceStock((int) $barangId, (int) $data['jumlah'][$index]);
            }

            $penjualan = PenjualanModel::create([
                'user_id' => $data['user_id'],
                'pembeli' => $data['pembeli'],
                'penjualan_kode' => $data['penjualan_kode'],
                'penjualan_tanggal' => $data['penjualan_tanggal'],
            ]);

            foreach ($data['barang_id'] as $index => $barangId) {
                $item = $barang->get($barangId);

                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barangId,
                    'harga' => $item->harga_jual,
                    'jumlah' => $data['jumlah'][$index],
                ]);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function show($id)
    {
        $penjualan = PenjualanModel::with(['user', 'details.barang'])->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Struk Penjualan',
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', compact('penjualan', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $penjualan = PenjualanModel::with('details')->findOrFail($id);
        $barang = BarangModel::orderBy('barang_nama')->get();
        $users = UserModel::orderBy('username')->get();

        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit penjualan',
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'users', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'penjualan_kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('m_penjualan', 'penjualan_kode')->ignore($id, 'penjualan_id'),
            ],
            'penjualan_tanggal' => ['required', 'date'],
            'user_id' => ['required', 'exists:m_user,user_id'],
            'pembeli' => ['required', 'string', 'max:50'],
            'barang_id' => ['required', 'array', 'min:1'],
            'barang_id.*' => ['required', 'exists:m_barang,barang_id'],
            'jumlah' => ['required', 'array', 'min:1'],
            'jumlah.*' => ['required', 'integer', 'min:1'],
            'detail_id' => ['sometimes', 'array'],
            'detail_id.*' => ['nullable', 'integer', 'exists:m_penjualan_detail_table,detail_id'],
        ]);

        if (count($data['barang_id']) !== count($data['jumlah'])) {
            throw ValidationException::withMessages([
                'jumlah' => 'Jumlah barang dan kuantitas tidak sesuai.',
            ]);
        }

        $barang = BarangModel::whereIn('barang_id', $data['barang_id'])->get()->keyBy('barang_id');
        $detailIds = collect($data['detail_id'] ?? [])
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->map(fn ($value) => (int) $value)
            ->values();

        if ($detailIds->count() !== $detailIds->unique()->count()) {
            throw ValidationException::withMessages([
                'detail_id' => 'Ada detail transaksi yang terkirim lebih dari satu kali.',
            ]);
        }

        DB::transaction(function () use ($id, $data, $barang, $detailIds) {
            $penjualan = PenjualanModel::with('details')->lockForUpdate()->findOrFail($id);
            $existingDetails = $penjualan->details->keyBy('detail_id');

            foreach ($detailIds as $detailId) {
                if (!$existingDetails->has($detailId)) {
                    throw ValidationException::withMessages([
                        'detail_id' => 'Detail barang tidak sesuai dengan transaksi ini.',
                    ]);
                }
            }

            // Kembalikan stok dari detail lama sebelum menghitung isi transaksi yang baru.
            foreach ($penjualan->details as $detail) {
                $this->restoreStock((int) $detail->barang_id, (int) $detail->jumlah);
            }

            // Kurangi stok sesuai detail transaksi yang baru.
            foreach ($data['barang_id'] as $index => $barangId) {
                $this->reduceStock((int) $barangId, (int) $data['jumlah'][$index]);
            }

            $penjualan->update([
                'penjualan_kode' => $data['penjualan_kode'],
                'penjualan_tanggal' => $data['penjualan_tanggal'],
                'user_id' => $data['user_id'],
                'pembeli' => $data['pembeli'],
            ]);

            if ($detailIds->isEmpty()) {
                $penjualan->details()->delete();
            } else {
                $penjualan->details()->whereNotIn('detail_id', $detailIds->all())->delete();
            }

            foreach ($data['barang_id'] as $index => $barangId) {
                $detailId = $data['detail_id'][$index] ?? null;
                $item = $barang->get($barangId);

                $detailData = [
                    'barang_id' => $barangId,
                    'harga' => $item->harga_jual,
                    'jumlah' => $data['jumlah'][$index],
                ];

                if ($detailId) {
                    $existingDetails->get((int) $detailId)->update($detailData);
                } else {
                    $penjualan->details()->create($detailData);
                }
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $penjualan = PenjualanModel::with('details')->lockForUpdate()->findOrFail($id);

            foreach ($penjualan->details as $detail) {
                $this->restoreStock((int) $detail->barang_id, (int) $detail->jumlah);
            }

            $penjualan->details()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus dan stok dikembalikan.');
    }

    private function reduceStock(int $barangId, int $quantity): void
    {
        $stok = StokModel::where('barang_id', $barangId)->lockForUpdate()->first();
        $barang = BarangModel::findOrFail($barangId);
        $available = (int) ($stok->stock_jumlah ?? 0);

        if (!$stok || $available < $quantity) {
            throw ValidationException::withMessages([
                'barang_id' => "Stok {$barang->barang_nama} tidak mencukupi. Tersedia {$available}, dibutuhkan {$quantity}.",
            ]);
        }

        $stok->stock_jumlah = $available - $quantity;
        $stok->stock_tanggal = now();
        $stok->user_id = auth()->id() ?? $stok->user_id;
        $stok->save();
    }

    private function restoreStock(int $barangId, int $quantity): void
    {
        $stok = StokModel::where('barang_id', $barangId)->lockForUpdate()->first();

        if ($stok) {
            $stok->stock_jumlah += $quantity;
            $stok->stock_tanggal = now();
            $stok->user_id = auth()->id() ?? $stok->user_id;
            $stok->save();

            return;
        }

        StokModel::create([
            'barang_id' => $barangId,
            'user_id' => auth()->id(),
            'stock_tanggal' => now(),
            'stock_jumlah' => $quantity,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard'],
        ];

        $activeMenu = 'dashboard';
        $totalBarang = BarangModel::count();
        $totalKategori = KategoriModel::count();
        $totalUser = UserModel::count();
        $totalStok = StokModel::sum('stock_jumlah');
        $jumlahTransaksiBulanIni = PenjualanModel::whereMonth('penjualan_tanggal', now()->month)
            ->whereYear('penjualan_tanggal', now()->year)
            ->count();

        $omzetBulanIni = PenjualanDetailModel::query()
            ->join('m_penjualan', 'm_penjualan_detail_table.penjualan_id', '=', 'm_penjualan.penjualan_id')
            ->whereMonth('m_penjualan.penjualan_tanggal', now()->month)
            ->whereYear('m_penjualan.penjualan_tanggal', now()->year)
            ->sum(\Illuminate\Support\Facades\DB::raw('m_penjualan_detail_table.harga * m_penjualan_detail_table.jumlah'));

        $transaksiTerbaru = PenjualanModel::with(['user', 'details'])
            ->orderByDesc('penjualan_tanggal')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'breadcrumb',
            'activeMenu',
            'totalBarang',
            'totalKategori',
            'totalUser',
            'totalStok',
            'jumlahTransaksiBulanIni',
            'omzetBulanIni',
            'transaksiTerbaru'
        ));
    }
}

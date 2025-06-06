<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    // ==================== STANDARD ====================

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

        if ($request->filled('kategori_id')) {
            $stok->whereHas('barang', function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            });
        }

        $stok = $stok->get();

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'stok', 'kategori'));
    }

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
            StokModel::create($request->all());
        }

        return redirect('/stok')->with('success', 'Data stok berhasil ditambahkan.');
    }

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:m_barang,barang_id',
            'stock_tanggal' => 'required|date',
            'stock_jumlah' => 'required|integer',
        ]);

        $stok = StokModel::findOrFail($id);
        $stok->update($request->all());

        return redirect('/stok')->with('success', 'Stok berhasil diperbarui.');
    }

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

    // ==================== AJAX ====================

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang.kategori']);

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', fn($s) => $s->barang->barang_nama ?? '-')
            ->addColumn('kategori_nama', fn($s) => $s->barang->kategori->kategori_nama ?? '-')
            ->addColumn('action', function ($item) {
                $btn  = '<button onclick="modalAction(\'' . url('/stok/' . $item->stock_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $item->stock_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $item->stock_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('stok.create_ajax', compact('barang', 'user'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'barang_id' => 'required|exists:m_barang,barang_id',
                'user_id' => 'required|exists:m_user,user_id',
                'stock_tanggal' => 'required|date',
                'stock_jumlah' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::where('barang_id', $request->barang_id)->first();
            if ($stok) {
                $stok->stock_jumlah += $request->stock_jumlah;
                $stok->save();
            } else {
                StokModel::create($request->all());
            }

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $stok = StokModel::findOrFail($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('stok.edit_ajax', compact('stok', 'barang', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'barang_id' => 'required|exists:m_barang,barang_id',
                'stock_tanggal' => 'required|date',
                'stock_jumlah' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::find($id);
            if (!$stok) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $stok->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil diperbarui'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax($id)
    {
        $stok = StokModel::with(['barang', 'user'])->find($id);
        return view('stok.show_ajax', compact('stok'));
    }

    public function confirm_ajax($id)
    {
        $stok = StokModel::findOrFail($id);
        return view('stok.confirm_ajax', compact('stok'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $stok = StokModel::find($id);
            if (!$stok) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            try {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok gagal dihapus'
                ]);
            }
        }

        return redirect('/');
    }
}

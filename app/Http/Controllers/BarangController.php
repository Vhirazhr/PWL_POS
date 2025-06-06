<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    // ==================== STANDARD ====================

    public function index(Request $request)
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object)[
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

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Barang Baru'
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'Barang';

        return view('barang.create', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

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
        $kategori = KategoriModel::all();

        return view('barang.edit', compact('barang', 'page', 'activeMenu', 'breadcrumb', 'kategori'));
    }

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

    // ==================== AJAX ====================

    public function list(Request $request)
    {
        $barang = BarangModel::with('kategori')->select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'harga_beli', 'harga_jual');

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', fn ($item) => $item->kategori->kategori_nama ?? '-')
            ->addColumn('action', function ($item) {
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $item->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $item->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $item->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::all();
        return view('barang.create_ajax', compact('kategori'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'kategori_id' => 'required|integer',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $barang = BarangModel::findOrFail($id);
        $kategori = KategoriModel::all();
        return view('barang.edit_ajax', compact('barang', 'kategori'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'kategori_id' => 'required|integer',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $barang = BarangModel::find($id);
            if (!$barang) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $barang->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil diubah'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax($id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        return view('barang.show_ajax', [
            'barang' => $barang,
            'page' => (object)[
                'title' => 'Detail Data Barang'
            ]
        ]);
    }

    public function confirm_ajax($id)
    {
        $barang = BarangModel::findOrFail($id);
        return view('barang.confirm_ajax', compact('barang'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if (!$barang) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            try {
                $barang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data barang berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data barang gagal dihapus karena sedang digunakan'
                ]);
            }
        }

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    //public function index()
   // {
       // Insert data (jika ingin digunakan, hapus tanda komentar)
        /*
        $data = [
            'kategori_kode' => 'SNK',
            'kategori_nama' => 'Snack/Makanan Ringan',
            'created_at' => now()
        ];

        DB::table('m_kategori')->insert($data);

        return 'Insert data baru berhasil!';
        */

        // Update data dan simpan jumlah baris yang diperbarui
       /* $row = DB::table('m_kategori')
                ->where('kategori_kode', 'SNK')
                ->update(['kategori_nama' => 'Camilan']);

        return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';*/

       /* $row = DB::table('m_kategori')
                ->where('kategori_kode', 'SNK')->delate();
        return 'Delete data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';*/

     //   $data = DB::table('m_kategori')->get();
      //  return view('kategori', ['data' => $data]);
//}
public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';
        $kategori = KategoriModel::all();

        return view('kategori.index', [
          'breadcrumb' => $breadcrumb, 
          'page' => $page, 
          'kategori' => $kategori,
          'activeMenu' => $activeMenu
      ]);
  }

  // Menampilkan form tambah level
  public function create()
  {
      $breadcrumb = (object) [
          'title' => 'Tambah kategori',
          'list' => ['Home', 'kategori', 'Tambah']
      ];

      $page = (object) [
          'title' => 'Tambah kategori baru'
      ];

      $activeMenu = 'kategor';

      return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
  }

  // Menyimpan data level baru
  public function store(Request $request)
  {
      $request->validate([
          'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
          'kategori_nama' => 'required|string|max:100'
      ]);

      KategoriModel::create([
          'kategori_kode' => $request->kategori_kode,
          'kategori_nama' => $request->kategori_nama
      ]);

      return redirect('/kategori')->with('success', 'Data level berhasil disimpan');
  }

  // Menampilkan detail level
  public function show(string $id)
  {
      $level = KategoriModel::find($id);

      $breadcrumb = (object) [
          'title' => 'Detail kode',
          'list'  => ['Home', 'kategori', 'Detail']
      ];

      $page = (object) [
          'title' => 'Detail kategori'
      ];

      $activeMenu = 'kategori';

      return view('kategori.show', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
  }

  // Menampilkan halaman form edit level
  public function edit(string $id)
  {
      $level = KategoriModel::find($id);

      $breadcrumb = (object) [
          'title' => 'Edit kategori',
          'list'  => ['Home', 'kategori', 'Edit']
      ];

      $page = (object) [
          'title' => 'Edit kategori'
      ];

      $activeMenu = 'kategori';

      return view('kategori.edit', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
  }

  // Menyimpan perubahan data level
  public function update(Request $request, string $id)
  {
      $request->validate([
          'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
          'kategori_nama' => 'required|string|max:100'
      ]);

      KategoriModel::find($id)->update([
          'kategori_kode' => $request->kategori_kode,
          'kategori_nama' => $request->kategori_nama
      ]);

      return redirect('/kategori')->with('success', 'Data level berhasil diubah');
  }

  // Menghapus data level
  public function destroy(string $id)
  {
      $check = KategoriModel::find($id);
      if (!$check) {
          return redirect('/kategori')->with('error', 'Data level tidak ditemukan');
      }

      try {
          KategoriModel::destroy($id);
          return redirect('/kategori')->with('success', 'Data level berhasil dihapus');
      } catch (\Illuminate\Database\QueryException $e) {
          return redirect('/kategori')->with('error', 'Data level gagal dihapus karena masih terdapat user yang menggunakan level ini');
      }
  }
}
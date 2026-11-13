<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller{
   
   /* public function index(){
      $user = UserModel::all();
      return view('user', ['data' => $user]); 
    }*/
    /*  public function tambah(){
      return view('user_tambah');
    }
      public function tambah_simpan(Request $request){
        UserModel::create([
          'username' => $request->username,
          'nama' => $request->nama,
          'password' => Hash::make($request->password),
          'level_id' => $request->level_id
        ]);
      return redirect('/user');
    }
     public function ubah($id){
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
      }
      public function ubah_simpan($id, Request $request){
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->level_id = $request->level_id;

        $user->save();
        return redirect('/user');
      }
      public function hapus($id){
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
      }

      /*public function index() {
        $user = UserModel::with('level')->get();
        return view ('user', ['data' => $user]);
      }*/

       // Menampilkan daftar user index
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';
        $level = LevelModel::all();

        return view('user.index', [
          'breadcrumb' => $breadcrumb, 
          'page' => $page, 
          'level' => $level,
          'activeMenu' => $activeMenu
      ]);
  }


    // Ambil data user dalam bentuk JSON untuk DataTables
public function list(Request $request)
{
    // Ambil data user dan relasi ke level
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
        ->with('level');

    // Filter data user berdasarkan level_id jika ada
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }

    // Kembalikan response dalam format DataTables
    return DataTables::of($users)
        ->addIndexColumn() // Menambahkan kolom index (DT_RowIndex)
        ->addColumn('action', function ($user) {
            $btn  = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['action']) // Memberitahu bahwa kolom aksi berisi HTML
        ->make(true);
}


    // Menampilkan form tambah user create
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    // Menyimpan data user baru store
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:20|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer|exists:m_level,level_id'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password), // Password disimpan dalam bentuk hash
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user show
    public function show(string $id)
    {
        $user = UserModel::with('level')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list'  => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
}   
  // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::findOrFail($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list'  => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'user'       => $user,
            'level'      => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {

     $request->validate([
    'username' => 'required|string|min:3|max:20|unique:m_user,username,' . $id . ',user_id',
    'nama'     => 'required|string|max:100',
    'password' => 'nullable|string|min:5',
    'level_id' => 'required|integer|exists:m_level,level_id'
]);

    

        $user = UserModel::findOrFail($id);
        $data = [
            'username' => $request->username,
            'nama' => $request->nama,
            'level_id' => $request->level_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

// Menghapus data user
public function destroy(string $id)
{
    $check = UserModel::find($id);
    if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }

    try {
        UserModel::destroy($id); // Hapus data level
        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
}

public function create_ajax(){
    $level = LevelModel::select('level_id', 'level_nama')->get();
    return view('user.create_ajax')
    ->with('level', $level);
}  

public function store_ajax(Request $request) {
    // cek apakah request berupa ajax
    if($request->ajax() || $request->wantsJson()){
        $rules = [
            'level_id' => 'required|integer|exists:m_level,level_id',
            'username' => 'required|string|min:3|max:20|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6'
        ];

        // use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        UserModel::create([
            'level_id' => $request->input('level_id'),
            'username' => $request->input('username'),
            'nama' => $request->input('nama'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

    return redirect()->route('dashboard');
}

// Menampilkan halaman form edit user ajax
public function edit_ajax(string $id)
{
    $user = UserModel::find($id);
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
}


public function update_ajax(Request $request, $id)
{
    // Cek apakah request berasal dari AJAX
    if ($request->ajax() || $request->wantsJson()) {

        // Validasi input
        $rules = [
            'level_id' => 'required|integer|exists:m_level,level_id',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ];

        // Jalankan validasi
        $validator = Validator::make($request->all(), $rules);

        // Jika validasi gagal, kirim respon JSON dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $user = UserModel::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data = [
            'level_id' => $request->input('level_id'),
            'username' => $request->input('username'),
            'nama' => $request->input('nama'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    // Jika bukan request AJAX, redirect ke halaman utama
    return redirect('/');
}

public function confirm_ajax(string $id){
    $user = UserModel::find($id);
    return view('user.confirm_ajax', ['user'=> $user]);
}

public function delete_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $user = UserModel::find($id);
        
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    
    return redirect('/');
}

public function show_ajax($id)
{
    $user = UserModel::with('level')->findOrFail($id);
    return view('user.show_ajax', compact('user'));
}

public function __construct()
{
    $this->middleware('auth')->only(['profile', 'updateProfile']);
}


public function profile()
{
    $user = auth()->user();
    $activeMenu = 'profile';

    $breadcrumb = (object)[
        'title' => 'Profil Saya',
        'list' => ['Home', 'Profil']
    ];

    return view('user.profile', compact('user', 'activeMenu', 'breadcrumb'));
}

public function editProfile()
{
    $user = auth()->user();
    $activeMenu = 'profile';

    $breadcrumb = (object)[
        'title' => 'Edit Profil',
        'list' => ['Home', 'Profil', 'Edit']
    ];

    return view('user.profile', compact('user', 'activeMenu', 'breadcrumb'));
}

public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'nama' => 'required|string|max:100',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
    ]);

    $user->nama = $request->nama;

    if ($request->hasFile('image')) {
        // Hapus file lama jika ada
        $oldImagePath = $user->getRawOriginal('image');
        if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        // Upload ke storage/app/public/uploads/profile
        $path = $request->file('image')->store('uploads/profile', 'public');
        $user->image = $path;
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
}

  }



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Level;

class LevelController extends Controller
{
    public function index() {
       // DB::insert('insert into m_level(level_kode, level_nama, created_at )
        // values(?, ?, ?)', ['CUS', 'pelanggan', now()]);

       // $row =DB::update('update m_level set level_nama = ? where level_kode =?', ['customer', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang di update: '.$row. 'baris';

        //$row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        //return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row.'baris'; 

        //$data = DB::select('select * from m_level');
        //return view('level', ['data' => $data]);

        // Tambah level baru
        DB::table('m_level')->insert([
            'level_id' => 4, 
            'level_kode' => 'CST', 
            'level_nama' => 'Customer'
        ]);

        return "Level baru berhasil ditambahkan!";
    }
}

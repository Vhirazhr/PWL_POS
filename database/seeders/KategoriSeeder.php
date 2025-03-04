<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [
            ['kategori_id' => 1, 'kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 2, 'kategori_kode' => 'ETN', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 3, 'kategori_kode' => 'KMK', 'kategori_nama' => 'Kosmetik'],
            ['kategori_id' => 4, 'kategori_kode' => 'PKN', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 5, 'kategori_kode' => 'DIY', 'kategori_nama' => 'Perkakas'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}

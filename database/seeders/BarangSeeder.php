<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 123,
                'kategori_id' => 1,
                'barang_kode' => 'RTI',
                'barang_nama' => 'Roti',
                'harga_beli' => 5000,
                'harga_jual' => 7000,
            ],
            [
                'barang_id' => 321,
                'kategori_id' => 1,
                'barang_kode' => 'SNC',
                'barang_nama' => 'Snack',
                'harga_beli' => 7000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 456,
                'kategori_id' => 2,
                'barang_kode' => 'STK',
                'barang_nama' => 'Setrika',
                'harga_beli' => 150000,
                'harga_jual' => 175000,
            ],
            [
                'barang_id' => 654,
                'kategori_id' => 2,
                'barang_kode' => 'BLD',
                'barang_nama' => 'Blender',
                'harga_beli' => 200000,
                'harga_jual' => 325000,
            ],
            [
                'barang_id' => 897,
                'kategori_id' => 3,
                'barang_kode' => 'CSH',
                'barang_nama' => 'Cussion',
                'harga_beli' => 150000,
                'harga_jual' => 175000,
            ],
            [
                'barang_id' => 821,
                'kategori_id' => 3,
                'barang_kode' => 'LIP',
                'barang_nama' => 'Lipgloss',
                'harga_beli' => 50000,
                'harga_jual' => 60000,
            ],
            [
                'barang_id' => 764,
                'kategori_id' => 4,
                'barang_kode' => 'VNC',
                'barang_nama' => 'Vneck',
                'harga_beli' => 50000,
                'harga_jual' => 60000,
            ],
            [
                'barang_id' => 983,
                'kategori_id' => 4,
                'barang_kode' => 'SHR',
                'barang_nama' => 'Shirt',
                'harga_beli' => 100000,
                'harga_jual' => 150000,
            ],
            [
                'barang_id' => 459,
                'kategori_id' => 5,
                'barang_kode' => 'TBR',
                'barang_nama' => 'ToothtBrush',
                'harga_beli' => 7000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 435,
                'kategori_id' => 5,
                'barang_kode' => 'GLS',
                'barang_nama' => 'Glass',
                'harga_beli' => 50000,
                'harga_jual' => 70000,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
    
}

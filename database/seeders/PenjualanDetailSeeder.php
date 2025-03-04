<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['detail_id' => 1001, 'penjualan_id' => 101, 'barang_id' => 435, 'harga' => 70000, 'jumlah' => 3],
            ['detail_id' => 1002, 'penjualan_id' => 101, 'barang_id' => 764, 'harga' => 60000, 'jumlah' => 5],
            ['detail_id' => 1003, 'penjualan_id' => 101, 'barang_id' => 654, 'harga' => 325000, 'jumlah' => 2],
            
            ['detail_id' => 1004, 'penjualan_id' => 102, 'barang_id' => 321, 'harga' => 10000, 'jumlah' => 6],
            ['detail_id' => 1005, 'penjualan_id' => 102, 'barang_id' => 897, 'harga' => 175000, 'jumlah' => 3],
            ['detail_id' => 1006, 'penjualan_id' => 102, 'barang_id' => 459, 'harga' => 10000, 'jumlah' => 4],

            ['detail_id' => 1007, 'penjualan_id' => 103, 'barang_id' => 821, 'harga' => 60000, 'jumlah' => 7],
            ['detail_id' => 1008, 'penjualan_id' => 103, 'barang_id' => 456, 'harga' => 175000, 'jumlah' => 2],
            ['detail_id' => 1009, 'penjualan_id' => 103, 'barang_id' => 654, 'harga' => 325000, 'jumlah' => 4],

            ['detail_id' => 1010, 'penjualan_id' => 104, 'barang_id' => 764, 'harga' => 60000, 'jumlah' => 3],
            ['detail_id' => 1011, 'penjualan_id' => 104, 'barang_id' => 321, 'harga' => 10000, 'jumlah' => 5],
            ['detail_id' => 1012, 'penjualan_id' => 104, 'barang_id' => 897, 'harga' => 175000, 'jumlah' => 3],

            ['detail_id' => 1013, 'penjualan_id' => 105, 'barang_id' => 764, 'harga' => 60000, 'jumlah' => 2],
            ['detail_id' => 1014, 'penjualan_id' => 105, 'barang_id' => 654, 'harga' => 325000, 'jumlah' => 2],
            ['detail_id' => 1015, 'penjualan_id' => 105, 'barang_id' => 435, 'harga' => 70000, 'jumlah' => 3],

            ['detail_id' => 1016, 'penjualan_id' => 106, 'barang_id' => 821, 'harga' => 60000, 'jumlah' => 6],
            ['detail_id' => 1017, 'penjualan_id' => 106, 'barang_id' => 459, 'harga' => 10000, 'jumlah' => 4],
            ['detail_id' => 1018, 'penjualan_id' => 106, 'barang_id' => 897, 'harga' => 175000, 'jumlah' => 5],

            ['detail_id' => 1019, 'penjualan_id' => 107, 'barang_id' => 654, 'harga' => 325000, 'jumlah' => 3],
            ['detail_id' => 1020, 'penjualan_id' => 107, 'barang_id' => 435, 'harga' => 70000, 'jumlah' => 2],
            ['detail_id' => 1021, 'penjualan_id' => 107, 'barang_id' => 764, 'harga' => 60000, 'jumlah' => 3],

            ['detail_id' => 1022, 'penjualan_id' => 108, 'barang_id' => 321, 'harga' => 10000, 'jumlah' => 4],
            ['detail_id' => 1023, 'penjualan_id' => 108, 'barang_id' => 456, 'harga' => 175000, 'jumlah' => 2],
            ['detail_id' => 1024, 'penjualan_id' => 108, 'barang_id' => 764, 'harga' => 60000, 'jumlah' => 3],

            ['detail_id' => 1025, 'penjualan_id' => 109, 'barang_id' => 897, 'harga' => 175000, 'jumlah' => 2],
            ['detail_id' => 1026, 'penjualan_id' => 109, 'barang_id' => 435, 'harga' => 70000, 'jumlah' => 3],
            ['detail_id' => 1027, 'penjualan_id' => 109, 'barang_id' => 459, 'harga' => 10000, 'jumlah' => 5],

            ['detail_id' => 1028, 'penjualan_id' => 110, 'barang_id' => 654, 'harga' => 325000, 'jumlah' => 3],
            ['detail_id' => 1029, 'penjualan_id' => 110, 'barang_id' => 459, 'harga' => 10000, 'jumlah' => 5],
            ['detail_id' => 1030, 'penjualan_id' => 110, 'barang_id' => 821, 'harga' => 60000, 'jumlah' => 2],
        ];
        DB::table('m_penjualan_detail_table')->insert($data);
    }
}

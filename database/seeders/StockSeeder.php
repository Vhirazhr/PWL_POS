<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'stock_id' => 111,
                'barang_id' => 123,
                'user_id' => 1,
                'stock_tanggal' => Carbon::now(),
                'stock_jumlah' => 10,
            ],
            [
                'stock_id' => 112,
                'barang_id' => 321,
                'user_id' => 1,
                'stock_tanggal' => Carbon::now(),
                'stock_jumlah' => 10,
            ],
            [
                'stock_id' => 222,
                'barang_id' => 456,
                'user_id' => 1,
                'stock_tanggal' => Carbon::now(),
                'stock_jumlah' => 10,
            ],
            [
                'stock_id' => 223,
                'barang_id' => 654,
                'user_id' => 1,
                'stock_tanggal' => Carbon::now(),
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 333,
                'barang_id' => 897,
                'user_id' => 1,
                'stock_tanggal' => '2025-01-20 10:30:00',
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 334,
                'barang_id' => 821,
                'user_id' => 1,
                'stock_tanggal' => '2025-01-20 10:30:00',
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 444,
                'barang_id' => 764,
                'user_id' => 1,
                'stock_tanggal' => '2025-01-20 10:30:00',
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 445,
                'barang_id' => 983,
                'user_id' => 1,
                'stock_tanggal' => '2025-01-20 10:30:00',
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 555,
                'barang_id' => 459,
                'user_id' => 1,
                'stock_tanggal' => '2025-02-01 10:30:00',
                'stock_jumlah' => 10,
            ],
            [   'stock_id' => 556,
                'barang_id' => 435,
                'user_id' => 1,
                'stock_tanggal' => '2025-02-01 10:30:00',
                'stock_jumlah' => 10,
            ],
        ];
        DB::table('m_stock')->insert($data);
    }
}

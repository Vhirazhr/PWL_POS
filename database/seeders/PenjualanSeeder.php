<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 101,
                'user_id' => 2,
                'pembeli' => 'Fatimah Qorin',
                'penjualan_kode' => 'ABC',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 102,
                'user_id' => 2,
                'pembeli' => 'Ahmad Rizki',
                'penjualan_kode' => 'ABC102',
                'penjualan_tanggal' => Carbon::today(), 
            ],
            [
                'penjualan_id' => 103,
                'user_id' => 2,
                'pembeli' => 'Siti Rahma',
                'penjualan_kode' => 'ABC103',
                'penjualan_tanggal' => Carbon::yesterday(),
            ],
            [
                'penjualan_id' => 104,
                'user_id' => 2,
                'pembeli' => 'Budi Santoso',
                'penjualan_kode' => 'ABC104',
                'penjualan_tanggal' => Carbon::today(),
            ],
            [
                'penjualan_id' => 105,
                'user_id' => 2,
                'pembeli' => 'Dewi Lestari',
                'penjualan_kode' => 'ABC105',
                'penjualan_tanggal' => Carbon::yesterday(),
            ],
            [
                'penjualan_id' => 106,
                'user_id' => 2,
                'pembeli' => 'Rizky Ramadhan',
                'penjualan_kode' => 'ABC106',
                'penjualan_tanggal' => Carbon::today(),
            ],
            [
                'penjualan_id' => 107,
                'user_id' => 2,
                'pembeli' => 'Nina Kartika',
                'penjualan_kode' => 'ABC107',
                'penjualan_tanggal' => Carbon::yesterday(),
            ],
            [
                'penjualan_id' => 108,
                'user_id' => 2,
                'pembeli' => 'Joko Susanto',
                'penjualan_kode' => 'ABC108',
                'penjualan_tanggal' => Carbon::today(),
            ],
            [
                'penjualan_id' => 109,
                'user_id' => 2,
                'pembeli' => 'Lina Sari',
                'penjualan_kode' => 'ABC109',
                'penjualan_tanggal' => Carbon::yesterday(),
            ],
            [
                'penjualan_id' => 110,
                'user_id' => 2,
                'pembeli' => 'Bagus Pratama',
                'penjualan_kode' => 'ABC110',
                'penjualan_tanggal' => Carbon::today(),
            ],
        ];

        DB::table('m_penjualan')->insert($data);
    }
}

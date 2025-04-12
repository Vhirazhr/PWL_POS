<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetailModel extends Model
{
    protected $table = 'm_penjualan_detail_table'; // tambahkan ini

    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = ['penjualan_id', 'barang_id', 'harga', 'jumlah'];

    public function penjualan()
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang()
{
    return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
}

}
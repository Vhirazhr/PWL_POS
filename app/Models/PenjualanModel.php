<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 'm_penjualan'; // 🛠️ Ini dia kuncinya
    protected $primaryKey = 'penjualan_id'; // optional tapi recommended

    protected $fillable = [
        'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function details()
{
    return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
}

}

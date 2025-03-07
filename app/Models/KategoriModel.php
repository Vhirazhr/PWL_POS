<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    public function user(): HasMany{
        return $this->hasMany(UserModel::class, 'barang_id', 'barang_id');
    }
}
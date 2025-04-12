<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

//model Eloquent di Laravel, yang mewakili tabel m_level di database.
class LevelModel extends Model
{
    use HasFactory;
    protected $table = "m_level";
    protected $primaryKey = "level_id";

    public function user(): HasMany {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];
    
}

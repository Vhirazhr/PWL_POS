<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


class UserModel extends Authenticatable implements JWTSubject 
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return[];
    }
    use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'image'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function level(){
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * Resolve profile photos saved by both the legacy public folder and
     * Laravel's public storage disk.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($image): ?string {
                if (!$image) {
                    return null;
                }

                // Preserve externally hosted profile images, if any.
                if (filter_var($image, FILTER_VALIDATE_URL)) {
                    return $image;
                }

                $path = ltrim(str_replace(chr(92), '/', trim($image)), '/');
                $path = preg_replace('#^(public/|storage/)#', '', $path);

                $candidates = [$path];

                // Older records may contain only the filename.
                if (!str_contains($path, '/')) {
                    $candidates[] = 'uploads/profile/'.$path;
                }

                foreach (array_unique($candidates) as $candidate) {
                    // New uploads are stored on Laravel's public disk.
                    if (Storage::disk('public')->exists($candidate)) {
                        return Storage::disk('public')->url($candidate);
                    }

                    // Older uploads were stored directly under public/.
                    if (is_file(public_path($candidate))) {
                        return asset($candidate);
                    }
                }

                // Let the view display its default avatar when the file is missing.
                return null;
            },
        );
    }

    public function getRouteKeyName()
{
    return 'user_id';
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('user_isolation', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check() && !auth()->user()->hasRole('Superadmin')) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    protected $fillable = [
        'user_id',
        'nama_media',
        'file_path',
        'tipe_media',
        'durasi',
    ];

    /**
     * Relasi ke User (Pemilik Media)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Gabungan (Many-to-Many)
     */
    public function gabungans(): BelongsToMany
    {
        return $this->belongsToMany(Gabungan::class, 'gabungan_media')
            ->withPivot('urutan')
            ->withTimestamps()
            ->using(GabunganMedia::class);
    }
}

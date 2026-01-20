<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gabungan extends Model
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

    protected $table = 'gabungan';

    protected $fillable = [
        'user_id',
        'nama_gabungan',
        'deskripsi',
        'jeda_detik',
    ];

    /**
     * Relasi ke User (Pemilik Gabungan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Media (Many-to-Many)
     */
    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'gabungan_media')
            ->withPivot('urutan')
            ->withTimestamps()
            ->using(GabunganMedia::class)
            ->orderBy('gabungan_media.urutan');
    }

    /**
     * Relasi ke Pivot GabunganMedia (Has-Many) untuk Repeater
     */
    public function gabunganMedia(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GabunganMedia::class, 'gabungan_id')
            ->orderBy('urutan');
    }

    /**
     * Relasi ke Outlet
     */
    public function outlets(): HasMany
    {
        return $this->hasMany(Outlet::class);
    }

    /**
     * Relasi ke Publish
     */
    public function publishes(): HasMany
    {
        return $this->hasMany(Publish::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outlet extends Model
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

    protected $table = 'outlet';

    protected $fillable = [
        'user_id',
        'kode_outlet',
        'nama_outlet',
        'gabungan_id',
        'status',
        'jadwal_mulai',
        'jadwal_selesai',
    ];

    protected $casts = [
        'jadwal_mulai' => 'datetime',
        'jadwal_selesai' => 'datetime',
    ];

    /**
     * Relasi ke User (Pemilik Outlet)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Gabungan
     */
    public function gabungan(): BelongsTo
    {
        return $this->belongsTo(Gabungan::class);
    }

    /**
     * Relasi ke Publish
     */
    public function publishes(): HasMany
    {
        return $this->hasMany(Publish::class);
    }
}

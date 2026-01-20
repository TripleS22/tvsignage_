<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publish extends Model
{
    use HasFactory;

    protected $table = 'publish';

    protected $fillable = [
        'outlet_id',
        'gabungan_id',
        'is_online',
        'last_ping',
        'published_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_ping' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Relasi ke Outlet
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Relasi ke Gabungan
     */
    public function gabungan(): BelongsTo
    {
        return $this->belongsTo(Gabungan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GabunganMedia extends Pivot
{
    protected $table = 'gabungan_media';
    public $incrementing = true;

    protected $fillable = [
        'gabungan_id',
        'media_id',
        'urutan',
    ];

    /**
     * Relasi ke Media (Belongs-To)
     */
    public function media(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    /**
     * Relasi ke Gabungan (Belongs-To)
     */
    public function gabungan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Gabungan::class, 'gabungan_id');
    }
}

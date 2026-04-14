<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananPerizinan extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'layanan_perizinan';

    protected $fillable = [
        'title',
        'icon',
        'link',
        'is_active',
        'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    // Scope untuk hanya menampilkan yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutkan berdasarkan position
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}

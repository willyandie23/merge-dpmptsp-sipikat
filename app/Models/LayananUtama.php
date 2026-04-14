<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananUtama extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'layanan_utama';

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'is_active',
        'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    // Opsional: Scope untuk hanya menampilkan yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Opsional: Urutkan berdasarkan position
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}

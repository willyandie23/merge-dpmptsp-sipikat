<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbup extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'perbup';

    protected $fillable = [
        'teks_perbup',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk hanya mengambil yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
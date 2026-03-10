<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MekanismePengaduan extends Model
{
    use HasFactory;

    protected $table = 'mekanisme_pengaduan';

    protected $fillable = [
        'name',
        'description',
        'image',
        'url',
        'position',
        'is_active',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean',
    ];
}

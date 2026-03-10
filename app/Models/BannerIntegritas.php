<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerIntegritas extends Model
{
    use HasFactory;

    protected $table = 'banner_integritas';

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

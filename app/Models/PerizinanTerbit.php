<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanTerbit extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'perizinan_terbit';

    protected $fillable = [
        'year',
        'triwulan',           // ← diganti dari 'month'
        'oss_rba',
        'sicantik_cloud',
        'simbg',
        'total_terbit',
    ];

    protected $casts = [
        'year' => 'integer',
        'triwulan' => 'integer',     // ← diganti
        'oss_rba' => 'integer',
        'sicantik_cloud' => 'integer',
        'simbg' => 'integer',
        'total_terbit' => 'integer',
    ];
}
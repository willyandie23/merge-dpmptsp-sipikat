<?php

namespace App\Models;

use App\Models\PeluangInvestasi;
use App\Models\Populasi;
use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory, ModelLog;

    protected $fillable = [
        'name',
        'id_populasi',
    ];

    public function populasi()
    {
        return $this->belongsTo(Populasi::class, 'id_populasi');
    }

    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class, 'id_kecamatan');
    }
}

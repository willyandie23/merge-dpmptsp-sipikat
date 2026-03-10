<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Populasi;
use App\Models\PeluangInvestasi;

class Kecamatan extends Model
{
    use HasFactory;

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kecamatan;
use App\Models\Sektor;

class PeluangInvestasi extends Model
{
    use HasFactory;

    protected $table = 'peluang_investasi';

    protected $fillable = [
        'title',
        'image',
        'description',
        'id_kecamatan',
        'id_sektor',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'id_sektor');
    }
}

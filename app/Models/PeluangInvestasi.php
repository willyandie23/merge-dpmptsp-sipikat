<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeluangInvestasi extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'peluang_investasi';

    protected $fillable = [
        'title',
        'image',
        'description',
        'kecamatan_id',     // <--- diubah dari id_kecamatan
        'sektor_id',        // <--- diubah dari id_sektor
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function sektor()
    {
        return $this->belongsTo(Sektor::class);
    }
}

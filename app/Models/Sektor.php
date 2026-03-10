<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProdukDomestik;
use App\Models\PeluangInvestasi;

class Sektor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_produk',
    ];

    public function produkDomestik()
    {
        return $this->belongsTo(ProdukDomestik::class, 'id_produk');
    }

    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class, 'id_sektor');
    }
}

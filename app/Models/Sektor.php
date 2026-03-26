<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'sektor';

    protected $fillable = ['name', 'kecamatan_id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function produkDomestik()
    {
        return $this->hasMany(ProdukDomestik::class);
    }

    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class);
    }

    // Accessor untuk Produk Domestik Terbaru
    public function getCurrentProdukDomestikAttribute()
    {
        $latest = $this->produkDomestik()->latest('year')->first();
        return $latest
            ? "Produk Domestik {$latest->year}: Rp " . number_format((float) $latest->amount, 2)
            : 'Belum ada data produk domestik';
    }
}

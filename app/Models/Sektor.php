<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'sektor';

    protected $fillable = [
        'name',
        // 'kecamatan_id' → dihapus karena sekarang independent
    ];

    // Relasi ke Peluang Investasi (tetap hasMany)
    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class, 'id_sektor');
    }

    // Relasi ke Kecamatan dihapus (karena tidak tergantung lagi)
    // public function kecamatan() { ... } → dihapus

    // Accessor untuk Produk Domestik (tetap dipertahankan)
    public function getCurrentProdukDomestikAttribute()
    {
        $latest = $this->produkDomestik()->latest('year')->first();
        return $latest
            ? "Produk Domestik {$latest->year}: Rp " . number_format((float) $latest->amount, 2)
            : 'Belum ada data produk domestik';
    }

    // Relasi ke Produk Domestik (jika masih ada)
    public function produkDomestik()
    {
        return $this->hasMany(ProdukDomestik::class);
    }
}
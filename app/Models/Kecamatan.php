<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'kecamatan';

    protected $fillable = [
        'name',
        'populasi_id',   // tetap
    ];

    // Relasi Populasi
    public function populasi()
    {
        return $this->hasMany(Populasi::class);
    }

    // Relasi ke Sektor dihapus karena Sektor sekarang independent
    // public function sektors() { ... } → dihapus

    // Relasi ke Peluang Investasi tetap ada
    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class, 'id_kecamatan');
    }

    public function getCurrentPopulasiAttribute()
    {
        $latest = $this->populasi()->latest('year')->first();
        return $latest
            ? "Populasi {$latest->year}: " . number_format($latest->amount) . " jiwa"
            : 'Belum ada data populasi';
    }
}
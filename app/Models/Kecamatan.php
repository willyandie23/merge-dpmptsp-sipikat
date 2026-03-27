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
        'populasi_id',        // lebih baik pakai ini (bukan id_populasi)
    ];

    // Relasi Populasi
    public function populasi()
    {
        return $this->hasMany(Populasi::class);   // ← hasMany (bukan belongsTo lagi)
    }

    public function sektors()
    {
        return $this->hasMany(Sektor::class);
    }

    // Relasi Peluang Investasi
    public function peluangInvestasi()
    {
        return $this->hasMany(PeluangInvestasi::class, 'kecamatan_id');
    }

    public function getCurrentPopulasiAttribute()
    {
        $latest = $this->populasi()->latest('year')->first();
        return $latest
            ? "Populasi {$latest->year}: " . number_format($latest->amount) . " jiwa"
            : 'Belum ada data populasi';
    }
}

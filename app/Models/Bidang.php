<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'bidang';

    protected $fillable = [
        'name',
        'position',
    ];

    // Relationship
    public function strukturOrganisasi()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'id_bidang');
    }

    // Pejabat Utama (is_pejabat = 1)
    public function pejabatUtama()
    {
        return $this->hasOne(StrukturOrganisasi::class, 'id_bidang')
            ->where('is_pejabat', 1);
    }

    // Staff Biasa (is_pejabat = 0)
    public function staff()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'id_bidang')
            ->where('is_pejabat', 0)
            ->orderBy('name');
    }

    // Total staff (termasuk pejabat)
    public function getTotalStaffAttribute()
    {
        return $this->strukturOrganisasi()->count();
    }
}

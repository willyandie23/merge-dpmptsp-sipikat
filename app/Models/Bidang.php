<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
    ];

    public function strukturOrganisasi()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'id_bidang');
    }
}

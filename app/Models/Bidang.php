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

    public function strukturOrganisasi()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'id_bidang');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bidang;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'name',
        'nip',
        'golongan',
        'image',
        'is_pejabat',
        'id_bidang',
    ];

    protected $casts = [
        'is_pejabat' => 'boolean',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang');
    }
}

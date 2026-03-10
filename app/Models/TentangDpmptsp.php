<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangDpmptsp extends Model
{
    use HasFactory;

    protected $table = 'tentang_dpmptsp';

    protected $fillable = [
        'description',
        'image',
        'dasar_hukum',
        'moto_layanan',
        'visi',
        'misi',
        'maklumat_layanan',
        'waktu_layanan',
        'alamat',
        'struktur_organisasi',
        'sasaran_layanan',
    ];
}

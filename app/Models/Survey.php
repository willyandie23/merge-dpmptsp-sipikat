<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'survey';

    protected $fillable = [
        'year',
        'triwulan',           // ← diganti dari month
        'jumlah_laki',
        'jumlah_perempuan',
        'indikator1',
        'indikator2',
        'indikator3',
        'indikator4',
        'indikator5',
        'indikator6',
        'indikator7',
        'indikator8',
        'indikator9',
    ];

    protected $casts = [
        'year'            => 'integer',
        'triwulan'        => 'integer',
        'jumlah_laki'     => 'integer',
        'jumlah_perempuan'=> 'integer',
        'indikator1'      => 'decimal:2',
        'indikator2'      => 'decimal:2',
        'indikator3'      => 'decimal:2',
        'indikator4'      => 'decimal:2',
        'indikator5'      => 'decimal:2',
        'indikator6'      => 'decimal:2',
        'indikator7'      => 'decimal:2',
        'indikator8'      => 'decimal:2',
        'indikator9'      => 'decimal:2',
    ];
}
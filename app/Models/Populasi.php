<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Populasi extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'populasi';

    protected $fillable = ['year', 'amount', 'kecamatan_id'];

    protected $casts = [
        'year' => 'integer',
        'amount' => 'integer',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}

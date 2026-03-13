<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Populasi extends Model
{
    use HasFactory, ModelLog;

    protected $fillable = [
        'year',
        'amount',
    ];

    protected $casts = [
        'year' => 'integer',
        'amount' => 'integer',
    ];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_populasi');
    }
}

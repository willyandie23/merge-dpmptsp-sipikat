<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDomestik extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'produk_domestik';

    protected $fillable = ['sektor_id', 'year', 'amount'];

    protected $casts = [
        'year' => 'integer',
        'amount' => 'decimal:2',
    ];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class);   // ← Perbaikan di sini
    }
}

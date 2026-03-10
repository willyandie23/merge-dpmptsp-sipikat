<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertumbuhanEkonomi extends Model
{
    use HasFactory;

    protected $table = 'pertumbuhan_ekonomi';

    protected $fillable = [
        'year',
        'amount',
    ];

    protected $casts = [
        'year' => 'integer',
        'amount' => 'decimal:2',   // misal 5.23%
    ];
}

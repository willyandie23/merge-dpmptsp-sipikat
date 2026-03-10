<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomoditasUnggulan extends Model
{
    use HasFactory;

    protected $table = 'komoditas_unggulan';

    protected $fillable = [
        'title',
        'image',
        'description',
    ];
}

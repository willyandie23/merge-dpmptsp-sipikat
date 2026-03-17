<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomoditasUnggulan extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'komoditas_unggulan';

    protected $fillable = [
        'title',
        'image',
        'description',
    ];
}

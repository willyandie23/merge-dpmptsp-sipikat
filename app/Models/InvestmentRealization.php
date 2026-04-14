<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentRealization extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'investment_realizations';

    protected $fillable = [
        'year',
        'quarter',
        'type',
        'realized_amount',
        'labor_absorbed',
    ];

    protected $casts = [
        'year'            => 'integer',
        'quarter'         => 'integer',
        'realized_amount' => 'integer',
        'labor_absorbed'  => 'integer',
    ];

    /**
     * Relasi ke Target Tahunan (sekarang target tidak punya type lagi)
     */
    public function target()
    {
        return $this->belongsTo(InvestmentTarget::class, 'year', 'year');
    }

    /**
     * Optional: Helper untuk menampilkan nama jenis dengan lebih bagus
     */
    public function getTypeNameAttribute()
    {
        return $this->type === 'PMA' ? 'Penanaman Modal Asing (PMA)' : 'Penanaman Modal Dalam Negeri (PMDN)';
    }
}
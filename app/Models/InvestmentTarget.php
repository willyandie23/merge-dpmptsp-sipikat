<?php

namespace App\Models;

use App\Traits\ModelLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentTarget extends Model
{
    use HasFactory, ModelLog;

    protected $table = 'investment_targets';

    protected $fillable = [
        'year',
        'quarter',
        'type',
        'target_amount',
    ];

    protected $casts = [
        'year' => 'integer',
        'quarter' => 'integer',
        'target_amount' => 'integer',
    ];

    /**
     * Relasi ke Realisasi
     */
    public function realizations()
    {
        return $this->hasMany(InvestmentRealization::class, 'year', 'year')
            ->whereColumn('investment_realizations.type', 'investment_targets.type')
            ->whereColumn('investment_realizations.quarter', 'investment_targets.quarter');
    }
}

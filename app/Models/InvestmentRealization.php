<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentRealization extends Model
{
    use HasFactory;

    protected $table = 'investment_realizations';

    protected $fillable = [
        'year',
        'quarter',
        'type',
        'realized_amount',
        'labor_absorbed',
    ];

    protected $casts = [
        'year' => 'integer',
        'quarter' => 'integer',
        'realized_amount' => 'integer',
        'labor_absorbed' => 'integer',
    ];

    /**
     * Relasi ke Target
     */
    public function target()
    {
        return $this->belongsTo(InvestmentTarget::class, 'year', 'year')
            ->whereColumn('investment_targets.quarter', 'investment_realizations.quarter')
            ->whereColumn('investment_targets.type', 'investment_realizations.type');
    }
}

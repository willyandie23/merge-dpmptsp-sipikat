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
        'target_amount',
    ];

    protected $casts = [
        'year'          => 'integer',
        'target_amount' => 'integer',
    ];

    /**
     * Relasi ke Realisasi (satu target tahunan punya banyak realisasi PMA & PMDN)
     */
    public function realizations()
    {
        return $this->hasMany(InvestmentRealization::class, 'year', 'year');
    }

    /**
     * Optional: Helper untuk mendapatkan total realisasi tahun ini
     */
    public function getTotalRealizationAttribute()
    {
        return $this->realizations()->sum('realized_amount');
    }

    /**
     * Optional: Helper untuk mendapatkan persentase capaian
     */
    public function getAchievementPercentageAttribute()
    {
        if ($this->target_amount == 0) return 0;
        
        return round(($this->total_realization / $this->target_amount) * 100, 2);
    }
}
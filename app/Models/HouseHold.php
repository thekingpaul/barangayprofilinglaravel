<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHold extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'household_no',
        'household_head',
        'purok',
        'address',
        'house_ownership',
        'house_type',
        'electricity',
        'monthly_income',
        'livelihood',
        'beneficiaries',
        'disaster_risk',
    ];

    protected $casts = [
        'electricity' => 'boolean',
        'monthly_income' => 'float',
        'beneficiaries' => 'array',
        'disaster_risk' => 'array',
    ];

    /**
     * Get the residents for the household.
     */
    public function residents()
    {
        return $this->hasMany(Resident::class, 'house_hold_id');
    }

    /**
     * Get formatted monthly income
     */
    public function getFormattedIncomeAttribute()
    {
        return '₱'.number_format((float) ($this->monthly_income ?? 0), 2);
    }

    /**
     * Mutator to ensure monthly_income is always float
     */
    public function setMonthlyIncomeAttribute($value)
    {
        $this->attributes['monthly_income'] = $value ? (float) $value : null;
    }
}

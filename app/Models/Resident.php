<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'household_no',
        'house_hold_id',
        'firstname',
        'middlename',
        'lastname',
        'alias',
        'birthday',
        'age',
        'gender',
        'civil_status',
        'voter_status',
        'birth_of_place',
        'citizenship',
        'mobile_no',
        'height',
        'weight',
        'email',
        'father',
        'mother',
    ];

    protected $casts = [
        'birthday' => 'date',
        'age' => 'integer',
    ];

    // Relationship with HouseHold
    // public function houseHold()
    // {
    //     return $this->belongsTo(HouseHold::class, 'household_no', 'id');
    //     // assuming 'household_no' is the foreign key in residents table
    // }

    public function houseHold()
    {
        return $this->belongsTo(HouseHold::class);
        // assuming 'household_no' is the foreign key in residents table
    }

    // Accessor to get full name
    public function getFullNameAttribute(): string
    {
        return trim($this->firstname.' '.$this->middlename.' '.$this->lastname);
    }

    // Accessor to get full name without middle name
    public function getShortNameAttribute(): string
    {
        return trim($this->firstname.' '.$this->lastname);
    }

    // Scope for filtering by gender
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    // Scope for filtering by voter status
    public function scopeVoters($query)
    {
        return $query->where('voter_status', 'Registered');
    }

    // Scope for filtering by civil status
    public function scopeByCivilStatus($query, $status)
    {
        return $query->where('civil_status', $status);
    }

    public function getPurokAttribute()
    {
        return $this->houseHold?->purok;
    }

    public static function getTableQuery(): EloquentBuilder
    {
        return parent::getTableQuery()->with('houseHold');
    }
}

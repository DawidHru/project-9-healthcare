<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Insurance extends Model
{

    protected $fillable = [
        'patient_id',
        'provider',
        'policy_number',
        'start_date',
        'end_date',
        'coverage_details'
    ];

    protected $casts = [
        'coverage_details' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    protected $appends = ['coverage_percentage'];

    public function getCoveragePercentageAttribute()
    {
        if (!$this->coverage_details) {
            return 0;
        }

        $totalServices = 12; // Total number of possible services
        $coveredServices = count(array_filter($this->coverage_details, function ($value) {
            return $value === true;
        }));

        return round(($coveredServices / $totalServices) * 100);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}

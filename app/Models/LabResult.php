<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'lab_technician_id',
        'test_name',
        'test_category',
        'result_value',
        'reference_range',
        'is_abnormal',
        'doctor_notes',
        'interpretation',
        'status',
        'test_date'
    ];

    protected $casts = [
        'is_abnormal' => 'boolean',
        'test_date' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function labTechnician()
    {
        return $this->belongsTo(LabTechnician::class);
    }
}

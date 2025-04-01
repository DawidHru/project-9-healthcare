<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTechnician extends Model
{
    use SoftDeletes;

    protected $fillable = ['staff_id', 'certification'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class, 'lab_technician_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Staff::class);
    }
}

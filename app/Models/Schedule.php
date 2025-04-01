<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'doctor_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function isAvailable($startTime, $endTime)
    {
        return !$this->where('start_time', '<=', $endTime)
            ->where('end_time', '>=', $startTime)
            ->exists();
    }
}

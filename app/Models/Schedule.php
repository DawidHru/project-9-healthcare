<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'staff_id',
        'start_time',
        'end_time',
        'shift_type'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function isAvailable($startTime, $endTime)
    {
        return !$this->where('start_time', '<=', $endTime)
            ->where('end_time', '>=', $startTime)
            ->exists();
    }
}

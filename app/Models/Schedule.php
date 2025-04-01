<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'staff_id'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

<<<<<<< HEAD
    public function department()
    {
        return $this->belongsTo(Department::class);
=======
    public function isAvailable($startTime, $endTime)
    {
        return !$this->where('start_time', '<=', $endTime)
            ->where('end_time', '>=', $startTime)
            ->exists();
>>>>>>> 9d34e96279d375f00c4c2fe3a3b91f47593c3fb0
    }
}

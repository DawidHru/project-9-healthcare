<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'location'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}

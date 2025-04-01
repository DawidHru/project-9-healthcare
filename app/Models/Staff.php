<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'department_id',
        'employee_id',
        'phone',
        'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function labTechnician()
    {
        return $this->hasOne(LabTechnician::class);
    }

    public function inventoryManager()
    {
        return $this->hasOne(InventoryManager::class);
    }
}

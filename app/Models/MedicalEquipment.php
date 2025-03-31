<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalEquipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'type', 'serial_number', 'purchase_date',
        'last_maintenance', 'next_maintenance', 'status',
        'location'
    ];

    protected $dates = [
        'purchase_date', 'last_maintenance', 'next_maintenance'
    ];

    public function reservations()
    {
        return $this->hasMany(EquipmentReservation::class, 'equipment_id');
    }

    public function activeReservation()
    {
        return $this->hasOne(EquipmentReservation::class)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('status', 'approved');
    }
}
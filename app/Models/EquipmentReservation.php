<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'staff_id', 'equipment_id', 'start_time', 
        'end_time', 'purpose', 'status', 'notes'
    ];

    protected $dates = ['start_time', 'end_time'];

    public function equipment()
    {
        return $this->belongsTo(MedicalEquipment::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
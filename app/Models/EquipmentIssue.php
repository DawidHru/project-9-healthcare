<?php

// app/Models/EquipmentIssue.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'reported_by',
        'description',
        'severity',
        'status',
        'resolution_notes',
        'resolved_by',
        'resolved_at'
    ];

    public function equipment()
    {
        return $this->belongsTo(MedicalEquipment::class);
    }

    public function reporter()
    {
        return $this->belongsTo(Staff::class, 'reported_by');
    }

    public function resolver()
    {
        return $this->belongsTo(Staff::class, 'resolved_by');
    }
}
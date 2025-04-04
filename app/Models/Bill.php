<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'insurance_id',
        'amount',
        'remaining_balance',
        'status',
        'due_date',
        'description',
        'procedure'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->paymentTransactions->sum('amount');
    }

    public function getRemainingBalanceAttribute()
    {
        return $this->amount - $this->total_paid;
    }

    public function isFullyPaid()
    {
        return $this->remaining_balance <= 0;
    }

    public function isOverdue()
    {
        return $this->due_date < now() && !$this->isFullyPaid();
    }
}

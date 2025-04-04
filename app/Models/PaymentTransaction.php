<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'bill_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}

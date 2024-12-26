<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxPayment extends Model
{
    use HasFactory;

    protected $table = 'tax_payments';

    protected $fillable = [
        'vehicle_id',
        'payment_date',
        'payment_amount',
        'payment_method',
        'payment_status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}

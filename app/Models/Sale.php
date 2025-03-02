<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'total_amount',
        'payment_method',
    ];

    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship with Sale Items
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relationship with Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

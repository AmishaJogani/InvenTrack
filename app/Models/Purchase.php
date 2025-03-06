<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'total_amount',
        'purchase_date'
    ];

      // Relationship with Supplier
      public function supplier()
      {
          return $this->belongsTo(Supplier::class);
      }
  
      // Relationship with Purchase Items
      public function items()
      {
          return $this->hasMany(PurchaseItem::class);
      }
}

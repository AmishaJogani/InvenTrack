<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'total_amount',
    ];

      // Relationship with Supplier
      public function supplier()
      {
          return $this->belongsTo(Supplier::class);
      }
  
      // Relationship with Purchase Items
      public function purchaseItems()
      {
          return $this->hasMany(PurchaseItem::class);
      }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'selling_price'
    ];

      // Relationship with Sale
      public function sale()
      {
          return $this->belongsTo(Sale::class);
      }
  
      // Relationship with Product
      public function product()
      {
          return $this->belongsTo(Product::class);
      }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'price',
        'description',
        'unit',
        'low_stock_alert'
    ];

   // Relationship with Category
   public function category()
   {
       return $this->belongsTo(Category::class);
   }

   // Relationship with Supplier
   public function supplier()
   {
       return $this->belongsTo(Supplier::class);
   }

   public function brand()
   {
    return $this->belongsTo(Brand::class);
   }
}

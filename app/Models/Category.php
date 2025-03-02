<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
    ];
     // Relationship with Subcategories
     public function subcategories()
     {
         return $this->hasMany(Category::class, 'parent_id');
     }
 
     // Relationship with Parent Category
     public function parent()
     {
         return $this->belongsTo(Category::class, 'parent_id');
     }
 
     // Relationship with Products
     public function products()
     {
         return $this->hasMany(Product::class);
     }


}

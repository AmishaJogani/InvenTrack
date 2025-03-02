<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'email',
        'address'
    ];

     // Relationship with Products
     public function products()
     {
         return $this->hasMany(Product::class);
     }
}

<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class ProductCreate extends Component
{
    public $category_id , $brand_id , $name , $price , $description , $unit , $low_stock_alert;
    public function render()
    {
        return view('livewire.products.product-create',['categories'=>Category::all() , 'brands'=>Brand::all()]);
    }

    public function save(){
        
        
        $validated = $this->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required',
            'description' => 'required|max:500',
            'unit' => 'required|int',
            'low_stock_alert' => 'required|int',
        ]);

        Product::create([
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'unit' => $this->unit,
            'low_stock_alert' => $this->low_stock_alert,
        ]);

        session()->flash('success', 'Product created successfully.');
        $this->reset(['category_id','brand_id','name','price','description','unit','low_stock_alert']);
    }
}

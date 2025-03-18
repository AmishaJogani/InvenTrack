<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-layout')]
class ProductCreate extends Component
{
    use WithFileUploads;
    public $category_id, $brand_id, $name, $price, $description, $unit, $low_stock_alert;
    public $images = [];
    public function render()
    {
        return view('livewire.products.product-create', ['categories' => Category::all(), 'brands' => Brand::all()]);
    }

    public function save()
    {


        $validated = $this->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required',
            'description' => 'required|max:500',
            'unit' => 'required|int',
            'low_stock_alert' => 'required|int',
            'images' => 'array|max:5', // Validation for images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Validation for images
        ]);

        $product =  Product::create([
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'unit' => $this->unit,
            'low_stock_alert' => $this->low_stock_alert,
        ]);

        // Handle image uploads
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                // Generate a meaningful filename
                $filename = Str::slug($this->name) . '-' . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('product_images',$filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        session()->flash('success', 'Product created successfully.');
        $this->reset(['category_id', 'brand_id', 'name', 'price', 'description', 'unit', 'low_stock_alert', 'images']);
    }
}

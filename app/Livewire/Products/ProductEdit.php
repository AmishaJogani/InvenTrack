<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Livewire;

#[Layout('layouts.admin-layout')]
class ProductEdit extends Component
{
    public  $id, $name, $price, $description, $unit, $low_stock_alert, $category_id, $brand_id;
    public $categories = [];
    public $brands = [];

    public function mount($id)
    {
        $product = Product::findOrFail($id);
        $this->name = $product->name;
        $this->id = $product->id;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->unit = $product->unit;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }
    public function render()
    {
        return view('livewire.products.product-edit');
    }

    public function update()
    {
        $validated = $this->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($this->id)
            ],
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:500',
            'unit' => 'required|integer|min:1',
            'low_stock_alert' => 'nullable|integer|min:0',
        ]);
        $product = Product::findOrFail($this->id);
        $product->update($validated);

           // Check for low stock and notify admin
           if ($product->unit <= $product->low_stock_alert) {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Log::info("Sending Low Stock Alert for: " . $product->name);
                $admin->notify(new LowStockAlert($product));
                $this->dispatch('stockUpdated');
            }
        }

        session()->flash('success', 'Product updated successfully!');
        $this->reset(['category_id','brand_id','name','price','description','unit','low_stock_alert']);
    }
}

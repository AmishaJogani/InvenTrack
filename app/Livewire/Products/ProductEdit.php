<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-layout')]
class ProductEdit extends Component
{
    use WithFileUploads;
    public  $id, $name, $price, $description, $unit, $low_stock_alert, $category_id, $brand_id, $product;
    public $images = []; // New images to be uploaded
    public $existingImages = []; // Images already stored in DB

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
        $this->low_stock_alert = $product->low_stock_alert;
        $this->categories = Category::all();
        $this->brands = Brand::all();

        // Load existing images
        $this->existingImages = ProductImage::where('product_id', $this->id)
            ->pluck('image_path')
            ->toArray();
    }

    public function updatedImages()
    {
        // Ensure only 5 images are allowed at a time
        if (count($this->images) > 5) {
            $this->images = array_slice($this->images, 0, 5);
            session()->flash('error', 'You can upload a maximum of 5 images.');
        }
    }

    public function deleteExistingImage($imagePath)
    {
        // Find and delete the image from the database
        $image = ProductImage::where('image_path', $imagePath)->first();
        if ($image) {
            Storage::disk('public')->delete($image->image_path); // Delete from storage
            $image->delete(); // Delete from DB
        }

        // Refresh the images list
        $this->existingImages = ProductImage::where('product_id', $this->id)->pluck('image_path')->toArray();
    }
    public function deleteNewImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images); // Reset array keys
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
            'images' => 'array|max:5', // Validation for images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Validation for images
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

        if ($this->images) {
            foreach ($this->images as $image) {
                $imagePath = $image->store('product_images', 'public');

                ProductImage::create([
                    'product_id' => $this->id,
                    'image_path' => $imagePath,
                ]);
            }
        }


        session()->flash('success', 'Product updated successfully!');
        $this->reset(['category_id', 'brand_id', 'name', 'price', 'description', 'unit', 'low_stock_alert', 'images']);
        // Clear existing images preview as well
        $this->existingImages = [];
    }
}

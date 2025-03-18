<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class ProductIndex extends Component
{
    use WithPagination;
    protected $listeners = ['refreshProductList' => 'render'];
    public $search = ''; // Search query
    public $selectedProductImages = [];
    public function showImages($productId)
    {
        $this->selectedProductImages = ProductImage::where('product_id', $productId)->pluck('image_path')->toArray();
        // Correct method for Livewire 3
        $this->dispatch('show-image-modal');
    }

    public function deleteImage($imagePath)
    {
        // Find the image in the database
        $image = ProductImage::where('image_path', $imagePath)->first();
    
        if ($image) {
            // Delete the image file from storage
            Storage::disk('public')->delete($image->image_path);
    
            // Delete the image record from the database
            $image->delete();
    
            // Remove the deleted image from the selected images array
            $this->selectedProductImages = array_values(array_diff($this->selectedProductImages, [$imagePath]));
    
            // Dispatch success message
            $this->dispatch('imageDeleted', ['message' => 'Image deleted successfully!']);
        }
    }
    

    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        // Log::info('Current search query: ' . $this->search); // Debugging

        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('category', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('brand', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        // Log::info('Products found: ' . $products->count()); // Debugging

        return view('livewire.products.product-index', compact('products'));
    }


    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted successfully.');
    }
}

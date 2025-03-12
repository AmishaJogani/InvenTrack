<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class ProductIndex extends Component
{
    use WithPagination;
    protected $listeners = ['refreshProductList' => 'render'];
    public $search = ''; // Search query
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

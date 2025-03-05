<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class ProductIndex extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.products.product-index',['products'=>Product::paginate(5)]);
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted successfully.');

    }
}

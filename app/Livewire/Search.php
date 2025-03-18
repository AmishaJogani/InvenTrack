<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class Search extends Component
{
    public $query = '';
    public $products = [];
    public $suppliers = [];
    public $perPage = 5; // Matches listing page pagination

    public function updatedQuery()
    {
        $this->search();
    }

    public function getProductPageNumber($productId)
    {
        $position = Product::where('id', '<=', $productId)->count();
        return ceil($position / $this->perPage);
    }

    public function search()
    {
        if (strlen($this->query) > 1) {
            $this->products = Product::where('name', 'like', '%' . $this->query . '%')->orderBy('id')->limit(5)->get();
            $this->suppliers = Supplier::where('name', 'like', '%' . $this->query . '%')->orderBy('id')->limit(5)->get();
        } else {
            $this->products = [];
            $this->suppliers = [];
        }
    }

    public function render()
    {
        $this->search(); // Important line added here
        return view('livewire.search');
    }
}

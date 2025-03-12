<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class BrandsIndex extends Component
{
use WithPagination;
public $search = ''; // Search query

protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $brands = Brand::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.brands.brands-index', compact('brands'));
    }

    public function delete($id){
        $brand = Brand::findOrFail($id);
        $brand->delete();

    session()->flash('success', 'Brand deleted successfully.');
    }
}

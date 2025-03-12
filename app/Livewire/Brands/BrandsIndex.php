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
    public function render()
    {
        return view('livewire.brands.brands-index',['brands' => Brand::paginate(10)]);
    }

    public function delete($id){
        $brand = Brand::findOrFail($id);
        $brand->delete();

    session()->flash('success', 'Brand deleted successfully.');
    }
}

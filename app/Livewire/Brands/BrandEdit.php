<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class BrandEdit extends Component
{
   public $name , $id;
    public function mount($id){
        $brand = Brand::findOrFail($id);
        $this->name = $brand->name;
        $this->id = $brand->id;
    }
    public function render()
    {
        return view('livewire.brands.brand-edit');
    }

    public function update(){
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);
        $brand = Brand::findOrFail($this->id);
        $brand->update($validated);

        session()->flash('success', 'Brand updated successfully!');
        $this->reset(['name']);
    }
}

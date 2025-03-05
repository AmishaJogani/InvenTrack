<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class BrandCreate extends Component
{
    public $name;
    public function render()
    {
        return view('livewire.brands.brand-create');
    }

    public function save(){
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        Brand::create([
            'name' => $this->name
        ]);
        session()->flash('success', 'Brand created successfully.');
        $this->reset(['name']);
    }
}

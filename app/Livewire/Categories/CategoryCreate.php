<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class CategoryCreate extends Component
{
    public $name , $parent_id=null;
    public function render()
    {
        return view('livewire.categories.category-create' , ['categories' => Category::all()]);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create([
            'name' => $this->name,
            'parent_id' => $this->parent_id
        ]);

        session()->flash('success', 'Category created successfully.');
        $this->reset(['name', 'parent_id']);
    }
}

<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class CategoryEdit extends Component
{
    public $categories = [], $name, $parent_id, $id;

    public function mount($id)
    {

        $category = Category::findOrFail($id);
        $this->name = $category->name;
        $this->id = $category->id;
        $this->parent_id = $category->parent_id;
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.categories.category-edit');
    }

    public function update(){
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($this->id);
        $category->update($validated);

        session()->flash('success', 'Category updated successfully!');

    }
}

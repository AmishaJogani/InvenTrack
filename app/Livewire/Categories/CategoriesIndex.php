<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class CategoriesIndex extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.categories.categories-index' , ['categories' => Category::paginate(10)]);
    }

    public function delete($id){
        $category = Category::findOrFail($id);

        if($category->subcategories()->count() > 0){
            session()->flash('error', 'Cannot delete category with subcategories.');
        return;
        }

        $category->delete();
    }


}

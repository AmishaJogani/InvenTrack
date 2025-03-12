<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class CategoriesIndex extends Component
{
    use WithPagination;
    public $search = ''; // Search query

    protected $queryString = ['search']; // Keeps search term in the URL

    public function updatingSearch()
    {
        // Log::info('Search input is being updated: ' . $this->search);
        $this->resetPage(); // Reset pagination on search
    }
    public function render()
    {
        // Debugging: Check if search is updating in Livewire logs
        // Log::info('Search query: ' . $this->search);
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.categories.categories-index', compact('categories'));
    }


    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->subcategories()->count() > 0) {
            session()->flash('error', 'Cannot delete category with subcategories.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Category deleted successfully.');
    }
}

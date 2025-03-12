<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class SupplierIndex extends Component
{
    use WithPagination;
    public $search = ''; // Search query
    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('contact', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.suppliers.supplier-index', compact('suppliers'));
    }

    public function delete($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        session()->flash('success', 'Supplier deleted successfully.');
    }
}

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
    public function render()
    {
        return view('livewire.suppliers.supplier-index',['suppliers'=>Supplier::paginate(5)]);
    }

    public function delete($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        session()->flash('success', 'Supplier deleted successfully.');
    }
}

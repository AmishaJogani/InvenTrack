<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class SupplierEdit extends Component
{
    public $id, $name, $email, $contact,$address;
    public function mount($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->name = $supplier->name;
        $this->id = $supplier->id;
        $this->contact = $supplier->contact;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
    }
    public function render()
    {
        return view('livewire.suppliers.supplier-edit');
    }

    public function update(){
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'contact' => ['required','regex:/^[0-9]{10}$/' , Rule::unique('suppliers','contact')->ignore($this->id)],
            'email' => ['required','email','max:255' , Rule::unique('suppliers','email')->ignore($this->id)],
            'address' => 'required|string|max:500',
        ]);

        $supplier = Supplier::findOrFail($this->id);
        $supplier->update($validated);

        session()->flash('success', 'Supplier updated successfully.');
        $this->reset(['name','contact','email','address']);

    }
}

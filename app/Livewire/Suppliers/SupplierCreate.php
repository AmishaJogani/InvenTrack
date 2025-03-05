<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class SupplierCreate extends Component
{
    public $name, $contact, $email, $address;

    public function render()
    {
        return view('livewire.suppliers.supplier-create');
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'address' => 'required|string|max:500',
        ]);

        Supplier::create([
            'name' => $this->name,
            'contact' => $this->contact,
            'email' => $this->email,
            'address' => $this->address
        ]);
        session()->flash('success', 'Supplier created successfully.');
        $this->reset(['name','contact','email','address']);

    }
}

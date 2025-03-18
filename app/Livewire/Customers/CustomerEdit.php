<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class CustomerEdit extends Component
{
    public $id , $name ,$contact , $email , $address;

    public function mount($id)
    {
        $customer = Customer::find($id);
        $this->id = $customer->id;
        $this->name = $customer->name;
        $this->contact = $customer->contact;
        $this->email = $customer->email;
        $this->address = $customer->address;
    }

    public function update()
    {
       $validates = $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $customer = Customer::find($this->id);
    $customer->update($validates);
    session()->flash('success', 'Customer Updated Successfully');
    $this->reset(['name','contact','email','address']);
    }
    public function render()
    {
        return view('livewire.customers.customer-edit');
    }
}

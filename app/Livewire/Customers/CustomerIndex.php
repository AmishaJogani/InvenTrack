<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class CustomerIndex extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.customers.customer-index',['customers'=>Customer::paginate(10)]);
    }
}

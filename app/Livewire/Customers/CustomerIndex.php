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
    public $search = ''; // Search query
    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $customers = Customer::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->orWhere('contact', 'like', '%' . $this->search . '%')
        ->orWhere('address', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.customers.customer-index',compact('customers'));
    }
}

<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.admin-layout')]
class SalesIndex extends Component
{
    use WithPagination;
    public $search = ''; // Search query
    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $sales = Sale::whereHas('customer', function($query){
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate(10);
        return view('livewire.sales.sales-index', compact('sales'));
    }
}

<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class PurchaseIndex extends Component
{
    use WithPagination;
    public $search = ''; // Search query    
    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $purchases = Purchase::whereHas('supplier', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('purchase_date', 'like', '%' . $this->search . '%');
        })
            ->paginate(10);

        return view('livewire.purchases.purchase-index', compact('purchases'));
    }
}

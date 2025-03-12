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
    public function render()
    {
        return view('livewire.purchases.purchase-index',['purchases'=>Purchase::paginate(10)]);
    }
}

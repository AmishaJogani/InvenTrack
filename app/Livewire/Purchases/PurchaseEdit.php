<?php

namespace App\Livewire\Purchases;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class PurchaseEdit extends Component
{
    public function render()
    {
        return view('livewire.purchases.purchase-edit');
    }
}

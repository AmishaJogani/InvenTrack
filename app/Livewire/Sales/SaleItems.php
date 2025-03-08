<?php

namespace App\Livewire\Sales;

use App\Models\SaleItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class SaleItems extends Component
{
    public function render()
    {
        return view('livewire.sales.sale-items',['saleitems'=>SaleItem::paginate(10)]);
    }
}

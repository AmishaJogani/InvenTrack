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
    public function render()
    {
        return view('livewire.sales.sales-index',['sales'=>Sale::paginate(10)]);
    }
}

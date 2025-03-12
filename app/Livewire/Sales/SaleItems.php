<?php

namespace App\Livewire\Sales;

use App\Models\SaleItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class SaleItems extends Component
{
    public $search = ''; // Search query
    protected $queryString = ['search']; // Keeps search term in the URL
    public function render()
    {
        $saleitems = SaleItem::whereHas('product' , function($query){
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate(10);
        return view('livewire.sales.sale-items', compact('saleitems'));
    }
}

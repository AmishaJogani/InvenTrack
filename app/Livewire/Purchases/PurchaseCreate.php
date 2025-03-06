<?php

namespace App\Livewire\Purchases;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.admin-layout')]
class PurchaseCreate extends Component
{
    public $supplier_id;
    public $purchase_date;

    public $items = [
        ['product_id' => null, 'quantity' => 1, 'cost_price' => 0],
    ];

    public $suppliers = [];
    public $products = [];

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->products = Product::all();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => null, 'quantity' => 1, 'cost_price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Re-index array after removing
    }

    public function resetForm()
{
    $this->supplier_id = null;
    $this->purchase_date = null;
    $this->items = [
        ['product_id' => null, 'quantity' => 1, 'cost_price' => 0],
    ];
}


    public function save()
    {
        $validated = $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date', 
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $purchase = Purchase::create([
                'supplier_id' => $this->supplier_id,
                'total_amount' => 0,
                'purchase_date' => $this->purchase_date
            ]);

            $totalAmount = 0;

            foreach ($this->items as $item) {
                $lineTotal = $item['quantity'] * $item['cost_price'];
                $totalAmount += $lineTotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                ]);

                // Optionally update product stock
                Product::where('id', $item['product_id'])->increment('unit', $item['quantity']);
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        session()->flash('success', 'Purchase created successfully.');
        $this->reset(['supplier_id', 'purchase_date']);
        $this->items = [
            ['product_id' => null, 'quantity' => 1, 'cost_price' => 0],
        ];
    }



    public function render()
    {
        return view('livewire.purchases.purchase-create');
    }
}

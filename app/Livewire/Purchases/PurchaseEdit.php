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
class PurchaseEdit extends Component
{
    public $purchaseId;

    public $supplier_id;
    public $purchase_date;
    public $items = [];

    public $suppliers = [];
    public $products = [];

    public function mount($purchaseId)
    {
        $this->purchaseId = $purchaseId;

        // Load suppliers & products
        $this->suppliers = Supplier::all();
        $this->products = Product::all();

        // Load purchase and items
        $purchase = Purchase::with('items')->findOrFail($purchaseId);
        $this->supplier_id = $purchase->supplier_id;
        $this->purchase_date = $purchase->purchase_date;

        $this->items = $purchase->items->map(function ($item) {
            return [
                'id' => $item->id, // Important to track existing purchase item
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'cost_price' => $item->cost_price,
            ];
        })->toArray();
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ];
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => null, // New item
            'product_id' => null,
            'quantity' => 1,
            'cost_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        $item = $this->items[$index];

        if (!empty($item['id'])) {
            // Existing item - restore stock for removed item
            Product::where('id', $item['product_id'])->decrement('unit', $item['quantity']);

            // Remove from DB (optional - depends on your logic)
            PurchaseItem::destroy($item['id']);
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex after removal
        $this->resetValidation(); // Clear any validation errors
    }

    public function update()
    {
        $this->validate();

        DB::transaction(function () {
            $purchase = Purchase::findOrFail($this->purchaseId);
            $purchase->update([
                'supplier_id' => $this->supplier_id,
                'purchase_date' => $this->purchase_date,
            ]);

            $existingItems = PurchaseItem::where('purchase_id', $this->purchaseId)->get()->keyBy('id');

            $totalAmount = 0;

            foreach ($this->items as $item) {
                $lineTotal = $item['quantity'] * $item['cost_price'];
                $totalAmount += $lineTotal;

                if (!empty($item['id'])) {
                    // Update existing item
                    $oldItem = $existingItems[$item['id']] ?? null;

                    if ($oldItem) {
                        $quantityDiff = $item['quantity'] - $oldItem->quantity;

                        $oldItem->update([
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'cost_price' => $item['cost_price'],
                        ]);

                        // Update stock based on quantity change
                        Product::where('id', $item['product_id'])->increment('unit', $quantityDiff);
                    }
                } else {
                    // New item - create and adjust stock
                    PurchaseItem::create([
                        'purchase_id' => $this->purchaseId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'cost_price' => $item['cost_price'],
                    ]);

                    Product::where('id', $item['product_id'])->increment('unit', $item['quantity']);
                }
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        session()->flash('success', 'Purchase updated successfully.');
        $this->reset(['supplier_id', 'purchase_date']);
        $this->items = [
            ['product_id' => null, 'quantity' => 1, 'cost_price' => 0],
        ];
       
    }

    public function render()
    {
        return view('livewire.purchases.purchase-edit');
    }
}

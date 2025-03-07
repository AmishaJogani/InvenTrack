<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class CreateBill extends Component
{
    public $searchTerm;
    public $customer = [];
    public $cart = [];
    public $products = [];
    public $payment_method = 'Cash';
    public $split_payments = [];
    public $total_amount = 0;
    public $invoice_url = null;

    public function mount()
    {
        $this->products = Product::all();
        $this->cart = [];  // Ensure cart is an array
    }

    public function searchCustomer()
    {
        $this->customer = Customer::where('contact', $this->searchTerm)
            ->orWhere('email', $this->searchTerm)
            ->first()?->toArray() ?? [];

        if (!$this->customer) {
            session()->flash('info', 'Customer not found. Please fill the details.');
            if (filter_var($this->searchTerm, FILTER_VALIDATE_EMAIL)) {
                $this->customer['email'] = $this->searchTerm;
            } else {
                $this->customer['contact'] = $this->searchTerm;
            }
        }
    }

    public function addToCart($productId)
    {
        if (!$productId) return;

        $product = Product::find($productId);

        foreach ($this->cart as &$item) {
            if ($item['id'] == $product->id) {
                $item['quantity']++;
                $this->recalculateRowTotal($item);
                return;
            }
        }

        $this->cart[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price, // price from product table
            'quantity' => 1,
            'total' => $product->price,
        ];

        $this->calculateTotal();
    }

    public function recalculateRowTotal(&$item)
    {
        $item['total'] = $item['quantity'] * $item['price'];
        $this->calculateTotal();
    }

    public function updateQuantity($index)
    {
        $this->cart[$index]['quantity'] = max(1, intval($this->cart[$index]['quantity']));
        $this->recalculateRowTotal($this->cart[$index]);
    }


    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_amount = collect($this->cart)->sum('total');
    }

    public function processSale()
    {
        $this->validate([
            'customer.name' => 'required',
            'customer.contact' => 'nullable|required|unique:customers,contact',
            'customer.email' => 'email|unique:customers,email',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::where('contact', $this->customer['contact'])
                ->orWhere('email', $this->customer['email'])
                ->first();

            if (!$customer) {
                $customer = Customer::create($this->customer);
            } else {
                // Update existing customer details if needed
                $customer->update($this->customer);
            }

            $sale = Sale::create([
                'customer_id' => $customer->id,
                'total_amount' => $this->total_amount,
                'payment_method' => $this->payment_method,
            ]);

            foreach ($this->cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'selling_price' => $item['price'],
                ]);
                Product::where('id', $item['id'])->decrement('unit', $item['quantity']);
            }

            Payment::create([
                'sale_id' => $sale->id,
                'payment_method' => $this->payment_method,
                'amount_paid' => $this->total_amount,
            ]);
            // pdf logic here
            DB::commit();

            $this->reset(['searchTerm', 'customer', 'cart', 'total_amount', 'payment_method']);
            session()->flash('success', 'Sale completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Sale failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.sales.create-bill');
    }
}

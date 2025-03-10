<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

#[Layout('layouts.admin-layout')]
class CreateBill extends Component
{
    public $searchTerm;
    public $selectedProduct;
    public $customer = [];
    public $cart = [];
    public $products = [];
    public $payment_method = 'Cash';
    public $split_payments = [];
    public $total_amount = 0;
    public $invoice_url = null;
    public $saleCompleted = false;
    public $saleId;


    public function mount()
    {
        $this->products = Product::all();
        $this->cart = [];  // Ensure cart is an array
    }

    public function resetSale()
    {
        $this->saleCompleted = false;
        $this->saleId = null;
    }


    public function enableNewCustomerForm()
    {
        if (empty($this->searchTerm)) {
            // Enable new customer entry
            $this->customer = [
                'name' => '',
                'contact' => '',
                'email' => '',
            ];
            session()->flash('info', 'Enter new customer details.');
        }
    }
    public function searchCustomer()
    {
        if (empty($this->searchTerm)) {
            $this->enableNewCustomerForm();
            return;
        }

        // Search for an existing customer
        $customer = Customer::where('contact', $this->searchTerm)
            ->orWhere('email', $this->searchTerm)
            ->first();

        if ($customer) {
            $this->customer = $customer->toArray(); // Auto-fill details
            session()->flash('success', 'Customer found!');
        } else {
            // If no customer is found, allow user to enter details
            $this->customer = [
                'name' => '',
                'contact' => $this->searchTerm, // Prefill contact field
                'email' => '',
                'address' => ''
            ];
            session()->flash('success', 'Customer not found. Please enter details.');
        }
    }

    public function addToCart($productId)
    {
        $this->validate([
            'selectedProduct' => 'required|exists:products,id'
        ], messages: [
            'selectedProduct.required' => 'Please select a product.',
            'selectedProduct.exists' => 'Invalid product selected.',
        ]);


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

        $this->resetSale(); // Reset previous sale data before processing a new sale

        // Ensure customer details are not empty
        if (empty($this->customer['name']) || empty($this->customer['email'])) {
            session()->flash('error', 'Please search for an existing customer or enter new customer details.');
            return;
        }

        $customer = Customer::where('contact', $this->customer['contact'])
            ->orWhere('email', $this->customer['email'])
            ->first();

        $this->validate([
            'customer.name' => 'required|string|max:255',
            'customer.contact' => [
                'nullable',
                Rule::unique('customers', 'contact')->ignore($customer?->id)
            ],
            'customer.email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignore($customer?->id)
            ],
        ]);

        if (count($this->cart) === 0) {
            session()->flash('error', 'You must add at least one product before submitting.');
            return;
        }

        DB::beginTransaction();
        try {

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

            // **Set saleCompleted to true and store saleId**
            $this->saleCompleted = true;
            $this->saleId = $sale->id;

            $this->reset(['searchTerm', 'customer', 'cart', 'total_amount', 'payment_method']);
            session()->flash('success', 'Sale completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Sale failed: ' . $e->getMessage());
        }
    }

    // for pdf generation
    public function generateInvoice($saleId)
    {
        $sale = Sale::with('customer', 'saleItems.product')->findOrFail($saleId);

        $html = view('livewire.sales.invoice', compact('sale'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $fileName = 'invoice_' . $saleId . '.pdf';

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $fileName);
    }


    public function render()
    {
        return view('livewire.sales.create-bill');
    }
}

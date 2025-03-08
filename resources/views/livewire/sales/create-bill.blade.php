<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("New Sale") }}
    </h2>
</x-slot>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Bill</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form wire:submit.prevent="processSale">
                <div class="mb-3">
                    <label class="form-label">Search by Contact or Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model="searchTerm" wire:focus="enableNewCustomerForm">
                        <button type="button" class="btn btn-outline-primary" wire:click="searchCustomer">Search</button>
                    </div>
                </div>
                

                @if($customer)
                    <h5 class="mt-4">Customer Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input class="form-control" wire:model="customer.name" {{ isset($customer['id']) ? 'disabled' : '' }}>
                            @error('customer.name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                
                        </div>
                        <div class="col-md-6">
                            <label>Contact</label>
                            <input class="form-control" wire:model="customer.contact" {{ isset($customer['id']) ? 'disabled' : '' }}>
                            @error('customer.contact')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Email</label>
                            <input class="form-control" wire:model="customer.email" {{ isset($customer['id']) ? 'disabled' : '' }}>
                            @error('customer.email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Address</label>
                            <textarea class="form-control" wire:model="customer.address" {{ isset($customer['id']) ? 'disabled' : '' }}></textarea>
                            @error('customer.address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                
                        </div>
                    </div>
                @endif

                <h5 class="mt-4">Add Products</h5>
                <select class="form-select" wire:model="selectedProduct" wire:change="addToCart($event.target.value)">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('selectedProduct')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            
 @if(count($cart) > 0)
                    <table class="table mt-3">
                        <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th>Action</th></tr>
                        @foreach($cart as $index => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td><input type="number" class="form-control" wire:model.defer="cart.{{ $index }}.quantity" wire:blur="updateQuantity({{ $index }})"></td>
                                <td>₹{{ $item['price'] }}</td>
                                <td>₹{{ $item['total'] }}</td>
                                <td><button type="button" wire:click="removeFromCart({{ $index }})" class="btn btn-danger">Remove</button></td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                <div><strong>Total: ₹{{ $total_amount }}</strong></div>

                <button type="submit" class="btn btn-success mt-3">Submit Sale</button>
            </form>
        </div>
    </div>
</div>

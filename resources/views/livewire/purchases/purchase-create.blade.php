<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Purchases') }}
    </h2>
</x-slot>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Purchase</h4>
        </div>
    
        <div class="card-body">
            <form wire:submit="save">
                {{-- Supplier Dropdown --}}
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select wire:model="supplier_id" class="form-select">
                        <option value="">-- Select Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') 
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
    
                {{-- Purchase Items Table --}}
                <h5 class="mt-4">Purchase Items</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Cost Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td>
                                    <select wire:model="items.{{ $index }}.product_id" class="form-select">
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error("items.$index.product_id")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model="items.{{ $index }}.quantity" class="form-control">
                                    @error("items.$index.quantity")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model="items.{{ $index }}.cost_price" step="0.01" class="form-control">
                                    @error("items.$index.cost_price")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="removeItem({{ $index }})">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                {{-- Add Product Button --}}
                <button type="button" class="btn btn-outline-primary" wire:click="addItem">+ Add Product</button>
    
                {{-- Submit Button --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Save Purchase</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
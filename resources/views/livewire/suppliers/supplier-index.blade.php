<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Suppliers') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <input class="form-control w-25" placeholder="Search Suppliers..." wire:model.live="search">
        @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <a href="{{ route('supplier.create') }}" class="btn btn-outline-success">
            + Add Supplier
        </a>
        @endif
    </div>

   
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    <th scope="col" style="width: 150px;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($suppliers->count() > 0)
                @foreach($suppliers as $Index => $supplier)
                    <tr wire:key="{{ $supplier->id }}">
                        <td>{{ $suppliers->firstItem()+$Index }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->address }}</td>
                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <td>
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $supplier->id }})" wire:confirm="Are you sure you want to delete this product?">Delete</button>
                        </td>
                        @endif
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center text-muted">No suppliers found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $suppliers->links(data: ['scrollTo' => false]) }}
    </div>
</div>

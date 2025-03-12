<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Purchases') }}
    </h2>
</x-slot>
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <input class="form-control w-25" placeholder="Search Purchases..." wire:model.live="search">
        <a href="{{ route('purchase.create') }}" class="btn btn-outline-success">
            + Add Purchase
        </a>
    </div>

   
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Purchase_date</th>
                    <th scope="col">Total_amount</th>
                    <th scope="col" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($purchases->count() > 0)
                @foreach($purchases as $Index => $purchase)
                    <tr wire:key="{{ $purchase->id }}">
                        <td>{{ $purchases->firstItem()+$Index }}</td>
                        <td>{{ $purchase->supplier->name }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ $purchase->total_amount }}</td>
                        <td>
                            <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $purchase->id }})" wire:confirm="Are you sure you want to delete this purchase?">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center text-muted">No purchase found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $purchases->links(data: ['scrollTo' => false]) }}
    </div>
</div>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Sales") }}
    </h2>
</x-slot>

<div class="container mt-4">
    <div class="d-flex justify-content-start align-items-center mt-3 mb-3">
        <input
            class="form-control w-25"
            placeholder="Search Sale..."
            wire:model.live="search"
        />
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px">#</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total_amount</th>
                    <th scope="col">Payment_method</th>
                </tr>
            </thead>
            <tbody>
                @if($sales->count() > 0) @foreach($sales as $Index => $sale)
                <tr wire:key="{{ $sale->id }}">
                    <td>{{ $sales->firstItem()+$Index }}</td>
                    <td>{{ optional($sale->customer)->name ?? 'N/A' }}</td>
                    <td>{{ $sale->total_amount }}</td>
                    <td>{{ $sale->payment_method }}</td>
                </tr>
                @endforeach @else
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No sales found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $sales->links(data: ['scrollTo' => false]) }}
    </div>
</div>

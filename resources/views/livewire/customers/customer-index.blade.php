<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Customers') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                </tr>
            </thead>
            <tbody>
                @if($customers->count() > 0)
                @foreach($customers as $Index => $customer)
                    <tr wire:key="{{ $customer->id }}">
                        <td>{{ $customers->firstItem()+$Index }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->contact }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->address }}</td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center text-muted">No sales found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $customers->links(data: ['scrollTo' => false]) }}
    </div>
</div>

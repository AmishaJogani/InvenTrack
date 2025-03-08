<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Sale-Items") }}
    </h2>
</x-slot>

<div class="container mt-4">
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px">#</th>
                    <th scope="col">sale_id</th>
                    <th scope="col">product_name</th>
                    <th scope="col">quantity</th>
                    <th scope="col">selling_price</th>
                </tr>
            </thead>
            <tbody>
                @if($saleitems->count() > 0) @foreach($saleitems as $Index => $saleitem)
                <tr wire:key="{{ $saleitem->id }}">
                    <td>{{ $saleitems->firstItem()+$Index }}</td>
                    <td>{{ $saleitem-> sale_id}}</td>
                    <td>{{ $saleitem->product->name }}</td>
                    <td>{{ $saleitem->quantity }}</td>
                    <td>{{ $saleitem->selling_price }}</td>
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
        {{ $saleitems->links(data: ['scrollTo' => false]) }}
    </div>
</div>

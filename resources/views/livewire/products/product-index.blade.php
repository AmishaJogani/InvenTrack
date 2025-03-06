<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Products') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
        
        <a href="{{ route('product.create') }}" class="btn btn-outline-success">
            + Add Product
        </a>
    </div>

   
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Brand Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Unit</th>
                    <th scope="col" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($products->count() > 0)
                @foreach($products as $Index => $product)
                    <tr wire:key="{{ $product->id }}">
                        <td>{{ $products->firstItem()+$Index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $product->id }})" wire:confirm="Are you sure you want to delete this product?">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center text-muted">No product found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash;
            if (hash.startsWith('#product-')) {
                const targetRow = document.querySelector(hash);
                if (targetRow) {
                    targetRow.classList.add('highlight');
                    // Optional: Remove highlight after few seconds
                    setTimeout(() => targetRow.classList.remove('highlight'), 4000);
                }
            }
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .product-row.highlight {
        background-color: #fff3cd; /* Light yellow */
        transition: background-color 0.5s ease;
    }
    
    </style>
    @endpush

</div>


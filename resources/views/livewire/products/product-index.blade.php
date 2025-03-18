<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Products") }}
    </h2>
</x-slot>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <input
            class="form-control w-25"
            placeholder="Search Products..."
            wire:model.live="search"
        />
        @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <a href="{{ route('product.create') }}" class="btn btn-outline-success">
            + Add Product
        </a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Brand Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Images</th>
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    <th scope="col" style="width: 150px">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($products->count() > 0) @foreach($products as $Index =>
                $product)
                <tr wire:key="{{ $product->id }}">
                    <td>{{ $products->firstItem()+$Index }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->unit }}</td>
                    <!-- Images Column -->
                    <td>
                        <button
                            wire:click="showImages({{ $product->id }})"
                            class="btn btn-primary btn-sm"
                        >
                            View Images
                        </button>
                    </td>
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    <td>
                        <a
                            href="{{ route('product.edit', $product->id) }}"
                            class="btn btn-sm btn-warning"
                            >Edit</a
                        >

                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="delete({{ $product->id }})"
                            wire:confirm="Are you sure you want to delete this product?"
                        >
                            Delete
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach @else
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No product found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>

<!-- Image Modal -->
<div wire:ignore.self class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-wrap gap-2">
                @if($selectedProductImages)
                    @foreach($selectedProductImages as $image)
                        <!-- Image Container with Delete Button -->
                        <div class="position-relative">
                            <!-- Image -->
                            <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" width="120">

                            <!-- Delete Button -->
                            @if (in_array(auth()->user()->role, ['admin', 'manager']))
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                wire:click="deleteImage('{{ $image }}')"
                                onclick="return confirm('Are you sure you want to delete this image?')">
                                ❌
                            </button>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No images available.</p>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('show-image-modal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    });
</script>



</div>

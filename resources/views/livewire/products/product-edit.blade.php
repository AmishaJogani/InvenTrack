<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Products") }}
    </h2>
</x-slot>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Update Product</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                {{ session("success") }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
            @endif

            <form wire:submit="update">
                <div class="mb-3">
                    <label for="name" class="form-label">product Name</label>
                    <input id="name" wire:model="name" class="form-control" />
                    @error('name')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">category</label>
                    <select
                        id="category_id"
                        wire:model="category_id"
                        class="form-select"
                    >
                        <option value="">select category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="brand_id" class="form-label">brand</label>
                    <select
                        id="brand_id"
                        wire:model="brand_id"
                        class="form-select"
                    >
                        <option value="">select Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">units</label>
                    <input id="unit" wire:model="unit" class="form-control" />
                    @error('unit')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">price</label>
                    <input id="price" wire:model="price" class="form-control" />
                    @error('price')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">description</label>
                    <input
                        id="description"
                        wire:model="description"
                        class="form-control"
                    />
                    @error('description')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="low_stock_alert" class="form-label"
                        >low_stock_alert</label
                    >
                    <input
                        id="low_stock_alert"
                        wire:model="low_stock_alert"
                        class="form-control"
                    />
                    @error('low_stock_alert')
                    <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

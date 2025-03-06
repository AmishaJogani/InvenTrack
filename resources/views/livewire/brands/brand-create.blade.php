<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Brands') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Create Brand</h5>
        </div>
        
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        

            <form wire:submit="save">
                <div class="mb-3">
                    <label for="name" class="form-label">Brand Name</label>
                    <input id="name" wire:model="name" class="form-control">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save Brand</button>
                </div>
            </form>

        </div>
    </div>

</div>
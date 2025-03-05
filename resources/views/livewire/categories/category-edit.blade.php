<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Categories') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Update Category</h5>
        </div>
        
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form wire:submit="update">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input id="name" wire:model="name" class="form-control">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Category (optional)</label>
                    <select id="parent_id" wire:model="parent_id" class="form-select">
                        <option value="">No Parent (Top-Level Category) </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Update Category</button>
                </div>
            </form>

        </div>
    </div>

</div>
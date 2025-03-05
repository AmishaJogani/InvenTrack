<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Categories') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
        
        <a href="{{ route('category.create') }}" class="btn btn-outline-success">
            + Add Category
        </a>
    </div>

   
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Parent category</th>
                    <th scope="col" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($categories)
                @foreach($categories as $Index => $category)
                    <tr wire:key="{{ $category->id }}">
                        <td>{{ $categories->firstItem()+$Index }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent?->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $category->id }})" wire:confirm="Are you sure you want to delete this category?">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @endif
                
            </tbody>
        </table>
        {{ $categories->links(data: ['scrollTo' => false]) }}
    </div>
</div>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Brands') }}
    </h2>
</x-slot>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <input class="form-control w-25" placeholder="Search Brands..." wire:model.live="search">
        @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <a href="{{ route('brand.create') }}" class="btn btn-outline-success">
            + Add Brand
        </a>
        @endif
    </div>

   
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">#</th>
                    <th scope="col">Brand</th>
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    <th scope="col" style="width: 150px;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($brands->count() > 0)
                @foreach($brands as $Index => $brand)
                    <tr wire:key="{{ $brand->id }}">
                        <td>{{ $brands->firstItem()+$Index }}</td>
                        <td>{{ $brand->name }}</td>
                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <td>
                            <a href="{{ route('brand.edit' , $brand->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $brand->id }})" wire:confirm="Are you sure you want to delete this Brand?">Delete</button>
                        </td>
                        @endif
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2" class="text-center text-muted">No Brand found.</td>
                </tr>
                @endif
                
            </tbody>
        </table>
        {{ $brands->links(data: ['scrollTo' => false]) }}
    </div>
</div>

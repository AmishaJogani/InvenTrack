<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
    </h2>
</x-slot>

<div>

    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
        
        <a href="{{ route('register') }}" class="btn btn-outline-success">
            + Add User
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td class="text-center">
                            <a href="{{ route('profile')}}" class="btn btn-sm btn-outline-warning">
                                Edit
                            </a>
                            <button wire:click="delete({{ $user->id }})" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

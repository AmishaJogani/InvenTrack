<div>
    <li class="dropdown-header">
        You have <span>{{ $notifications->count() }}</span> new notifications
        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
    </li>

    <ul class="notifications-list">
        @forelse ($notifications as $notification)
            <li class="notification-item">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <div>
                    <h6>{{ $notification->data['message'] }}</h6>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <button wire:click="markAsRead('{{ $notification->id }}')" class="btn btn-sm btn-light">
                    Mark as Read
                </button>
            </li>
        @empty
            <li class="text-center">No new notifications</li>
        @endforelse
    </ul>
</div>

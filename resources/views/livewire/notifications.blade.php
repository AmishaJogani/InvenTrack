<div>
    <li class="nav-item dropdown" wire:ignore>
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">{{ $notifications->count() }}</span> </a
        ><!-- End Notification Icon -->

        <ul
            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
        >
            <li class="dropdown-header">
                You have <span>{{ $notifications->count() }}</span> new
                notifications
                <!-- <a href="#"
                    ><span class="badge rounded-pill bg-primary p-2 ms-2"
                        >View all</span
                    ></a
                > -->
            </li>

            <ul class="notifications-list">
                @forelse ($notifications as $notification)
                <li class="notification-item">
                    <i class="bi bi-exclamation-triangle text-warning"></i>
                    <div>
                        <h6>{{ $notification->data['message'] }} (Product ID: {{ $notification->data['product_id'] }})</h6>
                        <small
                            class="text-muted"
                            >{{ $notification->created_at->diffForHumans() }}</small
                        >
                    </div>
                    <button
                        wire:click="markAsRead('{{ $notification->id }}')"
                        class="btn btn-sm btn-light"
                    >
                    <i class="bi bi-check2-circle"></i>
                    </button>
                </li>
                @empty
                <li class="text-center">No new notifications</li>
                @endforelse
            </ul>
        </ul>
    </li>
</div>

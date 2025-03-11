<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications;

    protected $listeners = ['stockUpdated' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function markAsRead($notificationId)
    {
        Auth::user()->notifications->where('id', $notificationId)->markAsRead();
        $this->loadNotifications();
    }


    public function render()
    {
        return view('livewire.notifications');
    }
}

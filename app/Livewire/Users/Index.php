<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    public $users, $userId, $name, $role, $email;

    public function mount()
    {
        $this->users = User::all();
    }
    public function render()
    {
        return view('livewire.users.index')->with('users', $this->users);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');

        $this->users = User::all(); // Refresh the list after delete
        return view('livewire.users.index')->with('users', $this->users);
    }

  
}

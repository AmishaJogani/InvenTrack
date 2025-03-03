<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    use WithPagination;
    public $userId, $name, $role, $email;

    public function render()
    {
        return view('livewire.users.index' , ['users' => User::paginate(5)]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
      
    }

  
}

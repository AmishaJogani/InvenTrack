<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;
    public $profileImgPath;
    public $profile_img;
    public string $role = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
    */
    
public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,manager,staff'], // Validate role
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // Max 1MB
        ]);

       

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if($this->profile_img){
            
            $profileImgPath = 'User_' . $user->id . '.' . $this->profile_img->getClientOriginalExtension();
            $this->profile_img->storeAs('profile_images' , $profileImgPath , 'public');
                    }

             $user->update(['profile_img' => $profileImgPath]);

            event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: true), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" method="post" enctype="multipart/form-data">
        <x-input-label for="role" :value="__('Role')" />
        <select wire:model="role" id="role" name="role"
            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            required>
            <option value="" disabled>Select Role</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="staff">Staff</option>
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    
    
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
    
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    
        <!-- Profile Image -->
        <div class="mt-4">
            <x-input-label for="profile_img" :value="__('Profile Img')" />
            <input wire:model="profile_img" id="profile_img"
                   class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm cursor-pointer text-gray-700 file:bg-indigo-50 file:border-0 file:text-indigo-600 file:font-medium file:cursor-pointer"
                   type="file" name="profile_img" accept="img/*" />
        
            <x-input-error :messages="$errors->get('profile_img')" class="mt-2" />
        
            @if ($profile_img)
                <img src="{{ $profile_img->temporaryUrl() }}" class="h-20 w-20 mt-2 rounded-full object-cover">
            @endif
        </div>
        
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Already registered?') }}
            </a>
    
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
</div>

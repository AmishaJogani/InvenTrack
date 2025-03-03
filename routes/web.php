<?php

use App\Http\Controllers\LogOutController;
use App\Livewire\Actions\Logout;
use App\Livewire\Users\Edit;
use App\Livewire\Users\Index;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::get('users',Index::class)->name('users.index'); 

    Route::post('logout',[Logout::class , 'logout'])->name('logout');
   

require __DIR__.'/auth.php';

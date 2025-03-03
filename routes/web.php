<?php

use App\Http\Controllers\LogOutController;
use App\Livewire\Actions\Logout;
use App\Livewire\Categories\CategoriesIndex;
use App\Livewire\Categories\CategoryCreate;
use App\Livewire\Categories\CategoryEdit;
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

    Route::post('logout',[Logout::class , 'logout'])->name('logout');

    Route::get('users',Index::class)->name('users.index'); 

    // categories Routes
    Route::get('category/create' , CategoryCreate::class)->name('category.create');
    Route::get('categories/index' , CategoriesIndex::class)->name('categories.index');
    Route::get('category/{id}edit' , CategoryEdit::class)->name('category.edit');

   

require __DIR__.'/auth.php';

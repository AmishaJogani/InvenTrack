<?php

use App\Http\Controllers\LogOutController;
use App\Livewire\Actions\Logout;
use App\Livewire\Brands\BrandCreate;
use App\Livewire\Brands\BrandEdit;
use App\Livewire\Brands\BrandsIndex;
use App\Livewire\Categories\CategoriesIndex;
use App\Livewire\Categories\CategoryCreate;
use App\Livewire\Categories\CategoryEdit;
use App\Livewire\Products\ProductCreate;
use App\Livewire\Products\ProductEdit;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Purchases\PurchaseCreate;
use App\Livewire\Purchases\PurchaseEdit;
use App\Livewire\Purchases\PurchaseIndex;
use App\Livewire\Suppliers\SupplierCreate;
use App\Livewire\Suppliers\SupplierEdit;
use App\Livewire\Suppliers\SupplierIndex;
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

Route::post('logout', [Logout::class, 'logout'])->name('logout');

Route::get('users', Index::class)->name('users.index');

// Categories Routes
Route::get('category/create', CategoryCreate::class)->name('category.create');
Route::get('categories/index', CategoriesIndex::class)->name('categories.index');
Route::get('category/{id}edit', CategoryEdit::class)->name('category.edit');

// Brands Routes
Route::get('brand/create', BrandCreate::class)->name('brand.create');
Route::get('brands/index', BrandsIndex::class)->name('brands.index');
Route::get('brand/{id}/edit', BrandEdit::class)->name('brand.edit');

// Product Routes
Route::get('product/create', ProductCreate::class)->name('product.create');
Route::get('product/index', ProductIndex::class)->name('product.index');
Route::get('product/{id}edit', ProductEdit::class)->name('product.edit');

// suppiers Routes
Route::get('supplier/create', SupplierCreate::class)->name('supplier.create');
Route::get('supplier/{id}/edit', SupplierEdit::class)->name('supplier.edit');
Route::get('supplier/index', SupplierIndex::class)->name('supplier.index');

// purchase Routes
Route::get('purchase/index',PurchaseIndex::class)->name('purchase.index');
Route::get('purchase/create',PurchaseCreate::class)->name('purchase.create');
Route::get('purchase/{purchaseId}/edit',PurchaseEdit::class)->name('purchase.edit');




require __DIR__ . '/auth.php';

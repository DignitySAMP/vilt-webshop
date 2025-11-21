<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/user', function () {

    return Inertia::render('Welcome');
})->name('profile');

Route::get('/user/two-faction-setup', function () {

    return Inertia::render('auth/TwoFactorSetup', [
        'mfa_enabled' => Auth::user()->two_factor_confirmed_at !== null,
    ]);
})->middleware(['auth', 'verified', 'password.confirm'])->name('two-factor.setup');

Route::resource('item', ItemController::class)->except(['show']);
Route::get('item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::resource('category', ItemCategoryController::class)->except(['show']);
Route::resource('supplier', SupplierController::class);

Route::resource('cart', ShoppingCartController::class)->except(['show', 'edit', 'create', 'destroy']);
Route::delete('cart/clear', [ShoppingCartController::class, 'destroy'])->name('cart.destroy');

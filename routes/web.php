<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
//     Route::get('/customers/{id}', [CustomerController::class, 'open'])->name('customers.view');
// });
Route::resource('customers', CustomerController::class)->middleware('auth', 'can:update,customer');;
Route::resource('invoices', InvoiceController::class)->middleware('auth');;

require __DIR__.'/auth.php';

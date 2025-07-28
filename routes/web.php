<?php

use App\Http\Controllers\CustomerRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/customer-requests', [CustomerRequestController::class, 'index'])->name('customer-requests.index');
Route::get('/customer-requests/create', [CustomerRequestController::class, 'create'])->name('customer-requests.create');
Route::post('/customer-requests', [CustomerRequestController::class, 'store'])->name('customer-requests.store');
Route::get('/customer-requests/{id}/edit', [CustomerRequestController::class, 'edit'])->name('customer-requests.edit');
Route::put('/customer-requests/{id}', [CustomerRequestController::class, 'update'])->name('customer-requests.update');
Route::delete('/customer-requests/{customerRequest}', [CustomerRequestController::class, 'destroy'])
    ->name('customer-requests.destroy');
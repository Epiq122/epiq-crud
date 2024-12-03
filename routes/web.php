<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('customer/trash', [CustomerController::class, 'trashIndex'])->name('customers.trash');
Route::resource('customers', CustomerController::class);




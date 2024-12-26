<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/bus/add', [BusController::class, 'add_bus'])->name('bus.add');
Route::post('/bus/store', [BusController::class, 'store_bus'])->name('bus.store');
Route::get('/bus/view', [BusController::class, 'view_buses'])->name('bus.view');
Route::get('/bus/{id}', [BusController::class, 'show_bus'])->name('bus.show');
Route::get('/bus/{id}/edit', [BusController::class, 'edit_bus'])->name('bus.edit');
Route::post('/bus/{id}/update', [BusController::class, 'update_bus'])->name('bus.update');
Route::get('/buses', [BusController::class, 'showBusList'])->name('bus.list');

Route::get('/bus/{id}/select', [BusController::class, 'selectBusForBooking'])->name('bus.select');

Route::post('/bus/book', [BusController::class, 'submitBooking'])->name('bus.submitBooking');

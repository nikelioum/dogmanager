<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SchedulesController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['verified', 'adminOrEmployee'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('pets', PetController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('schedules', SchedulesController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

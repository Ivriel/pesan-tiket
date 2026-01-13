<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('types', TypeController::class)->except('show');
    Route::resource('routes', RouteController::class)->except('show');
    Route::resource('transportations', TransportationController::class)->except('show');
    Route::resource('schedules', ScheduleController::class);
    // Custom route untuk booking - urutan penting: specific routes dulu, dynamic routes terakhir
    Route::get('/bookings/list', [BookingController::class, 'listBooking'])->name('bookings.list');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{schedule}', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('booking-details/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/api/seats', [BookingController::class, 'getAvailableSeats'])->name('api.seats');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

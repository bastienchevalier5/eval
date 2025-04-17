<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SalleController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('reservations.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('salles', SalleController::class);
    Route::get('/disponibilites', [DisponibiliteController::class, 'index'])->name('disponibilites.index');
    Route::post('/disponibilites/check', [DisponibiliteController::class, 'checkDisponibilite'])->name('disponibilites.check');
    Route::resource('reservations', ReservationController::class);
});

require __DIR__.'/auth.php';

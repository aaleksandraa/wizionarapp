<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('appointments.index');
    // return view('welcome');
})->middleware('auth');




    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('usluge', ServiceController::class)->parameters(['usluge' => 'service']);
    // Specifična ruta za prikaz termina po datumu
    Route::get('/appointments/date/{date}', [AppointmentController::class, 'showByDate'])->name('appointments.showByDate');

    // Standardne rute resursa
    Route::resource('appointments', AppointmentController::class);


    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/api/clients', [ClientController::class, 'apiIndex'])->name('api.clients.index');
});

require __DIR__.'/auth.php';









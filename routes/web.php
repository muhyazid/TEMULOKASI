<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\HasilRekomendasiController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDataLokasiController;

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

// =================== USER ROUTESSS =================== //
Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
})->name('user.dashboard');

Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi');
Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');

Route::get('/hasil-rekomendasi', [HasilRekomendasiController::class, 'index'])->name('hasil-rekomendasi');

Route::get('/manajemen-user', [ManajemenUserController::class, 'index'])->name('manajemen-user');

// =================== ADMIN ROUTES =================== //
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');

    Route::get('/datalokasi', [AdminDataLokasiController::class, 'index'])->name('datalokasi');
    Route::post('/datalokasi/store', [AdminDataLokasiController::class, 'store'])->name('datalokasi.store');
    Route::put('/datalokasi/update/{id}', [AdminDataLokasiController::class, 'update'])->name('datalokasi.update');
    Route::delete('/datalokasi/delete/{id}', [AdminDataLokasiController::class, 'destroy'])->name('datalokasi.delete');
});



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

require __DIR__.'/auth.php';

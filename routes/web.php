<?php

use App\Http\Controllers\KoudenController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
    // return view('top');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard')->middleware('verified');

Route::middleware(['auth'])->prefix('kouden')->group(function () {
    Route::get('/', [KoudenController::class, 'index'])->name('kouden');
    Route::get('/detail/{id}', [KoudenController::class, 'detail'])->name('kouden.detail');
    Route::get('/edit/{id}', [KoudenController::class, 'edit'])->name('kouden.edit');
    Route::get('/new', [KoudenController::class, 'new'])->name('kouden.new');

    Route::patch('/update', [KoudenController::class, 'update'])->name('kouden.update');
    Route::post('/create', [KoudenController::class, 'create'])->name('kouden.create');
    Route::delete('/remove/{id}', [KoudenController::class, 'remove'])->name('kouden.remove'); 
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

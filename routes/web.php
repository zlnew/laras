<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProyekController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->intended('login');
})->middleware('guest');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::prefix('proyek')->group(function() {
        Route::get('/', [ProyekController::class, 'index'])->name('proyek');
        Route::post('/', [ProyekController::class,'store'])->name('proyek.store');
        Route::patch('/{proyek}', [ProyekController::class, 'update'])->name('proyek.update');
        Route::delete('/{proyek}', [ProyekController::class, 'destroy'])->name('proyek.destroy');
    });
});

require __DIR__.'/auth.php';

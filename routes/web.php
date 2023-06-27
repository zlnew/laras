<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RABController;
use App\Http\Controllers\RAPController;

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

    Route::prefix('rab')->group(function() {
        Route::get('/search', [RABController::class, 'search'])->name('rab.search');
        Route::get('/detail/{RAB}', [RABController::class, 'detail'])->name('rab.detail');
        Route::post('/detail/{RAB}', [RABController::class,'store'])->name('rab.store');
        Route::patch('/detail/{DetailRAB}', [RABController::class, 'update'])->name('rab.update');
        Route::delete('/detail/{DetailRAB}', [RABController::class, 'destroy'])->name('rab.destroy');
        Route::patch('/tax/{RAB}', [RABController::class, 'update_tax'])->name('rab.update_tax');
    });

    Route::prefix('rap')->group(function() {
        Route::get('/search', [RAPController::class, 'search'])->name('rap.search');
        Route::get('/detail/{RAP}', [RAPController::class, 'detail'])->name('rap.detail');
        Route::post('/detail/{RAP}', [RAPController::class,'store'])->name('rap.store');
        Route::patch('/detail/{DetailRAP}', [RAPController::class, 'update'])->name('rap.update');
        Route::delete('/detail/{DetailRAP}', [RAPController::class, 'destroy'])->name('rap.destroy');
    });
});

require __DIR__.'/auth.php';

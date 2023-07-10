<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RABController;
use App\Http\Controllers\RAPController;
use App\Http\Controllers\DetailRABController;
use App\Http\Controllers\DetailRAPController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PengajuanDanaController;
use App\Http\Controllers\PencairanDanaController;
use App\Models\DetaiLRAB;

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
        Route::group(['middleware' => ['permission:view proyek']], function () {
            Route::get('/', [ProyekController::class, 'index'])->name('proyek');
        });

        Route::group(['middleware' => [
            'permission:create proyek|update proyek|delete proyek'
        ]], function () {
            Route::post('/', [ProyekController::class,'store'])->name('proyek.store');
            Route::patch('/{Proyek}', [ProyekController::class, 'update'])->name('proyek.update');
            Route::delete('/{Proyek}', [ProyekController::class, 'destroy'])->name('proyek.destroy');
        });
    });

    Route::prefix('rab')->group(function() {
        Route::group(['middleware' => ['permission:view rab']], function () {
            Route::get('/', [RABController::class, 'index'])->name('rab');
            Route::get('/detail/{RAB}', [DetaiLRABController::class, 'index'])->name('detail_rab');
        });

        Route::group(['middleware' => [
            'permission:create rab|update rab|delete rab'
        ]], function () {
            Route::post('/', [RABController::class, 'store'])->name('rab.store');
            Route::patch('/{RAB}', [RABController::class, 'update'])->name('rab.update');
            Route::patch('/tax/{RAB}', [RABController::class, 'update_tax'])->name('rab.update_tax');
            Route::delete('/{RAB}', [RABController::class, 'destroy'])->name('rab.destroy');
            Route::post('/submit/{RAB}', [RABController::class, 'submit'])->name('rab.submit');

            Route::post('/detail/{RAB}', [DetailRABController::class,'store'])->name('detail_rab.store');
            Route::patch('/detail/{DetailRAB}', [DetailRABController::class, 'update'])->name('detail_rab.update');
            Route::delete('/detail/{DetailRAB}', [DetailRABController::class, 'destroy'])->name('detail_rab.destroy');
        });

        Route::group(['middleware' => ['permission:approve rab']], function () {
            Route::post('/approve/{RAB}', [RABController::class, 'approve'])->name('rab.approve');
            Route::post('/refuse/{RAB}', [RABController::class, 'refuse'])->name('rab.refuse');
        });
    });

    Route::prefix('rap')->group(function() {
        Route::group(['middleware' => ['permission:view rap']], function () {
            Route::get('/', [RAPController::class, 'index'])->name('rap');
            Route::get('/detail/{RAP}', [DetailRAPController::class, 'index'])->name('detail_rap');
        });

        Route::group(['middleware' => [
            'permission:create rap|update rap|delete rap'
        ]], function () {
            Route::post('/', [RAPController::class, 'store'])->name('rap.store');
            Route::patch('/{RAP}', [RAPController::class, 'update'])->name('rap.update');
            Route::delete('/{RAP}', [RAPController::class, 'destroy'])->name('rap.destroy');
            Route::post('/submit/{RAP}', [RAPController::class, 'submit'])->name('rap.submit');

            Route::post('/detail/{RAP}', [DetailRAPController::class,'store'])->name('detail_rap.store');
            Route::patch('/detail/{DetailRAP}', [DetailRAPController::class, 'update'])->name('detail_rap.update');
            Route::delete('/detail/{DetailRAP}', [DetailRAPController::class, 'destroy'])->name('detail_rap.destroy');
        });

        Route::group(['middleware' => ['permission:approve rap']], function () {
            Route::post('/approve/{RAP}', [RAPController::class, 'approve'])->name('rap.approve');
            Route::post('/refuse/{RAP}', [RAPController::class, 'refuse'])->name('rap.refuse');
        });
    });

    Route::prefix('keuangan')->group(function () {
        Route::group(['middleware' => ['permission:view pengajuan dana']], function () {
            Route::get('/', [KeuanganController::class, 'index'])->name('keuangan');
        });

        Route::group(['middleware' => [
            'permission:create pengajuan dana|update pengajuan dana|delete pengajuan dana'
        ]], function () {
            Route::post('/', [KeuanganController::class, 'store'])->name('keuangan.store');
            Route::patch('/{Keuangan}', [KeuanganController::class, 'update'])->name('keuangan.update');
            Route::delete('/{Keuangan}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
        });

        Route::prefix('pengajuan-dana')->group(function() {
            Route::group(['middleware' => ['permission:view pengajuan dana']], function () {
                Route::get('/detail/{PengajuanDana}', [PengajuanDanaController::class, 'detail'])->name('pengajuan_dana.detail');
            });
    
            Route::group(['middleware' => [
                'permission:create pengajuan dana|update pengajuan dana|delete pengajuan dana'
            ]], function () {
                Route::post('/detail/{PengajuanDana}', [PengajuanDanaController::class,'store'])->name('pengajuan_dana.store');
                Route::patch('/detail/{DetailPengajuanDana}', [PengajuanDanaController::class, 'update'])->name('pengajuan_dana.update');
                Route::delete('/detail/{DetailPengajuanDana}', [PengajuanDanaController::class, 'destroy'])->name('pengajuan_dana.destroy');
                Route::post('/detail/{PengajuanDana}/submit', [PengajuanDanaController::class, 'submit'])->name('pengajuan_dana.submit');
            });

            Route::middleware(['permission:approve pengajuan dana'])->group(function() {
                Route::post('/detail/{PengajuanDana}/approve', [PengajuanDanaController::class, 'approve'])->name('pengajuan_dana.approve');
                Route::post('/detail/{PengajuanDana}/reject', [PengajuanDanaController::class, 'reject'])->name('pengajuan_dana.reject');
            });
        });
    
        Route::prefix('pencairan-dana')->group(function() {
            Route::group(['middleware' => ['permission:view pencairan dana']], function () {
                Route::get('/detail/{PencairanDana}', [PencairanDanaController::class, 'detail'])->name('pencairan_dana.detail');
            });
    
            Route::group(['middleware' => [
                'permission:create pencairan dana|update pencairan dana|delete pencairan dana'
            ]], function () {
                Route::post('/detail/{PencairanDana}', [PencairanDanaController::class,'store'])->name('pencairan_dana.store');
                Route::patch('/detail/{DetailPencairanDana}', [PencairanDanaController::class, 'update'])->name('pencairan_dana.update');
                Route::delete('/detail/{DetailPencairanDana}', [PencairanDanaController::class, 'destroy'])->name('pencairan_dana.destroy');
            });
        });
    });
});

require __DIR__.'/auth.php';

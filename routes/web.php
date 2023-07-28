<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\UsersController;
use App\Http\Controllers\Master\SatuanController;
use App\Http\Controllers\Master\RekeningController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RABController;
use App\Http\Controllers\RAPController;
use App\Http\Controllers\DetailRABController;
use App\Http\Controllers\DetailRAPController;
use App\Http\Controllers\PengajuanDanaController;
use App\Http\Controllers\PencairanDanaController;
use App\Http\Controllers\PenagihanController;
use App\Http\Controllers\DetailPengajuanDanaController;
use App\Http\Controllers\DetailPencairanDanaController;
use App\Http\Controllers\DetailPenagihanController;
use App\Http\Controllers\LaporanController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::prefix('master')->middleware('role:admin')->group(function() {
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

        Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
        Route::post('/satuan', [SatuanController::class, 'store'])->name('satuan.store');
        Route::patch('/satuan/{satuan}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/satuan/{satuan}', [SatuanController::class, 'destroy'])->name('satuan.destroy');

        Route::get('/rekening', [RekeningController::class, 'index'])->name('rekening');
        Route::post('/rekening', [RekeningController::class, 'store'])->name('rekening.store');
        Route::patch('/rekening/{rekening}', [RekeningController::class, 'update'])->name('rekening.update');
        Route::delete('/rekening/{rekening}', [RekeningController::class, 'destroy'])->name('rekening.destroy');
    });
    
    Route::prefix('proyek')->group(function() {
        Route::group(['middleware' => ['permission:view proyek']], function () {
            Route::get('/', [ProyekController::class, 'index'])->name('proyek');
        });

        Route::group(['middleware' => ['permission:create & modify proyek']], function () {
            Route::post('/', [ProyekController::class,'store'])->name('proyek.store');
            Route::patch('/{proyek}', [ProyekController::class, 'update'])->name('proyek.update');
            Route::delete('/{proyek}', [ProyekController::class, 'destroy'])->name('proyek.destroy');
        });
    });

    Route::prefix('rab')->group(function() {
        Route::group(['middleware' => ['permission:view rab']], function () {
            Route::get('/', [RABController::class, 'index'])->name('rab');
            Route::get('/detail/{rab}', [DetaiLRABController::class, 'index'])->name('detail_rab');
        });

        Route::group(['middleware' => ['permission:create & modify rab']], function () {
            Route::post('/', [RABController::class, 'store'])->name('rab.store');
            Route::patch('/{rab}', [RABController::class, 'update'])->name('rab.update');
            Route::patch('/tax/{rab}', [RABController::class, 'update_tax'])->name('rab.update_tax');
            Route::delete('/{rab}', [RABController::class, 'destroy'])->name('rab.destroy');
            Route::post('/submit/{rab}', [RABController::class, 'submit'])->name('rab.submit');

            Route::post('/detail/{rab}', [DetailRABController::class,'store'])->name('detail_rab.store');
            Route::patch('/detail/{detailRab}', [DetailRABController::class, 'update'])->name('detail_rab.update');
            Route::delete('/detail/{detailRab}', [DetailRABController::class, 'destroy'])->name('detail_rab.destroy');
        });

        Route::group(['middleware' => ['permission:approve rab']], function () {
            Route::post('/approve/{rab}', [RABController::class, 'approve'])->name('rab.approve');
            Route::post('/refuse/{rab}', [RABController::class, 'refuse'])->name('rab.refuse');
        });
    });

    Route::prefix('rap')->group(function() {
        Route::group(['middleware' => ['permission:view rap']], function () {
            Route::get('/', [RAPController::class, 'index'])->name('rap');
            Route::get('/detail/{rap}', [DetailRAPController::class, 'index'])->name('detail_rap');
        });

        Route::group(['middleware' => ['permission:create & modify rap']], function () {
            Route::post('/', [RAPController::class, 'store'])->name('rap.store');
            Route::patch('/{rap}', [RAPController::class, 'update'])->name('rap.update');
            Route::delete('/{rap}', [RAPController::class, 'destroy'])->name('rap.destroy');
            Route::post('/submit/{rap}', [RAPController::class, 'submit'])->name('rap.submit');

            Route::post('/detail/{rap}', [DetailRAPController::class,'store'])->name('detail_rap.store');
            Route::patch('/detail/{detailRap}', [DetailRAPController::class, 'update'])->name('detail_rap.update');
            Route::delete('/detail/{detailRap}', [DetailRAPController::class, 'destroy'])->name('detail_rap.destroy');
        });

        Route::group(['middleware' => ['permission:approve rap']], function () {
            Route::post('/approve/{rap}', [RAPController::class, 'approve'])->name('rap.approve');
            Route::post('/refuse/{rap}', [RAPController::class, 'refuse'])->name('rap.refuse');
        });
    });

    Route::prefix('keuangan')->group(function () {
        Route::prefix('pengajuan-dana')->group(function() {
            Route::group(['middleware' => ['permission:view pengajuan dana']], function () {
                Route::get('/', [PengajuanDanaController::class, 'index'])->name('pengajuan_dana');
                Route::get('/detail/{pengajuanDana}', [DetailPengajuanDanaController::class, 'index'])->name('detail_pengajuan_dana');
            });
    
            Route::group(['middleware' => ['permission:create & modify pengajuan dana']], function () {
                Route::post('/', [PengajuanDanaController::class, 'store'])->name('pengajuan_dana.store');
                Route::patch('/{pengajuanDana}', [PengajuanDanaController::class, 'update'])->name('pengajuan_dana.update');
                Route::delete('/{pengajuanDana}', [PengajuanDanaController::class, 'destroy'])->name('pengajuan_dana.destroy');

                Route::post('/detail/{pengajuanDana}', [DetailPengajuanDanaController::class,'store'])->name('detail_pengajuan_dana.store');
                Route::patch('/detail/{detailPengajuanDana}', [DetailPengajuanDanaController::class, 'update'])->name('detail_pengajuan_dana.update');
                Route::delete('/detail/{detailPengajuanDana}', [DetailPengajuanDanaController::class, 'destroy'])->name('detail_pengajuan_dana.destroy');
                Route::post('/detail/{pengajuanDana}/submit', [DetailPengajuanDanaController::class, 'submit'])->name('detail_pengajuan_dana.submit');
            });

            Route::middleware(['permission:approve pengajuan dana'])->group(function() {
                Route::post('/detail/{pengajuanDana}/approve', [DetailPengajuanDanaController::class, 'approve'])->name('detail_pengajuan_dana.approve');
                Route::post('/detail/{pengajuanDana}/refuse', [DetailPengajuanDanaController::class, 'refuse'])->name('detail_pengajuan_dana.refuse');
            });
        });
    
        Route::prefix('pencairan-dana')->group(function() {
            Route::group(['middleware' => ['permission:view pencairan dana']], function () {
                Route::get('/', [PencairanDanaController::class, 'index'])->name('pencairan_dana');
                Route::get('/detail/{pencairanDana}', [DetailPencairanDanaController::class, 'index'])->name('detail_pencairan_dana');
            });
    
            Route::group(['middleware' => ['permission:create & modify pencairan dana']], function () {
                Route::post('/', [PencairanDanaController::class, 'store'])->name('pencairan_dana.store');
                Route::patch('/{pencairanDana}', [PencairanDanaController::class, 'update'])->name('pencairan_dana.update');
                Route::delete('/{pencairanDana}', [PencairanDanaController::class, 'destroy'])->name('pencairan_dana.destroy');

                Route::post('/detail/{pencairanDana}', [DetailPencairanDanaController::class,'store'])->name('detail_pencairan_dana.store');
                Route::post('/detail/{pencairanDana}/submit', [DetailPencairanDanaController::class, 'submit'])->name('detail_pencairan_dana.submit');
            });

            Route::middleware(['permission:receipt pencairan dana'])->group(function() {
                Route::post('/detail/{pencairanDana}/confirm', [DetailPencairanDanaController::class, 'confirm'])->name('detail_pencairan_dana.confirm');
                Route::post('/detail/{pencairanDana}/decline', [DetailPencairanDanaController::class, 'decline'])->name('detail_pencairan_dana.decline');
            });
        });

        Route::prefix('penagihan')->group(function() {
            Route::group(['middleware' => ['permission:view penagihan']], function () {
                Route::get('/', [PenagihanController::class, 'index'])->name('penagihan');
                Route::get('/detail/{penagihan}', [PenagihanController::class, 'index'])->name('detail_penagihan');
            });
    
            Route::group(['middleware' => ['permission:create & modify penagihan']], function () {
                Route::post('/', [PenagihanController::class, 'store'])->name('penagihan.store');
                Route::patch('/{penagihan}', [PenagihanController::class, 'update'])->name('penagihan.update');
                Route::delete('/{penagihan}', [PenagihanController::class, 'destroy'])->name('penagihan.destroy');

                Route::post('/detail/{penagihan}', [DetailPenagihanController::class,'store'])->name('detail_penagihan.store');
                Route::patch('/detail/{detailPenagihan}', [DetailPenagihanController::class, 'update'])->name('detail_penagihan.update');
                Route::delete('/detail/{detailPenagihan}', [DetailPenagihanController::class, 'destroy'])->name('detail_penagihan.destroy');
                Route::post('/detail/{penagihan}/submit', [DetailPenagihanController::class, 'submit'])->name('detail_penagihan.submit');
            });

            Route::middleware(['permission:receipt penagihan'])->group(function() {
                Route::post('/detail/{penagihan}/confirm', [DetailPenagihanController::class, 'confirm'])->name('detail_penagihan.confirm');
                Route::post('/detail/{penagihan}/decline', [DetailPenagihanController::class, 'decline'])->name('detail_penagihan.decline');
            });
        });
    });

    Route::prefix('laporan')->middleware(['permission:view laporan'])->group(function () {
        Route::get('/pengajuan-dana', [LaporanController::class, 'pengajuan_dana'])->name('laporan.pengajuan_dana');
        Route::get('/pencairan-dana', [LaporanController::class, 'pencairan_dana'])->name('laporan.pencairan_dana');
        Route::get('/penagihan', [LaporanController::class, 'penagihan'])->name('laporan.penagihan');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/artisan.php';

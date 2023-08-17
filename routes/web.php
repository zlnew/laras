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
use App\Http\Controllers\FilesController;
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
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/manajer-proyek', [DashboardController::class, 'manajer_proyek'])->name('dashboard.manajer_proyek');
    Route::get('/dashboard/kepala-divisi', [DashboardController::class, 'kepala_divisi'])->name('dashboard.kepala_divisi');
    Route::get('/dashboard/keuangan', [DashboardController::class, 'keuangan'])->name('dashboard.keuangan');
    Route::get('/dashboard/direktur-utama', [DashboardController::class, 'direktur_utama'])->name('dashboard.direktur_utama');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::prefix('file')->group(function() {
        Route::post('/{model_id}', [FilesController::class, 'store'])->name('file.store');
        Route::post('/{file}/update', [FilesController::class, 'update'])->name('file.update');
        Route::delete('/{file}', [FilesController::class, 'destroy'])->name('file.destroy');
    });

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
            Route::patch('/status/{proyek}', [ProyekController::class, 'status'])->name('proyek.status');
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
            Route::post('/detail/{rab}/import', [DetailRABController::class,'import'])->name('detail_rab.import');
        });

        Route::group(['middleware' => ['permission:approve rab']], function () {
            Route::post('/approve/{rab}', [RABController::class, 'approve'])->name('rab.approve');
            Route::post('/reject/{rab}', [RABController::class, 'reject'])->name('rab.reject');
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
            Route::post('/detail/{rap}/import', [DetailRAPController::class,'import'])->name('detail_rap.import');
        });

        Route::middleware('permission:approve rap')->group(function () {
            Route::post('/approve/{rap}', [RAPController::class, 'approve'])->name('rap.approve');
            Route::post('/reject/{rap}', [RAPController::class, 'reject'])->name('rap.reject');
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
                Route::post('/{pengajuanDana}/submit', [PengajuanDanaController::class, 'submit'])->name('pengajuan_dana.submit');

                Route::post('/detail/{pengajuanDana}', [DetailPengajuanDanaController::class,'store'])->name('detail_pengajuan_dana.store');
                Route::patch('/detail/{detailPengajuanDana}', [DetailPengajuanDanaController::class, 'update'])->name('detail_pengajuan_dana.update');
                Route::delete('/detail/{detailPengajuanDana}', [DetailPengajuanDanaController::class, 'destroy'])->name('detail_pengajuan_dana.destroy');
            });

            Route::middleware('permission:approve pengajuan dana')->group(function () {
                Route::post('/approve/{pengajuanDana}', [PengajuanDanaController::class, 'approve'])->name('pengajuan_dana.approve');
                Route::post('/reject/{pengajuanDana}', [PengajuanDanaController::class, 'reject'])->name('pengajuan_dana.reject');
            });
        });
    
        Route::prefix('pencairan-dana')->group(function() {
            Route::group(['middleware' => ['permission:view pencairan dana']], function () {
                Route::get('/', [PencairanDanaController::class, 'index'])->name('pencairan_dana');
                Route::get('/detail/{pencairanDana}', [DetailPencairanDanaController::class, 'index'])->name('detail_pencairan_dana');
            });
    
            Route::group(['middleware' => ['permission:create & modify pencairan dana']], function () {
                Route::post('/submit/{pencairanDana}', [PencairanDanaController::class, 'submit'])->name('pencairan_dana.submit');

                Route::post('/detail/{pencairanDana}', [DetailPencairanDanaController::class,'store'])->name('detail_pencairan_dana.store');
            });

            Route::middleware(['permission:confirm pencairan dana'])->group(function() {
                Route::post('/confirm/{pencairanDana}', [PencairanDanaController::class, 'confirm'])->name('pencairan_dana.confirm');
                Route::post('/reject/{pencairanDana}', [PencairanDanaController::class, 'reject'])->name('pencairan_dana.reject');
            });
        });

        Route::prefix('penagihan')->group(function() {
            Route::group(['middleware' => ['permission:view penagihan']], function () {
                Route::get('/', [PenagihanController::class, 'index'])->name('penagihan');
                Route::get('/detail/{penagihan}', [DetailPenagihanController::class, 'index'])->name('detail_penagihan');
            });
    
            Route::group(['middleware' => ['permission:create & modify penagihan']], function () {
                Route::post('/', [PenagihanController::class, 'store'])->name('penagihan.store');
                Route::patch('/{penagihan}', [PenagihanController::class, 'update'])->name('penagihan.update');
                Route::put('/{penagihan}', [PenagihanController::class, 'fill'])->name('penagihan.fill');
                Route::put('/tax/{penagihan}', [PenagihanController::class, 'tax'])->name('penagihan.tax');
                Route::delete('/{penagihan}', [PenagihanController::class, 'destroy'])->name('penagihan.destroy');
                Route::post('/submit/{penagihan}', [PenagihanController::class, 'submit'])->name('penagihan.submit');

                Route::post('/detail/{penagihan}', [DetailPenagihanController::class,'store'])->name('detail_penagihan.store');
                Route::patch('/detail/{detailPenagihan}', [DetailPenagihanController::class, 'update'])->name('detail_penagihan.update');
                Route::delete('/detail/{detailPenagihan}', [DetailPenagihanController::class, 'destroy'])->name('detail_penagihan.destroy');
            });

            Route::middleware(['permission:confirm penagihan'])->group(function() {
                Route::post('/confirm/{penagihan}', [PenagihanController::class, 'confirm'])->name('penagihan.confirm');
                Route::post('/reject/{penagihan}', [PenagihanController::class, 'reject'])->name('penagihan.reject');
            });
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/pengajuan-dana', [LaporanController::class, 'pengajuan_dana'])->name('laporan.pengajuan_dana');
        Route::get('/pencairan-dana', [LaporanController::class, 'pencairan_dana'])->name('laporan.pencairan_dana');
        Route::get('/penagihan', [LaporanController::class, 'penagihan'])->name('laporan.penagihan');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/artisan.php';
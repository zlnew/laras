<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/ssh/storage-link', function () {
    Artisan::call('storage:link');
    dd('Storage linked!');
});

Route::get('/ssh/key-generate', function () {
    Artisan::call('key:generate');
    dd('Key generated!');
});

Route::get('/ssh/cache-clear', function () {
    Artisan::call('cache:clear');
    dd('Cache cleared!');
});

Route::get('/ssh/route-clear', function () {
  Artisan::call('route:clear');
  dd('Routes cleared!');
});

Route::get('/ssh/config-clear', function () {
  Artisan::call('config:clear');
  dd('Config cleared!');
});

Route::get('/ssh/view-clear', function () {
  Artisan::call('view:clear');
  dd('Views cleared!');
});

Route::get('/ssh/optimize-clear', function () {
  Artisan::call('optimize:clear');
  dd('All Optimized!');
});
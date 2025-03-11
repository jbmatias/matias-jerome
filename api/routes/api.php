<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\GetStoreHoursController;
use Illuminate\Support\Facades\Route;

Route::get('/store-hours', GetStoreHoursController::class)->name('index.store-hours');
Route::put('/store-hours', ConfigurationController::class)->name('update.store-hours');

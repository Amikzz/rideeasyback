<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/view-bus-schedule', [UserController::class, 'viewBusSchedule'])->name('view-bus-schedule');
Route::get('/location-get', [UserController::class, 'locationget'])->name('locationget');
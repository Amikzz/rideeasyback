<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function (){
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard/addride', function (){
        return view('addride');
    })->name('addride');
    Route::post('/dashboard/addride', [App\Http\Controllers\ConductorController::class, 'busDriveConductorRegistration'])->name('addridepost');
    Route::get('/dashboard/viewtrips', [App\Http\Controllers\ConductorController::class, 'viewTrips'])->name('viewtrips');
    Route::post('/dashboard/viewtrips', [App\Http\Controllers\ConductorController::class, 'viewTrips'])->name('viewtrips.post');
    Route::get('/dashboard/deleteride', [App\Http\Controllers\ConductorController::class, 'showDeleteRideForm'])->name('deleteride');
    Route::post('/dashboard/deleteride', [App\Http\Controllers\ConductorController::class, 'deleteRide'])->name('deleteride.post');
    Route::post('/update-location', [App\Http\Controllers\UserController::class, 'liveLocationTracking'])->name('updatelocation.post');
    Route::post('/dashboard/viewtrips/{trip_id}', [App\Http\Controllers\ConductorController::class, 'startTrip'])->name('starttrip.post');
    Route::post('/dashboard/viewtrips/{trip_id}/end', [App\Http\Controllers\ConductorController::class, 'endTrip'])->name('endtrip.post');
});

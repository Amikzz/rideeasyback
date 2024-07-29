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
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/dashboard/addride', [App\Http\Controllers\ConductorController::class, 'showAddRideForm'])->name('addride');
    Route::post('/dashboard/addride', [App\Http\Controllers\ConductorController::class, 'busDriveConductorRegistration'])->name('addridepost');
    Route::get('/dashboard/viewtrips', [App\Http\Controllers\ConductorController::class, 'viewTrips'])->name('viewtrips');
    Route::post('/dashboard/viewtrips', [App\Http\Controllers\ConductorController::class, 'viewTrips'])->name('viewtrips.post');
    Route::get('/dashboard/deleteride', [App\Http\Controllers\ConductorController::class, 'showDeleteRideForm'])->name('deleteride');
    Route::delete('/dashboard/viewtrips/{trip_id}/delete', [App\Http\Controllers\ConductorController::class, 'deleteRide'])->name('deleteride.post');
    Route::post('/update-location', [App\Http\Controllers\UserController::class, 'liveLocationTracking'])->name('updatelocation.post');
    Route::post('/dashboard/viewtrips/{trip_id}', [App\Http\Controllers\ConductorController::class, 'startTrip'])->name('starttrip.post');
    Route::post('/dashboard/viewtrips/{trip_id}/end', [App\Http\Controllers\ConductorController::class, 'endTrip'])->name('endtrip.post');
    Route::get('/dashboard/support', [App\Http\Controllers\ConductorController::class, 'showSupportForm'])->name('support');
    Route::post('/dashboard/support', [App\Http\Controllers\ConductorController::class, 'conductorSupportController'])->name('support.post');
});

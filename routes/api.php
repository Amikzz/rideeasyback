<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/view-bus-schedule', [UserController::class, 'viewBusSchedule'])->name('view-bus-schedule');
Route::get('/location-get', [UserController::class, 'locationget'])->name('locationget');
Route::post('/review-post', [UserController::class, 'reviewStore'])->name('review.post');
Route::post('/support-post', [UserController::class, 'supportRequest'])->name('support.get');
Route::post('/search-bus', [UserController::class, 'searchBus'])->name('search.bus');
Route::post('/book-ticket', [UserController::class, 'bookTicket'])->name('book.ticket');
Route::post('/safety-button', [UserController::class, 'safetyButton'])->name('safety.button');
Route::post('/check-seats', [UserController::class, 'seatAvailability'])->name('availability.seat');
Route::post('/seat-booking', [UserController::class, 'seatReservation'])->name('seat.booking');

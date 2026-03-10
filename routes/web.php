<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/ics', [EventController::class, 'downloadIcs'])->name('events.ics');
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');

Route::get('/submit-event', [EventController::class, 'create'])->name('events.create');
Route::post('/submit-event', [EventController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('events.store');

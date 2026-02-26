<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;



Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/eventos/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/divulgar-evento', [EventController::class, 'create'])->name('events.create');
Route::post('/divulgar-evento', [EventController::class, 'store'])->name('events.store');

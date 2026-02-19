<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventSubmissionController;

Route::get('/enviar-evento', [EventSubmissionController::class, 'create'])->name('events.create');
Route::post('/enviar-evento', [EventSubmissionController::class, 'store'])->name('events.store');

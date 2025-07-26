<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeLogController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time_logs.index');
Route::post('/time-logs', [TimeLogController::class, 'store'])->name('time_logs.store');
Route::get('/time-logs/{timeLog}/edit', [TimeLogController::class, 'edit'])->name('time_logs.edit');
Route::put('/time-logs/{timeLog}', [TimeLogController::class, 'update'])->name('time_logs.update');

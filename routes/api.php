<?php

use App\Http\Controllers\Api\Taskcontroller;
use Illuminate\Support\Facades\Route;

Route::post('/tasks', [Taskcontroller::class, 'store']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/todo', [TodoController::class, 'create']);
    Route::get('/todos', [TodoController::class, 'index']);
    Route::delete("/todo/{todo}", [TodoController::class, 'destroy']);
    Route::put('/todo/{todo}', [TodoController::class, 'update']);
    Route::get('/trash', [TodoController::class, 'trash']);
    Route::put('/trash/{todo}/restore', [TodoController::class, 'restore']);
    Route::delete('/trash/{todo}', [TodoController::class, 'forceDelete']);
});

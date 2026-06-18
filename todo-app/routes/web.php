<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::middleware('auth')->group( function () {
    Route::post('/todo', [TodoController::class, 'create']);
    Route::get('/todos', [TodoController::class, 'index']);
    Route::delete("/todo/{todo}", [TodoController::class, 'destroy']);
    Route::put('/todo/{todo}', [TodoController::class, 'update']);
});

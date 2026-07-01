<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// These are routes exposed to the public
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// these are positional, login will be caught before the catchall down below
// if i want to add more php pages, i can just add them above the catchall
Route::view('/login', 'login');

// These are public view routes that ship php
Route::get('/{any}', function () {
    return view('welcome'); // Points to resources/views/app.blade.php
})->where('any', '.*');

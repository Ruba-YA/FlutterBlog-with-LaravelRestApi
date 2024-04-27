<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AdminController::class, 'create']);
Route::post('/register', [AdminController::class, 'store']);

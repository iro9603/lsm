<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/calendario', function () {
    return view('admin.calendario');
})->name('calendario');
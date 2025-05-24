<?php

use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CalendarController;

Route::get('/', function () {
    return view('admin.dashboard');
})->middleware('can:access_dashboard')->name('dashboard');

Route::resource('users', UserController::class)->middleware('can:manage_users');
Route::resource('roles', RoleController::class)->middleware('can:manage_roles');
Route::resource('permissions', PermissionController::class)->middleware('can:manage_permissions');

Route::resource('calendar', CalendarController::class)->middleware('can:access_dashboard');
Route::resource('bookings', BookingsController::class)->middleware('can:access_dashboard');



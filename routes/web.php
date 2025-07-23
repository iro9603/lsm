<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ManageDatesController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckCartItems;
use App\Livewire\Asesoria;
use App\Livewire\Us;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('courses', [CourseController::class, 'index'])->name('courses.index');


Route::get('courses/my-courses', [CourseController::class, 'myCourses'])->middleware('auth')->name('courses.myCourses');

Route::get('my-classes', [ClassesController::class, 'index'])->middleware('auth')->name('classes.myClasses');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::get('courses-status/{course}/{lesson?}', [CourseController::class, 'status'])->name('courses.status');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('checkout', [CheckOutController::class, 'index'])->middleware(CheckCartItems::class)->name('checkout.index');


Route::post('checkout/createPaypalOrder', [CheckOutController::class, 'createPaypalOrder'])->name('checkout.createPaypalOrder');

Route::post('checkout/capturePaypalOrder', [CheckOutController::class, 'capturePaypalOrder'])->name('checkout.capturePaypalOrder');

Route::get('gracias', function () {
    return view('gracias');
})->name('success');

Route::get('asesoria', [Asesoria::class, 'index'])->middleware('auth')->name('asesoria');

Route::post('asesoria/bookClass', [ManageDatesController::class, 'handleForm'])->middleware('auth')->name('asesoria.handleForm');

Route::get('auth/google', [GoogleController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

Route::get('us', [Us::class, 'render'])->name('nosotros');

Route::get('/calendar/{date}', [ManageDatesController::class, 'getTimeSlotsperDay'])->name('user.getTimeSlots')->middleware('auth:sanctum');

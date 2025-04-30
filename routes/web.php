<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ManageDatesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckCartItems;
use App\Livewire\Asesoria;
use App\Models\AvailableSlot;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\TimeSlot;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::get('courses-status/{course}', [CourseController::class, 'status'])->name('courses.status');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('checkout', [CheckOutController::class, 'index'])->middleware(CheckCartItems::class)->name('checkout.index');

Route::get('prueba', function () {
    /* TimeSlot::create([
        'start_time' => '10:00:00',
        'end_time' => '11:00:00'
    ]); */

    AvailableSlot::create([
        'date' => '2025-04-30',
        'time_slot_id' => 2
    ]);

});

Route::post('/create-spei-payment', [PaymentController::class, 'createSPEIPayment'])->name('checkout.payment');

Route::post('checkout/createPaypalOrder', [CheckOutController::class, 'createPaypalOrder'])->name('checkout.createPaypalOrder');

Route::post('checkout/capturePaypalOrder', [CheckOutController::class, 'capturePaypalOrder'])->name('checkout.capturePaypalOrder');

Route::get('gracias', function () {
    return view('gracias');
})->name('gracias');

Route::get('asesoria/', [Asesoria::class, 'index'])->name('asesoria');

Route::get('calendar/{date}', [ManageDatesController::class, 'getTimeSlots'])->name('calendar.getTimeSlots');

Route::post('calendar/captureClass', [ManageDatesController::class, 'handleForm'])->name('calendar.handleForm');


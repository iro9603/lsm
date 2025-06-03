<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ManageDatesController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckCartItems;
use App\Livewire\Asesoria;


use App\Models\Course;
use App\Models\Lesson;
use App\Models\TimeSlot;
use CodersFree\Shoppingcart\Facades\Cart;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('courses', [CourseController::class, 'index'])->name('courses.index');


Route::get('courses/my-courses', [CourseController::class, 'myCourses'])->middleware('auth')->name('courses.myCourses');

Route::get('my-classes', [ClassesController::class, 'index'])->middleware('auth')->name('classes.myClasses');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::get('courses-status/{course}/{lesson?}', [CourseController::class, 'status'])->name('courses.status');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('checkout', [CheckOutController::class, 'index'])->middleware(CheckCartItems::class)->name('checkout.index');

Route::get('prueba', function () {
    $start = Carbon::createFromTimeString('00:00:00');

    while ($start->lt(Carbon::createFromTimeString('23:59:59'))) {
        $end = (clone $start)->addMinutes(30);

        TimeSlot::create([
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
        ]);

        $start->addMinutes(30);
    }

    /* AvailableSlot::create([
        'date' => '2025-05-11',
        'time_slot_id' => 2
    ]); */

});

/* Route::post('/create-spei-payment', [PaymentController::class, 'createSPEIPayment'])->name('checkout.payment'); */

Route::post('checkout/createPaypalOrder', [CheckOutController::class, 'createPaypalOrder'])->name('checkout.createPaypalOrder');

Route::post('checkout/capturePaypalOrder', [CheckOutController::class, 'capturePaypalOrder'])->name('checkout.capturePaypalOrder');

Route::get('gracias', function () {
    return view('gracias');
})->name('success');

Route::get('asesoria', [Asesoria::class, 'index'])->middleware('auth')->name('asesoria');

Route::post('asesoria/bookClass', [ManageDatesController::class, 'handleForm'])->middleware('auth')->name('asesoria.handleForm');



/* Route::post('/create-payment-intent', [StripeController::class, 'handleTransfer'])->name('StripeCheckout');
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle']); */

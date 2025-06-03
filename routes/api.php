<?php

use App\Http\Controllers\MercadoPagoWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\AvailableSlotsController;
use App\Http\Controllers\ManageDatesController;

Route::post('/reserveSlots', [\App\Http\Controllers\Admin\AvailableSlotsController::class, 'createSlots']);
Route::get('/timeSlots', [\App\Http\Controllers\Admin\AvailableSlotsController::class, 'getTimeSlots']);
Route::delete('/destroySlots/{id}', [\App\Http\Controllers\Admin\AvailableSlotsController::class, 'destroyTimeSlots']);
Route::get('calendar/{date}', [ManageDatesController::class, 'getTimeSlots'])->name('user.getTimeSlots');

Route::post('/mercadopago/webhook', [MercadoPagoWebhookController::class, 'handle']);

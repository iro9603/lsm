<?php

use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\InfoController;
use App\Livewire\ChatComponent;
use App\Livewire\ChatTutorComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('instructor.dashboard');
});

Route::redirect('/', '/instructor/courses')->name('home');

/* Cursos */
Route::resource('courses', CourseController::class);

Route::get('courses/{course}/video', [CourseController::class, 'video'])->name('courses.video');


Route::get('courses/{course}/goals', [CourseController::class, 'goals'])->name('courses.goals');

Route::get('courses/{course}/requirements', [CourseController::class, 'requirements'])->name('courses.requirements');

Route::get('courses/{course}/curriculum', [CourseController::class, 'curriculum'])->name('courses.curriculum');

Route::put('courses/{course}/status',  [CourseController::class, 'updateStatus'])->name('courses.update-status');

Route::resource('info', InfoController::class);

Route::get('chatroom', [ChatTutorComponent::class, 'index'])->middleware(['auth'])->name('chatroom.index');

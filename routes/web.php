<?php

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg
;
Route::get('/', function () {
    return view('welcome');
});

Route::get('prueba', function () {
    $course = Course::first();
    $sections = $course->sections()->with([
        'lessons' => function ($query) {
            $query->orderBy('position', 'asc');
        }
    ])->get();

    $orderLessons = $sections->pluck('lessons')->collapse()->pluck('id');

    return $orderLessons->search(5) + 1;
});

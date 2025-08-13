<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ExchangeRate;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{


    public function index()
    {
        return view('courses.index');
    }

    public function show(Course $course)
    {


        // Sumar duración de todas las lecciones de todas las secciones del curso
        $totalDuration = $course->sections()
            ->with('lessons') // para evitar N+1
            ->get()
            ->flatMap(fn($section) => $section->lessons)
            ->sum('duration');

        return view('courses.show', compact('course', 'totalDuration'));
    }

    public function myCourses()
    {
        $courses = Auth::user()->courses_enrolled;


        return view('courses.my-courses', compact('courses'));
    }

    public function status(Course $course, ?Lesson $lesson = null)
    {
        // Recuperar las lecciones en orden

        $sections = Section::where('course_id', $course->id)->whereHas('lessons', function ($query) {
            $query->where('is_published', true);
        })->with('lessons', function ($query) {
            $query->where('is_published', true)->orderBy('position', 'asc');
        })->orderBy('position', 'asc')->get();

        $lessons = $course->sections->pluck('lessons')->collapse();
        $orderLessons = $sections->pluck('lessons')->collapse()->pluck('id');
        // Si no hay leccion seleccionada se encuentra la primera
        if (!$lesson) {
            $lesson = Lesson::whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id())->where('current', true);
            })->first();

            if (!$lesson) {
                $lesson = $lessons->first();
            }


            return redirect()->route('courses.status', [$course, $lesson]);
        }

        // Se lleva control de la leccion visualizada
        if (Auth::check()) {
            DB::table('course_lesson_user')->where('user_id', Auth::id())->where('course_id', $course->id)->update([
                'current' => false
            ]);

            DB::table('course_lesson_user')->updateOrInsert([
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'user_id' => Auth::id()

            ], [
                'current' => true
            ]);
        }



        return view('courses.status', compact('course', 'sections', 'lessons', 'lesson', 'orderLessons'));
    }
}

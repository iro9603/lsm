<?php

namespace App\Livewire;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CourseStatus extends Component
{
    public $course;

    public $lessons;

    public $current;

    public $sections;

    public $orderLessons;

    public $open_lessons;

    public $completed = false;

    public $advance;

    public $review = [
        'open' => false,
        'rating' => 5,
        'comment' => ''
    ];

    public function mount()
    {
        $this->setOpenLessons();
        $this->setCompleted();
        $this->setAdvance();
    }

    public function updated($property, $value)
    {
        if ($property == 'completed') {
            DB::table('course_lesson_user')->where('lesson_id', $this->current->id)->where('user_id', Auth::id())->update([
                'completed' => $value
            ]);

            $this->setOpenLessons();
        }
    }

    public function previousLesson()
    {

        $index = $this->lessons->pluck('id')->search($this->current->id);

        if ($index == 0) {
            $lesson = $this->lessons->last();
        } else {
            $lesson = $this->lessons[$index - 1];
        }

        return redirect()->route('courses.status', [$this->course, $lesson['slug']]);
    }

    public function nextLesson()
    {
        $index = $this->lessons->pluck('id')->search($this->current->id);
        if ($index == $this->lessons->count() - 1) {
            $lesson = $this->lessons->first();

        } else {
            $lesson = $this->lessons[$index + 1];
        }

        return redirect()->route('courses.status', [$this->course, $lesson]);
    }

    public function setOpenLessons()
    {
        $this->open_lessons = DB::table('course_lesson_user')->where('course_id', $this->course->id)->where('user_id', Auth::id())->whereIn('lesson_id', $this->lessons->pluck('id'))->get();
    }

    public function setCompleted()
    {

        $this->completed = $this->open_lessons->where('user_id', Auth::id())->where('lesson_id', $this->current->id)->where('completed', 1)->count();




    }

    public function setAdvance()
    {
        $this->advance = round($this->open_lessons->where('completed', 1)->count() * 100 / ($this->lessons->count()));
    }

    public function completedLesson()
    {
        DB::table('course_lesson_user')->where('lesson_id', $this->current->id)->where('user_id', Auth::id())->update([
            'completed' => true
        ]);

        $this->nextLesson();
    }


    public function storeReview()
    {

        $this->validate([
            'review.rating' => 'required',
            'review.comment' => 'required'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
            'rating' => $this->review['rating'],
            'comment' => $this->review['comment']
        ]);

        $this->reset('review');
    }

    public function render()
    {
        return view('livewire.course-status');
    }
}

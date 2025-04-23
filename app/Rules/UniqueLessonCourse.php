<?php

namespace App\Rules;

use App\Models\Lesson;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
class UniqueLessonCourse implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public $courseId;

    public function __construct($courseId)
    {
        $this->courseId = $courseId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $slug = Str::slug($value);

        $lesson = Lesson::where('slug', $slug)->whereHas('section', function ($query) {
            $query->where('course_id', $this->courseId);
        })->first();

        if ($lesson) {
            $fail('Ya existe una lección con este nombre en este curso.');
        }
    }
}

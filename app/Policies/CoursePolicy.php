<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function enrolled(User $user, Course $course)
    {
        return $user->courses_enrolled->contains($course);
    }

    public function review_enabled(User $user, Course $course)
    {
        return $user->courses_enrolled->contains($course) && $user->reviews()->where('course_id', $course->id)->doesntExist();
    }
}

<?php

namespace App\Livewire\Instructor\Courses;

use App\Events\VideoUploaded;
use App\Models\Lesson;
use App\Rules\UniqueLessonCourse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLessons extends Component
{

    use WithFileUploads;

    public $section;
    public $lesson;

    public $video, $url;

    public $lessonCreate = [
        'open' => false,
        'name' => null,
        /* 'slug' => null, */
        'platform' => 1,
        /* 'video_path' => null, */
        'video_original_name' => null
    ];

    public function rules()
    {
        $rules = [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.platform' => 'required',
        ];

        if ($this->lessonCreate['platform'] == 1) {
            $rules['video'] = 'required|mimes:mp4,mov,avi,wmv,flv,3gp';
        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }


        return $rules;
    }

    public function store()
    {
        $this->validate();

        if ($this->lessonCreate['platform'] == 1) {
            $this->lessonCreate['video_original_name'] = $this->video->getClientOriginalName();
            $lesson = $this->section->lessons()->create($this->lessonCreate);
            $this->dispatch('uploadVideo', $lesson->id)->self();
        } elseif ($this->lessonCreate['platform'] == 2) {


            $this->lessonCreate['video_original_name'] = $this->url;
            $lesson = $this->section->lessons()->create($this->lessonCreate);

            VideoUploaded::dispatch($lesson);
        }

        $this->reset(['url', 'lessonCreate']);
    }

    #[On('uploadVideo')]
    public function uploadVideo($lessonId)
    {

        $lesson = Lesson::find($lessonId);

        $lesson->video_path = $this->video->store('courses/lessons');

        $lesson->save();

        VideoUploaded::dispatch($lesson);

        $this->reset('video');

    }

    public function render(
    ) {
        return view('livewire.instructor.courses.manage-lessons');
    }
}

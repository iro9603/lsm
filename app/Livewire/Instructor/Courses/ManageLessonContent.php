<?php

namespace App\Livewire\Instructor\Courses;

use App\Events\VideoUploaded;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLessonContent extends Component
{
    use WithFileUploads;
    public $lesson;

    public $editVideo = false;

    public $platform = 1, $video, $url;

    public function saveVideo()
    {
        $rules = [
            'platform' => 'required'
        ];
        if ($this->platform == 1) {
            $rules['video'] = 'required|mimes:mp4,mov,avi,wmv,flv,3gp';


        } else {
            $rules['url'] = ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?(youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]{10,12})/'];
        }

        $this->validate($rules);

        if ($this->lesson->platfom == 1) {
            Storage::delete($this->lesson->video_path);

            Storage::delete('lessons/original/' . $this->lesson->image_path);
        }

        $this->lesson->platform = $this->platform;


        $this->lesson->is_processed = false;

        if ($this->platform == 1) {
            $this->lesson->video_original_name = $this->video->getClientOriginalName();



            $this->lesson->save();

            $this->dispatch('uploadVideo', $this->lesson->id)->self();
        } else {

            $this->lesson->video_original_name = $this->url;

            $this->lesson->save();

            VideoUploaded::dispatch($this->lesson);
        }

        $this->reset('editVideo', 'platform', 'url');

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


    public function render()
    {
        return view('livewire.instructor.courses.manage-lesson-content');
    }
}
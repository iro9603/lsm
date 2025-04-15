<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class PromotionalVideo extends Component
{

    use WithFileUploads;

    public $course;

   
    public $video;

    public function rules()
    {
        return [
            'video' => 'required|file|mimes:mp4,avi,mov', // ajusta las reglas según necesites
        ];
    }

public function save(){

        $this->validate();
    
        if (!$this->video) {
            throw new \Exception('Archivo no recibido por Livewire');
        }
    
        try {
            if (!$this->video->isValid()) {
                throw new \Exception('Archivo inválido o dañado');
            }
    
            $path = $this->video->store('courses/promotional-videos', 'public');
            $this->course->video_path = $path;
            $this->course->save();
            
            return $this->redirectRoute('instructor.courses.video', $this->course, true, true);
        } catch (\Exception $e) {
            session()->flash('error', 'Subir video ha fallado: ' . $e->getMessage());
        }
        /* $this->validate();
        dd($this->video);
        $this->course->video_path = $this->video->store('courses/promotional-videos', 'public');

        $this->course->save(); */
    }
        

      
    

    public function render()
    {
        return view('livewire.instructor.courses.promotional-video');
    }
}

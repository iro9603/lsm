<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Goal;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Goals extends Component
{

    public $course;

    public $goals;

    #[Validate('required|string|max:255')]
    public $name;



    public function mount(){
        $this->goals = Goal::where('course_id', $this->course->id)->get()->toArray();
    }

    public function store(){
  
        $this->validate();
    
        $this->course->goals()->create([
            'name' => $this->name
        ]);

        $this->goals = Goal::where('course_id', $this->course->id)->get()->toArray();
        

        $this->reset('name');

    }

    public function update(){
        $this->validate([
            'goals.*.name' => 'required|string|max:255'
        ]);

        foreach ($this->goals as $goal) {
            # code...
            Goal::find($goal['id'])->update([
                'name' => $goal['name']
            ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'Los objetivos se han actualizado correctamente'
        ]);
    }


    public function render()
    {
        return view('livewire.instructor.courses.goals');
    }
}

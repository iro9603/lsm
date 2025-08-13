<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Tutors extends Component
{
    public $tutors;

    public function mount($tutors)
    {
        $this->tutors = $tutors;
    }

    public function render()
    {
        return view('livewire.tutors');
    }
}

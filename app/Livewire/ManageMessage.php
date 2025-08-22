<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ManageMessage extends Component
{

    public $tutor;
    public $content;
    public $tutorName;
    public $mensajes;

    public function mount($tutor)
    {
        $this->tutor = $tutor;

        $this->tutorName = $this->tutor->name;
        $this->getMensajes();
    }

    public function getMensajes()
    {
        $this->mensajes = Message::with('user')->where('user_id', $this->tutor->id)
            ->latest()
            ->get();
    }

    public function save()
    {

        $this->validate([
            'content' => 'required|min:5'
        ]);

        Message::create([
            'content' => $this->content,
            'user_id' => Auth::id()
        ]);
        $this->content = "";
        $this->getMensajes();
    }
    public function render()

    {
        return view('livewire.manage-message');
    }
}

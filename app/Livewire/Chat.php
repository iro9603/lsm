<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Chat extends Component
{
    public $messages;
    public $newMessage;

    public function mount()
    {
        $this->messages = Message::with('user')->latest()->take(20)->get()->reverse();
    }

    public function sendMessage()
    {
        $message = Message::create([
            'user_id' => Auth::id(),
            'content' => $this->newMessage
        ]);

        $this->newMessage = '';

        broadcast(new \App\Events\MessageSent($message))->toOthers();
        $this->messages->push($message);
    }

    #[On('message-received')]
    public function addMessage($message)
    {
        $this->messages->push(Message::find($message['id']));
    }

    public function render()
    {
        return view('livewire.chat');
    }
}

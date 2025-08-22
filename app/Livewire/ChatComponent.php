<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatComponent extends Component
{
    public $search;

    public $contactChat, $chat;

    public $bodyMessage;

    //Propiedad computada

    public function getContactsProperty()
    {
        return Contact::where('user_id', Auth::user()->id)->when($this->search, function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'like', $this->search . '%')
                    ->orWhereHas('user', function ($query) {
                        $query->where('email', 'like', $this->search . '%');
                    });
            });
        })->get() ?? [];
    }

    //Propiedad computada
    public function getMessagesProperty()
    {

        return $this->chat ?  $this->chat->messages()->get() : [];
    }

    public function getChatsProperty()
    {
        return Auth::user()->chats()->get();
    }

    public function open_chat(Chat $chat)
    {
        $this->chat = $chat;
        $this->reset('contactChat', 'bodyMessage');
    }

    public function open_chat_contact(Contact $contact)
    {
        $chat = Auth::user()->chats()->whereHas('users', function ($query) use ($contact) {
            $query->where('user_id', $contact->contact_id);
        })->has('users', 2)->first();
        if ($chat) {
            $this->chat = $chat;
            $this->reset('contactChat', 'bodyMessage', 'search');
        } else {
            $this->contactChat = $contact;
            $this->reset('chat', 'bodyMessage', 'search');
        }
    }


    public function sendMessage()
    {
        $this->validate(['bodyMessage' => 'required']);
        if (!($this->chat)) {
            $this->chat = Chat::create();
            $this->chat->users()->attach([Auth::user()->id, $this->contactChat->contact_id]);
        }
        $this->chat->messages()->create([
            'body' => $this->bodyMessage,
            'user_id' => Auth::user()->id
        ]);

        $this->reset('bodyMessage', 'contactChat');
    }

    public function index()
    {
        return view('chatroom.index');
    }

    public function render()
    {

        return view('livewire.chat-component');
    }

    public function closeChat()
    {
        $this->chat = null;
        $this->contactChat = null;
    }
}

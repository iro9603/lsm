<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ChatTutorComponent extends Component
{
    public $search;

    public $contactChat, $chat;

    public $bodyMessage, $users;
    public $chat_id;

    public $receiver;
    public function mount()
    {
        $this->users = collect();
    }

    public function getListeners()
    {
        $user_id = Auth::id();

        return [
            "echo-private:App.Models.User.{$user_id},MessageSent" => 'render',
            "echo-presence:chat.1,here" => 'chatHere',
            "echo-presence:chat.1,joining" => 'chatJoining',
            "echo-presence:chat.1,leaving" => 'chatLeaving',
        ];
    }



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
        return Auth::user()->chats()->get()->sortByDesc('last_message_at');
    }

    public function getUsersNotificationsProperty()
    {
        return $this->chat ? $this->chat->users->where('id', '!=', Auth::id()) : collect();
    }

    public function getActiveProperty()
    {
        return $this->users->contains($this->users_notifications->first()->id);
    }

    public function updatedBodyMessage($value)
    {
        if ($value) {
            $this->receiver = $this->chat->users->where('id', '!=', Auth::id())->first();
            $receiver_id = $this->receiver->id;
            broadcast(new UserTyping($this->chat->id, $receiver_id));
        }
    }

    public function open_chat(Chat $chat)
    {
        $this->chat = $chat;
        $this->chat_id = $this->chat->id;
        $this->reset('contactChat', 'bodyMessage');
    }

    public function open_chat_contact(Contact $contact)
    {
        $chat = Auth::user()->chats()->whereHas('users', function ($query) use ($contact) {
            $query->where('user_id', $contact->contact_id);
        })->has('users', 2)->first();
        if ($chat) {
            $this->chat = $chat;
            $this->chat_id = $this->chat->id;
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
            $this->chat_id = $this->chat->id;
            $this->chat->users()->attach([Auth::user()->id, $this->contactChat->contact_id]);
        }

        $this->chat->messages()->create([
            'body' => $this->bodyMessage,
            'user_id' => Auth::user()->id
        ]);

        if ($this->contactChat) {
            $receiver_id = $this->contactChat->contact_id;
        } else {
            // Si el chat ya existe, obtener el otro usuario del chat
            $receiver_id = $this->chat->users->where('id', '!=', Auth::id())->first()->id;
        }



        broadcast(new MessageSent($receiver_id))->toOthers();

        $this->reset('bodyMessage', 'contactChat');
    }

    public function chatHere($users)
    {
        $this->users = collect($users)->pluck('id');
    }

    public function chatJoining($user)
    {
        $this->users->push($user['id']);
    }

    public function chatLeaving($user)
    {
        $this->users = $this->users->filter(function ($id) use ($user) {
            return $id != $user['id'];
        });
    }

    public function index()
    {
        return view('instructor.chatroom.index');
    }

    public function render()
    {
        if ($this->chat) {
            $this->dispatch('scrollIntoView');
        }
        return view('livewire.chat-component');
    }

    public function closeChat()
    {
        $this->chat = null;
        $this->contactChat = null;
    }
}

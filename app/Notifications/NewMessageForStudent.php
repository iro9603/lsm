<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Notification;

class NewMessageForStudent extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     */
    public $message;

    public $tutor_id;

    public $chat;

    public $receiver_id; // <-- destinatario

    public function __construct($message, $tutor_id, $chat, $receiver_id)
    {
        $this->message = $message;
        $this->tutor_id = $tutor_id;
        $this->chat = $chat;
        $this->receiver_id = $receiver_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $sender = User::findOrfail($this->tutor_id);

        $sender_name = $sender->name;
        return (new MailMessage)
            ->subject('📩 Nuevo mensaje de tu tutor')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has recibido un **nuevo mensaje** de tu tutor.')
            ->line('👤 De: ' . $sender_name) // asumiendo que pasas el mensaje al notification
            ->line('💬 "' . \Str::limit($this->message, 100) . '"') // muestra un preview del mensaje
            ->action('Ver mensaje',  route('chatroom.index')) // link directo al chat
            ->line('Gracias por seguir en contacto en nuestra plataforma. 🚀');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function broadcastOn()
    {
        return ['App.Models.User.' . $this->receiver_id];
    }

    public function broadcastWith()
    {
        return [
            'chat_id' => $this->chat->id,
            'body' => $this->message,
            'user_id' => $this->tutor_id
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([]);
    }
}

<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\BroadcastMessage;


use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class NewMessage extends Notification implements ShouldBroadcastNow
{
    use Queueable;
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new notification instance.
     */

    protected $receiver_id;

    public function __construct($receiver_id)
    {
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

    public function toBroadcast($notifiable)
    {
        /* dd("ENVIANDO", $notifiable->id); */
        return new BroadcastMessage([
            'message' => 'Tienes un nuevo mensaje',
        ]);
    }

    public function broadcastOn()
    {
        // $notifiable es el usuario que recibe la notificación
        return new PrivateChannel('App.Models.User.' . $this->receiver_id);
    }
}

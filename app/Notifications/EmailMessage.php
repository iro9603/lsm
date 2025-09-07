use Illuminate\Notifications\Messages\MailMessage;


/**
* Get the mail representation of the notification.
*/


/* public function toMail(object $notifiable): MailMessage
{
$sender = User::findOrfail($this->user_id);

$sender_name = $sender->name;
return (new MailMessage)
->subject('📩 Nuevo mensaje en el chat')
->greeting('¡Hola ' . $notifiable->name . '!')
->line('Has recibido un **nuevo mensaje** en tu chat.')
->line('👤 De: ' . $sender_name) // asumiendo que pasas el mensaje al notification
->line('💬 "' . \Str::limit($this->message, 100) . '"') // muestra un preview del mensaje
->action('Ver mensaje', route('instructor.chatroom.index')) // link directo al chat
->line('Gracias por seguir en contacto en nuestra plataforma. 🚀');
} */
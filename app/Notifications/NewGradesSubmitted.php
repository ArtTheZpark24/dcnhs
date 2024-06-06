<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGradesSubmitted extends Notification
{  

    public $mailmessage;
    public  $subjectMail;
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($mailmessage, $subjectMail)
    {
        $this->mailmessage = $mailmessage;
        $this->subjectMail = $subjectMail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subjectMail)
            ->line($this->mailmessage['grades'])
            ->line('Thank you for using our application!');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GradesSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $mailmessage;
    public $subjectMail;

    /**
     * Create a new message instance.
     */
    public function __construct($mailmessage, $subjectMail)
    {
        $this->mailmessage = $mailmessage;
        $this->subjectMail = $subjectMail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.newgrade')
                    ->subject($this->subjectMail);
    }
}

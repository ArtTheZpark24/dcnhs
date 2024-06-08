<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class GradePosted extends Notification
{
    use Queueable;

    protected $finalGrade;
    protected $studentId;

    /**
     * Create a new notification instance.
     */
    public function __construct($finalGrade, $studentId = null)
    {
        $this->finalGrade = $finalGrade;
        $this->studentId = $studentId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = '';

     
        if (Auth::guard('student')->check()) {
            $url = url('http://127.0.0.1:8000/student/grades');
        } elseif (Auth::guard('guardian')->check() && !is_null($this->studentId)) {
            $url = url('http://127.0.0.1:8000/guardian/student/grades/' . $this->studentId);
        } elseif (Auth::guard('guardian')->check()) {
     
            $url = url('http://127.0.0.1:8000/guardian/dashboard');
        }

        return (new MailMessage)
            ->subject('Your grades have been posted')
            ->greeting('New grades have been posted.')
            ->line('Grade: ' . $this->finalGrade->final_grade)
            ->action('View Grades', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentScheduledNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $appointment;
    

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        \Log::info('Preparing to send email to client: ' . $notifiable->email);
        
        return (new MailMessage)
            ->subject('Appointment Scheduled')
            ->greeting('Hello ' . $this->appointment->client->name . '!')
            ->line('Your appointment for ' . $this->appointment->pet->name . ' has been scheduled.')
            // Make sure `appointment_date` is treated as a Carbon instance
            ->line('Appointment Date: ' . $this->appointment->appointment_date->format('F j, Y, g:i a'))
            ->line('Status: ' . ucfirst($this->appointment->status))
            ->line('Thank you for choosing our veterinary clinic!');
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
}

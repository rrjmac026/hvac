<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\TwilioMessage;
use App\Models\Appointment;


class AppointmentReminderSMS extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['twilio']; // Using Twilio for SMS
    }

    /**
     * Get the Twilio message representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\TwilioMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioMessage)
            ->content("Reminder: You have an appointment on {$this->appointment->appointment_date}. Notes: {$this->appointment->notes}");
    }
}

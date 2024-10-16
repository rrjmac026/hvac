<?php

namespace App\Console;

use App\Models\Appointment; // Import the Appointment model
use App\Notifications\AppointmentReminderMail; // Import the email notification
use App\Notifications\AppointmentReminderSMS; // Import the SMS notification
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Add your custom commands here
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Fetch appointments that are due within the next day
            $appointments = Appointment::where('appointment_date', '<=', now()->addDays(1))->get();

            foreach ($appointments as $appointment) {
                // Send email reminder
                Mail::to($appointment->client->email)->send(new AppointmentReminderMail($appointment));
                
                // Send SMS reminder
                $appointment->client->notify(new AppointmentReminderSMS($appointment));
            }
        })->daily(); // Adjust frequency as needed

        $schedule->command('send:vaccination-reminders')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    
}

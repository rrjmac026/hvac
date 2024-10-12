<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Illuminate\Support\Facades\Notification;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:remind';
    protected $description = 'Send appointment reminders to clients';

    public function handle()
    {
        $appointments = Appointment::where('appointment_date', '<=', now()->addHours(24))->get();
        foreach ($appointments as $appointment) {
            Notification::send($appointment->client, new AppointmentReminder($appointment));
        }
    }
}

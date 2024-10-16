<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Notifications\AppointmentReminder;
use App\Models\Appointment;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\AppointmentScheduledNotification;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function afterSave()
    {
        parent::afterSave();

        // Trigger notification
        $appointment = $this->record;
        $appointment->client->notify(new AppointmentReminder($appointment)); // Ensure the client is properly notified
    }

    protected function afterCreate(): void
    {
        // After the appointment is created, send the notification
        $this->record->client->notify(new AppointmentScheduledNotification($this->record));
    }
}

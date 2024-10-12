<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Notifications\AppointmentScheduledNotification;
use App\Models\Appointment;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function afterSave(): void
    {
        // Get the appointment record
        $appointment = $this->record;

        // Send an email notification to the client
        $appointment->client->notify(new AppointmentScheduledNotification($appointment));

        // Optionally, you could also send an SMS or perform other actions here.
    }
}



<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\PetResource;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentScheduledNotification;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Pet;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea; // Import Textarea component
use Illuminate\Database\Eloquent\Model;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
 

class CalendarWidget extends FullCalendarWidget
{

    use HasWidgetShield;
    // Specify the model that this widget interacts with
    public Model|string|null $model = Appointment::class;
    

    public function fetchEvents(array $fetchInfo): array
    {
        // Fetch appointments within the specified range
        $appointments = Appointment::whereBetween('appointment_date', [$fetchInfo['start'], $fetchInfo['end']])
            ->get();

        // Map the appointments to FullCalendar format
        return $appointments->map(function (Appointment $appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->client->name . ' - ' . $appointment->pet->name,
                'start' => $appointment->appointment_date->toIso8601String(),
                'end' => $appointment->appointment_date->addHour()->toIso8601String(), // Adjust duration as needed
                // 'url' => AppointmentResource::getUrl(name: 'edit', parameters: ['record' => $appointment]),
                'shouldOpenUrlInNewTab' => false,
            ];
        })->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    DateTimePicker::make('appointment_date')
                        ->label('Appointment Date')
                        ->required(),
                    
                    Select::make('client_id')
                        ->label('Client')
                        ->options(
                            Client::all()->pluck('name', 'id')->toArray()
                        )
                        ->required()
                        ->placeholder('Select a client')
                        ->reactive() // Make this field reactive
                        ->afterStateUpdated(function ($state, $component) {
                            // Fetch pets based on selected clie    nt
                            $petOptions = Pet::where('client_id', $state)->pluck('name', 'id')->toArray();
                            
                            // Set the options for pet_id dynamically
                            // $component->form->getComponent('pet_id')->options($petOptions);
                        }),
                    
                    
                    Select::make('pet_id')
                        ->label('Pet')
                        ->options(Pet::all()->pluck('name', 'id')->toArray()) // Initially empty
                        ->required()
                        ->placeholder('Select a pet'),
                    

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'scheduled' => 'Scheduled',
                            'completed' => 'Completed',
                            'canceled' => 'Canceled',
                        ])
                        ->default('scheduled')
                        ->required(),

                    Textarea::make('notes') // Use Textarea component
                        ->label('Notes')
                        ->nullable(),
                ]),
        ];
    }

    public function createAppointment(array $data)
    {
        \Log::info('Creating appointment with data:', $data);

        // Create the appointment
        $appointment = Appointment::create($data);

        \Log::info('Appointment created successfully.', ['appointment_id' => $appointment->id]);

        // Make sure client and pet are loaded
        $appointment->load(['client', 'pet']);
        \Log::info('Appointment client:', ['client' => $appointment->client]);
        \Log::info('Appointment pet:', ['pet' => $appointment->pet]);

        // Send notification if client exists
        if ($appointment->client) {
            \Log::info('Sending notification to client:', ['client_id' => $appointment->client->id]);
            Notification::send($appointment->client, new AppointmentScheduledNotification($appointment));
        } else {
            \Log::error('Client not found for appointment ID: ' . $appointment->id);
        }
    }


    public static function canView(): bool
    {
        // Return true to allow it to be viewed on the calendar page
        return request()->routeIs('filament.pages.calendar');
    }
}
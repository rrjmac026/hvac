<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Visit;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Vaccination;
use App\Models\MedicalRecord;
use App\Models\Pet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
 

class AppointmentWidget extends BaseWidget
{
    use HasWidgetShield;
    protected function getStats(): array
    {
        return [
            // Total Appointments
            Stat::make('Total Appointments', Appointment::count())
                ->description('Total Appointments')
                ->descriptionIcon('heroicon-m-calendar', IconPosition::Before)
                ->chart([100, 120, 130, 150, 170, 200]) // Example data
                ->color('success'),
            
            // Total Invoices
            Stat::make('Total Invoices', Invoice::count())
                ->description('Total Invoices')
                ->descriptionIcon('heroicon-m-document', IconPosition::Before)
                ->chart([100, 120, 130, 150, 170, 200]) // Example data
                ->color('success'),
                
            // New Appointments
            Stat::make('New Appointments', Appointment::where('created_at', '>=', now()->subMonth())->count())
                ->description('Appointments added in the last month')
                ->descriptionIcon('heroicon-o-calendar', IconPosition::Before)
                ->chart([5, 10, 15, 20, 25, 30]) // Example data for new appointments
                ->color('primary'),

            // Total Visits
            Stat::make('Total Visits', Visit::count())
                ->description('Total Visits')
                ->descriptionIcon('heroicon-o-document-text', IconPosition::Before)
                ->chart([100, 120, 130, 150, 170, 200]) // Example data
                ->color('warning'),

            // New Visits
            Stat::make('New Visits', Visit::where('created_at', '>=', now()->subMonth())->count())
                ->description('Visits added in the last month')
                ->descriptionIcon('heroicon-m-document-plus', IconPosition::Before)
                ->chart([2, 5, 8, 10, 15, 20]) // Example data for new visits
                ->color('info'),

            // Total Clients
            Stat::make('Total Clients', Client::count())
                ->description('Total number of clients')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([100, 120, 130, 150, 170, 200]) // Example data
                ->color('danger'),

            // Total Pets
            Stat::make('Total Pets', Pet::count())
                ->description('Total number of pets')
                ->descriptionIcon('heroicon-m-user', IconPosition::Before)
                ->chart([200, 220, 240, 260, 280, 300]) // Example data
                ->color('danger'),

            Stat::make('Total Vaccinations', Vaccination::count())
                ->description('Total number of vaccination')
                ->descriptionIcon('heroicon-m-eye-dropper', IconPosition::Before)
                ->chart([200, 220, 240, 260, 280, 300]) // Example data
                ->color('success'),
            Stat::make('Total Medical Records', MedicalRecord::count())
                ->description('Total number of medical records')
                ->descriptionIcon('heroicon-m-finger-print', IconPosition::Before)
                ->chart([200, 220, 240, 260, 280, 300]) // Example data
                ->color('warning'),
        ];
    }
}

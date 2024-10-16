<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Pet;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Total Clients
            // Stat::make('Total Clients', Client::count())
            //     ->description('Total number of clients')
            //     ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            //     ->chart([100, 120, 130, 150, 170, 200]) // Example data
            //     ->color('danger'),

            // // New Clients
            // Stat::make('New Clients', Client::where('created_at', '>=', now()->subMonth())->count())
            //     ->description('Clients added in the last month.')
            //     ->descriptionIcon('heroicon-m-user-plus', IconPosition::Before)
            //     ->chart([5, 10, 15, 20, 25, 30]) // Example data for new clients
            //     ->color('success'),

            // Total Pets
            // Stat::make('Total Pets', Pet::count())
            //     ->description('Total number of pets')
            //     ->descriptionIcon('heroicon-m-user', IconPosition::Before)
            //     ->chart([200, 220, 240, 260, 280, 300]) // Example data
            //     ->color('danger'),

            // // New Pets
            // Stat::make('New Pets', Pet::where('created_at', '>=', now()->subMonth())->count())
            //     ->description('Pets added in the last month.')
            //     ->descriptionIcon('heroicon-m-user', IconPosition::Before)
            //     ->chart([2, 5, 8, 10, 15, 20]) // Example data for new pets
            //     ->color('success'),
        ];
    }
}
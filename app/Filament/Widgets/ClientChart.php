<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;


class ClientChart extends ChartWidget
{

    use HasWidgetShield;
    
    protected static ?string $heading = 'Clients Added per Month';

    protected static ?int $columns = 5; // Adjust column span here


    protected function getData(): array
    {
        $data = Trend::model(Client::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Clients Added',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

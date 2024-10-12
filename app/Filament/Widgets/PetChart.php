<?php

namespace App\Filament\Widgets;

use App\Models\Pet;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class PetChart extends ChartWidget
{
    protected static ?string $heading = 'Pets Added per Month';

    protected function getData(): array
    {
        $data = Trend::model(Pet::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pets Added',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FF9AA2',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Different chart type for variety, or use 'line' if preferred
    }
}

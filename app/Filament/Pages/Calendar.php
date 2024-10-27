<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CalendarWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Calendar extends Page
{

    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.calendar';

    protected function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
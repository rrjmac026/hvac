<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CalendarWidget;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.calendar';

    protected function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
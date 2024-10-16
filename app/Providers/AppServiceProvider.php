<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Notifications\Channels\TwilioChannel;

use Filament\Facades\Filament;

use App\Filament\Widgets\CalendarWidget;



use Livewire\Livewire; 


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Notification::extend('twilio', function ($app) {
            return new TwilioChannel(new TwilioClient(
                $app['config']['services.twilio.sid'],
                $app['config']['services.twilio.token']
            ));
        });

        Livewire::component('filament.widgets.calendar-widget', CalendarWidget::class);

        Filament::registerWidgets([
            // Ensure CalendarWidget is NOT registered here for the dashboard.
            CalendarWidget::class, // REMOVE THIS LINE
        ]);
    }
    
}

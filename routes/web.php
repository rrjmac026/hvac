<?php

use Illuminate\Support\Facades\Route;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderSMS;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('filament.pages.dashboard');
})->middleware(['auth']);

Route::get('/test-sms', function () {
    $appointment = Appointment::first(); // Or fetch a specific appointment
    if ($appointment) {
        $appointment->client->notify(new AppointmentReminderSMS($appointment));
        return 'SMS sent!';
    } else {
        return 'No appointments found!';
    }
});




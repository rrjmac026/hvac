<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendVaccinationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-vaccination-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $upcomingVaccinations = Vaccination::where('next_due_date', '<=', now()->addDays(7))->get();

        foreach ($upcomingVaccinations as $vaccination) {
            $vaccination->pet->owner->notify(new VaccinationReminder($vaccination));
        }
    }

}

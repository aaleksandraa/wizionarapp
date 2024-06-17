<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Definiranje rasporeda za generiranje dnevnog izvještaja
       // $schedule->command('report:generate')->dailyAt('01:56');
       $schedule->command('revenue:update-daily')->dailyAt('12:31');

        // Ažuriranje mjesečnog prometa svaki dan u 21:05
        $schedule->command('revenue:update-monthly')->dailyAt('12:32');

    }

    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

       
    

       // require base_path('routes/console.php');
    }
}

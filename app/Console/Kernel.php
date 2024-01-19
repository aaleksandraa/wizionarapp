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
        // $schedule->command('inspire')->hourly();
        $schedule->command('report:daily')->dailyAt('20:05');

        $schedule->call(function () {
            (new RevenueService())->updateDailyRevenue();
        })->dailyAt('20:00'); // Postavlja se na kraj dana
    
        $schedule->call(function () {
            (new RevenueService())->updateMonthlyRevenue();
        })->monthlyOn(1, '00:01'); // Postavlja se na početak svakog mjeseca
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}

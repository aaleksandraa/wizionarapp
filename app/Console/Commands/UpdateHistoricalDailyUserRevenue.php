<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;
use Carbon\Carbon;
use App\Services\User;

class UpdateHistoricalDailyUserRevenue extends Command
{
    protected $signature = 'revenue:update-historical-daily-user';

    protected $description = 'Update historical daily user revenue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $revenueService = new RevenueService();
        $startDate = Carbon::parse('2024-03-01'); // Početni datum od kojeg želite ažurirati
        $endDate = Carbon::now()->subDay(); // Završni datum - jučer

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $revenueService->updateDailyUserRevenue($startDate->toDateString());
            $this->info('Daily user revenue updated for ' . $startDate->toDateString());
            $startDate->addDay();
        }

        $this->info('Historical daily user revenue update completed.');
    }
}


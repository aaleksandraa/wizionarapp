<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 


class UpdateHistoricalDailyRevenue extends Command
{
    protected $signature = 'revenue:update-historical-daily';

    protected $description = 'Update historical daily revenue';

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
            $revenueService->updateDailyRevenue($startDate->format('Y-m-d'));
            $this->info('Daily revenue updated for ' . $startDate->toDateString());
            $startDate->addDay();
        }

        $this->info('Historical daily revenue update completed.');
    }
}


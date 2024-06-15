<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDailyUserRevenue extends Command
{
    protected $signature = 'revenue:update-daily-user';

    protected $description = 'Update daily user revenue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $revenueService = new RevenueService();
        $revenueService->updateDailyUserRevenue();
        
        $this->info('Daily user revenue updated successfully.');
    }
}
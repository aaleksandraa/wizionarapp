<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;

class UpdateHistoricalRevenue extends Command
{
    protected $signature = 'revenue:update-historical';

    protected $description = 'Update historical revenue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $revenueService = new RevenueService();
        $revenueService->updateDailyRevenue();
        $this->info('Historical revenue update completed.');
    }
}

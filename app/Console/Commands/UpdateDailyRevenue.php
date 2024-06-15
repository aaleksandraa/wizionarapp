<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;

class UpdateDailyRevenue extends Command
{
    protected $signature = 'revenue:update-daily';

    protected $description = 'Update daily revenue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $revenueService = new RevenueService();
        $revenueService->updateDailyRevenue();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;

class UpdateDailyRevenueCommand extends Command
{
    protected $signature = 'revenue:update-daily';
    protected $description = 'Update daily revenue';

    protected $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        parent::__construct();
        $this->revenueService = $revenueService;
    }

    public function handle()
    {
        $this->revenueService->updateDailyRevenue();
        $this->info('Daily revenue updated successfully');
    }
}


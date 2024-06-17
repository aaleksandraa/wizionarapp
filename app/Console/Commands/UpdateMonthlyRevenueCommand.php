<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RevenueService;

class UpdateMonthlyRevenueCommand extends Command
{
    protected $signature = 'revenue:update-monthly';
    protected $description = 'Update monthly revenue';

    protected $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        parent::__construct();
        $this->revenueService = $revenueService;
    }

    public function handle()
    {
        $this->revenueService->updateMonthlyRevenue();
        $this->info('Monthly revenue updated successfully');
    }
}


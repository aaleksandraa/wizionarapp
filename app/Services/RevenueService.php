<?php

namespace App\Services;

use App\Models\DailyRevenue;
use App\Models\MonthlyRevenue;
use App\Models\Appointment;

class RevenueService
{
    public function updateDailyRevenue()
    {
        $today = now()->format('Y-m-d');
        $totalRevenueToday = Appointment::whereDate('date', $today)->sum('service_price');
        $totalServicesToday = Appointment::whereDate('date', $today)->count();

        DailyRevenue::updateOrCreate(
            ['date' => $today],
            ['total_revenue' => $totalRevenueToday, 'total_services' => $totalServicesToday]
        );
    }

    public function updateMonthlyRevenue()
    {
        $currentMonth = now()->format('Y-m');
        $totalRevenueThisMonth = DailyRevenue::where('date', 'like', $currentMonth . '%')->sum('total_revenue');
        $totalServicesThisMonth = DailyRevenue::where('date', 'like', $currentMonth . '%')->sum('total_services');

        MonthlyRevenue::updateOrCreate(
            ['month' => $currentMonth],
            ['total_revenue' => $totalRevenueThisMonth, 'total_services' => $totalServicesThisMonth]
        );
    }
}

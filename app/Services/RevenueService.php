<?php

namespace App\Services;

use App\Models\DailyRevenue;
use App\Models\MonthlyRevenue;
use App\Models\Appointment;
use App\Models\User;
use App\Models\UserDailyRevenue;

class RevenueService
{
    public function updateDailyRevenue()
    {
        $today = now()->format('Y-m-d');

        $users = User::where('user_type', 'moderator')->get();
        foreach ($users as $user) {
            $totalRevenue = Appointment::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price');

            UserDailyRevenue::updateOrCreate(
                ['user_id' => $user->id, 'date' => $today],
                ['revenue' => $totalRevenue]
            );
        }

        $totalRevenueToday = Appointment::whereDate('date', $today)
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

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

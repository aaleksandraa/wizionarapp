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

			// Sumiranje cijena svih usluga (service) za današnji dan
			$totalRevenueToday = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
									->whereDate('appointments.date', $today)
									->sum('services.price'); // Sumiranje cijena usluga

			// Brojanje ukupnog broja usluga (tretmana) za današnji dan
			$totalServicesToday = Appointment::whereDate('date', $today)->count();

			// Ažuriranje ili kreiranje zapisa u tabeli daily_revenues
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

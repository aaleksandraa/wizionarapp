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


        public function updateDailyUserRevenue()
    {
        // Dohvati sve korisnike
        $users = User::all();

        // Iteriraj kroz svakog korisnika
        foreach ($users as $user) {
            // Dohvati sve datume za koje postoji promet za korisnika
            $dates = Appointment::where('user_id', $user->id)
                ->distinct()
                ->pluck('date');

            // Iteriraj kroz svaki datum i izračunaj promet za korisnika
            foreach ($dates as $date) {
                $totalRevenue = Appointment::where('user_id', $user->id)
                    ->where('date', $date)
                    ->join('services', 'appointments.service_id', '=', 'services.id')
                    ->sum('services.price');

                // Spremi promet za korisnika za taj datum u tablicu user_daily_revenues
                UserDailyRevenue::updateOrCreate(
                    ['user_id' => $user->id, 'date' => $date],
                    ['revenue' => $totalRevenue]
                );
            }
        }
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
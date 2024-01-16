<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon; 
use App\Models\Service;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type !== 'administrator') {
            // Preusmerite ne-administratore na drugu stranicu
            return redirect('/appointments');
        }

        return view('dashboard');
    }

    // Dnevni promet (danas vs juce)  
    public function calculateDailyRevenueComparison() {
        $today = \Carbon\Carbon::now();
        $yesterday = \Carbon\Carbon::yesterday();
    
        $todayRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                            ->whereDate('appointments.date', $today->format('Y-m-d'))
                            ->sum('services.price');
    
        $yesterdayRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                ->whereDate('appointments.date', $yesterday->format('Y-m-d'))
                                ->sum('services.price');
    
        $percentageChange = $yesterdayRevenue != 0 
                            ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100
                            : 0;
    
        return [
            'todayRevenue' => $todayRevenue,
            'yesterdayRevenue' => $yesterdayRevenue,
            'percentageChange' => $percentageChange
        ];
    }
    
    
    
        
        // Sedmicni promet (ova vs prosla sedmica)
        public function calculateWeeklyRevenueComparison() {
            $startOfThisWeek = Carbon::now()->startOfWeek();
            $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
            $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
        
            $thisWeekRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                ->whereBetween('appointments.date', [$startOfThisWeek, Carbon::now()])
                                ->sum('services.price');
        
            $lastWeekRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                    ->whereBetween('appointments.date', [$startOfLastWeek, $endOfLastWeek])
                                    ->sum('services.price');
        
            $percentageChange = $lastWeekRevenue != 0 
                                ? (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100
                                : 0;
        
            return [
                'thisWeekRevenue' => $thisWeekRevenue,
                'lastWeekRevenue' => $lastWeekRevenue,
                'percentageChange' => $percentageChange
            ];
        }
        
    
        // Mjesecni promet (ovaj vs prosli mjesec)
        public function calculateMonthlyRevenueComparison() {
            $startOfThisMonth = Carbon::now()->startOfMonth();
            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        
            $thisMonthRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                ->whereBetween('appointments.date', [$startOfThisMonth, Carbon::now()])
                                ->sum('services.price');
        
            $lastMonthRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                    ->whereBetween('appointments.date', [$startOfLastMonth, $endOfLastMonth])
                                    ->sum('services.price');
        
            $percentageChange = $lastMonthRevenue != 0 
                                ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
                                : 0;
        
            return [
                'thisMonthRevenue' => $thisMonthRevenue,
                'lastMonthRevenue' => $lastMonthRevenue,
                'percentageChange' => $percentageChange
            ];
        }
        
    
        
        // Godisnji promet ova vs prosla godina
        public function calculateAnnualRevenueComparison() {
            $startOfThisYear = Carbon::now()->startOfYear();
            $startOfLastYear = Carbon::now()->subYear()->startOfYear();
            $endOfLastYear = Carbon::now()->subYear()->endOfYear();
        
            $thisYearRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                ->whereBetween('appointments.date', [$startOfThisYear, Carbon::now()])
                                ->sum('services.price');
        
            $lastYearRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                                    ->whereBetween('appointments.date', [$startOfLastYear, $endOfLastYear])
                                    ->sum('services.price');
        
            $percentageChange = $lastYearRevenue != 0 
                                ? (($thisYearRevenue - $lastYearRevenue) / $lastYearRevenue) * 100
                                : 0;
        
            return [
                'thisYearRevenue' => $thisYearRevenue,
                'lastYearRevenue' => $lastYearRevenue,
                'percentageChange' => $percentageChange
            ];
        }
        
        
        
        // najpopularnija usluga mjesec
        public function getTopServices($period = 'monthly') {
            // Možete prilagoditi logiku za period (dnevno, nedeljno, godišnje)
            // Ovde je prikazan primer za mesečni period
            $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
            $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
        
            return Service::withSum(['appointments' => function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }], 'price')
            ->orderBy('appointments_sum_price', 'desc')
            ->take(5)
            ->get();
        }
        
    
        // pregled broja tretmana za mjesec
        public function getTreatmentCounts($period = 'monthly') {
            // Slično kao i za usluge, prilagodite logiku za izabrani period
            $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
            $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
        
            return Appointment::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
        }
    
        
        // analiza klijenta
        public function getClientAnalysis($period = 'monthly') {
            $startPeriod = \Carbon\Carbon::now()->startOfMonth();
            $endPeriod = \Carbon\Carbon::now()->endOfMonth();
        
            $newClientsCount = Client::whereHas('appointments', function($query) use ($startPeriod, $endPeriod) {
                                $query->whereBetween('date', [$startPeriod, $endPeriod]);
                            })->where('created_at', '>=', $startPeriod)
                            ->count();
        
            $returningClientsCount = Client::whereHas('appointments', function($query) use ($startPeriod, $endPeriod) {
                                        $query->whereBetween('date', [$startPeriod, $endPeriod]);
                                    })->where('created_at', '<', $startPeriod)
                                    ->count();
        
            return [
                'newClients' => $newClientsCount,
                'returningClients' => $returningClientsCount
            ];
        }

    public function dashboard() {
        $dailyRevenue = $this->calculateDailyRevenueComparison();
        $weeklyRevenue = $this->calculateWeeklyRevenueComparison();
        $monthlyRevenue = $this->calculateMonthlyRevenueComparison();
        $annualRevenue = $this->calculateAnnualRevenueComparison();
        $topServices = $this->getTopServices();
        $treatmentCounts = $this->getTreatmentCounts();
        $clientAnalysis = $this->getClientAnalysis();
    
        return view('dashboard', compact('dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'annualRevenue', 'topServices', 'treatmentCounts', 'clientAnalysis'));
    }
    
}

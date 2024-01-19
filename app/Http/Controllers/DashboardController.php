<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyRevenue;
use App\Models\MonthlyRevenue;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use App\Services\RevenueService; 
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        
    }

    public function dashboard() {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
        $currentDailyRevenue = $this->calculateCurrentDailyRevenue($today);
        $dnevniBrojServisa = $this->calculateCurrentDailyServiceCount($today);
        $dailyRevenue = DailyRevenue::where('date', $today)->first();
        $monthlyRevenue = MonthlyRevenue::where('month', $currentMonth)->first();
        $weeklyRevenue = $this->calculateWeeklyRevenueComparison();

        return view('dashboard', compact('currentDailyRevenue', 'dailyRevenue', 'dnevniBrojServisa', 'monthlyRevenue', 'weeklyRevenue'));

    }

    private function calculateCurrentDailyRevenue($date) {
        return Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                          ->whereDate('appointments.date', $date)
                          ->sum('services.price');
    }

    private function calculateCurrentDailyServiceCount($date) {
        return Appointment::whereDate('date', $date)->count();
    }

    public function calculateWeeklyRevenueComparison() {
        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now();
    
        $thisWeekRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                            ->whereBetween('appointments.date', [$startOfThisWeek, $endOfThisWeek])
                            ->sum('services.price');
    
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = $startOfLastWeek->copy()->endOfWeek();
    
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


    
            public function getTopServices()
        {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            return Service::withCount(['appointments' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }])
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();
        }
    
}

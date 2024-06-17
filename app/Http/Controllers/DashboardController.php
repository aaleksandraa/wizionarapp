<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyRevenue;
use App\Models\MonthlyRevenue;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use App\Services\RevenueService; 
use Illuminate\Support\Facades\DB;
use App\Models\UserDailyRevenue;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');

        $currentDailyRevenue = $this->calculateCurrentDailyRevenue($today);
        $dnevniBrojServisa = $this->calculateCurrentDailyServiceCount($today);
        $weeklyRevenue = $this->calculateWeeklyRevenueComparison();
        $usersRevenueToday = UserDailyRevenue::where('date', $today)->with('user')->get();

        $monthlyTotalRevenue = UserDailyRevenue::whereBetween('date', [$startOfMonth, $endOfMonth])
                                                ->whereHas('user', function($query) {
                                                    $query->where('user_type', 'moderator');
                                                })
                                                ->sum('revenue');
        
        $monthlyUsersRevenue = UserDailyRevenue::whereBetween('date', [$startOfMonth, $endOfMonth])
                                                ->whereHas('user', function($query) {
                                                    $query->where('user_type', 'moderator');
                                                })
                                                ->with('user')
                                                ->select('user_id', DB::raw('SUM(revenue) as total_revenue'))
                                                ->groupBy('user_id')
                                                ->get();

        return view('dashboard', compact('currentDailyRevenue', 'dnevniBrojServisa', 'weeklyRevenue', 'usersRevenueToday', 'monthlyTotalRevenue', 'monthlyUsersRevenue'));
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
}
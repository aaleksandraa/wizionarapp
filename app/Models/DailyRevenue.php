<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\DailyRevenue;
use Illuminate\Support\Facades\DB;

class DailyRevenue extends Model
{
    protected $fillable = ['date', 'total_revenue', 'total_services'];
}




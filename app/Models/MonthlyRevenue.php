<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MonthlyRevenue;


class MonthlyRevenue extends Model
{
    protected $fillable = ['month', 'total_revenue', 'total_services'];
}



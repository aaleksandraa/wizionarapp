<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyRevenue extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'revenue'];

    // Dodajte relaciju ako je potrebno
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
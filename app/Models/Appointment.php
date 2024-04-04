<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service_id', 'date', 'start_time', 'end_time', 'user_id'];

    // Relacija sa Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relacija sa Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;

class SendDailyReport extends Command
{
    protected $signature = 'report:daily';
    protected $description = 'Send daily report via email';

    public function handle()
    {
        $date = now()->format('Y-m-d');
        $appointments = Appointment::whereDate('date', $date)->get();
        $totalPrice = $appointments->sum('service.price');

        $mailData = [
            'date' => $date,
            'appointments' => $appointments,
            'totalPrice' => $totalPrice
        ];

        // Lista email adresa na koje se šalje izveštaj
        $recipients = ['email1@example.com', 'email2@example.com'];

        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new DailyReportMail($mailData));
        }

        $this->info('Daily report sent successfully!');
    }
}
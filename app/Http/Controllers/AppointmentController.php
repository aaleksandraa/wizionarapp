<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; 
use App\Models\Client;      
use App\Models\Service;    
use App\Models\DailyRevenue;
use App\Models\User;

class AppointmentController extends Controller
{
    // Prikazuje listu svih termina
    public function index(Request $request)
    {
        $userType = auth()->user()->user_type; // Dobavljanje uloge trenutno prijavljenog korisnika

        // Ako je korisnik administrator, prikaži sve termine
        if ($userType === 'administrator') {   
            $date = $request->query('date', now()->format('Y-m-d')); // Ako datum nije prosleđen, koristi današnji datum         
            // $today = now()->format('Y-m-d');
            $users = User::where('user_type', '!=', 'administrator')->get(); // Dobavljanje svih korisnika osim administratora            
            $appointments = Appointment::whereDate('date', $date)->get();


            return view('appointments.admin_index', compact('users', 'appointments'));        



        } else {
            // Inače, prikaži samo termine trenutno prijavljenog korisnika
            $userId = auth()->id(); // Dobavljanje ID-a trenutno prijavljenog korisnika
            $today = \Carbon\Carbon::now()->format('Y-m-d');     
            $appointments = Appointment::where('user_id', $userId) // Filtriranje po user_id
                               ->whereDate('date', $today)
                               ->get();

   
        

        // Izračunavanje ukupne cijene
        $totalPrice = $appointments->sum(function ($appointment) {
            return $appointment->service->price;
        });

        return view('appointments.index', compact('appointments', 'totalPrice'));
    }
    }

    // Prikazuje formu za kreiranje novog termina
    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        // return view('appointments.create', compact('clients', 'services'));
        $today = \Carbon\Carbon::now()->format('d.m.Y');
        return view('appointments.create', compact('services', 'today'));
    }

    // Čuva novi termin u bazi podataka
    public function store(Request $request)
    {
        try {
        $request->validate([
            'client_name' => 'required',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable',
            'service_id' => 'required',
            'date' => 'required|date_format:Y-m-d', // Ako je format datuma Y-m-d
            'start_time' => 'required',
            'end_time' => 'required'
        ]);
    } catch (\Exception $e) {
        return back()->withError('Greška: ' . $e->getMessage())->withInput();
    }
    
        // Kreiranje novog klijenta
        $client = Client::create([
            'name' => $request->input('client_name'),
            'email' => $request->input('client_email'),
            'phone' => $request->input('client_phone')
        ]);
    
        // Kreiranje novog termina
        $appointment = new Appointment([
            'client_id' => $client->id,
            'service_id' => $request->input('service_id'),
            // 'date' => \Carbon\Carbon::createFromFormat('d.m.Y', $request->input('date'))->format('Y-m-d'),

            'date' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d'),

            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'user_id' => auth()->id()
        ]);
        $appointment->save();

        // Ažuriranje DailyRevenue za dan kada je kreiran appointment
        // $this->updateDailyRevenue($appointment);
    
        return redirect()->route('appointments.index')
                         ->with('success', 'Termin je uspešno dodat.');
                         
    }


    // Prikazuje jedan termin
    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    // Prikazuje formu za izmenu termina
    public function edit(Appointment $appointment)
    {
        $clients = Client::all();
        $services = Service::all();
        return view('appointments.edit', compact('appointment', 'clients', 'services'));
    }

    // Ažurira termin u bazi podataka
    public function update(Request $request, Appointment $appointment)
{
    $request->validate([
        'client_name' => 'required',
        'client_email' => 'nullable|email',
        'client_phone' => 'nullable',
        'service_id' => 'required',
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required'
    ]);
    

    // Ažuriranje klijenta
    $client = Client::find($appointment->client_id);
    if ($client) {
        $client->update([
            'name' => $request->client_name,
            'email' => $request->client_email,
            'phone' => $request->client_phone
        ]);
    }

    // Ažuriranje termina
    $appointment->update([
        'service_id' => $request->service_id,        
        'date' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d'),
        'start_time' => $request->start_time,
        'end_time' => $request->end_time
    ]);

    return redirect()->route('appointments.index')->with('success', 'Termin je uspešno ažuriran.');
}


    // Briše termin
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
                         ->with('success', 'Termin je uspešno obrisan.');
    }

    public function showByDate($date)
    {   
    $userId = auth()->id(); // Dobavljanje ID-a trenutno prijavljenog korisnika
    $userType = auth()->user()->user_type; // Dobavljanje uloge trenutno prijavljenog korisnika
     // Ako je korisnik administrator, prikaži sve termine
    if ($userType === 'administrator') {
        $appointments = Appointment::whereDate('date', $date)->get();
    } else {
        // Inače, prikaži samo termine trenutno prijavljenog korisnika
        $appointments = Appointment::where('user_id', $userId)
                                   ->whereDate('date', $date)
                                   ->get();
    }
    $totalPrice = $appointments->sum(function ($appointment) {
        return $appointment->service->price;
    });

    return view('appointments.index', compact('appointments', 'totalPrice'));
    }  

}
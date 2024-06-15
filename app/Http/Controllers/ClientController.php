<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        
     public function index(Request $request)
    {
        $search = $request->input('search', '');

        $clients = Client::where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->get();

        if ($request->ajax()) {
            return view('clients.partial', compact('clients'));
        }

        return view('clients.index', compact('clients'));
    }

    
    public function apiIndex(Request $request)
    {
        $search = $request->input('search', '');

        $clients = Client::where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->get();

        return response()->json($clients);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
{
    $appointments = $client->appointments()->with('service')->get();
    $totalSpent = $appointments->sum(function($appointment) {
        return $appointment->service->price;
    });
    return view('clients.show', compact('client', 'appointments', 'totalSpent'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function mergeDuplicatesByName()
    {
        // Dohvatimo sve klijente grupirane po imenu i prezimenu
        $duplicates = DB::table('clients')
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            $clients = Client::where('name', $duplicate->name)->get();
            $mainClient = $clients->first();

            foreach ($clients->slice(1) as $duplicateClient) {
                // Ažuriramo email i telefon ako glavni klijent nema te podatke
                if (!$mainClient->email && $duplicateClient->email) {
                    $mainClient->email = $duplicateClient->email;
                }
                if (!$mainClient->phone && $duplicateClient->phone) {
                    $mainClient->phone = $duplicateClient->phone;
                }

                // Pripojimo sve usluge dupliciranog klijenta glavnom klijentu
                Appointment::where('client_id', $duplicateClient->id)
                    ->update(['client_id' => $mainClient->id]);

                // Izbrišemo duplicirani klijent
                $duplicateClient->delete();
            }

            // Spremimo ažuriranog glavnog klijenta
            $mainClient->save();
        }

        return redirect()->route('clients.index')->with('success', 'Duplicirani klijenti su uspješno spojeni.');
    }
    
}

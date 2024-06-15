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

    
    
}

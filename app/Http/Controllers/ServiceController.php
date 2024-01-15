<?php

namespace App\Http\Controllers;
use App\Models\Service; 
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Prikazuje sve usluge
    public function index()
    {
        $services = Service::all();
        return view('usluge.index', compact('services'));
    }

    // Prikazuje formu za kreiranje nove usluge
    public function create()
    {
        return view('usluge.create');
    }

    // Čuva novu uslugu u bazi
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        Service::create($request->all());
        return redirect()->route('usluge.index')
                         ->with('success', 'Usluga je uspešno dodata.');
    }

    // Prikazuje jednu uslugu
    public function show(Service $service)
    {
        return view('usluge.show', compact('service'));
    }

    // Prikazuje formu za uređivanje usluge
    public function edit(Service $service)
    {
        return view('usluge.edit', compact('service'));
    }

    // Ažurira uslugu u bazi
    public function update(Request $request, Service $service)
    { 
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        $service->update($request->all());
        return redirect()->route('usluge.index')
                         ->with('success', 'Usluga je uspešno ažurirana.');
    }

    // Briše uslugu
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('usluge.index')
                         ->with('success', 'Usluga je uspešno obrisana.');
    }
}
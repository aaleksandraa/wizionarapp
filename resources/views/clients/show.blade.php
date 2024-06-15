@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">{{ $client->name }}</h2>
        <p class="text-gray-700"><strong>Email:</strong> {{ $client->email }}</p>
        <p class="text-gray-700"><strong>Telefon:</strong> {{ $client->phone }}</p>
    </div>

    <h3 class="text-xl font-semibold mt-6 mb-4">Usluge</h3>
    <ul class="space-y-4">
        @foreach($appointments as $appointment)
            <li class="bg-white p-4 rounded-lg shadow-md">
                <p class="text-gray-700"><strong>Datum:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d.m.Y') }}</p>
                <p class="text-gray-700"><strong>Usluga:</strong> {{ $appointment->service->name }}</p>
                <p class="text-gray-700"><strong>Cijena:</strong> {{ $appointment->service->price }} KM</p>                
            </li>
            <br>
        @endforeach
    </ul>

    <div class="bg-gray-100 p-4 mt-6 rounded-lg shadow-md">
        <p class="text-gray-700 font-semibold text-lg"><strong>Ukupno:</strong> {{ number_format($totalSpent, 2) }} KM</p>
    </div>
</div>
@endsection

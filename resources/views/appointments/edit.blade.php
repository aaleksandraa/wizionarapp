@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Izmijeni Termin</h2>
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            {{-- Ime i Prezime Klijenta --}}
            <div class="mb-4">
                <label for="client_name" class="block text-gray-700 text-sm font-bold mb-2">Ime i Prezime Klijenta</label>
                <input type="text" name="client_name" id="client_name" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ $appointment->client->name }}" required>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="client_email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="client_email" id="client_email" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ $appointment->client->email }}">
            </div>

            {{-- Broj Telefona --}}
            <div class="mb-4">
                <label for="client_phone" class="block text-gray-700 text-sm font-bold mb-2">Broj Telefona</label>
                <input type="text" name="client_phone" id="client_phone" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ $appointment->client->phone }}">
            </div>

            {{-- Usluga --}}
            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 text-sm font-bold mb-2">Usluga</label>
                <select name="service_id" id="service_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            

            {{-- Input za Datum sa Date Picker-om --}}
            <div class="mb-4">
                <label for="datePicker" class="block text-gray-700 text-sm font-bold mb-2">Datum:</label>
                <input type="text" id="datePicker" name="date" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ \Carbon\Carbon::parse($appointment->date)->format('Y.m.d') }}">
            </div>

            {{-- Vreme Početka --}}
        <div class="mb-4">
            <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Vreme Početka (24h format)</label>
            <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" id="start_time" name="start_time" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time)->format('H:i') }}" required>
        </div>

        {{-- Vreme Završetka --}}
        <div class="mb-4">
            <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Vreme Završetka (24h format)</label>
            <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" id="end_time" name="end_time" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time)->format('H:i') }}" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sačuvaj</button>
            <a href="{{ route('appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-pink-600 hover:text-pink-700">Nazad</a>
        </div>
    </form>
</div>
</div>
<script>
    flatpickr("#datePicker", {
        altInput: true,
        altFormat: "d.m.Y",
        dateFormat: "Y-m-d",
    });
</script>
@endsection


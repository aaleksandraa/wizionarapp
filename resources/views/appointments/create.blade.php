@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Dodaj Novi Termin</h2>
        <form action="{{ route('appointments.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Izaberite tip klijenta</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="radio" name="client_type" value="existing" id="existing_client_radio" class="form-radio h-4 w-4 text-pink-600">
                        <span class="ml-2">Postojeći Klijent</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="client_type" value="new" id="new_client_radio" class="form-radio h-4 w-4 text-pink-600">
                        <span class="ml-2">Novi Klijent</span>
                    </label>
                </div>
            </div>

            <div id="existing_client_section" class="mb-4" style="display: none;">
                <label for="existing_client" class="block text-gray-700 text-sm font-bold mb-2">Izaberite klijenta</label>
                <select id="existing_client" name="existing_client" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="new_client_section" style="display: none;">
                <div class="mb-4">
                    <label for="client_name" class="block text-gray-700 text-sm font-bold mb-2">Ime i Prezime Klijenta</label>
                    <input type="text" name="client_name" id="client_name" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                </div>
                <div class="mb-4">
                    <label for="client_email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="client_email" id="client_email" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                </div>
                <div class="mb-4">
                    <label for="client_phone" class="block text-gray-700 text-sm font-bold mb-2">Broj Telefona</label>
                    <input type="text" name="client_phone" id="client_phone" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                </div>
            </div>

            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 text-sm font-bold mb-2">Usluga</label>
                <select name="service_id" id="service_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
             
            <div class="mb-4">
                <label for="datePicker" class="block text-gray-700 text-sm font-bold mb-2">Datum</label>
                <input type="text" id="datePicker" name="date" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
            </div>

            <div class="mb-4">
                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Vreme Početka (24h format)</label>
                <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" id="start_time" name="start_time" required>
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Vreme Završetka (24h format)</label>
                <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" id="end_time" name="end_time" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sačuvaj</button>
                <a href="{{ route('appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-pink-600 hover:text-pink-700">Nazad</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('existing_client_radio').addEventListener('change', function() {
    document.getElementById('existing_client_section').style.display = 'block';
    document.getElementById('new_client_section').style.display = 'none';
});

document.getElementById('new_client_radio').addEventListener('change', function() {
    document.getElementById('existing_client_section').style.display = 'none';
    document.getElementById('new_client_section').style.display = 'block';
});

function formatDate(date) {
    var d = new Date(date),
        day = '' + d.getDate(),
        month = '' + (d.getMonth() + 1),
        year = d.getFullYear();

    if (day.length < 2) 
        day = '0' + day;
    if (month.length < 2) 
        month = '0' + month;

    return [day, month, year].join('.');
}

flatpickr("#datePicker", {
    altInput: true,
    altFormat: "d.m.Y",
    dateFormat: "Y-m-d",
    defaultDate: new Date().toISOString().slice(0, 10) // Formatira današnji datum kao YYYY-MM-DD
});
</script>
@endsection

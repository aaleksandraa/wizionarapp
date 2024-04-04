@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <div class="mb-4">
            <label for="datePicker" class="block text-gray-700 text-sm font-bold mb-2">Odaberite datum:</label>
            <input type="text" id="datePicker" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">            
        </div> 
    </div>

    @if ($appointments->isEmpty())
        <div class="alert alert-info">Trenutno nema dodanih usluga / pregleda za odabrani datum.</div>
    @else
        @foreach($users as $user)
            <h3 class="text-xl font-semibold mb-0">{{ $user->name }} {{ $user->surname }}</h3> <!-- Uklonjena margina ispod H3 -->

            @php
                $userAppointments = $appointments->where('user_id', $user->id);
            @endphp

            @if($userAppointments->isEmpty())
                <div class="alert alert-info">Nema podataka za ovog korisnika.</div>
            @else
                <div class="bg-white shadow-md rounded my-6 hidden md:block">
                    <table class="text-left w-full border-collapse">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="py-2 px-4">Vrijeme</th>
                                <th class="py-2 px-4">Klijent</th>
                                <th class="py-2 px-4 hidden md:table-cell">Telefon</th>
                                <th class="py-2 px-4">Usluga</th>
                                <th class="py-2 px-4">Cijena</th>
                                <th class="py-2 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userAppointments as $appointment)
                                <tr class="hover:bg-gray-100 {{ $loop->even ? 'bg-gray-100' : '' }}">
                                    <td class="py-2 px-4">{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time)->format('H:i') }}</td>
                                    <td class="py-2 px-4">{{ $appointment->client->name }}</td>
                                    <td class="py-2 px-4 hidden md:table-cell">{{ $appointment->client->phone }}</td>
                                    <td class="py-2 px-4">{{ $appointment->service->name }}</td>
                                    <td class="py-2 px-4">{{ $appointment->service->price }} KM</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-pink-600 hover:text-pink-700"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-800 ml-2"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @php
                    $totalPriceForUser = $userAppointments->sum(function ($appointment) {
                        return $appointment->service->price;
                    });
                @endphp

                <div class="flex justify-end mb-20 hidden md:block"> <!-- Povećan razmak posle tabele -->
                    <div class="text-xl font-semibold">Ukupan promet: <span class="ml-2">{{ $totalPriceForUser }} KM</span></div>
                </div>
                
                

            @endif
        

        @if(!$userAppointments->isEmpty())
        <div class="bg-white shadow-md rounded my-6 block md:hidden">
            @foreach($userAppointments as $appointment)
            <div class="p-4 mb-4 border-b">
                <div><strong>Vrijeme:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time)->format('H:i') }}</div>
                <div><strong>Klijent:</strong> {{ $appointment->client->name }}</div>
                <div><strong>Telefon:</strong> {{ $appointment->client->phone }}</div>
                <div><strong>Usluga:</strong> {{ $appointment->service->name }}</div>
                <div><strong>Cijena:</strong> {{ $appointment->service->price }} KM</div>
                <div class="flex justify-end mt-2">
                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-pink-600 hover:text-pink-700"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-800"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-end mb-20 md:hidden"> <!-- Povećan razmak posle tabele -->
            <div class="text-xl font-semibold">Ukupan promet: <span class="ml-2">{{ $totalPriceForUser }} KM</span></div>
        </div>
        @endif

        <div class="mb-8"></div> <!-- Ovo je nova linija za veći razmak -->

        @endforeach
    @endif
</div>








<script>
    // Funkcija za formatiranje datuma
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

    // Provera da li postoji datum u URL-u
    function getDateFromUrl() {
        const pathParts = window.location.pathname.split('/');
        const datePart = pathParts[pathParts.length - 1];
        if (datePart.match(/\d{4}-\d{2}-\d{2}/)) {
            return new Date(datePart);
        }
        return new Date(); // Vraća današnji datum ako datum nije u URL-u
    }

    const selectedDate = getDateFromUrl();

    // Postavljanje placeholder-a na osnovu izabranog datuma ili današnjeg datuma
    document.getElementById('datePicker').placeholder = formatDate(selectedDate);

    flatpickr("#datePicker", {
        altInput: true,
        altFormat: "d.m.Y",
        dateFormat: "Y-m-d",
        defaultDate: selectedDate,
        locale: "sr",
        onChange: function(selectedDates, dateStr, instance) {
            window.location.href = '{{ route("appointments.index") }}?date=' + dateStr;
        }
    });
</script>
@endsection





   
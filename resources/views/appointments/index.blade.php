@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <div class="mb-4">
            <label for="datePicker" class="block text-gray-700 text-sm font-bold mb-2">Odaberite datum:</label>
            <input type="text" id="datePicker" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">            
        </div> 

       {{-- <h2 class="text-2xl font-semibold">Pregledi / usluge</h2>  --}}
        <a href="{{ route('appointments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Dodaj Novi Tretman</a>
    </div>

    @if ($appointments->isEmpty())
        <div class="alert alert-info">Trenutno nema dodanih usluga / pregleda za odabrani datum.</div>
    @else
        <div class="bg-white shadow-md rounded my-6">
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
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-100 {{ $loop->even ? 'bg-gray-100' : '' }}">
                            <td class="py-2 px-4">{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time)->format('H:i') }}</td>
                            <td class="py-2 px-4">{{ $appointment->client->name }}</td>
                            <td class="py-2 px-4 hidden md:table-cell">{{ $appointment->client->phone }}</td>
                            <td class="py-2 px-4">{{ $appointment->service->name }}</td>
                            <td class="py-2 px-4">{{ $appointment->service->price }} KM</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-blue-500 hover:text-blue-800"><i class="fas fa-edit"></i></a>
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
        {{-- Red za ukupnu cijenu --}}
        <div class="flex justify-end">
            <div class="text-xl font-semibold mr-4">Ukupan promet: {{ $totalPrice }} KM</div>
        </div>
    @endif
</div>

<script>
    flatpickr("#datePicker", {
        altInput: true,
        altFormat: "d.m.Y",
        dateFormat: "Y-m-d",
        locale: "sr", // Opcionalno, postavite lokalizaciju na srpski ili drugi jezik
        onChange: function(selectedDates, dateStr, instance) {
            window.location.href = '{{ url("appointments") }}/' + dateStr;
        }
    });
</script>

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

    // Inicijalizacija flatpickr
    flatpickr("#datePicker", {
        altInput: true,
        altFormat: "d.m.Y",
        dateFormat: "Y-m-d",
        defaultDate: selectedDate,
        onChange: function(selectedDates, dateStr, instance) {
            window.location.href = '{{ url("appointments/date") }}/' + dateStr;
        }
    });
</script>



@endsection

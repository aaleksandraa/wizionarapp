<!DOCTYPE html>
<html>
<head>
    <style>
        // Ovdje dodajte vaš CSS
    </style>
</head>
<body>
    <h1>Dnevni Izvještaj za {{ $date }}</h1>
    <table>
        <thead>
            <tr>
                <th>Vrijeme</th>
                <th>Klijent</th>
                <th>Usluga</th>
                <th>Cijena</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                    <td>{{ $appointment->client->name }}</td>
                    <td>{{ $appointment->service->name }}</td>
                    <td>{{ $appointment->service->price }} KM</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Ukupan promet</td>
                <td>{{ $totalPrice }} KM</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

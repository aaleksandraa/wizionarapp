<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dnevni Izvještaj</title>
    <style>
        /* Ovdje dodajte vaše CSS stilove */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <h2>Dnevni Izvještaj - {{ $date }}</h2>
    
    <table>
        <thead>
            <tr>
                <th>Vrijeme</th>
                <th>Korisnik</th>
                <th>Klijent</th>
                <th>Telefon</th>
                <th>Usluga</th>
                <th>Cijena</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                <td>{{ $appointment->user->name }}</td>
                <td>{{ $appointment->client->name }}</td>
                <td>{{ $appointment->client->phone }}</td>
                <td>{{ $appointment->service->name }}</td>
                <td>{{ $appointment->service->price }} KM</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">Ukupan promet</td>
                <td>{{ $totalPrice }} KM</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

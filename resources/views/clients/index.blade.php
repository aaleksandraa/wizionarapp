@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <input type="text" id="searchBox" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Pretraži klijente...">
    </div>

    <div id="clientList">
        @foreach ($clients as $client)
            <div class="bg-white p-4 mb-4 shadow rounded">
                <div>{{ $client->name }}</div>
                <div>{{ $client->email }}</div>
                <div>{{ $client->phone }}</div>
            </div>
        @endforeach
    </div>
</div>


<script>
    document.getElementById('searchBox').addEventListener('keyup', function() {
        var search = this.value;
        fetch("{{ route('api.clients.index') }}?search=" + search)
            .then(response => response.json())
            .then(data => {
                var clientListHtml = '';
                data.forEach(client => {
                    clientListHtml += `
                        <div class="bg-white p-4 mb-4 shadow rounded">
                            <div>${client.name}</div>
                            <div>${client.email}</div>
                            <div>${client.phone}</div>
                        </div>
                    `;
                });
                document.getElementById('clientList').innerHTML = clientListHtml;
            });
    });
</script>


@endsection

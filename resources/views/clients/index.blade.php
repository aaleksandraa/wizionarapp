@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4 flex justify-between items-center">
        <input type="text" id="searchBox" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Pretraži klijente...">
        <a href="{{ route('clients.mergeDuplicatesByName') }}" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Spoji Duplikate po Imenu</a>
    </div>

    <div id="clientList">
        @foreach ($clients as $client)
            <div class="bg-white p-4 mb-4 shadow rounded">
                <div>
                    <a href="{{ route('clients.show', $client->id) }}" class="text-blue-500 hover:text-blue-700">{{ $client->name }}</a>
                </div>
                @if($client->email)
                    <div>{{ $client->email }}</div>
                @endif
                @if($client->phone)
                    <div>{{ $client->phone }}</div>
                @endif
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
                            <div>
                                <a href="{{ url('clients') }}/${client.id}" class="text-blue-500 hover:text-blue-700">${client.name}</a>
                            </div>
                            ${client.email ? `<div>${client.email}</div>` : ''}
                            ${client.phone ? `<div>${client.phone}</div>` : ''}
                        </div>
                    `;
                });
                document.getElementById('clientList').innerHTML = clientListHtml;
            });
    });
</script>
@endsection


@foreach ($clients as $client)
    <div class="bg-white p-4 mb-4 shadow rounded">
        <div>{{ $client->name }}</div>
        <div>{{ $client->email }}</div>
        <div>{{ $client->phone }}</div>
    </div>
@endforeach

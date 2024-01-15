@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Uredi Uslugu</h2>
            <form action="{{ route('usluge.update', ['service' => $service->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naziv Usluge</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ $service->name }}" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Cijena</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" value="{{ $service->price }}" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ažuriraj</button>
                <a href="{{ route('usluge.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Nazad</a>
            </div>
        </form>
    </div>
</div>
@endsection

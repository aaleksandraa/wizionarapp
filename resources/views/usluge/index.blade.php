@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-4xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Usluge</h2>
                <a href="{{ route('usluge.create') }}" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">Dodaj Novu Uslugu</a>
            </div>

            @if ($services->isEmpty())
                <div class="alert alert-info">Trenutno nema dostupnih usluga.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $service)
                        <div class="bg-white shadow rounded p-4">
                            <h3 class="text-lg font-semibold">{{ $service->name }}</h3>
                            <p class="text-gray-700">{{ $service->price }} KM</p>
                            <div class="flex mt-4">
                                <a href="{{ route('usluge.edit', $service->id) }}" class="text-gray-600 hover:text-pink-700 mr-2">
                                    Izmijeni
                                </a>
                                <form action="{{ route('usluge.destroy', $service->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-800" onclick="return confirm('Da li ste sigurni da želite obrisati ovu uslugu?')">
                                        Obriši
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

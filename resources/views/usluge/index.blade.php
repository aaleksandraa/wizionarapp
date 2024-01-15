@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-4xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Usluge</h2>
                <a href="{{ route('usluge.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Dodaj Novu Uslugu</a>
            </div>

            @if ($services->isEmpty())
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">Trenutno nema dostupnih usluga.</span>
                </div>
            @else
                <div class="bg-white shadow-md rounded my-6">
                    <table class="text-left w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="py-4 px-8 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Naziv</th>
                                <th class="py-4 px-8 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Cijena</th>
                                <th class="py-4 px-8 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-8 border-b border-grey-light">{{ $service->name }}</td>
                                    <td class="py-4 px-8 border-b border-grey-light">{{ $service->price }} KM</td>
                                    <td class="py-4 px-8 border-b border-grey-light flex items-center">
                                        <a href="{{ route('usluge.edit', $service->id) }}" class="text-blue-500 hover:text-blue-800 mr-2">
                                            Izmijeni <i class="fas fa-edit ml-1"></i>
                                        </a>
                                        <form action="{{ route('usluge.destroy', $service->id) }}" method="POST" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-800" onclick="return confirm('Da li ste sigurni da želite obrisati ovu uslugu?')">
                                                Obriši <i class="fas fa-trash-alt ml-1"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

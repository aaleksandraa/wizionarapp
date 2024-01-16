@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Dnevni Promet -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Dnevni Promet (Danas vs Juče)</h3>
            <div class="text-center">
                <p class="text-xl">
                    {{ number_format($dailyRevenue['todayRevenue'], 2) }} KM
                </p>
                <p class="{{ $dailyRevenue['percentageChange'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ number_format($dailyRevenue['percentageChange'], 2) }}%
                </p>
            </div>
        </div>

        <!-- Sedmični Promet -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Sedmični Promet (Ova Sedmica vs Prošla Sedmica)</h3>
            <div class="text-center">
                <p class="text-xl">
                    {{ number_format($weeklyRevenue['thisWeekRevenue'], 2) }} KM
                </p>
                <p class="{{ $weeklyRevenue['percentageChange'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ number_format($weeklyRevenue['percentageChange'], 2) }}%
                </p>
            </div>
        </div>

        <!-- Mesečni Promet -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Mesečni Promet (Ovaj Mesec vs Prošli Mesec)</h3>
            <div class="text-center">
                <p class="text-xl">
                    {{ number_format($monthlyRevenue['thisMonthRevenue'], 2) }} KM
                </p>
                <p class="{{ $monthlyRevenue['percentageChange'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ number_format($monthlyRevenue['percentageChange'], 2) }}%
                </p>
            </div>
        </div>

        <!-- Godišnji Promet -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Godišnji Promet (Ova Godina vs Prošla Godina)</h3>
            <div class="text-center">
                <p class="text-xl">
                    {{ number_format($annualRevenue['thisYearRevenue'], 2) }} KM
                </p>
                <p class="{{ $annualRevenue['percentageChange'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ number_format($annualRevenue['percentageChange'], 2) }}%
                </p>
            </div>
        </div>
        <!-- Najpopularnije Usluge -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Najpopularnije Usluge Ovog Mjeseca</h3>
            <ul class="list-disc pl-5">
                @foreach($topServices as $service)
                    <li>{{ $service->name }} - {{ number_format($service->appointments_sum_price, 2) }} KM</li>
                @endforeach
            </ul>
        </div>

        <!-- Pregled Broja Tretmana -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Broj Tretmana Ovog Mjeseca</h3>
            <div class="text-center">
                <p class="text-xl">{{ $treatmentCounts }}</p>
            </div>
        </div>

        <!-- Analiza Klijenata -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="font-semibold text-lg">Analiza Klijenata Ovog Mjeseca</h3>
            <div>
                <p>Novi Klijenti: {{ $clientAnalysis['newClients'] }}</p>
                <p>Povratni Klijenti: {{ $clientAnalysis['returningClients'] }}</p>
            </div>
        </div>
    </div>
</div>


@endsection

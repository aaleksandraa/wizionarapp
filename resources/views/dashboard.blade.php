{{-- dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Trenutni Dnevni Promet -->        
            <div class="bg-white dark:bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer" onclick="redirectToAppointments()">

            <h3 class="font-semibold text-lg dark:bg-gray-300 text-center">Trenutni Dnevni Promet</h3>
            <br/>
            <div class="text-center">
                <p class="text-3xl">
                    {{ number_format($currentDailyRevenue, 2) }} KM
                </p>
                <p class="text-sm">
                    Trenutni broj tretmana danas: {{ $dnevniBrojServisa }}
                </p>
            </div>
        </div>  
        
        
         <!-- Sedmični Promet -->
         @if(isset($weeklyRevenue))
         <div class="bg-white dark:bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg p-4">
             <h3 class="font-semibold text-lg dark:bg-gray-300 text-center">Sedmični Promet</h3>
             <br/>
             <div class="text-center">
                 <p class="text-3xl">
                     {{ number_format($weeklyRevenue['thisWeekRevenue'], 2) }} KM
                     <sup class="{{ $weeklyRevenue['percentageChange'] >= 0 ? 'text-green-500' : 'text-red-500' }}" style="font-size: 15px;">
                         {{ number_format($weeklyRevenue['percentageChange'], 2) }}%
                     </sup>
                 </p>
                 <p class="text-sm">Prošla sedmica: {{ number_format($weeklyRevenue['lastWeekRevenue'], 2) }} KM</p>
             </div>
         </div>
         
     @endif

        <!-- Mesečni Promet -->
        @if($monthlyRevenue)
            <div class="bg-white dark:bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <h3 class="font-semibold text-lg dark:bg-gray-300 text-center">Mjesečni Promet</h3>     
                <br/>                          
                <div class="text-center">
                    <p class="text-3xl">
                        {{ number_format($monthlyRevenue->total_revenue, 2) }} KM
                    </p>
                    <p class="text-sm">Ukupno usluga ovog mjeseca: {{ $monthlyRevenue->total_services }}</p>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <h3 class="font-semibold text-lg dark:bg-gray-300 text-center">Mjesečni Promet</h3> 
                <br/>
                <p class="text-center">Nema podataka za tekući mjesec.</p>
            </div>
        @endif

        

</div>
</div>

<script>
    function redirectToAppointments() {
        window.location.href = '{{ url("/appointments") }}';
    }
</script>

@endsection

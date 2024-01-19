<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_revenues', function (Blueprint $table) {
            $table->id();
            $table->string('month'); // Format: 'YYYY-MM'
            $table->decimal('total_revenue', 10, 2); // Ukupan prihod za mjesec
            $table->integer('total_services'); // Ukupan broj usluga pruženih tog mjeseca
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_revenues');
    }
};

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
        Schema::create('daily_revenues', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // Jedinstveni datum za svaki zapis
            $table->decimal('total_revenue', 10, 2); // Ukupan prihod za dan
            $table->integer('total_services'); // Ukupan broj usluga pruženih tog dana
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_revenues');
    }
};
